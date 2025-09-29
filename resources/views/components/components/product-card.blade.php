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
            <button onclick="addToCart({{ $product_id }})"
                    class="w-full bg-green-900 hover:bg-green-800 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200 flex items-center justify-center mt-auto">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                    <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z"/>
                </svg>
                Add to Cart
            </button>
        @endif
    </div>
</div>

<script>
function addToCart(productId) {
    // TODO: Implement cart functionality
    alert('Added to cart! (Feature coming soon)');
}
</script>
