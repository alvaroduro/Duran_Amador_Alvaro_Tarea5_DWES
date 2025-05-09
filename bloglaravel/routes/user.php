<?php
use Illuminate\Support\Facades\Route;

Route::get('/',function() {
    return "Hola user";
})->name('dashboard');