<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\EntradaController;

Route::resource('entradas', EntradaController::class);