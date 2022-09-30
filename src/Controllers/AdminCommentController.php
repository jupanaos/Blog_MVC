<?php

namespace App\Controllers;

use App\Repositories\CommentRepository;

class AdminCommentController extends AdminController
{
    function __construct() {
        parent::__construct();
    }
    
    public function manageComment($id)
    {
        $commentRepository = new CommentRepository;
        $comment = $commentRepository->getCommentById($id);

        if(!empty($_POST)){
            $comment->setStatus($_POST["status"]);

            if ($commentRepository->updateStatus($comment)) {
                $this->flashMessage->addFlashMessage('success', 'Le statut de ce commentaire a bien été mis à jour.');
            } else {
                $this->flashMessage->addFlashMessage('error', 'Le statut de ce commentaire n\'a pas pu être modifié, veuillez réessayer.');
            }
        }

        $messageFlash = $this->flashMessage->getFlashMessage();
        $this->showTwig('pages/admin/comment/status.html.twig',
                                ['comment' => $comment,
                                'messages' => $messageFlash]);
    }
}