<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Auth required (create must be before {post} wildcard)
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});

// Public show (after create to avoid conflict)
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
