<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Users;
use App\Livewire\Categorias;
use App\Livewire\Produtos;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/utilizadores', Users::class)->name('users');
    Route::get('/categorias', Categorias::class)->name('categorias');
    Route::get('/produtos', Produtos::class)->name('produtos');
});
