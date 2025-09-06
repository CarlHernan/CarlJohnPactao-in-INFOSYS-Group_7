<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
   public function index(): JsonResponse
    {
        $products = Product::query()->latest()->paginate(15);
        return response()->json($products);
    }

   public function menus()
    {
        $products = Product::orderByDesc('created_at')->paginate(20);
        return view('admin.dashboard.menus', compact('products'));
    }

   public function orders()
    {
        $orders = collect();
        return view('admin.dashboard.orders', compact('orders'));
    }

   public function create()
    {
        return view('admin.dashboard.create-menu');
    }

   public function store(Request $request)
    {
        if ($request->expectsJson()) {
            $fields = $request->validate([
                'dish_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'is_available' => 'required|boolean',
                'category' => 'required|string|max:100',
                'image_path' => 'required|string',
                'is_featured' => 'sometimes|boolean',
            ]);

            $product = Product::create($fields);
            return response()->json($product, 201);
        }

        $request->validate([
            'dish_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-images', 'public');
        }

        Product::create([
            'dish_name' => $request->dish_name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image_path' => $imagePath,
            'is_available' => $request->has('is_available'),
            'is_featured' => $request->has('is_featured')
        ]);

        return redirect()->route('admin.dashboard.menus')->with('success', 'Menu item created successfully!');
    }

   public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

   public function edit(Product $product)
    {
        return view('admin.dashboard.edit-menu', compact('product'));
    }

   public function update(Request $request, Product $product)
    {
        // Check if request expects JSON (API) or web response
        if ($request->expectsJson()) {
            $fields = $request->validate([
                'dish_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'is_available' => 'required|boolean',
                'category' => 'required|string|max:100',
                'image_path' => 'required|string',
                'is_featured' => 'sometimes|boolean',
            ]);

            $product->update($fields);
            return response()->json($product);
        }

        // Web form validation and handling
        $request->validate([
            'dish_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $updateData = [
            'dish_name' => $request->dish_name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'is_available' => $request->has('is_available'),
            'is_featured' => $request->has('is_featured')
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
            $updateData['image_path'] = $request->file('image')->store('menu-images', 'public');
        }

        $product->update($updateData);

        return redirect()->route('admin.dashboard.menus')->with('success', 'Menu item updated successfully!');
    }

   public function destroy(Product $product)
    {
        // Check if request expects JSON (API) or web response
        if (request()->expectsJson()) {
            $product->delete();
            return response()->json(null, 204);
        }

        // Delete associated image
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('admin.dashboard.menus')->with('success', 'Menu item deleted successfully!');
    }

    public function featured(): JsonResponse
    {
        $featured = Product::where('is_featured', true)->get();
        return response()->json($featured);
    }
}
