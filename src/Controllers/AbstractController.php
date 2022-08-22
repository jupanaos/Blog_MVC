<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


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
    }
}