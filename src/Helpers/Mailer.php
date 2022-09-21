<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// $mail = new PHPMailer(true);

class Mailer extends PHPMailer {

    public function __construct($exceptions = null)
    {
        //Server settings
        $this->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $this->isSMTP();                                            //Send using SMTP
        $this->Host       = 'smtp.mailtrap.io';                     //Set the SMTP server to send through
        $this->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->Username   = 'eb30b5e14bdc37';                       //SMTP username
        $this->Password   = 'd4a0a4f4276da9';                       //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $this->Port       = 2525;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        parent::__construct($exceptions);
    }
    
    public function sendMail(array $mailData) {
        try {
            $this->setFrom('no-reply@julie-pariona.com', 'no-reply');
            $this->addAddress('jutest@test.com', 'Julie Pariona');
            $this->addReplyTo($mailData['email'], $mailData['names']);
            // $this->AddBCC($this->config['contact-to']['mail'], $this->config['contact-to']['name']);
            $this->isHTML(true);
            $this->Subject = $mailData['subject'];
            $this->Body = $mailData['message'];
            $this->send();
            // echo 'Message has been sent';
            return true;
        } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$e}";
            return false;
        }
    }
}