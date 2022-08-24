<?php

namespace App\Repositories;

class AdminRepository extends AbstractRepository
{
    public function getAdmin()
    {
        if(ISSET($_POST['login'])){
            if($_POST['username'] != "" || $_POST['password'] != ""){
                $username = $_POST['username'];
                $password = $_POST['password'];
                $query = $this->prepare('SELECT * FROM `user` WHERE `username`=? AND `password`=? AND `roles`= $ROLE_ADMIN');
                $query->execute(array($username,$password));
                $row = $query->rowCount();
                $fetch = $query->fetch();
                if($row > 0) {
                    echo"<h5 class='text-success'>Login successfully</h5>";
                } else{
                    echo"<h5 class='text-danger'>Invalid username or password</h5>";
                }
            }
        }
    }
}