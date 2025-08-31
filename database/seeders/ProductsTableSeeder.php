<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'Adobo',
                'description' => 'Classic pork or chicken stew braised in soy sauce, vinegar, and spices.',
                'price' => 75.00,
                'is_available' => true,
                'category' => 'Ulam',
                'image_path' => 'images/products/adobo.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sinigang na Baboy',
                'description' => 'Pork belly in a sour tamarind broth with vegetables.',
                'price' => 85.00,
                'is_available' => true,
                'category' => 'Ulam',
                'image_path' => 'images/products/sinigang.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kare-Kare',
                'description' => 'Oxtail and vegetables stewed in a peanut sauce, served with bagoong.',
                'price' => 100.00,
                'is_available' => true,
                'category' => 'Ulam',
                'image_path' => 'images/products/kare-kare.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tinola',
                'description' => 'Chicken soup with ginger, papaya, and chili leaves.',
                'price' => 70.00,
                'is_available' => true,
                'category' => 'Ulam',
                'image_path' => 'images/products/tinola.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Laing',
                'description' => 'Taro leaves cooked in coconut milk with chili and dried fish or pork.',
                'price' => 65.00,
                'is_available' => true,
                'category' => 'Ulam',
                'image_path' => 'images/products/laing.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bicol Express',
                'description' => 'Spicy pork cooked in coconut milk with chilies.',
                'price' => 80.00,
                'is_available' => true,
                'category' => 'Ulam',
                'image_path' => 'images/products/bicol-express.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
