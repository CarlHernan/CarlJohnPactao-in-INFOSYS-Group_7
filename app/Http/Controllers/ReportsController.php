<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display sales report page.
     */
    public function sales(Request $request): View
    {
        $period = $request->get('period', 'monthly'); // daily, weekly, monthly
        $startDate = $request->get('start_date', now()->subMonth());
        $endDate = $request->get('end_date', now());

        // Parse dates
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        // Get sales data based on period
        $salesData = $this->getSalesData($period, $startDate, $endDate);
        
        // Get summary statistics
        $summary = $this->getSalesSummary($startDate, $endDate);

        return view('admin.dashboard.reports.sales', compact('salesData', 'summary', 'period', 'startDate', 'endDate'));
    }

    /**
     * Display product performance page.
     */
    public function products(): View
    {
        // Most sold products
        $topProducts = OrderItem::select('product_id', 'products.dish_name', 'products.price', 'products.category_id', 'categories.name as category_name')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->selectRaw('SUM(order_items.quantity * order_items.price) as total_revenue')
            ->selectRaw('COUNT(DISTINCT order_items.order_id) as order_count')
            ->groupBy('product_id', 'products.dish_name', 'products.price', 'products.category_id', 'categories.name')
            ->orderBy('total_quantity', 'desc')
            ->limit(10)
            ->get();

        // Least sold products
        $bottomProducts = OrderItem::select('product_id', 'products.dish_name', 'products.price', 'products.category_id', 'categories.name as category_name')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_quantity')
            ->selectRaw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as total_revenue')
            ->selectRaw('COUNT(DISTINCT order_items.order_id) as order_count')
            ->groupBy('product_id', 'products.dish_name', 'products.price', 'products.category_id', 'categories.name')
            ->orderBy('total_quantity', 'asc')
            ->limit(10)
            ->get();

        // Products with no sales
        $noSalesProducts = Product::leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->whereNull('order_items.product_id')
            ->select('products.*', 'categories.name as category_name')
            ->get();

        return view('admin.dashboard.reports.products', compact('topProducts', 'bottomProducts', 'noSalesProducts'));
    }

    /**
     * Display customer insights page.
     */
    public function customers(): View
    {
        // Top customers by total purchase
        $topCustomers = User::where('is_admin', false)
            ->withCount(['orders', 'orders as completed_orders_count' => function ($query) {
                $query->where('status', 'delivered');
            }])
            ->with(['orders' => function ($query) {
                $query->where('status', 'delivered');
            }])
            ->get()
            ->map(function ($user) {
                $user->total_spent = $user->orders->sum('total_amount');
                $user->average_order_value = $user->orders->count() > 0 ? $user->orders->avg('total_amount') : 0;
                return $user;
            })
            ->sortByDesc('total_spent')
            ->values()
            ->take(20);

        // Customer acquisition trends
        $acquisitionData = User::where('is_admin', false)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subYear())
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Customer segments - optimized with single query
        $allCustomers = User::where('is_admin', false)
            ->with(['orders' => function ($query) {
                $query->where('status', 'delivered');
            }])
            ->get();
            
        $segments = [
            'high_value' => $allCustomers->filter(function ($user) {
                return $user->orders->sum('total_amount') >= 1000;
            })->count(),
            'regular' => $allCustomers->filter(function ($user) {
                $total = $user->orders->sum('total_amount');
                return $total >= 100 && $total < 1000;
            })->count(),
            'new' => $allCustomers->filter(function ($user) {
                return $user->orders->sum('total_amount') < 100;
            })->count(),
        ];

        return view('admin.dashboard.reports.customers', compact('topCustomers', 'acquisitionData', 'segments'));
    }

    /**
     * Export sales data to CSV.
     */
    public function exportSales(Request $request): Response
    {
        $period = $request->get('period', 'monthly');
        $startDate = Carbon::parse($request->get('start_date', now()->subMonth()));
        $endDate = Carbon::parse($request->get('end_date', now()));

        $salesData = $this->getSalesData($period, $startDate, $endDate);

        $filename = 'sales_report_' . $period . '_' . $startDate->format('Y-m-d') . '_to_' . $endDate->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($salesData, $period) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            if ($period === 'daily') {
                fputcsv($file, ['Date', 'Orders', 'Revenue', 'Average Order Value']);
            } elseif ($period === 'weekly') {
                fputcsv($file, ['Week', 'Orders', 'Revenue', 'Average Order Value']);
            } else {
                fputcsv($file, ['Month', 'Orders', 'Revenue', 'Average Order Value']);
            }

            // CSV data
            foreach ($salesData as $data) {
                fputcsv($file, [
                    $data['period'],
                    $data['orders'],
                    $data['revenue'],
                    $data['avg_order_value']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get sales data based on period.
     */
    private function getSalesData(string $period, Carbon $startDate, Carbon $endDate): array
    {
        $query = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate]);

        switch ($period) {
            case 'daily':
                $data = $query->selectRaw('DATE(created_at) as period')
                    ->selectRaw('COUNT(*) as orders')
                    ->selectRaw('SUM(total_amount) as revenue')
                    ->selectRaw('AVG(total_amount) as avg_order_value')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
                break;

            case 'weekly':
                $data = $query->selectRaw('YEAR(created_at) as year, WEEK(created_at) as week')
                    ->selectRaw('COUNT(*) as orders')
                    ->selectRaw('SUM(total_amount) as revenue')
                    ->selectRaw('AVG(total_amount) as avg_order_value')
                    ->groupBy('year', 'week')
                    ->orderBy('year')
                    ->orderBy('week')
                    ->get()
                    ->map(function ($item) {
                        $item->period = "Week {$item->week}, {$item->year}";
                        return $item;
                    });
                break;

            default: // monthly
                $data = $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
                    ->selectRaw('COUNT(*) as orders')
                    ->selectRaw('SUM(total_amount) as revenue')
                    ->selectRaw('AVG(total_amount) as avg_order_value')
                    ->groupBy('year', 'month')
                    ->orderBy('year')
                    ->orderBy('month')
                    ->get()
                    ->map(function ($item) {
                        $item->period = Carbon::create($item->year, $item->month)->format('F Y');
                        return $item;
                    });
                break;
        }

        return $data->map(function ($item) {
            return [
                'period' => $item->period,
                'orders' => $item->orders,
                'revenue' => number_format($item->revenue ?? 0, 2),
                'avg_order_value' => number_format($item->avg_order_value ?? 0, 2),
            ];
        })->toArray();
    }

    /**
     * Get sales summary statistics.
     */
    private function getSalesSummary(Carbon $startDate, Carbon $endDate): array
    {
        $totalRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $totalOrders = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Previous period comparison
        $periodLength = $endDate->diffInDays($startDate);
        $prevStartDate = $startDate->copy()->subDays($periodLength);
        $prevEndDate = $startDate->copy();

        $prevRevenue = Order::where('status', 'delivered')
            ->whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->sum('total_amount');

        $revenueGrowth = $prevRevenue > 0 ? (($totalRevenue - $prevRevenue) / $prevRevenue) * 100 : 0;

        return [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'avg_order_value' => $avgOrderValue,
            'revenue_growth' => $revenueGrowth,
            'period' => $startDate->format('M d') . ' - ' . $endDate->format('M d, Y'),
        ];
    }
}