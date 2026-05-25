<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('role:admin,editor')->name('dashboard');

    Route::resource('posts', PostController::class);

    Route::delete('/attachments/{attachment}', [PostController::class, 'destroyAttachment'])
        ->name('attachments.destroy');
});