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
        /*$query = $this->prepare('SELECT * FROM '. $this->table .' ORDER BY created_at DESC');
        $query->execute();
        $results = $query->fetchAll();
        return $results;*/

        return $this->findBy([], ['created_at' => 'DESC']);
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        $queryString = sprintf('SELECT * FROM %s', $this->table);
        
        if (0 < count($criteria)) {
            $loop = 0;
            
            foreach($criteria as $key => $value) {
                $queryString = sprintf('%s %s %s = "%s"', $queryString, 0 === $loop ? 'WHERE' : 'AND', $key, $value);

                $loop++;
            }
        }

        if (null !== $orderBy && 0 < count($orderBy)) {
            $loop = 0;

            foreach($orderBy as $key => $value) {
                $queryString = sprintf('%s %s %s %s', $queryString, 0 === $loop ? 'ORDER BY' : ',', $key, $value);

                $loop++;
            } 
        }

        if (null !== $limit) {
            $queryString = sprintf('%s LIMIT %s', $queryString, $limit);
        }

        if (null !== $offset) {
            $queryString = sprintf('%s OFFSET %s', $queryString, $offset);
        }

        $query = $this->prepare($queryString);
        $query->execute();

        return $query->fetchAll();
    }


    public function findItemBy(array $criteria = [], array $orderBy = [], int $offset = null) {
        $item = $this->findBy($criteria, $orderBy, 1, $offset);

        if (!empty($item)) {
            return $item[0];
        } else {
            return false;
        }
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