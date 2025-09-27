<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Ulam',
                'description' => 'Main dishes and viands',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kanin',
                'description' => 'Rice and rice-based dishes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gulay',
                'description' => 'Vegetable dishes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sabaw',
                'description' => 'Soups and broths',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dessert',
                'description' => 'Sweet treats and desserts',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Beverages',
                'description' => 'Drinks and refreshments',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
