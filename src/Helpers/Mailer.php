<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer extends PHPMailer {

    public function __construct($exceptions = null)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
        $dotenv->load();

        //Server settings
        $this->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $this->isSMTP();                                            //Send using SMTP
        $this->Host       = $_ENV['MAILER_HOST'];                     //Set the SMTP server to send through
        $this->SMTPAuth   = $_ENV['MAILER_SMTP'];                                    //Enable SMTP authentication
        $this->Username   = $_ENV['MAILER_USERNAME'];                        //SMTP username
        $this->Password   = $_ENV['MAILER_PASSWORD'];                      //SMTP password
        $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $this->Port       = $_ENV['MAILER_PORT'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        parent::__construct($exceptions);
    }
    
    public function sendMail(array $mailData) {
        try {
            $this->setFrom('no-reply@julie-pariona.com', 'no-reply');
            $this->addAddress($_ENV['SENDTO_ADDRESS'], $_ENV['SENDTO_NAME']);
            $this->addReplyTo($mailData['contact-email'], $mailData['names']);
            $this->isHTML(true);
            $this->Subject = $mailData['contact-subject'];
            $this->Body = $mailData['contact-message'];
            $this->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}