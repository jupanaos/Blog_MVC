<?php

namespace App\Helpers;

class Validation
{
    public static function checkPassword()
    {
        $password = $_POST['password'];

        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);

        if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
            return false;
        } else {
            return true;
        }
    }

    public static function checkUsername()
    {
        $username = $_POST['username'];

        $noSpecialChars = preg_match("/^[a-zA-Z0-9]*$/", $username);

        if(!$noSpecialChars) {
            return false;
        } else {
            return true;
        }
    }
}