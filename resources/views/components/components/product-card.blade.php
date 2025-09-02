<div class="max-w-sm rounded overflow-hidden shadow-md bg-white">
    <!-- Image Section -->
    <div class="bg-gray-800 flex items-center justify-center h-56">
        <img src="{{ $image_path }}" alt="{{ $name }}" class="object-contain h-40">
    </div>

    <!-- Content Section -->
    <div class="p-4">
        <!-- Title + Price -->
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold text-gray-900">{{ $name }}</h2>
            <span class="text-emerald-900 font-bold text-lg">₱{{ number_format($price, 2) }}</span>
        </div>

        <!-- Description -->
        <p class="text-sm text-gray-600">
            {{ Str::limit($description, 80) }}
            <span class="font-semibold text-black">Read More</span>
        </p>
    </div>
</div>
