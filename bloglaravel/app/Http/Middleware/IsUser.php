<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->rol === 'user') {
            return $next($request);
        }

        // Mostramos un mensaje de éxito
        session()->flash('swa1', [
            'icon' => 'danger',
            'tittle' => '¡Error!',
            'text' => 'Acceso no permitido.'
        ]);

        return redirect()->route('home');
    }
    }

