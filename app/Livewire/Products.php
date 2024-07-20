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

    public function confirmProductAdd()
    {
        $this->reset(['product']);
        $this->confirmingProductUpdate = true;
    }

    public function confirmProductEdit(Product $product){
        $this->resetErrorBag();
        $this->product = $product;
        $this->confirmingProductUpdate = true;
    }

    public function saveProduct(){
        $this->validate();

        if(isset($this->product->id)){
            $this->product->save();
            session()->flash('message', 'Product saved successfully');
        } else {
            Product::create([
                'name' => $this->product->name,
                'price' => $this->product->price,
            ]);
            session()->flash('message', 'Product created successfully');
        }
        $this->confirmingProductUpdate = false;
    }


}
