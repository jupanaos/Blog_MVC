<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(ROOT. '/Views/templates');
        $this->twig = new Environment($this->loader);
    }
}