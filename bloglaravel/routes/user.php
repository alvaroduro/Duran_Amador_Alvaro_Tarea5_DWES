<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\EntradaController;

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::resource('entradas', EntradaController::class);
});
