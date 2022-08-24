<?php

declare(strict_types=1);

namespace App\Models;

class User
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    // $user->getRoles() === User::ROLE_ADMIN

    private $id;
    private $lastName;
    private $firstName;
    private $username;
    private $email;
    private $createdAt;
    private $updatedAt;

    public function __construct($id, $lastName, $firstName, $username, $email, $password, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->username = $username;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->password = $password;
        
    }

}