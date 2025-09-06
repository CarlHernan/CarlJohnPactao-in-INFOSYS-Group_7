<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $table = 'menu';

    protected $primaryKey = 'menu_id';  // Magsabi sa Eloquent na ang primary key is 'product_id' imbes na 'id'

    protected $fillable = [
        'dish_name',
        'description',
        'price',
        'is_available',
        'is_featured',
        'category',
        'image_path',
    ];

    protected $casts = [
        'is_available' => 'boolean', // ensures true/false instead of 1/0
        'is_featured' => 'boolean', //gaya gaya lang
        'price' => 'decimal:2',
    ];

}
