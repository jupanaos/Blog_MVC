<?php

namespace App\Repositories;
use App\Models\User;

class AdminRepository extends AbstractRepository
{
    public function findAdmin(string $admin)
    {
        $admin = [];
        $query = $this->prepare('SELECT * FROM user WHERE roles = "admin" ');
        $query->execute();

        $items = $query->fetchAll();

        foreach($items as $item) {
            $admin[] = $this->transform($item);
        }

        return $admin[0];
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