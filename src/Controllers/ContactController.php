<?php

namespace App\Controllers;
use App\Helpers\Security;
use App\Helpers\Mailer;

class ContactController extends AbstractController
{
    public function contact()
    {
        $mailData = [];

        $mailData['names'] = Security::secureHTML($_POST['names']);
        $mailData['email'] = Security::validateEmail($_POST['email']);
        $mailData['subject'] = Security::secureHTML($_POST['subject']);
        $mailData['message'] = Security::secureHTML($_POST['message']);

        $mailer = new Mailer;

        if(!empty($mailData['email'])){
            $mailer->sendMail($mailData);
        } else {
            echo "Merci de remplir tous les champs.";
        }




        echo $this->twig->display('pages/client/contact.html.twig');
    }

}