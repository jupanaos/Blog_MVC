<?php

namespace App\Repositories;
use App\Core\Database;
use Exception;

abstract class AbstractRepository extends Database
{
    protected $table;
    private $db; //instance of Database

    public function findAll()
    {   
        $query = $this->prepare('SELECT * FROM '. $this->table);
        $query->execute();
        return $query->fetchAll();
        // var_dump($query);
        // echo "le model";
    }

    function select ($sql, $cond=null) {
        $result = false;
        $this->db = Database::getInstance();
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute($cond);
            $result = $this->stmt->fetchAll();
            return $result;
        } catch (Exception $ex) { 
            $this->error = $ex->getMessage(); 
            return false;
        }
    }

    

    // public function query(string $sql, array $attributes = null)
    // {
    //     //get instance of Database
    //     $this->db = Database::getInstance();

    //     //check if there are attributes
    //     if($attributes !== null){
    //         //prepared request
    //         $query = $this->db->prepare($sql);
    //         $query->execute($attributes);
    //         return $query;
    //     }else{
    //         //simple request
    //         return $this->db->query($sql);
    //     }
    // }
}