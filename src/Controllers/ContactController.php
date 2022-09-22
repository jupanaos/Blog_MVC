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

        if(!empty($_POST)){

            if(!empty($mailData['names']) && !empty($mailData['email']) && !empty($mailData['subject']) && !empty($mailData['message'])){
                if ($mailer->sendMail($mailData)){
                    $this->addFlashMessage('success', 'Message envoyé !');
                } else {
                    $this->addFlashMessage('error', 'Erreur d\'envoi');
                }
            } elseif(empty($mailData['email'])) {
                $this->addFlashMessage('error', 'Merci de remplir votre email.');
            } else {
                $this->addFlashMessage('error', 'Merci de remplir tous les champs.');
            }

        }
        
        $messageFlash = $this->getFlashMessage();
        echo $this->twig->display('pages/client/contact.html.twig',
                                ['messages' => $messageFlash]);
    }

}