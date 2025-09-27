@extends('layouts.master')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Orders Management</h1>
    <div class="flex space-x-2">
        <a href="{{ route('admin.dashboard.orders.stats') }}" 
           class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
            View Stats
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

<!-- Filter and Search -->
<div class="bg-white shadow rounded-lg mb-6 p-6">
    <div class="flex flex-wrap gap-4 items-center">
        <div class="flex space-x-2">
            <a href="{{ route('admin.dashboard.orders') }}" 
               class="px-3 py-1 rounded-full text-sm {{ !request('status') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All Orders
            </a>
            <a href="{{ route('admin.dashboard.orders.by-status', 'pending') }}" 
               class="px-3 py-1 rounded-full text-sm {{ request('status') == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Pending
            </a>
            <a href="{{ route('admin.dashboard.orders.by-status', 'confirmed') }}" 
               class="px-3 py-1 rounded-full text-sm {{ request('status') == 'confirmed' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Confirmed
            </a>
            <a href="{{ route('admin.dashboard.orders.by-status', 'delivered') }}" 
               class="px-3 py-1 rounded-full text-sm {{ request('status') == 'delivered' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Delivered
            </a>
        </div>
        
        <form method="GET" action="{{ route('admin.dashboard.orders.search') }}" class="flex-1 min-w-64">
            <div class="relative">
                <input type="text" 
                       name="q" 
                       value="{{ request('q') }}"
                       placeholder="Search by order ID, customer name, or email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $order->orderItems->count() }} item{{ $order->orderItems->count() > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                ₱{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->payment)
                                    @php
                                        $paymentColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'paid' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paymentColors[$order->payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($order->payment->status) }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        No Payment
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}<br>
                                <span class="text-xs">{{ $order->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.dashboard.orders.show', $order) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        View
                                    </a>
                                    <form action="{{ route('admin.dashboard.orders.status', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" 
                                                onchange="this.form.submit()" 
                                                class="text-xs px-2 py-1 border border-gray-300 rounded-md bg-white text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                            <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
    @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if(request('q'))
                    No orders match your search criteria.
                @else
                    No orders have been placed yet.
                @endif
            </p>
        </div>
    @endif
</div>

@if($orders->hasPages())
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
@endif
@endsection