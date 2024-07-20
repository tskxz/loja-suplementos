<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\WithPagination;

class Categorias extends Component
{

    use WithPagination;

    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];


    // Form Field
    public $rId = null;
    public $isFormOpen = false;
    public $nome;


    // Action
    public $dId = '';
    public $isDeleteModalOpen = false;

    public function sortBy($field){
        $this->sortDirection = $this->sortField === $field ?
            $this->sortDirection = $this->sortDirection == 'asc' ?
            'desc' : 'asc'
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
        try{
            $categoria = Categoria::find($this->dId);
            if($categoria){
                $categoria->delete();
            }
            $this->closeDelete();
            session()->flash('success', 'Record deleted successfully');
        } catch (\Exception $ex){
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function edit($id = null){
        try {
            $this->rId = $id;
            if(!empty($this->rId)){
                $categoria = Categoria::find($this->rId);
                if($categoria){
                    $this->nome = $categoria->nome;
                }
            }
            $this->isFormOpen = true;
        } catch (\Exception $ex){
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function save(){
        $ruleFields = [
            'nome' => 'required',
        ];
        
        $validatedData = $this->validate($ruleFields);
        try {
            $categoriaQuery = Categoria::query();
            if(!empty($this->rId)){
                $categoria = $categoriaQuery->find($this->rId);
                if($categoria){
                    $categoria->update($validatedData);
                } 
            } else {
                $categoriaQuery->create($validatedData);
            }
            $this->closeFormModal();
        } catch (\Exception $ex){
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    public function closeFormModal(){
        $this->isFormOpen = false;
        $this->reset();
    }

    public function render()
    {
        return view('livewire.categorias', [
            'recirds' => Categoria::orderBy($this->sortField, $this->sortDirection)->paginate($this->perPage)
        ])->layout('layouts.app');
    }
}
