@extends('layouts.master')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Order Details</h1>
    <a href="{{ route('admin.dashboard.orders') }}" 
       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
        Back to Orders
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Header -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    <div class="flex space-x-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'confirmed' => 'bg-blue-100 text-blue-800',
                                'preparing' => 'bg-orange-100 text-orange-800',
                                'ready' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800'
                            ];
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Order Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('M d, Y h:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($order->orderItems as $item)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                @if($item->product->image_path)
                                    <img class="h-12 w-12 rounded-lg object-cover mr-4" 
                                         src="{{ asset('storage/' . $item->product->image_path) }}" 
                                         alt="{{ $item->product->dish_name }}">
                                @else
                                    <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center mr-4">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->product->dish_name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $item->product->category->name ?? 'No Category' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">₱{{ number_format($item->price, 2) }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                <p class="text-sm font-semibold text-gray-900">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                        <h4 class="text-sm font-medium text-gray-900">{{ $order->user->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    </div>
                </div>
                
                <div class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Customer ID</dt>
                        <dd class="text-sm text-gray-900">#{{ str_pad($order->user->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                        <dd class="text-sm text-gray-900">{{ $order->user->created_at->format('M d, Y') }}</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Actions</h3>
            </div>
            
            <div class="px-6 py-4 space-y-4">
                <!-- Status Update -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Update Status</label>
                    <form action="{{ route('admin.dashboard.orders.status', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                onchange="this.form.submit()">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>

                <!-- Payment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                    <form action="{{ route('admin.dashboard.orders.payment', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="payment_status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                onchange="this.form.submit()">
                            <option value="pending" {{ $order->payment && $order->payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment && $order->payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment && $order->payment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </form>
                </div>

                <!-- Delivery Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Status</label>
                    <form action="{{ route('admin.dashboard.orders.delivery', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="delivery_status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                onchange="this.form.submit()">
                            <option value="pending" {{ $order->delivery && $order->delivery->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="shipped" {{ $order->delivery && $order->delivery->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->delivery && $order->delivery->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Summary</h3>
            </div>
            
            <div class="px-6 py-4">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Subtotal</span>
                        <span class="text-sm font-medium text-gray-900">₱{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Delivery Fee</span>
                        <span class="text-sm font-medium text-gray-900">₱0.00</span>
                    </div>
                    <div class="border-t border-gray-200 pt-2">
                        <div class="flex justify-between">
                            <span class="text-base font-medium text-gray-900">Total</span>
                            <span class="text-base font-semibold text-gray-900">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
