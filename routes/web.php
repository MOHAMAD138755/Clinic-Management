<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Maintenance;
use Illuminate\Support\Facades\Route;

Route::middleware(Maintenance::class)->group(function (){

        Route::prefix('auth')->middleware(['guest'])->group(function () {
            Route::get('login', [AuthController::class,'login'])->name('login');
            Route::get('register', [AuthController::class,'register'])->name('register');
            Route::get('register/complete', [AuthController::class,'registerComplete'])->name('registerComplete');
            Route::post('register/name', [AuthController::class,'registerName'])->name('registerName');
            Route::post('register/password', [AuthController::class,'registerPassword'])->name('registerPassword');
            Route::post('login/complete', [AuthController::class,'loginComplete'])->name('loginComplete');
        });

});
