<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterDoctorAction
{
    public function execute($phone, $email, $password, $firstName, $lastName, $medical_system_number, $profile)
    {
        return DB::transaction(function () use ($phone, $email, $password, $firstName, $lastName, $medical_system_number, $profile) {

            $image = Storage::disk('public')->putFile('doctors', $profile);
            $user = User::create([
                'name' => $phone,
                'email' => $email,
                'password' => $password,
            ]);

            $user->doctor()->create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'medical_system_number' => $medical_system_number,
                'profile' => $image,
                'phone' => $phone,
            ]);

            $user->assignRole('doctor');

            return $user;
        });
    }
}
