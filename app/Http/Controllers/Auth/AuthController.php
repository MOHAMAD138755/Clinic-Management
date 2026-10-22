<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login(): \Inertia\Response
    {
        return Inertia::render('Auth/login',[]);
    }

    public function register(): \Inertia\Response
    {
        return Inertia::render('Auth/register1',[]);
    }

    public function registerComplete(): \Inertia\Response
    {
        return Inertia::render('Auth/register2',[]);
    }
}
