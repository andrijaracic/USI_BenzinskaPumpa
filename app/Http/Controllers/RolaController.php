<?php

namespace App\Http\Controllers;

use App\Models\Rola;
use Illuminate\Http\Request;

class RolaController extends Controller
{
    public function index()
    {
        $role = Rola::all();
        return view('admin.rola.index', compact('role'));
    }

    public function create()
    {
        return view('admin.rola.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'naziv_role' => 'required|string|max:255'
        ]);

        Rola::create([
            'naziv_role' => $request->naziv_role
        ]);

        return redirect()->route('admin.rola.index')->with('success', 'Rola uspešno dodata!');
    }

    public function edit(Rola $rola)
    {
        return view('admin.rola.edit', compact('rola'));
    }

    public function update(Request $request, Rola $rola)
    {
        $request->validate([
            'naziv_role' => 'required|string|max:255'
        ]);

        $rola->update([
            'naziv_role' => $request->naziv_role
        ]);

        return redirect()->route('admin.rola.index')->with('success', 'Rola uspešno izmenjena!');
    }

    public function destroy(Rola $rola)
    {
        $rola->delete();
        return redirect()->route('admin.rola.index')->with('success', 'Rola uspešno obrisana!');
    }
}
