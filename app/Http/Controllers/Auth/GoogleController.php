<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function index(): RedirectResponse
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])->redirect();
    }

    public function callback(AuthService $service): RedirectResponse
    {
        $user = $service->registerUserGoogle();
        Auth::login($user);

        session()->regenerate();
        return redirect('/');
    }
}
