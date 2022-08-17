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
        $this->loader = new FilesystemLoader(VIEWS_DIR);
        $this->twig = new Environment($this->loader);
    }

    /**
     * Renders a view.
     */
    // protected function render(string $view, array $parameters = [], Response $response = null): Response
    // {
    //     $content = $this->renderView($view, $parameters);

    //     if (null === $response) {
    //         $response = new Response();
    //     }

    //     $response->setContent($content);

    //     return $response;
    // }
}