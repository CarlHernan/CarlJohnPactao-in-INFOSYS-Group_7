@extends('layouts.master')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Payment Details</h1>
    <a href="{{ route('admin.dashboard.payments') }}" 
       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Back to Payments
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Payment Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Payment Header -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Payment #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    <div class="flex space-x-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'failed' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Payment Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $payment->created_at->format('M d, Y h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ strtoupper($payment->payment_method) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Amount</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">₱{{ number_format($payment->amount, 2) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Payment ID</dt>
                        <dd class="mt-1 text-sm text-gray-900">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Proof Section -->
        @if($payment->payment_proof)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment Proof</h3>
                </div>
                
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Payment proof uploaded</p>
                                <p class="text-sm text-gray-500">{{ $payment->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.dashboard.payments.download-proof', $payment) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                            Download Proof
                        </a>
                    </div>
                    
                    <!-- Image Preview -->
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" 
                             alt="Payment Proof" 
                             class="max-w-xs rounded-lg shadow-md">
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Payment Proof</h3>
                </div>
                
                <div class="px-6 py-4">
                    <div class="flex items-center">
                        <svg class="h-8 w-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">No payment proof uploaded</p>
                            <p class="text-sm text-gray-500">Customer has not provided payment proof yet</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Related Order Information -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Related Order</h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">
                            Order #{{ str_pad($payment->order->id, 6, '0', STR_PAD_LEFT) }}
                        </h4>
                        <p class="text-sm text-gray-500">{{ $payment->order->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <a href="{{ route('admin.dashboard.orders.show', $payment->order) }}" 
                       class="text-blue-600 hover:text-blue-900 text-sm">
                        View Order Details →
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Order Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($payment->order->status) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Order Total</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">₱{{ number_format($payment->order->total_amount, 2) }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer Information -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">{{ $payment->order->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $payment->order->user->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Customer ID</dt>
                        <dd class="text-sm text-gray-900">#{{ str_pad($payment->order->user->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                        <dd class="text-sm text-gray-900">{{ $payment->order->user->created_at->format('M d, Y') }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Actions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Actions</h3>
            </div>
            
            <div class="px-6 py-4 space-y-4">
                <!-- Status Update -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Payment Status</label>
                    <form action="{{ route('admin.dashboard.payments.status', $payment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                onchange="this.form.submit()">
                            <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </form>
                </div>

                <!-- Upload Payment Proof -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Payment Proof</label>
                    <form action="{{ route('admin.dashboard.payments.update', $payment) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-3">
                            <input type="file" 
                                   name="payment_proof" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <input type="hidden" name="status" value="{{ $payment->status }}">
                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                Upload Proof
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Summary</h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Order Amount</span>
                        <span class="text-sm font-medium text-gray-900">₱{{ number_format($payment->order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Payment Method</span>
                        <span class="text-sm font-medium text-gray-900">{{ strtoupper($payment->payment_method) }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-2">
                        <div class="flex justify-between">
                            <span class="text-base font-medium text-gray-900">Total Paid</span>
                            <span class="text-base font-semibold text-gray-900">₱{{ number_format($payment->amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
