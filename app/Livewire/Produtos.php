<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produto;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Produtos extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $perPage = 10;
    public $sortField = 'nome';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];

    public $rId = null;
    public $isFormOpen = false;
    public $nome, $descricao, $preco, $stock, $categoria_id;
    public $imagem, $newImagem;

    public $dId = '';
    public $isDeleteModalOpen = false;

    public function sortBy($field){
        $this->sortDirection = $this->sortField === $field?
            $this->sortDirection = $this->sortDirection == 'asc'? 'desc' : 'asc'
            : 'asc';
        $this->sortField = $field;
    }

    public function deleteId($id){
        $this->dId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function closeDelete(){
        $this->dId = '';
        $this->isDeleteModalOpen = false;
    }

    public function delete(){
        try {
            $produto = Produto::find($this->dId);
            if ($produto) {
                $produto->delete();
            }
            $this->closeDelete();
            session()->flash('success', 'Record deleted successfully!!');
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function edit($id = null){
        try {
            $this->rId = $id;
            if(!empty($this->rId)){
                $produto = Produto::find($this->rId);
                if($produto){
                    $this->nome = $produto->nome;
                    $this->descricao = $produto->descricao;
                    $this->preco = $produto->preco;
                    $this->stock = $produto->stock;
                    $this->categoria_id = $produto->categoria_id;
                    $this->imagem = $produto->imagem;
                }
            }
            $this->isFormOpen = true;
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function save(){
        $ruleFields = [
            'nome' =>'required',
            'descricao' =>'required',
            'preco' =>'required|numeric',
            'stock' =>'required|numeric',
            'categoria_id' => 'required|exists:categorias,id',
            'newImagem' => 'nullable|image',
        ];

        $validatedData = $this->validate($ruleFields);
        try {
            $produtoQuery = Produto::query();
            if (!empty($this->rId)) {
                $produto = $produtoQuery->find($this->rId);
                if ($produto) {
                    if($this->newImagem){
                        if($produto->imagem){
                            Storage::delete('public/images/' . $produto->imagem);
                        }
                        $validatedData['imagem'] = $this->newImagem->store('images', 'public');
                    }
                    $produto->update($validatedData);
                }
            } else {
                if($this->newImagem){
                    $validatedData['imagem'] = $this->newImagem->store('imagens', 'public');
                }
                $produtoQuery->create($validatedData);
            }
            $this->closeFormModal();
        } catch (\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function closeFormModal(){
        $this->isFormOpen = false;
        $this->reset();
    }


    public function render()
    {
        return view('livewire.produtos', [
            'records' => Produto::orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ])->layout('layouts.app');
    }
}
