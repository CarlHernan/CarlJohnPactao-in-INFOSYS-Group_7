@extends('layouts.master')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Categories Management</h1>
    <a href="{{ route('admin.dashboard.categories.create') }}" 
       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Add New Category
    </a>
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

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    @if($categories->count() > 0)
        <ul class="divide-y divide-gray-200">
            @foreach($categories as $category)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-sm text-gray-600 mt-1">{{ $category->description }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $category->products_count }} product(s) in this category
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.dashboard.categories.edit', $category) }}" 
                               class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.dashboard.categories.destroy', $category) }}" 
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-center py-8">
            <p class="text-gray-500">No categories found. <a href="{{ route('admin.dashboard.categories.create') }}" class="text-blue-600 hover:text-blue-800">Create your first category</a></p>
        </div>
    @endif
</div>

@if($categories->hasPages())
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endif
@endsection
