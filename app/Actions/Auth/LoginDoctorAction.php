<?php

namespace App\Actions\Auth;

use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginDoctorAction
{
    public function execute($phone,$password,$email,$remember)
    {
        $doctor = Doctor::where('phone',$phone)->first();
        $key = 'login-doctor: '.Str::lower($phone).'|'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 4)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'phone' => "Your phone number or password or email has expired, {$seconds} seconds ago."
            ]);
        }

        if (!$doctor || !Auth::attempt(['id' => $doctor->user_id, 'password' => $password,'email' => $email], $remember)) {
            RateLimiter::hit($key,200);
            throw ValidationException::withMessages([
                'phone' => 'Phone or password or email is incorrect',
            ]);
        }

        RateLimiter::clear($key);
        session()->regenerate();
        return Auth::user();
    }
}
