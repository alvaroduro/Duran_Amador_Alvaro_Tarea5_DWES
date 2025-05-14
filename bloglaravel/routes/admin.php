<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\EntradaController;
use App\Http\Controllers\Admin\UsuarioController;
use Illuminate\Support\Facades\Route;

// Agrupar todas las rutas bajo el middleware 'is_admin'
Route::middleware('is_admin')->group(function () {
    Route::resource('categorias', CategoriaController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('entradas', EntradaController::class);
    Route::get('usuarios.pdf', [UsuarioController::class, 'exportarPdf'])->name('usuarios.pdf');
});
