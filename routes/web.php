<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Maintenance;
use Illuminate\Support\Facades\Route;

Route::middleware(Maintenance::class)->group(function (){

        Route::prefix('auth')->middleware(['guest'])->group(function () {
            Route::get('login', [AuthController::class,'login'])->name('login');
        });

});
