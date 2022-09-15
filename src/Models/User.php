<?php

// declare(strict_types=1);

namespace App\Models;

class User extends AbstractModel
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    // $user->getRoles() === User::ROLE_ADMIN

    private $lastName;
    private $firstName;
    private $username;
    private $email;
    private $password;
    private $role;
    // private array $comments = [];

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setDefaultRole()
    {
        $this->setRole(self::ROLE_USER);
    }

    public function getLastname()
    {
        return $this->lastName;
    }

    public function setLastname($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getFirstname()
    {
        return $this->firstName;
    }

    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPasswordHash($hashedPassword)
    {
        $this->password = password_hash($hashedPassword, PASSWORD_DEFAULT);
    }

    public function setPassword($password)
    {
        $this->password = $password;
        // $this->setPasswordHash($this->getPassword());
    }

    

}