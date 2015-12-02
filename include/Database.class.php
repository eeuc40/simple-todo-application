<?php
/*
 * The MIT License
 *
 * Copyright 2015 Richie.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Description of Database
 *
 * @author Richie
 */
class Database {

    private $host = 'localhost';
    private $dbname = 'DATABASE_NAME';
    // Define the database's own user
    private $user = 'DATABASE_USER';
    private $pass = 'DATABASE_PASSWORD';
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
