<?php

namespace App\Actions\Auth;

use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function execute($phone, $password,$remember)
    {
        $patient = Patient::where('phone',$phone)->first();

        if (!$patient || !Auth::attempt(['id' => $patient->user_id, 'password' => $password], $remember)) {
            throw ValidationException::withMessages([
                'phone' => 'Phone or password is incorrect',
            ]);
        }

        session()->regenerate();
        return Auth::user();
    }
}
