<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Products extends Component
{

    use WithPagination;
    public function render()
    {
        $products = Product::paginate(10);
        return view('livewire.products', [
            'products' => $products,
        ]);
    }
}
