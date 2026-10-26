<?php

namespace App\Actions\Auth;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function execute($phone, $password,$remember)
    {
        $patient = Patient::where('phone',$phone)->first();
        $key = 'login-user: '.Str::lower($phone).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'phone' => "Your phone number or password has expired, {$seconds} seconds ago."
            ]);
        }

        if (!$patient || !Auth::attempt(['id' => $patient->user_id, 'password' => $password], $remember)) {
            RateLimiter::hit($key,200);
            throw ValidationException::withMessages([
                'phone' => 'Phone or password is incorrect',
            ]);
        }

        RateLimiter::clear($key);
        session()->regenerate();
        return Auth::user();
    }
}
