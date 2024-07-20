<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;

class Produtos extends Component
{

    public $produtos, $nome, $preco, $quantidade, $produto_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->produtos = Produto::all();
        return view('livewire.produtos');
    }

    public function create(){
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover(){
        $this->isModalOpen = true;
    }

    public function closeModalPopover(){
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->nome = '';
        $this->preco = '';
        $this->quantidade = '';
    }

    public function store(){
        $this->validate([
            'nome' => ['required','min:3'],
            'preco' => ['required','numeric'],
            'quantidade' => ['required','numeric']
        ]);

        Produto::updateOrcreate(['id' => $this->produto_id], [
            'nome' => $this->nome,
            'preco' => $this->preco,
            'quantidade' => $this->quantidade
        ]);

        $this->resetCreateForm();
        $this->closeModalPopover();
        session()->flash('message', 'Produto criado com sucesso!');
    }

    public function edit($id){
        $produto = Produto::findOrFail($id);
        $this->produto_id = $id;
        $this->nome = $produto->nome;
        $this->preco = $produto->preco;
        $this->quantidade = $produto->quantidade;

        $this->openModalPopover();
    }

    public function delete($id){
        Produto::find($id)->delete();
        session()->flash('message', 'Produto deletado com sucesso!');
    }
}
