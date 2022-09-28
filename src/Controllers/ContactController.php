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
        $mailData['contact-email'] = Security::validateEmail($_POST['contact-email']);
        $mailData['contact-subject'] = Security::secureHTML($_POST['contact-subject']);
        $mailData['contact-message'] = Security::secureHTML(nl2br($_POST['contact-message']));
        
        $mailer = new Mailer;

        if(!empty($_POST)){


            if(!empty($mailData['names']) && !empty($mailData['contact-email']) && !empty($mailData['contact-subject']) && !empty($mailData['contact-message'])){
                if ($mailer->sendMail($mailData)){
                    $this->flashMessage->addFlashMessage('success', 'Message envoyé ! Nous vous répondrons dans les plus brefs délais.');
                } else {
                    $this->flashMessage->addFlashMessage('error', 'Erreur d\'envoi.');
                }
            } else {
                $this->flashMessage->addFlashMessage('error', 'Veuillez remplir tous les champs de contact.');
            }

        }
        
        $messageFlash = $this->flashMessage->getFlashMessage();
        $this->showTwig('pages/client/contact.html.twig',
                                ['messages' => $messageFlash]);
    }

}