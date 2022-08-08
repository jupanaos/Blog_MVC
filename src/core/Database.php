<?php

namespace App\Core;
use PDO;
use PDOException;

class Database extends PDO
{
    //unique class instance
    private static $instance;

    private const DB_HOST = 'localhost';
    private const DB_NAME = 'juliepar_blog';
    private const DB_USER = 'root';
    private const DB_PASSWORD = 'root';

    public function __construct()
    {
        $_dsn = 'mysql:dbname='. self::DB_NAME. ';host='. self::DB_HOST;

        try{
            parent::__construct($_dsn, self::DB_USER, self::DB_PASSWORD);
            
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo '<script>console.log("Connexion établie")</script>';
        }catch(PDOException $e){
            die("Erreur:".$e->getMessage());
        }
    }

    //get unique instance
    public static function getInstance()
    {
        //check if the instance exists, if yes it returns it, if not it creates a new database
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
}