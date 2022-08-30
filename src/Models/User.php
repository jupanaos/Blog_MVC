<?php

// declare(strict_types=1);

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
    private $password;
    private $role;
    private $createdAt;
    private $updatedAt;

    public function __construct(array $data = [])
    {
        // $this->id = self::setId($id);
        // $this->lastName = self::setId($lastName);
        // $this->firstName = $firstName;
        // $this->username = $username;
        // $this->email = $email;
        // $this->password = $password;
        // $this->role = $role;
        // $this->createdAt = $createdAt;
        // $this->updatedAt = $updatedAt;
        if (!empty($data)) {
            $this->hydrate($data);
        }
        $this->setDefaultRole();
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = "set".str_replace(' ', '',ucwords(str_replace('_', ' ', $key)));
            if (is_callable(array($this, $method))) {
                $this->$method($value);
            }
            // var_dump($method);
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }


    // public function isAdmin()
    // {
    //     return ($this->roles)=='ADMIN';
    // }

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
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

}