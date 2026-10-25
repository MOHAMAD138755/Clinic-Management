<?php

namespace App\Services\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\RegisterDoctorAction;
use App\Actions\Auth\RegisterUserAction;
use App\Actions\Auth\RegisterUserGoogleAction;
use App\Models\User;

class AuthService
{
    public function __construct(protected RegisterUserAction $registerUserAction
        , protected LoginUserAction $loginUserAction
        , protected RegisterUserGoogleAction $registerUserGoogleAction
        , protected RegisterDoctorAction $registerDoctorAction)
    {}

    public function registerUser($phone, $password): User
    {
        return $this->registerUserAction->execute($phone, $password);
    }

    public function loginUser($phone, $password,$remember)
    {
        return $this->loginUserAction->execute($phone, $password,$remember);
    }

    public function registerUserGoogle()
    {
        return $this->registerUserGoogleAction->execute();
    }

    public function registerDoctor($phone, $email, $password, $firstName, $lastName, $medical_system_number, $profile): User
    {
        return $this->registerDoctorAction->execute($phone,$email,$password,$firstName,$lastName,$medical_system_number,$profile);
    }

}
