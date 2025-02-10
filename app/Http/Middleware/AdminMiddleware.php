<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Trata a requisição e verifica se o usuário é administrador.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado e se o campo 'role' é 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        // Se não for admin, redireciona ou retorna erro (aqui redirecionamos para a home com uma mensagem)
        return redirect('/')->with('error', 'Você não tem permissão para acessar esta área.');
    }
}
