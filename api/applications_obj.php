<?php
class Applicant {
    public $firstName;
    public $surname;
    public $phone;
    public $email;
    public $coverLetterPath;
    public $passportPath;
    public $resumePath;
    public $db;
    public $table;

    private $host="localhost";
    private $username = "root";
    private $password = "";
    private $db_name = "upperlink";
    private $conn;


    function _construct($conn){
        //$this->db = $conn;
        $this->table = "applications";

        $this->conn = null;
 
        try{
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if($this->conn->connect_error){
                throw new Exception('Failed to connect to database server: ' . $conn->connect_error);
            }
        }catch(Exception $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        $this->db = $this->conn;
    }

    function submitApplication($db) {
        // check if the number of application is enough
        $select_query = mysqli_query($db,"select *from ".$this->table);
        // check if the number of applications is upto 4
        if(mysqli_num_rows($select_query) > 3)
        { // reject application, we have gotten the number of application needed
            return "Appication Closed";
        } else {
            // go ahead and insert application
            /* $sql = "insert into ".$this->table ."(firstname, surname, phone, email, coverletter_path, 
            passport_path, resume_path)
            values('".$this->firstName."', '".$this->surname."', '".$this->phone."', '".$this->email."',
            '".$this->coverLetterPath."', '".$this->passportPath."','".$this->resumePath."')"; */

             // go ahead and insert application
             $sql = "insert into ".$this->table ."set firstname = '".$this->firstName."', surname = '".$this->surname."',
              phone='".$this->phone."', email='".$this->email."', coverletter_path='".$this->coverLetterPath."', 
             passport_path='".$this->passportPath."', resume_path='".$this->resumePath."')";

            if(mysqli_query($db,$sql)) {
                return "Application submitted successfully.";
            }else {
                return "Could not submit your application, try again later. : ".mysqli_error($db);
            }
        }
    }
}
?>