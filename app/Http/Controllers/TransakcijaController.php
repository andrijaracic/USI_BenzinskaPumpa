<?php

namespace App\Http\Controllers;

use App\Models\Transakcija;
use App\Models\Proizvod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransakcijaController extends Controller
{
    
    
    public function index()
    {
        $transakcije = Transakcija::with('user')->latest()->get();
        return view('admin.transakcije.index', compact('transakcije'));
    }

    public function create()
    {
        $users = User::all();
        $proizvodi = Proizvod::all();
        return view('admin.transakcije.create', compact('proizvodi', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'datum' => 'required|date',
            'stavke.*.proizvod_id' => 'required|exists:proizvod,id',
            'stavke.*.kolicina' => 'required|integer|min:1',
        ]);

        // Kreiraj transakciju
        $transakcija = Transakcija::create([
            'user_id' => $request->user_id,
            'datum' => $request->datum,
        ]);

        // Kreiraj stavke transakcije
        foreach ($request->stavke as $stavka) {
            $transakcija->stavkaTransakcijas()->create([
                'proizvod_id' => $stavka['proizvod_id'],
                'kolicina' => $stavka['kolicina'],
            ]);
        }

        return redirect()->route('admin.transakcije.index')->with('success', 'Transakcija je uspešno kreirana.');
    }

    public function show(Transakcija $transakcija)
    {
        $transakcija->load('stavke.proizvod','user');
        return view('admin.transakcije.show', compact('transakcija'));
    }

    public function edit(Transakcija $transakcija)
    {
        $transakcija->load('stavkaTransakcijas');
        $users = User::all();
        $proizvodi = Proizvod::all();
        return view('admin.transakcije.edit', compact('transakcija','users','proizvodi'));
    }

    public function update(Request $request, Transakcija $transakcija)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'datum' => 'required|date',
            'stavka_transakcija' => 'required|array',
            'stavka_transakcija.*.proizvod_id' => 'required|exists:proizvod,id',
            'stavka_transakcija.*.kolicina' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($data, $transakcija) {
            $transakcija->update([
                'user_id' => $data['user_id'],
                'datum' => $data['datum'],
            ]);

            // obriši stare stavke i snimi nove
            $transakcija->stavkaTransakcijas()->delete();
            foreach ($data['stavka_transakcija'] as $stavka) {
                $transakcija->stavkaTransakcijas()->create($stavka);
            }
        });

        return redirect()->route('admin.transakcije.index')->with('success','Transakcija izmenjena');
    }

    public function destroy(Transakcija $transakcija)
    {
        $transakcija->delete();
        return redirect()->route('admin.transakcije.index')
                        ->with('success','Transakcija obrisana');
    }
}
