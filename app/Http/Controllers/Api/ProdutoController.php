<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Exibe a lista de produtos.
     */
    public function index()
    {
        // Recupera todos os produtos do banco de dados
        $produtos = Produto::all();
        // Para este exemplo, vamos retornar JSON.
        // Em uma aplicação real com React, você poderá consumir esses endpoints.
        return response()->json($produtos);
    }

    /**
     * Armazena um novo produto.
     */
    public function store(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome'      => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'estoque'   => 'required|integer|min:0',
        ]);

        // Cria o produto
        $produto = Produto::create($validatedData);

        return response()->json(['message' => 'Produto criado com sucesso!', 'produto' => $produto], 201);
    }

    /**
     * Exclui um produto.
     */
    public function destroy($id)
    {
        $produto = Produto::find($id);

        if (!$produto) {
            return response()->json(['message' => 'Produto não encontrado'], 404);
        }

        $produto->delete();
        return response()->json(['message' => 'Produto excluído com sucesso!'], 200);
    }
}
