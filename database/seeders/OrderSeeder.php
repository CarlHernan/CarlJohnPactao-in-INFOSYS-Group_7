<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Delivery;

class OrderSeeder extends Seeder
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

        // Get some products for the order
        $products = Product::take(2)->get();
        
        if ($products->count() > 0) {
            // Create an order
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total_amount' => 0, // Will be calculated
            ]);

            $totalAmount = 0;

            // Add products to order
            foreach ($products as $product) {
                $quantity = 2; // Fixed quantity for testing
                $itemTotal = $product->price * $quantity;
                $totalAmount += $itemTotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);

            // Create payment for the order
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => 'cod',
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // Create delivery for the order
            Delivery::create([
                'order_id' => $order->id,
                'address' => '123 Test Street, Test City, 1234',
                'status' => 'pending',
                'delivery_date' => now()->addDays(1),
            ]);
        }
    }
}
