<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthDoctorController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::get('register/complete', [AuthController::class, 'registerComplete'])->name('registerComplete');
    Route::post('register/name', [AuthController::class, 'registerName'])->name('registerName');
    Route::post('register/password', [AuthController::class, 'registerPassword'])->name('registerPassword');
    Route::post('login/complete', [AuthController::class, 'loginComplete'])->name('loginComplete');

    Route::get('google', [GoogleController::class, 'index'])->name('google');
    Route::get('google/callback', [GoogleController::class, 'callback'])->name('googleCallback');

    Route::prefix('doctor')->group(function () {
        Route::get('login', [AuthDoctorController::class, 'login'])->name('doctor.login');
        Route::post('login/check', [AuthDoctorController::class, 'loginCheck'])->name('doctorLoginCheck');
        Route::get('register', [AuthDoctorController::class, 'register'])->name('doctor.register');
        Route::get('register/profile', [AuthDoctorController::class, 'registerProfile'])->name('doctor.registerProfile');


        Route::post('register/complete', [AuthDoctorController::class, 'registerComplete'])
            ->name('doctor.registerComplete');
        Route::post('registerDoctor', [AuthDoctorController::class, 'registerDoctor']);
    });
});
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
