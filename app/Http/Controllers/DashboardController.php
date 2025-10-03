<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Orders breakdown
        $ordersByStatus = Order::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $orders = [
            'pending' => (int) ($ordersByStatus['pending'] ?? 0),
            'confirmed' => (int) ($ordersByStatus['confirmed'] ?? 0),
            'preparing' => (int) ($ordersByStatus['preparing'] ?? 0),
            'ready' => (int) ($ordersByStatus['ready'] ?? 0),
            'delivered' => (int) ($ordersByStatus['delivered'] ?? 0),
            'cancelled' => (int) ($ordersByStatus['cancelled'] ?? 0),
        ];

        // Total sales = sum of payments with status 'paid' OR orders delivered
        $totalSales = Payment::where('status', 'paid')->sum('amount');

        // Total customers (non-admin users)
        $totalCustomers = User::where('is_admin', false)->count();

        // Sales last 7 days for mini chart
        $last7 = Order::where('status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as d, SUM(total_amount) as revenue')
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        $chart = [
            'labels' => collect(range(6,0))->map(function ($i) {
                return Carbon::now()->subDays($i)->format('M d');
            })->values(),
            'data' => collect(range(6,0))->map(function ($i) use ($last7) {
                $date = Carbon::now()->subDays($i)->toDateString();
                return (float) ($last7->firstWhere('d', $date)->revenue ?? 0);
            })->values(),
        ];

        return view('dashboard', compact('orders', 'totalSales', 'totalCustomers', 'chart'));
    }
}
