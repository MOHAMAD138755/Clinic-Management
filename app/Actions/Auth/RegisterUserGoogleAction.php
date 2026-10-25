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
            $user = User::firstOrNew(['google_id' => $googleUser->getId()]);
            if (!$user->exists) {

                $user = User::where('email', $googleUser->getEmail())->first();

                if ($user) {
                    if ($user->google_id && $user->google_id !== $googleUser->getId()) {
                        throw new RuntimeException('User Account exists');
                    }
                    $user->google_id = $googleUser->getId();
                }else {
                    $user = new User();
                    $user->name = $googleUser->getName();
                    $user->email = $googleUser->getEmail();
                    $user->google_id = $googleUser->getId();
                    $user->password = Hash::make(Str::random(15));
                }
                $user->save();
            }

            Patient::firstOrCreate([
                'user_id' => $user->id,
            ],[
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
