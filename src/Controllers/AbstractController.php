<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Helpers\TwigGlobals;

abstract class AbstractController
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(VIEWS_DIR);
        $this->twig = new Environment($this->loader, [
            'debug' => false,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        self::addTwigGlobals($this->twig);
    }
    
    /**
     * Renders a view
     */
    public function showTwig($template, $array) {
        echo $this->twig->render($template, $array);
    }

    public function addTwigGlobals($twig)
    {
        $twigGlobals = new TwigGlobals();
        $twig->addGlobal('session', $twigGlobals->getSession());
        $this->resetFlashMessage();
    }

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
        $sec = "2";
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

    public function addFlashMessage(string $type, string $message)
    {
        $messageFlash[] = [
            'type' => $type,
            'message' => $message,
        ];

        $_SESSION['messagesFlash'] = $messageFlash;
    }

    public function getFlashMessage()
    {
        $messagesFlash = $_SESSION['messagesFlash'];
        return $messagesFlash;
    }

    public function resetFlashMessage() {
        unset($_SESSION['messagesFlash']);
    }
}