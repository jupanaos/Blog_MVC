<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_TOTO = 'toto';

    // $user->getRoles() === User::ROLE_ADMIN
}