<?php

namespace App\Core;

class Session
{
    public function __construct()
    {
        $this->createSession();
    }

    public function createSession()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }

    public function destroySession(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE)
        {
            session_destroy();
        }
    }

    public function get(string $key, $default = null)
    {
        $this->createSession();
        if(array_key_exists($key, $_SESSION)){
            return $_SESSION[$key];
        }
        return $default;
    }

    public function set(string $key, $value): void
    {
        $this->createSession();
        $_SESSION[$key] = $value;
    }
}