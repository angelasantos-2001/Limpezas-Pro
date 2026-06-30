<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se o utilizador está autenticado E se é administrador
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request); // Permite avançar para a página
        }

        // Se não for admin, bloqueia o acesso com o erro 403 (Proibido)
        abort(403, 'Acesso não autorizado. Apenas administradores.');
    }
}