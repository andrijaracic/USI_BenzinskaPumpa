<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProizvodController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

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

    // Ostale admin rute...
});
