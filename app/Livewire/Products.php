<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{

    public $product;
    public $confirmingProductUpdate = false;

    protected $rules = [
        'product.name' => 'required|string|min:3',
        'product.price' => 'required|numeric|beetween:1,100',
    ];

    use WithPagination;
    public function render()
    {
        $products = Product::paginate(10);
        return view('livewire.products', [
            'products' => $products,
        ]);
    }


}
