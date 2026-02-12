<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HabitantController;
use App\Http\Controllers\CertificatController;
use App\Http\Controllers\HabitantDashboardController;
use App\Http\Controllers\HabitantAuthController;

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification pour les habitants
Route::get('/habitant/login', [HabitantAuthController::class, 'showLoginForm'])
    ->name('habitant.login');

Route::post('/habitant/login', [HabitantAuthController::class, 'login'])
    ->name('habitant.login.submit');

Route::post('/habitant/logout', [HabitantAuthController::class, 'logout'])
    ->name('habitant.logout');

// Routes pour l'espace habitant (guard: habitant)
Route::middleware(['habitant'])->group(function () {
    Route::get('/habitant/dashboard', [HabitantDashboardController::class, 'index'])
        ->name('habitant.dashboard');
    
    Route::get('/habitant/certificat/{certificat}', [HabitantDashboardController::class, 'show'])
        ->name('habitant.certificat.show');
    
    Route::post('/habitant/certificat/{certificat}/payer', [HabitantDashboardController::class, 'payer'])
        ->name('habitant.certificat.payer');
    
    Route::get('/habitant/payment/success', [HabitantDashboardController::class, 'paymentSuccess'])
        ->name('habitant.payment.success');
});

// Routes pour l'administration (guard: web - admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('habitants', HabitantController::class);
    Route::resource('certificats', CertificatController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

