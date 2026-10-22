<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Http\RedirectResponse;
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

    public function registerPassword(RegisterUserRequest $request,RegisterUserAction $action): RedirectResponse
    {
        $data = $request->validated();

        $user = $action->execute(session('name'), $data['data']['password']);
        auth()->login($user, true);
        $request->session()->regenerate();
        session()->forget('name');

        return redirect('/');
    }
}
