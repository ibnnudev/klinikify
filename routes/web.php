<?php

use App\Http\Controllers\DoctorCategoryController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('doctor', DoctorController::class);
    Route::resource('doctor-category', DoctorCategoryController::class);
    Route::resource('patient', PatientController::class);
    Route::resource('medicine', MedicineController::class);
    Route::resource('reservation', ReservationController::class);
    Route::post('reservation/check', [ReservationController::class, 'check'])->name('reservation.check');
});

require __DIR__ . '/auth.php';
