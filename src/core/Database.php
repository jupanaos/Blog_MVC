<?php

namespace App\Core;
use PDO;
use PDOException;

class Database extends PDO
{
    //unique class instance
    private static $instance;

    protected $dotenv;
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER ;
    private $DB_PASSWORD;

    public function __construct()
    { 
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
        $dotenv->load();

        $this->DB_HOST = $_ENV['DB_HOST'];
        $this->DB_NAME = $_ENV['DB_NAME'];
        $this->DB_USER = $_ENV['DB_USER'];
        $this->DB_PASSWORD = $_ENV['DB_PASSWORD'];

        $_dsn = 'mysql:dbname='. $this->DB_NAME. ';host='. $this->DB_HOST;

        try{
            parent::__construct($_dsn, $this->DB_USER, $this->DB_PASSWORD);
            
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            $e->getMessage();
            exit();
        }
    }

    /**
     * Check if instance exist and returns it
     *
     * @return Database
     */
    public static function getInstance()
    {
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }
}