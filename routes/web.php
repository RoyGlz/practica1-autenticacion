<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas de Autenticación de Laravel Breeze (Login, Register, etc.)
require __DIR__.'/auth.php';

// Rutas protegidas (solo usuarios autenticados)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard protegido con rol
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

});