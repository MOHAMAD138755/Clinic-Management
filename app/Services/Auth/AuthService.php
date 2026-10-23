<?php

namespace App\Services\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Models\User;

class AuthService
{
    public function __construct(protected RegisterUserAction $registerUserAction)
    {
    }

    public function registerUser($phone,$password): User
    {
        return $this->registerUserAction->execute($phone,$password);
    }

}
