<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\AuthDoctorController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Middleware\Maintenance;
use Illuminate\Support\Facades\Route;

Route::middleware(Maintenance::class)->group(function () {

    require_once __DIR__ . '/auth.php';
});
