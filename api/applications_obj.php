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

    function _construct($conn){
        //$this->db = $conn;
        $this->table = "applicats_data";
    }

    function submitApplication($db) {
        // check if the number of application is enough
        $select_query = mysqli_query($db,"select *from applicats_data");
        // check if the number of applications is upto 4
        if(mysqli_num_rows($select_query) > 3)
        { // reject application, we have gotten the number of application needed
            return "Appication Closed";
        } else {
             // go ahead and insert application
             $sql = "insert into applicats_data set firstname = '".$this->firstName."', surname = '".$this->surname."',
              phone='".$this->phone."', email='".$this->email."', coverletter_path='".$this->coverLetterPath."', 
             passport_path='".$this->passportPath."', resume_path='".$this->resumePath."'";

            if(mysqli_query($db,$sql)) {
                return "Application submitted successfully.";
            }else {
                return "Could not submit your application, try again later. : ".mysqli_error($db);
            }
        }
    }
}
?>
