<?php

use App\Http\Controllers\DoctorCategoryController;
use App\Http\Controllers\DoctorController;
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
});

require __DIR__.'/auth.php';
