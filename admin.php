<?php
// get database connection
include_once 'api/database.php';
 
// instantiate product object
include_once 'api/applications_obj.php';
 
$database = new Database();
$db = $database->getConnection();
 
$applicant = new Applicant($db);
$msg = "";
 
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
input[type=text], input[type=email] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

textarea {
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
td th{
    width:20%;
}
        </style>
    </head>
    <body>
        <main>

        <div id="fomContainer">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
                <tr>
                    <?php
                        $query = $applicant->viewApplications($db);
                        while($row = mysqli_fetch_assoc($query)){
                            echo "<td>".$row['firstname']." ". $row['surname'] ."</td>
                            <td>".$row['phone']." ". $row['phone'] ."</td>
                            <td>".$row['email']." ". $row['email'] ."</td>";
                        }
                    ?>
                    
                </tr>
            </table>
        </div>
</main>
    </body>
</html>
        <!--Main Navigat
