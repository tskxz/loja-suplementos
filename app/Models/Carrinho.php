<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Produto;

class Carrinho extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];


    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    
    public function produtos(): BelongsToMany{
        return $this->belongsToMany(Produto::class, 'carrinho_produto')
        ->withPivot('quantidade')
        ->withTimestamps();
    }
}
