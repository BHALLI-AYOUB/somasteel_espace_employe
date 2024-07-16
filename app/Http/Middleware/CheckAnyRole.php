<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAnyRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && ($user->isRH() || $user->isResponsable())) {
            return $next($request);
        }

        return redirect()->back(); // Redirigez vers une page appropriée si l'utilisateur n'est pas autorisé
    }
}
