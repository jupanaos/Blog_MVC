<?php

namespace App\Models;
use App\Core\Database;

class Model extends Database
{
    protected $table;
    private $db; //instance of Database

    public function findAll()
    {   
        $query = $this->query('SELECT * FROM '. $this->table);
        return $query->fetchAll();
    }

    public function query(string $sql, array $attributes = null)
    {
        //get instance of Database
        $this->db = Database::getInstance();

        //check if there are attributes
        if($attributes !== null){
            //prepared request
            $query = $this->db->prepare($sql);
            $query->execute($attributes);
            return $query;
        }else{
            //simple request
            return $this->db->query($sql);
        }
    }
}