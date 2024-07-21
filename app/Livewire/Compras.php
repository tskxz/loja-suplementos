<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Carrinho;
use App\Models\User;
use App\Models\Compra;

use Livewire\WithPagination;

class Compras extends Component
{

    use WithPagination;
    
    public $perPage = 10;
    public $sortField = 'carrinho_id';
    public $sortDirection = 'asc';

    protected $queryString = ['sortField', 'sortDirection'];

    public $rId = null;
    public $isFormOpen = false;
    public $carrinho_id, $user_id, $status;

    public $dId;
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
            $compra = Compra::find($this->dId);
            if ($compra) {
                $compra->delete();
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
                $compra = Compra::find($this->rId);
                if($compra){
                    $this->carrinho_id = $compra->carrinho_id;
                    $this->user_id = $compra->user_id;
                    $this->status = $compra->status;
                }
            }
            $this->isFormOpen = true;
        } catch(\Exception $ex) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function save(){
        $ruleFields = [
            'user_id' => 'required',
            'carrinho_id' => 'required',
            'status' => 'required'
        ];

        $validatedData = $this->validate($ruleFields);
        try {
            $compraQuery = Compra::query();
            if(!empty($this->rId)){
                $compra = $compraQuery->find($this->rId);
                if($compra){
                    $compra->update($validatedData);
                }
            } else {
                $compraQuery->create($validatedData);
            }
            $this->closeFormModal();
        } catch (\Exception $ex ) {
            session()->flash('success', 'Something goes wrong!!');
        }
    }

    public function closeFormModal(){
        $this->isFormOpen = false;
        $this->reset();
    }

    public function render()
    {
        return view('livewire.compras', [
            'records' => Compra::orderBy($this->sortField, $this->sortDirection)
                ->paginate($this->perPage)
        ])->layout('layouts.app');
    }
}
