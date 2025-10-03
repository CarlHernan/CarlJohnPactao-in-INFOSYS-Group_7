<x-layout>
<div class="min-h-screen" style="background-color: #dddbd9;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 font-poppins">
        <h1 class="text-3xl font-bold text-emerald-900 mb-6 font-merriweather">Your Cart</h1>

        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
        @endif

        @if($items->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <p class="text-gray-600">Your cart is empty.</p>
                <a href="{{ route('menu') }}" class="mt-4 inline-block bg-green-900 hover:bg-green-800 text-white px-4 py-2 rounded transition-colors">Browse Menu</a>
            </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($items as $item)
                        <tr>
                            <td class="px-6 py-4 align-middle">
                                <div class="flex items-center">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded mr-4">
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item['name'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-700 tabular-nums align-middle">₱{{ number_format($item['price'], 2) }}</td>
                            <td class="px-6 py-4 text-center align-middle w-32">
                                <form method="POST" action="{{ route('cart.update', $item['product_id']) }}" class="inline-flex items-center justify-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" max="99" class="w-16 h-9 border rounded px-2 text-center">
                                    <button type="submit" class="text-green-900 hover:text-green-800 whitespace-nowrap">Update</button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900 font-medium tabular-nums align-middle">₱{{ number_format($item['subtotal'], 2) }}</td>
                            <td class="px-6 py-4 text-right align-middle w-28">
                                <form method="POST" action="{{ route('cart.remove', $item['product_id']) }}" class="inline-flex items-center justify-end">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-800">Remove</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                    <div class="flex justify-between text-sm text-gray-700 mb-2">
                        <span>Subtotal</span>
                        <span class="tabular-nums">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-700 mb-4">
                        <span>Delivery</span>
                        <span class="tabular-nums">₱0.00</span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-gray-900 mb-6">
                        <span>Total</span>
                        <span class="tabular-nums">₱{{ number_format($total, 2) }}</span>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('checkout.index') }}" class="block text-center bg-green-900 hover:bg-green-800 text-white px-4 py-2 rounded transition-colors">Proceed to Checkout</a>
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            <button type="submit" class="w-full text-center bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">Clear Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
</x-layout>
