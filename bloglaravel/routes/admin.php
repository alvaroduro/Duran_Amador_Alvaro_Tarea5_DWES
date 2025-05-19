<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\EntradaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\LogController;
use Illuminate\Support\Facades\Route;

// Agrupar todas las rutas bajo el middleware 'is_admin'
Route::middleware('is_admin')->group(function () {
    Route::resource('categorias', CategoriaController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('entradas', EntradaController::class);
    Route::resource('logs', LogController::class);
    Route::get('usuarios.pdf', [UsuarioController::class, 'exportarPdf'])->name('usuarios.pdf');
    Route::get('usuarios.buscar', [SearchController::class, 'buscar'])->name('usuarios.buscar');
    Route::get('entradas.buscar', [SearchController::class, 'buscarEntradas'])->name('entradas.buscar');
    Route::post('importar', [UsuarioController::class, 'importarExcel'])->name('importar');
    Route::get('importados', [UsuarioController::class, 'vistaImportados'])->name('importados');
    Route::post('guardar_importados', [UsuarioController::class, 'guardarImportados'])->name('guardarImportados');
    Route::get('logs.pdf', [LogController::class, 'exportarPdf'])->name('logs.pdf');
});
