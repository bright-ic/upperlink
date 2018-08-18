<?php
// get database connection
include_once 'api/database.php';
 
// instantiate product object
include_once 'api/applications_obj.php';
 
$database = new Database();
$db = $database->getConnection();
 
$applicant = new Applicant($db);
$msg = "";
 
// get posted data
//$data = json_decode(file_get_contents("php://input"));

if(isset($_POST['submit_application'])) {
    $dir = "uploads/";
    $passportUpload = false;
    $resumeUpload = false;

    // set applicants property values
    $applicant->firstName = htmlspecialchars(strip_tags($_POST['firstname']));
    $applicant->surname = htmlspecialchars(strip_tags($_POST['surname']));
    $applicant->phone = htmlspecialchars(strip_tags($_POST['phone']));
    $applicant->email = htmlspecialchars(strip_tags($_POST['email']));
    $applicant->coverLetterPath = htmlspecialchars(strip_tags($_POST['coverletter']));

    // get passport
    $passport_target = $dir . basename($_FILES['passport']['name']);
    $ext = strtolower(pathinfo($passport_target, PATHINFO_EXTENSION));
    // check whether file is image
    $check = getimagesize($_FILES['passport']['tmp_name']);
    if($check !== false)
    {
        // go ahead
        // validate image type and size
        if($ext === 'jpg' && $_FILES['passport']['size'] <= (1000*1000)){
            if(move_uploaded_file($_FILES['passport']['tmp_name'], $passport_target)){
                $applicant->passportPath = $passport_target;
                $passportUpload = true;   
            }
        }else {
            $msg = "Only jpeg format is allowed and picture size max size = 100kb.--- ext: ".$ext. ", size: ".$_FILES['passport']['size'];
        }
    } else {
        $msg = "File is not an image";
    }

    // validate and upload resume
    // get passport
    $resume_target = $dir . basename($_FILES['resume']['name']);
    $ext = strtolower(pathinfo($resume_target, PATHINFO_EXTENSION));
    // validate image type and size
    if(($ext === 'pdf' || $ext === 'doc' || $ext === 'docx') && $_FILES['resume']['size'] <= (1000*2000)){
        if(move_uploaded_file($_FILES['resume']['tmp_name'], $resume_target)){
            $applicant->resumePath = $resume_target;
            $resumeUpload = true;   
        }
    }else {
        $msg = "Only pdf, doc and docx formats are allowed and doc size max size = 2MB.--- ext: ".$ext. ", size: ".$_FILES['resume']['size'];
    }

    // check whether files were uploaded successfully
    if($resumeUpload && $passportUpload) {
        // go ahead insert ito db
        // create applicants file/ insert to db
        $msg = $applicant->submitApplication($db);
    }
    /*TODO:  sanitize user input*/
}// close isset
?>
<!DOCTYPE html>
<html lang="en" class="full-height">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Bright - Freelancer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            {box-sizing: border-box}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Overwrite default styles of hr */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

/* Set a style for the submit/register button */
.registerbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity:1;
}

/* Add a blue text color to links */
a {
  color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
#fomContainer{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    
}
#fomContainer form{
    width:50%;
}
        </style>
    </head>
    <body>
        <main>

        <div id="fomContainer">
        <form action="index.php" method="post" enctype="multipart/form-data">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to Apply an account.</p>
    <p><?php if(isset($msg)) echo $msg; ?> </p>
    <hr>

    <label for="firstname"><b>FirstName</b></label>
    <input type="text" placeholder="Enter firstname" name="firstname" required>
    <label for="email"><b>Surname</b></label>
    <input type="text" placeholder="Enter Surname" name="surname" required>
    <label for="phone"><b>phone</b></label>
    <input type="text" placeholder="Enter phone" name="phone" required>
    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" required>
    <div>
        <label for="email"><b>Cover Leter</b></label>
        <textarea name="coverletter" rows="4" style="width:100%;"></textarea>
    </div>
    <label for="passport"><b>Passport</b></label>
    <input type="file" name="passport" id="passport" required>
    <label for="passport"><b>Resume</b></label>
    <input type="file" name="resume" id="resume" required>
    <hr>

    <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
    <button type="submit" name="submit_application" class="registerbtn">Register</button>
  </div>

  <div class="container signin">
    <p>Already have an account? <a href="#">Sign in</a>.</p>
  </div>
</form>
        </div>
</main>
    </body>
</html>
        <!--Main Navigat
