@props([
    'dish_name' => 'Dish Name',
    'price' => 0,
    'description' => '',
    'image_path' => null,
    'product_id' => null,
    'href' => null,
])

@php
    $imgSrc = $image_path ?: asset('images/logo.png');
@endphp

<div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden flex flex-col h-full">
    <div class="relative h-48 bg-gray-100 flex items-center justify-center">
        @if($href)
            <a href="{{ $href }}" class="block w-full h-full">
                <img src="{{ $imgSrc }}" alt="{{ $dish_name }}" class="w-full h-full object-cover">
            </a>
        @else
            <img src="{{ $imgSrc }}" alt="{{ $dish_name }}" class="w-full h-full object-cover">
        @endif
    </div>

    <div class="p-4 flex flex-col h-full">
        <div class="flex justify-between items-start mb-2">
            @if($href)
                <a href="{{ $href }}" class="text-lg font-semibold text-gray-900 line-clamp-1 hover:underline">{{ $dish_name }}</a>
            @else
                <h3 class="text-lg font-semibold text-gray-900 line-clamp-1">{{ $dish_name }}</h3>
            @endif
            <span class="text-emerald-900 font-bold text-lg ml-2">₱{{ number_format($price, 2) }}</span>
        </div>

        <p class="text-sm text-gray-600 mb-4 line-clamp-2 flex-grow">
            {{ $description }}
        </p>

        @if($product_id)
            <form method="POST" action="{{ route('cart.add', $product_id) }}" class="mt-auto">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit"
                        class="w-full bg-green-900 hover:bg-green-800 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 flex items-center justify-center">
                    <span class="mr-2 inline-flex">@include('components.icons.cart')</span>
                    Add to Cart
                </button>
            </form>
        @endif
    </div>
</div>

