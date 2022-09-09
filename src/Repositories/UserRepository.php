<?php

namespace App\Repositories;

use App\Core\Session;
use App\Models\User;
use PDO;
use stdClass;

class UserRepository extends AbstractRepository
{
    protected $table = 'user';

    /**
     * Get all users
     * return $users
     */

    public function getUsers()
    {
        $users = [];
        $items = $this->findAll();

        foreach($items as $item) {
            $users[] = $this->transform($item);
        }

        return $users;
    }

    public function getUserById($id)
    {
        $user = [];
        $query = $this->prepare('SELECT * FROM user WHERE id =' . '"'.$id.'"');
        $query->execute();

        $items = $query->fetchAll();

        foreach($items as $item) {
            $user[] = $this->transform($item);
        }

        return $user;
    }

    public function findByRole()
    {
        // TO DO
    }

    public function add(User $user)
    {
        $lastName = $user->getLastname();
        $firstName = $user->getFirstname();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        $queryString = 'INSERT INTO user (last_name, first_name, username, email, password, roles)
                        VALUES (:lastname, :firstname, :username, :email, :password, :role)';

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
            return true;
            // SUCCESS FLASH TO DO
        } else {
            return false;
            // FAIL FLASH TO DO
        }
    }

    public function tryLogin()
    {
        $password = strip_tags($_POST['password']);
        $username = strip_tags($_POST['username']);

        $userArray = $this->findItemBy(['username' => $username]);
        $user = new User($userArray);

        /**
         * Check role and password
         */
        if(isset($user)){
            if($userArray['roles'] === 'admin'){
                $user->setRole("admin");
            } else {
                $user->setRole("user");
            }

            if(password_verify($password, $user->getPassword())){
                self::userSession($user);
                var_dump($user);
                var_dump($_SESSION);

                echo "le mot de passe correspond";
            } else {
                echo"le mot de passe ne correspond pas";
            }
        } else {
            echo "le compte n'existe pas";
        }
    }

    /**
     * Creates a user Session
     *
     * @param User $userInfos
     * @return void
     */
    public function userSession(User $userInfos)
    {
        $_SESSION['user'] = $userInfos;
        $_SESSION['loginDate'] = date('d-m-Y H:i:s');
        $_SESSION['logged'] = TRUE;
    }

    public function update(User $user)
    {
        $lastName = $user->getLastname();
        $firstName = $user->getFirstname();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        $queryString = 'UPDATE user SET last_name = :lastname,
                                        first_name = :firstname,
                                        username = :username,
                                        email = :email,
                                        password = :password,
                                        roles = :role
                        WHERE id = :id';

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
            echo "user modifié";
        } else {
            // return false;
            echo "échec modification";
        }
    }

    public function delete(string $userId)
    {
        $queryString = "DELETE FROM user WHERE id=:id";
        $stmt = $this->getInstance()->prepare($queryString);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * Array to object
     *
     * @param array $userArray
     * @return $user
     */
    public function transform(array $userArray) {
        $user = new User($userArray);

        if($userArray['roles'] === 'admin'){
            $user->setRole("admin");
        } else {
            $user->setRole("user");
        }
        return $user;
    }

}