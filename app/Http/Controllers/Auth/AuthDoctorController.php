<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterDoctorRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class AuthDoctorController extends Controller
{
    public function login()
    {

    }

    public function register(): \Inertia\Response
    {
        return Inertia::render('Auth/doctor/register1', []);
    }

    public function registerDoctor(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'data.phone' => ['required', 'string', 'digits:11', "unique:doctors,phone", "unique:users,name", "regex:/^([0-9\s\-\+\(\)]*)$/"],
            'data.password' => ['required', 'string', 'min:6', 'max:15', Password::min(6)->mixedCase()->numbers()->max(15)->symbols()],
            'data.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email' ,'regex:/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[A-Za-z]{2,}$/'],
        ]);

        session()->put([
            'phone' => $data['data']['phone'],
            'email' => $data['data']['email'],
            'password' => Hash::make($data['data']['password']),
        ]);
        return to_route('doctor.registerProfile');
    }

    public function registerProfile(): \Inertia\Response
    {
        return Inertia::render('Auth/doctor/register2', [
            'phone' => session('phone'),
        ]);
    }

    public function registerComplete(RegisterDoctorRequest $request, AuthService $service): RedirectResponse
    {
        $data = $request->validated();

        $service->registerDoctor(session('phone')
            , session('email'), session('password')
            , $data['data']['first_name'], $data['data']['last_name']
            , $data['data']['medical_system_number'], $data['data']['profile']);

        session()->regenerate();
        session()->forget(['phone', 'email', 'password']);
        return redirect('/');
    }
}
