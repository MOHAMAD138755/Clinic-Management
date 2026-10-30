<?php

namespace App\Actions\Auth;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use RuntimeException;

class RegisterUserGoogleAction
{
    public function execute()
    {
        $googleUser = Socialite::driver('google')->user();

        return DB::transaction(function () use ($googleUser) {

            if (!$googleUser->getEmail() || !($googleUser->user['email_verified'] ?? false)) {
                throw new RuntimeException('Google email is not verified.');
            }

            $user = User::where('google_id', $googleUser->getId())->first();
            if (!$user) {

                $userEmail = User::where('email', $googleUser->getEmail())->first();

                if ($userEmail) {

                    if ($userEmail->google_id && $userEmail->google_id !== $googleUser->getId()) {
                        throw new RuntimeException('User Account exists');
                    }

                    $userEmail->google_id = $googleUser->getId();
                    $userEmail->save();
                    $user = $userEmail;

                } else {
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'google_id' => $googleUser->getId(),
                        'password' => Hash::make(Str::random(32)),
                    ]);
                }
            }

            Patient::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'phone' => Str::random(11),
                'full_name' => $user->name,
                'national_code' => Str::random(10),
            ]);

            if (!$user->hasRole('patient')) {
                $user->assignRole('patient');
            }

            return $user;
        });
    }
}
