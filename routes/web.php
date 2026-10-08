<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Redirect root URL directly to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authenticated CRUD routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ItemController::class, 'index'])->name('dashboard');
    Route::post('/items', [ItemController::class, 'store'])->name('items.store');
    
    // Support both PUT and POST for multipart file uploads via method spoofing
    Route::match(['put', 'post'], '/items/{item}', [ItemController::class, 'update'])->name('items.update');
    
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes (login, register, reset password, etc.)
require __DIR__.'/auth.php';