<?php

use App\Http\Middleware\Maintenance;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(Maintenance::class)->group(function (){

    Route::get('/', function () {
        return Inertia::render('Home',[
            'projects' => 'laravel'
        ]);
    });

});
