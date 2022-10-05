<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Helpers\TwigGlobals;
use App\Helpers\FlashMessage;
use App\Helpers\Redirect;

abstract class AbstractController
{
    private $loader;
    protected $twig;
    protected $flashMessage;
    public $redirect;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(VIEWS_DIR);
        $this->twig = new Environment($this->loader, [
            'debug' => false,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->flashMessage = new FlashMessage();
        $this->redirect = new Redirect();
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
        $this->flashMessage->resetFlashMessage();
    }
}