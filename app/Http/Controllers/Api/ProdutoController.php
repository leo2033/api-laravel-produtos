<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    // Listar todos os produtos (GET /api/produtos)
    public function index()
    {
        return response()->json(Produto::all(), 200);
    }

    // Criar um novo produto (POST /api/produtos)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
        ]);

        $produto = Produto::create($validatedData);
        return response()->json($produto, 201);
    }

    // Exibir um produto específico (GET /api/produtos/{id})
    public function show($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }
        return response()->json($produto, 200);
    }

    // Atualizar um produto (PUT/PATCH /api/produtos/{id})
    public function update(Request $request, $id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $validatedData = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'sometimes|nullable|string',
            'preco' => 'sometimes|required|numeric',
        ]);

        $produto->update($validatedData);
        return response()->json($produto, 200);
    }

    // Deletar um produto (DELETE /api/produtos/{id})
    public function destroy($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $produto->delete();
        return response()->json(['message' => 'Produto removido'], 200);
    }
}
