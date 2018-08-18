<?php
    class Database {
        private $host="localhost";
        private $username = "root";
        private $password = "";
        private $db_name = "upperlink";
        private $conn;

        // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if($this->conn->connect_error){
                throw new Exception('Failed to connect to database server: ' . $conn->connect_error);
            }
        }catch(Exception $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>