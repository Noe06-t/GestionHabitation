<?php

use App\Http\Controllers\HabitantController;
use App\Models\Habitant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificatController;

Route::get('/', function () {
    return view('welcome');
});

//Routes pour les habitants
Route::resource('habitants',HabitantController::class);

//Routes pour les certificats 
Route::resource('certificats', CertificatController::class);