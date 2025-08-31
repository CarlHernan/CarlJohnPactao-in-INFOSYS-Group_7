<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $primaryKey = 'product_id';  // Magsabi sa Eloquent na ang primary key is 'product_id' imbes na 'id'

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_available',
        'category',
        'image_path',
    ];

    protected $casts = [
        'available' => 'boolean', // ensures true/false instead of 1/0
    ];
}
