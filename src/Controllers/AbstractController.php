<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Core\Session;
use App\Helpers\TwigGlobals;


abstract class AbstractController
{
    private $loader;
    protected $twig;

    /**
     * Renders a view
     */
    public function __construct()
    {
        $this->loader = new FilesystemLoader(VIEWS_DIR);
        $this->twig = new Environment($this->loader);
        self::addTwigGlobals($this->twig);

        // $this->twig->addGlobal('session', $_SESSION);

        // $sessionGlobals = new Session();
        // $this->twig->addGlobal('session', $sessionGlobals->getSession());
    }

    public function addTwigGlobals($twig) {
        $twigGlobals = new TwigGlobals();
        $twig->addGlobal('session', $twigGlobals->getSession());
        // $twig->addGlobal('admin', $twigGlobals->getAdmin());
        $twig->addGlobal('_post', $_POST);
        $twig->addGlobal('_get', $_GET);
    }

    public function redirectToIndex() {
        header('Location: /');
        exit;
    }

    public function redirectToPrevious() {
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }

    public function redirectToLogin() {
        header('Location: /?p=account');
        exit;
    }

    public function redirectToAdmin() {
        header('Location: /?p=admin');
        exit;
    }

    public function redirectToDashboard() {
        header('Location: /?p=account/dashboard');
        exit;
    }

}