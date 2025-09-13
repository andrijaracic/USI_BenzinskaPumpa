<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    // Prikaz login forme
    public function showLoginForm()
    {
        return view('admin.login'); // ovo ćemo kasnije napraviti
    }

    // Logika za login
    public function login(Request $request)
    {
        // validacija inputa
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // pokušaj login-a sa rolom admin
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
            'rola_id' => 1
        ])) {
            // uspešno logovan admin
            return redirect()->route('admin.dashboard');
        }

        // ako nije uspeo login
        return back()->withErrors([
            'email' => 'Email, šifra ili pristup nisu ispravni.'
        ]);
    }

    // Admin dashboard
    public function dashboard()
    {
        return view('admin.dashboard'); // napraviti view
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
