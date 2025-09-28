@props([
    'dish_name' => 'Dish Name',
    'price' => 0,
    'description' => '',
    'image_path' => null,
])

@php
    $imgSrc = $image_path ?: asset('images/logo.png');
@endphp

{{--Original homepage design--}}

    <div class="max-w-sm mx-8 rounded-xl overflow-hidden shadow-md bg-white h-auto hover:shadow-xl transition-shadow duration-300">
        <div class="bg-gray-800 flex items-center justify-center h-56">
            <img src="{{ $imgSrc }}" alt="{{ $dish_name }}" class="object-contain h-40">
        </div>

        <div class="p-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold text-gray-900">{{ $dish_name }}</h2>
                <span class="text-emerald-900 font-bold text-lg">₱{{ number_format($price, 2) }}</span>
            </div>

            <p class="text-sm text-gray-600">
                {{ Str::limit($description, 80) }}
                <span class="font-semibold text-black">Read More</span>
            </p>
        </div>
    </div>
