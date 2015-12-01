<?php

/**
 * Description of Database
 *
 * @author Richie
 */
class Database {

    private $host = 'localhost';
    private $dbname = 'todo';
    // Define the database's own user
    private $user = 'todo1';
    private $pass = 'GmUYPFVCxtenvvNh';
    private $pdo;
    private $stmt;
    private $error;
    
   /**
     * A constructor for the Database class
     */
    public function __construct() {
        
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        }
        // Catch any errors
        
        catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * 
     * @param type $query
     */
    public function query($query) {
        $this->stmt = $this->pdo->prepare($query);
    }

    /**
     * 
     * @param type $param
     * @param type $value
     * @param type $type
     */
    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * 
     * @return type
     */
    public function execute() {
        return $this->stmt->execute();
    }

    /**
     * 
     * @return type
     */
    public function getRow() {
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

}
