<?php

namespace App\Helpers;

class FlashMessage
{
    public function addFlashMessage(string $type, string $message)
    {
        $messageFlash[] = [
            'type' => $type,
            'message' => $message,
        ];

        $_SESSION['messagesFlash'] = $messageFlash;
    }

    public function getFlashMessage()
    {
        $messagesFlash = $_SESSION['messagesFlash'];
        return $messagesFlash;
    }

    public function resetFlashMessage() {
        unset($_SESSION['messagesFlash']);
    }
}