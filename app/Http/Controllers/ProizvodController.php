<?php

namespace App\Http\Controllers;

use App\Models\Proizvod;
use Illuminate\Http\Request;

class ProizvodController extends Controller
{
    public function index()
    {
        $proizvodi = Proizvod::all();
        return view('admin.proizvodi.index', compact('proizvodi'));
    }

    public function userIndex()
    {
        $proizvodi = Proizvod::all();
        $goriva = Proizvod::whereIn('id', [1, 2, 3, 4, 5])->get();
        return view('dashboard', compact('proizvodi','goriva'));
    }

    public function create()
    {
        return view('admin.proizvodi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'cena' => 'required|numeric|min:0',
            'na_akciji' => 'required|boolean',
            'popust_procenat' => 'nullable|numeric|min:0|max:100',
        ]);

        Proizvod::create($validated);

        return redirect()->route('admin.proizvodi.index')
                         ->with('success', 'Proizvod je uspešno dodat!');
    }

    public function edit(Proizvod $proizvod)
    {
        return view('admin.proizvodi.edit', compact('proizvod'));
    }

    public function update(Request $request, Proizvod $proizvod)
    {
        $validated = $request->validate([
            'naziv' => 'required|string|max:255',
            'cena' => 'required|numeric|min:0',
            'na_akciji' => 'required|boolean',
            'popust_procenat' => 'nullable|numeric|min:0|max:100',
        ]);

        $proizvod->update($validated);

        return redirect()->route('admin.proizvodi.index')
                         ->with('success', 'Proizvod je uspešno ažuriran!');
    }

    public function destroy(Proizvod $proizvod)
    {
        $proizvod->delete();
        return redirect()->route('admin.proizvodi.index')
                         ->with('success', 'Proizvod je obrisan!');
    }
}


