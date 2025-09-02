<?php

namespace App\View\Components\compoZnents;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCard extends Component
{

    public $name, $description, $price, $image_path;
    public function __construct($name, $description, $price, $image_path)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image_path = $image_path;
   }

   public function render(): View|Closure|string
    {
        return view('components.components.product-card');
    }
}
