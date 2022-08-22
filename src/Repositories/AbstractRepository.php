<?php

namespace App\Repositories;
use App\Core\Database;
use Exception;
use PDO;

abstract class AbstractRepository extends Database
{
    protected $table;
    // protected $entity;

    // public function __construct()  {
    //     $this->entity = "\\App\\Models\\".ucfirst($this->table);
    // }

    public function findAll()
    {   
        $query = $this->prepare('SELECT * FROM '. $this->table .' ORDER BY created_at DESC');
        $query->execute();
        $results = $query->fetchAll();
        return $results;
    }

    // function select($sql, $cond=null)
    // {
    //     $result = false;
    //     $this->db = Database::getInstance();
    //     try {
    //         $this->stmt = $this->pdo->prepare($sql);
    //         $this->stmt->execute($cond);
    //         $result = $this->stmt->fetchAll();
    //         return $result;
    //     } catch (Exception $ex) { 
    //         $this->error = $ex->getMessage(); 
    //         return false;
    //     }
    // }

    // public function getAsEntities(array $results) {
    //     $entities = [];
    //     foreach ($results as $result) {
            
    //     }
    //     return $entities;
    // }
}