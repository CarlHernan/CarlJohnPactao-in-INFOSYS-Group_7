<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        // Get a regular user (not admin)
        $user = User::where('is_admin', false)->first();
        
        if (!$user) {
            // Create a regular user if none exists
            $user = User::create([
                'name' => 'Test Customer',
                'email' => 'customer@example.com',
                'password' => bcrypt('password123'),
                'is_admin' => false,
            ]);
        }

        // Create cart for the user
        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        // Get some products to add to cart
        $products = Product::take(3)->get();

        // Add products to cart
        foreach ($products as $index => $product) {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $index + 1, // Different quantities for testing
            ]);
        }
    }
}
