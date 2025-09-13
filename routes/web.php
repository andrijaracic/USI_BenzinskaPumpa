<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProizvodController;
use App\Http\Controllers\TransakcijaController;
use App\Models\Proizvod;
use App\Models\Transakcija;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        $proizvodi = Proizvod::all();
        $goriva = Proizvod::whereIn('id', [1, 2, 3, 4, 5])->get();
        $proizvodiNaAkciji = Proizvod::where('na_akciji', true)->get();

        // Dodaj transakcije i ukupne bodove
        $transakcije = Transakcija::with('stavkaTransakcijas.proizvod', 'user')->get();

        $ukupniBodovi = $transakcije->sum(function($t) {
            $ukupnaCena = $t->stavkaTransakcijas->sum(function($stavka) {
                return $stavka->kolicina * $stavka->proizvod->cena;
            });
            return floor($ukupnaCena / 1000) * 20;
        });

        return view('dashboard', compact('proizvodi', 'goriva', 'proizvodiNaAkciji', 'transakcije', 'ukupniBodovi'));
    })->middleware(['auth', 'verified'])->name('dashboard');

});

Route::get('/proizvodi', function() {
    $proizvodi = Proizvod::all();
    return view('proizvodi.index', compact('proizvodi'));
})->name('proizvodi.index');

Route::get('/transakcije', function() {
    $transakcije = Transakcija::all();
    return view('transakcije.index', compact('transakcije'));
})->name('transakcije.index');

// Prikaz login forme
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');

// Submit login forme
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

// Admin dashboard - zaštićeno
Route::get('/admin/dashboard', [AdminLoginController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware('auth');

// Logout
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');



Route::prefix('admin')->group(function() {
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);
});

use App\Http\Middleware\AdminMiddleware;

Route::prefix('admin')->name('admin.')->middleware([AdminMiddleware::class])->group(function () {

    // Dashboard – bez posebnog kontrolera, samo direktno view
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    // CRUD za korisnike
    Route::resource('users', UserController::class);

    
    Route::resource('proizvodi', ProizvodController::class)
    ->parameters(['proizvodi' => 'proizvod']); // <--- ovo rešava tvoj problem

    Route::resource('transakcije', TransakcijaController::class)
     ->parameters(['transakcije' => 'transakcija']);

});
