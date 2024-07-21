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
    public $isAddModalOpen = false;
    public $isDeleteModalOpen = false;
    public $deleteProdutoId;

    //form field
    public $isFormOpen = false;
    
    public function mount()
    {
        $this->carrinho = Carrinho::where('user_id', Auth::id())->first();
        if (!$this->carrinho) {
            $this->carrinho = Carrinho::create(['user_id' => Auth::id()]);
        }
    }

    public function openAddModal()
    {
        $this->reset(['produto_id', 'quantidade']);
        $this->isAddModalOpen = true;
        $this->isFormOpen = true;
    }

    public function closeAddModal()
    {
        $this->isAddModalOpen = false;
        $this->isFormOpen = false;
    }

    public function save()
    {
        $this->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);
    
        $produto = Produto::find($this->produto_id);
    
        if ($this->carrinho) {
            if ($this->carrinho->produtos->contains($produto->id)) {
                $this->carrinho->produtos()->updateExistingPivot($produto->id, ['quantidade' => $this->quantidade]);
            } else {
                $this->carrinho->produtos()->attach($produto->id, ['quantidade' => $this->quantidade]);
            }
    
            session()->flash('success', 'Produto adicionado ao carrinho!');
        } else {
            session()->flash('error', 'Carrinho não encontrado.');
        }
    
        $this->closeAddModal();
        $this->mount(); // Recarregue o carrinho
    }

    public function removeProduto($produto_id)
    {
        $this->deleteProdutoId = $produto_id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->deleteProdutoId = null;
    }

    public function deleteProduto()
    {
        if ($this->deleteProdutoId) {
            $this->carrinho->produtos()->detach($this->deleteProdutoId);
            session()->flash('success', 'Produto removido do carrinho!');
        }
        $this->closeDeleteModal();
    }

    public function closeFormModal()
    {
        $this->isFormOpen = false;
        $this->reset();
    }

    public function render()
    {
        $produtos = Produto::orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage);
        $itens = $this->carrinho ? $this->carrinho->produtos : collect();

        return view('livewire.carrinhos', [
            'produtos' => $produtos,
            'itens' => $itens
        ])->layout('layouts.app');
    }
}
