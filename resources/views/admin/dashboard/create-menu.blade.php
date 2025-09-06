<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Add New Menu Item') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-white">{{ __('Menu Item Details') }}</h3>
                    <a href="{{ route('admin.dashboard.menus') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm">{{ __('Back to Menu') }}</a>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.dashboard.menus.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label for="dish_name" class="block text-sm font-medium text-white">Dish Name</label>
                        <input type="text"
                               id="dish_name"
                               name="dish_name"
                               value="{{ old('dish_name') }}"
                               class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-white">Description</label>
                        <textarea id="description"
                                  name="description"
                                  rows="3"
                                  class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-white">Price (₱)</label>
                            <input type="number"
                                   id="price"
                                   name="price"
                                   value="{{ old('price') }}"
                                   step="0.01"
                                   min="0"
                                   class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                   required>
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-white">Category</label>
                            <select id="category"
                                    name="category"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    required>
                                <option value="">Select Category</option>
                                <option value="Main Course" {{ old('category') == 'Main Course' ? 'selected' : '' }}>Main Course</option>
                                <option value="Appetizer" {{ old('category') == 'Appetizer' ? 'selected' : '' }}>Appetizer</option>
                                <option value="Dessert" {{ old('category') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                                <option value="Beverage" {{ old('category') == 'Beverage' ? 'selected' : '' }}>Beverage</option>
                                <option value="Rice" {{ old('category') == 'Rice' ? 'selected' : '' }}>Rice</option>
                                <option value="Soup" {{ old('category') == 'Soup' ? 'selected' : '' }}>Soup</option>
                            </select>
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-white">Image</label>
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/*"
                               class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                               required>
                        <p class="mt-1 text-sm text-gray-400">Accepted formats: JPEG, PNG, JPG, GIF, WebP. Max size: 2MB</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_available"
                                   name="is_available"
                                   value="1"
                                   {{ old('is_available') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-600 rounded bg-gray-700">
                            <label for="is_available" class="ml-2 block text-sm text-white">Available for ordering</label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"
                                   id="is_featured"
                                   name="is_featured"
                                   value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-600 rounded bg-gray-700">
                            <label for="is_featured" class="ml-2 block text-sm text-white">Featured item</label>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.dashboard.menus') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm">Create Menu Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
