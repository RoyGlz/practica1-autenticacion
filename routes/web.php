<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas generadas por Breeze (autenticación)
require __DIR__.'/auth.php';

// ── Práctica 1: Dashboard con roles ───────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');
});

// ── Práctica 2: CRUD de Posts ──────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('posts', PostController::class);
});