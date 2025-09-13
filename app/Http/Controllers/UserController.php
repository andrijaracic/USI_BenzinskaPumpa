<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Prikaz svih korisnika
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Forma za dodavanje novog korisnika
    public function create()
    {
        return view('admin.users.create');
    }

    // Snimi novog korisnika
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'rola_id' => 'required|integer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rola_id' => $request->rola_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Korisnik je dodat.');
    }

    // Forma za edit korisnika
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update korisnika
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'rola_id' => 'required|integer',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'rola_id' => $request->rola_id,
        ]);

        if ($request->password) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Korisnik je ažuriran.');
    }

    // Brisanje korisnika
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Korisnik je obrisan.');
    }
}
