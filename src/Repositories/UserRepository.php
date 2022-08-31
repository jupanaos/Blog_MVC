<?php

namespace App\Repositories;

use App\Core\Session;
use App\Models\User;
use PDO;

class UserRepository extends AbstractRepository
{
    protected $table = 'user';

    // add, edit, delete

    public function add(User $user)
    {
        $lastName = $user->getLastname();
        $firstName = $user->getFirstname();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        var_dump($user);
        $queryString = 'INSERT INTO user (last_name, first_name, username, email, password, roles) values (:lastname, :firstname, :username, :email, :password, :role)';

        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(":lastname", $lastName, PDO::PARAM_STR);
        $stmt->bindValue(":firstname", $firstName, PDO::PARAM_STR);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
        $stmt->bindValue(":password", $password, PDO::PARAM_STR);
        $stmt->bindValue(":role", $role, PDO::PARAM_STR);
        $result = $stmt->execute();
        $stmt->closeCursor();

        if ($result > 0) {
            // return true;
            echo "user ajouté";
        } else {
            // return false;
            echo "échec ajout";
        }
        // if(empty($data['lastName']) || empty($data['firstName']) || empty($data['username']) || empty($data['email']) || empty($data['password'])) {
        //     echo "Veuillez remplir tous les champs"; 
        // }

        // if(!preg_match("/^[a-zA-Z0-9]*$/", $data['username'])){
        //     echo "Pseudo invalide";
        // }
    }

    public function tryLogin()
    {
        $password = $_POST['password'];
        $username = $_POST['username'];
        $user = $this->findItemBy(['username' => $username]);
        // var_dump($user);

        // if(isset($user)){
        //     if(password_verify($password, $user->getPassword())){
        //         // $user->setPassword();
        //         $session = new Session;
        //         $session->createSession();
        //         return $user;
        //     } else {
        //         return "le mot de passe ne correspond pas";
        //     }
        // } else {
        //     return "le compte n'existe pas";
        // }
    }

    // public function createSession(User $userInfos)
    // {
    //     $_SESSION['user'] = $userInfos;
    //     $_SESSION['loginDate'] = date('d-m-Y H:i:s');
    //     $_SESSION['logged'] = TRUE;
    // }
}