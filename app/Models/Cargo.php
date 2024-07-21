<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Cargo extends Model
{
    use HasFactory;
    protected $fillable = ['nome'];

    public function users(): HasMany{
        return $this->hasMany(User::class);
    }
}
