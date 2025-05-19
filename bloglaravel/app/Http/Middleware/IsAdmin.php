<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->rol === 'admin') {
            return $next($request);
        }

        session()->flash('swa1', [
            'icon' => 'danger',
            'title' => '¡Error!',
            'text' => 'Acceso no permitido.',
        ]);

        return redirect()->route('home');
    }
}

