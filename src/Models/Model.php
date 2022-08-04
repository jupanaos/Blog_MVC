<?php

namespace App\Models;
use App\Core\Database;

class Model extends Database
{
    protected $table;
    private $db; //instance of Database

    public function findAll()
    {   
        //select all from $table, send to query(), with 1 argument so simple request, return query of request, get in $query and fetch all datas from table
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




// class DB {
//   // (A) CONNECT TO DATABASE
//   public $error = "";
//   private $pdo = null;
//   private $stmt = null;
//   function __construct () {
//     try {
//       $this->pdo = new PDO(
//         "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET, 
//         DB_USER, DB_PASSWORD, [
//           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
//         ]
//       );
//     } catch (Exception $ex) { exit($ex->getMessage()); }
//   }

//   // (B) CLOSE CONNECTION
//   function __destruct () {
//     if ($this->stmt!==null) { $this->stmt = null; }
//     if ($this->pdo!==null) { $this->pdo = null; }
//   }

//   // (C) RUN A SELECT QUERY
//   function select ($sql, $cond=null) {
//     $result = false;
//     try {
//       $this->stmt = $this->pdo->prepare($sql);
//       $this->stmt->execute($cond);
//       $result = $this->stmt->fetchAll();
//       return $result;
//     } catch (Exception $ex) { 
//       $this->error = $ex->getMessage(); 
//       return false;
//     }
//   }
// }

// // (D) DATABASE SETTINGS - CHANGE TO YOUR OWN!
// define("DB_HOST", "localhost");
// define("DB_NAME", "juliepar_blog");
// define("DB_CHARSET", "utf8");
// define("DB_USER", "admin-J1");
// define("DB_PASSWORD", "blogadmin!2022");