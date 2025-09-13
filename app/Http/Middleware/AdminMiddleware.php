<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Provera da li je korisnik prijavljen i da li je admin
        if (Auth::check() && Auth::user()->rola_id == 1) {
            return $next($request);
        }

        // Ako nije admin, logout i preusmeri na admin login
        Auth::logout();
        return redirect()->route('admin.login')->withErrors(['email' => 'Nemate pristup admin panelu.']);
    }
}
