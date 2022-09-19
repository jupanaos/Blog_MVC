<?php

namespace App\Helpers;

class Security
{
    public static function secureHTML($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }
}