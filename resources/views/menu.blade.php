<x-layout>

    <div class="min-h-screen w-screen overflow-y-auto flex flex-col items-center ">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-12">
            @foreach($menu as $products)
                <x-components.product-card
                    :dish_name="$products->dish_name"
                    :price="$products->price"
                    :description="$products->description"
                    :image_path="asset('storage/' . $products->image_path)"/>
            @endForEach
        </div>
    </div>
</x-layout>
