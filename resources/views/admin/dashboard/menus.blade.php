<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Manage Menus') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">{{ __('Menu Items') }}</h3>
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">{{ __('Add Dish') }}</a>
                </div>

                <table class="min-w-full text-sm text-white">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700 text-left text-white">
                            <th class="py-2 pr-4 text-white">ID</th>
                            <th class="py-2 pr-4 text-white">Dish</th>
                            <th class="py-2 pr-4 text-white">Category</th>
                            <th class="py-2 pr-4 text-white">Price</th>
                            <th class="py-2 pr-4 text-white">Available</th>
                            <th class="py-2 pr-4 text-white">Featured</th>
                            <th class="py-2 pr-4 text-white">Updated</th>
                            <th class="py-2 pr-4 text-white">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr class="border-b border-gray-100 dark:border-gray-700 text-white">
                                <td class="py-2 pr-4 text-white">{{ $product->menu_id }}</td>
                                <td class="py-2 pr-4 font-medium text-white">{{ $product->dish_name }}</td>
                                <td class="py-2 pr-4 text-white">{{ $product->category }}</td>
                                <td class="py-2 pr-4 text-white">₱{{ number_format($product->price, 2) }}</td>
                                <td class="py-2 pr-4 text-white">
                                    @if($product->is_available)
                                        <span class="px-2 py-1 bg-green-600 text-white rounded text-xs">Yes</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-white rounded text-xs">No</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-4 text-white">
                                    @if($product->is_featured)
                                        <span class="px-2 py-1 bg-yellow-600 text-white rounded text-xs">★</span>
                                    @endif
                                </td>
                                <td class="py-2 pr-4 text-white text-xs">{{ $product->updated_at->diffForHumans() }}</td>
                                <td class="py-2 pr-4 space-x-2 text-white">
                                    <button class="text-indigo-600 hover:underline text-xs text-white">Edit</button>
                                    <button class="text-red-600 hover:underline text-xs text-white">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-6 text-center text-white">No menu items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 text-white">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
