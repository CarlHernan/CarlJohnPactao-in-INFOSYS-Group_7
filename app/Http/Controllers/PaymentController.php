<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request)
    {
        $query = Payment::with(['order.user']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('order', function($orderQuery) use ($search) {
                      $orderQuery->where('id', 'like', "%{$search}%")
                                ->orWhereHas('user', function($userQuery) use ($search) {
                                    $userQuery->where('name', 'like', "%{$search}%")
                                             ->orWhere('email', 'like', "%{$search}%");
                                });
                  });
            });
        }

        $payments = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.dashboard.payments', compact('payments'));
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $payment->load(['order.user', 'order.orderItems.product']);
        
        return view('admin.dashboard.payment-details', compact('payment'));
    }

    /**
     * Update the payment status
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed'
        ]);

        $payment->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.dashboard.payments')
            ->with('success', 'Payment status updated successfully.');
    }

    /**
     * Update payment with proof upload
     */
    public function updateWithProof(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,failed',
            'payment_proof' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = ['status' => $request->status];

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($payment->payment_proof) {
                Storage::disk('public')->delete($payment->payment_proof);
            }

            // Store new proof
            $file = $request->file('payment_proof');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('payment-proofs', $filename, 'public');
            $data['payment_proof'] = $path;
        }

        $payment->update($data);

        return redirect()->route('admin.dashboard.payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    /**
     * Get payments statistics
     */
    public function getStats()
    {
        $stats = [
            'total_payments' => Payment::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'paid_payments' => Payment::where('status', 'paid')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
            'total_amount' => Payment::where('status', 'paid')->sum('amount'),
            'today_payments' => Payment::whereDate('created_at', today())->count(),
        ];

        $recentPayments = Payment::with(['order.user'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard.payment-stats', compact('stats', 'recentPayments'));
    }

    /**
     * Get payments by status
     */
    public function getByStatus($status)
    {
        $payments = Payment::with(['order.user'])
            ->where('status', $status)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.dashboard.payments', compact('payments', 'status'));
    }

    /**
     * Download payment proof
     */
    public function downloadProof(Payment $payment)
    {
        if (!$payment->payment_proof || !Storage::disk('public')->exists($payment->payment_proof)) {
            abort(404, 'Payment proof not found.');
        }

        return Storage::disk('public')->download($payment->payment_proof);
    }
}