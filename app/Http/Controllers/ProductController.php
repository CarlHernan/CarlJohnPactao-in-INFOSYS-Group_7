<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
   public function index(): JsonResponse
    {
        $products = Product::query()->latest()->paginate(15);
        return response()->json($products);
    }

   public function menus()
    {
        $products = Product::with('category')->orderByDesc('created_at')->paginate(20);
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
                'category_id' => 'required|exists:categories,id',
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
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        $imagePath = null;
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            if ($file && $file->isValid()) {
                try {
                    // Use move() instead of store() to avoid path issues
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $storagePath = storage_path('app/public/menu-images');
                    $file->move($storagePath, $filename);
                    $imagePath = 'menu-images/' . $filename;
                } catch (\Exception $e) {
                    return back()->withErrors(['image' => 'Failed to upload image: ' . $e->getMessage()])->withInput();
                }
            } else {
                return back()->withErrors(['image' => 'The uploaded file is not valid.'])->withInput();
            }
        } else {
            return back()->withErrors(['image' => 'Please select an image file.'])->withInput();
        }

        // If no valid image was uploaded, return with error
        if (!$imagePath) {
            return back()->withErrors(['image' => 'Please upload a valid image file.'])->withInput();
        }

        Product::create([
            'dish_name' => $request->dish_name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
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
                'category_id' => 'required|exists:categories,id',
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
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_available' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        $updateData = [
            'dish_name' => $request->dish_name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'is_available' => $request->has('is_available'),
            'is_featured' => $request->has('is_featured')
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            
            if ($file->isValid()) {
                try {
                    // Store old image path before updating
                    $oldImagePath = $product->image_path;
                    
                    // Use move() instead of store() to avoid path issues
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $storagePath = storage_path('app/public/menu-images');
                    $file->move($storagePath, $filename);
                    $imagePath = 'menu-images/' . $filename;
                    
                    $updateData['image_path'] = $imagePath;
                    
                    // Delete old image after successful upload
                    $this->deleteOldImage($oldImagePath);
                    
                } catch (\Exception $e) {
                    return back()->withErrors(['image' => 'Failed to update image: ' . $e->getMessage()])->withInput();
                }
            } else {
                return back()->withErrors(['image' => 'The uploaded file is not valid.'])->withInput();
            }
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

    /**
     * Delete old image from storage when product image is replaced
     */
    private function deleteOldImage($oldImagePath)
    {
        if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            try {
                Storage::disk('public')->delete($oldImagePath);
                return true;
            } catch (\Exception $e) {
                \Log::warning("Failed to delete old image: {$oldImagePath}. Error: " . $e->getMessage());
                return false;
            }
        }
        return true;
    }

}
