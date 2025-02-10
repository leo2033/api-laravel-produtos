<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Grupo de rotas que requer autenticação
Route::middleware(['auth'])->group(function () {
    // Rota para a página de gerenciamento de produtos
    Route::get('/produtos', function () {
        return Inertia::render('Products'); // O componente Products será buscado em resources/js/Pages/Products.jsx
    })->name('produtos');
});

require __DIR__.'/auth.php';
