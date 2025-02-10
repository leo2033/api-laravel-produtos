<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui você pode registrar rotas de API para seu aplicativo. Essas
| rotas são carregadas pelo RouteServiceProvider dentro de um grupo
| que é atribuído o grupo de middleware "api".
|
*/

// Rota para listar produtos (qualquer usuário autenticado pode visualizar)
Route::middleware('auth:sanctum')->get('/produtos', [ProdutoController::class, 'index']);

// Rotas restritas a administradores (para criar e excluir produtos)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/produtos', [ProdutoController::class, 'store']);
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy']);
});
