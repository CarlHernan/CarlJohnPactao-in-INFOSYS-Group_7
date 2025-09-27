<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.dashboard.orders', compact('orders'));
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product', 'payment', 'delivery']);
        
        return view('admin.dashboard.order-details', compact('order'));
    }

    /**
     * Update the order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.dashboard.orders')
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Update delivery status
     */
    public function updateDeliveryStatus(Request $request, Order $order)
    {
        $request->validate([
            'delivery_status' => 'required|in:pending,shipped,delivered'
        ]);

        $order->delivery()->updateOrCreate(
            ['order_id' => $order->id],
            ['status' => $request->delivery_status]
        );

        return redirect()->route('admin.dashboard.orders')
            ->with('success', 'Delivery status updated successfully.');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->payment()->updateOrCreate(
            ['order_id' => $order->id],
            ['status' => $request->payment_status]
        );

        return redirect()->route('admin.dashboard.orders')
            ->with('success', 'Payment status updated successfully.');
    }

    /**
     * Get orders statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'confirmed_orders' => Order::where('status', 'confirmed')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
        ];

        $recentOrders = Order::with(['user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard.order-stats', compact('stats', 'recentOrders'));
    }

    /**
     * Get orders by status
     */
    public function getByStatus($status)
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->where('status', $status)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.dashboard.orders', compact('orders', 'status'));
    }

    /**
     * Search orders
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereHas('user', function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->orWhere('id', 'like', "%{$query}%")
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.dashboard.orders', compact('orders', 'query'));
    }
}