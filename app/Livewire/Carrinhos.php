<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Carrinho;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;

class Carrinhos extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField = 'nome';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];

    public $carrinho;
    public $produto_id;
    public $quantidade = 1;

    public function mount()
    {
        $this->carrinho = Carrinho::where('user_id', Auth::id())->first();
        if (!$this->carrinho) {
            $this->carrinho = Carrinho::create(['user_id' => Auth::id()]);
        }
    }

    public function addProduto()
    {
        $this->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Produto::find($this->produto_id);

        if ($this->carrinho->produtos->contains($produto->id)) {
            $this->carrinho->produtos()->updateExistingPivot($produto->id, ['quantidade' => $this->quantidade]);
        } else {
            $this->carrinho->produtos()->attach($produto->id, ['quantidade' => $this->quantidade]);
        }

        session()->flash('success', 'Produto adicionado ao carrinho!');
        $this->reset(['produto_id', 'quantidade']);
    }

    public function removeProduto($produto_id)
    {
        $this->carrinho->produtos()->detach($produto_id);
        session()->flash('success', 'Produto removido do carrinho!');
    }

    public function render()
    {
        $produtos = Produto::orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);

        return view('livewire.carrinhos', [
            'produtos' => $produtos,
            'itens' => $this->carrinho->produtos
        ])->layout('layouts.app');
    }
}
