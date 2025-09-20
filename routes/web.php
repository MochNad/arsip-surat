<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LetterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LetterController::class, 'index'])->name('home');

// Letter routes
Route::resource('letters', LetterController::class);
Route::get('letters/{letter}/download', [LetterController::class, 'download'])->name('letters.download');

// Category routes
Route::resource('categories', CategoryController::class);

// About route
Route::get('/about', [HomeController::class, 'about'])->name('about');
