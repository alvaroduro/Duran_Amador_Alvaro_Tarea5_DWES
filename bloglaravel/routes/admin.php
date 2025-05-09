<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\EntradaController;
use App\Http\Controllers\Admin\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::resource('categorias', CategoriaController::class);
Route::resource('usuarios', UsuarioController::class);
Route::resource('entradas', EntradaController::class);