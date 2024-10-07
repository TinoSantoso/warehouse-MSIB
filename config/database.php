<?php
require_once 'constants.php';

class Database{
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // Use constants to set the database credentials
        $this->host = DB_HOST;
        $this->port = DB_PORT;
        $this->db_name = DB_DATABASE;
        $this->username = DB_USERNAME;
        $this->password = DB_PASSWORD;
    }
    public function getConnection(){
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;port=$this->port", $this->username, $this->password);
            $this->conn->exec("set names utf8");
            
        } catch (\Throwable $err) {
            echo "Connection failed: " . $err->getMessage();
        }

        return $this->conn;
    }
}
?>