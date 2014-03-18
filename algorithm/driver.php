<?php
session_start();
include_once"connection.php";

// check if user is logged in
if(!$_SESSION['tee']){
    echo'You do not have permission';
}
if($_POST['carMake']){
    $carMake=$_POST['carMake'];
    $carModel=$_POST['carModel'];
    $otherVehicle=$_POST['otherVehicle'];
    $seats=$_POST['seats'];
    $colour=$_POST['colour'];
    $comfort=$_POST['comfort'];
    $licence=$_POST['licence'];
    $insured=$_POST['insured'];
    $mot=$_POST['mot'];
    $tax=$_POST['tax'];
    $registration=$_POST['registration'];
    
    
    // secure data for database
    //car Make
    $carMake = mysql_real_escape_string($carMake);
    $carMake = stripslashes($carMake);  
    $carMake = strip_tags($carMake);
    
    //car Model
    $carModel = mysql_real_escape_string($carModel);
    $carModel = stripslashes($carModel);  
    $carModel = strip_tags($carModel);
    
    //other vehicle input
    $otherVehicle = mysql_real_escape_string($otherVehicle);
    $otherVehicle = stripslashes($otherVehicle);  
    $otherVehicle = strip_tags($otherVehicle);
    
    //seats
    $seats = mysql_real_escape_string($seats);
    $seats = stripslashes($seats);  
    $seats = strip_tags($seats);
    
    //colour
    $colour = mysql_real_escape_string($colour);
    $colour = stripslashes($colour);  
    $colour = strip_tags($colour);
    
    //comfort
    $comfort = mysql_real_escape_string($comfort);
    $comfort = stripslashes($comfort);  
    $comfort = strip_tags($comfort);
    
     //tax mot insurance licence
    $tax = mysql_real_escape_string($tax);
    $tax = stripslashes($tax);  
    $tax = strip_tags($tax);
    $licence = mysql_real_escape_string($licence);
    $licence = stripslashes($licence);  
    $licence = strip_tags($licence);
    $insured = mysql_real_escape_string($insured);
    $insured = stripslashes($insured);  
    $insured = strip_tags($insured);
    $mot = mysql_real_escape_string($mot);
    $mot = stripslashes($mot);  
    $mot = strip_tags($mot);
    
    //reg
    $registration = mysql_real_escape_string($registration);
    $registration = stripslashes($registration);  
    $registration = strip_tags($registration);

    // check for missing data
    if ((!$carMake) || (!$carModel) || (!$seats) || (!$colour) || (!$comfort) || (!$registration))
    {
        echo'<div id="eMessage">You must fill in all fields.</div>';
    }
    else
    {
        $error = "false";
        // check checkboxes
        if($tax!=="tick"){
            $error = "true";
        }
        else if($licence!=="tick"){
            $error = "true";
        }
        else if($insured!=="tick"){
            $error = "true";
        }
        else if($mot!=="tick"){
            $error = "true";
        }
        
        if($error == "true")
        {
            echo'<div id="eMessage">You must have valid a licence, insurance, tax and mot.</div>';
        }
        else
        {
            $userId = $_SESSION['tee'];
            
            // get username for email to user
             $getUsername = mysql_query("SELECT username, email FROM user WHERE id='$userId' LIMIT 1");
                while($row = mysql_fetch_array($getUsername)){  
                $username = $row["username"];
                $email = $row["email"];
                }
            
            // insert details into the database
            $sqlInsertUser = mysql_query("INSERT INTO driver (userId, carMake, carModel, colour, seatNumber, registration, comfort) VALUES('$userId','$carMake', '$carModel', '$colour', '$seats', '$registration', '$comfort')") or die (mysql_error("Could not insert data"));
              // send user to next page
        echo'...';
        

        // Send email for activation
        // script is open source from https://github.com/PHPMailer/PHPMailer
        require 'email/PHPMailerAutoload.php';
        $mail = new PHPMailer;

        $mail->isSMTP();                                      // Set mailer to use SMTP
        /*$mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup server
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'jswan';                            // SMTP username
        $mail->Password = 'secret';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted*/
        
        $mail->From = 'clickcar@samdr.co.uk';
        $mail->FromName = 'Click Car';
        $mail->addAddress('' . $email . '', '' . $username . '');  // Add a recipient
        
        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = 'Driver Registration';
        $mail->Body    = '
        <h4>Hi ' . $username . '<h4><br>
        <span>Congratulations,<br></span>
        You are now a driver. That means that you can offer journeys to passengers.
        <br>
        Please read our terms of use before setting up any journeys.<br><br>
        <span>If you did not register as a driver you should contact us.</span>
        Happy driving,<br>
        Kind Regards,<br>
        ClickCar</span>
        ';
        $mail->AltBody = '<h4>Hi ' . $username . '<h4><br>
        <span>Congratulations,<br></span>
        You are now a driver. That means that you can offer journeys to passengers.
        <br>
        Please read our terms of use before setting up any journeys.<br><br>
        <span>If you did not register as a driver you should contact us.</span>
        Happy driving,<br>
        Kind Regards,<br>
        ClickCar</span>';
        
        if(!$mail->send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit;
        }
        //////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        }
        
}
}
?>