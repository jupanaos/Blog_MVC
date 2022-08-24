<?php

namespace App\Controllers;

class ContactController extends AbstractController
{
    public function contact()
    {
        echo $this->twig->display('pages/contact.html.twig');
    }

}