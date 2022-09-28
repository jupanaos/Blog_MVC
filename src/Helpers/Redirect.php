<?php

namespace App\Helpers;

class Redirect
{
    public function redirectToIndex()
    {
        header('Location: /');
        exit;
    }

    public function redirectToPrevious()
    {
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }

    public function refreshPage()
    {
        $page = $_SERVER['HTTP_REFERER'];
        $sec = "1.5";
        header("Refresh: $sec; url = $page");
    }

    public function redirectToLogin()
    {
        header('Location: /?p=account');
        exit;
    }

    public function redirectToAdmin()
    {
        header('Location: /?p=admin');
        exit;
    }

    public function redirectToDashboard()
    {
        header('Location: /?p=account/dashboard');
        exit;
    }
}