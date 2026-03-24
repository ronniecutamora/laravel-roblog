<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    // 'Home' maps to resources/js/Pages/Home.svelte
    // The array becomes the component's $props()
    return Inertia::render(
        'Home', [
            'greeting' => 'Hello from Laravel + Svelte!',
        ]
    );
});
