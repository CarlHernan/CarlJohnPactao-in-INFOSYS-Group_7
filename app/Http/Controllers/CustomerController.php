<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(Request $request): View
    {
        $query = User::where('is_admin', false)
            ->withCount(['orders', 'orders as completed_orders_count' => function ($query) {
                $query->where('status', 'delivered');
            }])
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by registration date
        if ($request->has('date_filter') && $request->date_filter) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('created_at', '>=', now()->subYear());
                    break;
            }
        }

        $customers = $query->paginate(20);

        return view('admin.dashboard.customers', compact('customers'));
    }

    /**
     * Display the specified customer profile.
     */
    public function show(User $customer): View
    {
        // Ensure this is not an admin user
        if ($customer->is_admin) {
            abort(404);
        }

        $customer->load([
            'orders' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'orders.orderItems.product',
            'orders.payment',
            'orders.delivery'
        ]);

        // Get payment history
        $payments = Payment::whereHas('order', function ($query) use ($customer) {
            $query->where('user_id', $customer->id);
        })->with('order')->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $stats = [
            'total_orders' => $customer->orders->count(),
            'completed_orders' => $customer->orders->where('status', 'delivered')->count(),
            'pending_orders' => $customer->orders->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])->count(),
            'cancelled_orders' => $customer->orders->where('status', 'cancelled')->count(),
            'total_spent' => $customer->orders->where('status', 'delivered')->sum('total_amount'),
            'average_order_value' => $customer->orders->where('status', 'delivered')->avg('total_amount') ?? 0,
        ];

        return view('admin.dashboard.customer-profile', compact('customer', 'payments', 'stats'));
    }

    /**
     * Display customer statistics page.
     */
    public function stats(): View
    {
        $totalCustomers = User::where('is_admin', false)->count();
        $newCustomersToday = User::where('is_admin', false)->whereDate('created_at', today())->count();
        $newCustomersThisWeek = User::where('is_admin', false)->where('created_at', '>=', now()->subWeek())->count();
        $newCustomersThisMonth = User::where('is_admin', false)->where('created_at', '>=', now()->subMonth())->count();

        $stats = [
            'total_customers' => $totalCustomers,
            'new_today' => $newCustomersToday,
            'new_this_week' => $newCustomersThisWeek,
            'new_this_month' => $newCustomersThisMonth,
        ];

        return view('admin.dashboard.customer-stats', compact('stats'));
    }

    /**
     * Get customer statistics (API method).
     */
    public function getStats(): array
    {
        $totalCustomers = User::where('is_admin', false)->count();
        $newCustomersToday = User::where('is_admin', false)->whereDate('created_at', today())->count();
        $newCustomersThisWeek = User::where('is_admin', false)->where('created_at', '>=', now()->subWeek())->count();
        $newCustomersThisMonth = User::where('is_admin', false)->where('created_at', '>=', now()->subMonth())->count();

        return [
            'total_customers' => $totalCustomers,
            'new_today' => $newCustomersToday,
            'new_this_week' => $newCustomersThisWeek,
            'new_this_month' => $newCustomersThisMonth,
        ];
    }

    /**
     * Search customers.
     */
    public function search(Request $request): View
    {
        $search = $request->get('q', '');
        
        $customers = User::where('is_admin', false)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->withCount(['orders', 'orders as completed_orders_count' => function ($query) {
                $query->where('status', 'delivered');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.dashboard.customers', compact('customers', 'search'));
    }

    /**
     * Deactivate/Activate customer account.
     */
    public function toggleStatus(User $customer): RedirectResponse
    {
        if ($customer->is_admin) {
            return redirect()->back()->with('error', 'Cannot modify admin accounts.');
        }

        // Toggle active status
        $customer->is_active = ! (bool) ($customer->is_active ?? true);
        $customer->save();

        $message = $customer->is_active ? 'Customer account activated.' : 'Customer account deactivated.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Delete customer account.
     */
    public function destroy(User $customer): RedirectResponse
    {
        if ($customer->is_admin) {
            return redirect()->back()->with('error', 'Cannot delete admin accounts.');
        }

        // Delete related data first
        $customer->orders()->delete();
        
        // Delete the customer
        $customer->delete();

        return redirect()->route('admin.dashboard.customers')
            ->with('success', 'Customer account deleted successfully.');
    }
}