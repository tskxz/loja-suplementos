<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Carrinho;

class Produto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'preco', 'stock', 'categoria_id', 'imagem'];

    public function categoria(): BelongsTo{
        return $this->belongsTo(Categoria::class);
    }

    public function carrinhos(): BelongsToMany{
        return $this->belongsToMany(Carrinho::class, 'carrinho_produto')
        ->withPivot('quantidade')
        ->withTimestamps();
    }
}
