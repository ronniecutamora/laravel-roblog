<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PostController;

//Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::get('/wa-practice', function() {
    return Inertia::render(
        'Wapractice'
    );
});

require __DIR__.'/posts.php';
