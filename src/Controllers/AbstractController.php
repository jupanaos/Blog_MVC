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
        // $this->loader = new FilesystemLoader(VIEWS_DIR . '/layouts', 'layouts');
        // $this->twig = new Environment($this->loader);

        $loader = new FilesystemLoader(VIEWS_DIR);
        $loader->addPath(VIEWS_DIR . '/layouts', 'layouts');

        $this->twig = new Environment($this->loader);

        
   
    }

    public function twigRender($layout, $array): ?string {
        return $this->twig->render($layout, $array);
        
    }

    public function render($layout, $array) {
        echo $this->twig->twigRender($layout, $array);
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