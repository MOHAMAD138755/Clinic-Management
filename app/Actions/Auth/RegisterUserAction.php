<?php

namespace App\Actions\Auth;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserAction
{
    public function execute($phone, $password)
    {
        return DB::transaction(function () use ($phone, $password) {
            $user = User::create([
                'name' => 'Patient-' . Str::uuid(),
                'password' => Hash::make($password),
                'email' => 'patient' . Str::uuid() . '@gmail.com',
            ]);

            $user->assignRole('patient');

            Patient::create([
                'phone' => $phone,
                'user_id' => $user->id,
                'full_name' => $user->name,
                'national_code' => Str::random(10),
            ]);

            return $user;
        });
    }
}
