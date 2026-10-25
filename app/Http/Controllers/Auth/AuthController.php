<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return Inertia::render('Auth/register2',[
            'name' => session('name'),
        ]);
    }

    public function registerName(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'data.name' => ['required', 'string', 'digits:11', 'regex:/^09[0-9]{9}$/', 'unique:users,name','unique:patients,phone'],
        ]);

        session()->put('name', $data['data']['name']);

        return to_route('registerComplete');
    }

    public function registerPassword(RegisterUserRequest $request,AuthService $service): RedirectResponse
    {
        $data = $request->validated();
        $user = $service->registerUser(session('name'),$data['data']['password']);

//        auth()->login($user);
        $request->session()->regenerate();
        session()->forget('name');

        return redirect('/');
    }

    public function loginComplete(LoginUserRequest $request,AuthService $service): RedirectResponse
    {
        $data = $request->validated();

        $service->loginUser($data['data']['name'],$data['data']['password'],$data['data']['remember']);

        return redirect('/');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return to_route('login');
    }
}
