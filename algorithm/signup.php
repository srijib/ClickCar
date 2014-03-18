<?php
session_start();
include_once"connection.php";

if($_POST['username']){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password2=$_POST['password2'];
    $phone=$_POST['phone'];
    
    
    // secure data for database
    //username
    $username = mysql_real_escape_string($username);
    $username = stripslashes($username);  
    $username = strip_tags($username);
    
    //email
    $email = mysql_real_escape_string($email);
    $email = stripslashes($email);  
    $email = strip_tags($email);
    
    //password
    $password = mysql_real_escape_string($password);
    $password = stripslashes($password);  
    $password = strip_tags($password);
    $password2 = mysql_real_escape_string($password2);
    $password2 = stripslashes($password2);  
    $password2 = strip_tags($password2);
    
    //phone
    $phone = mysql_real_escape_string($phone);
    $phone = stripslashes($phone);  
    $phone = strip_tags($phone);
    
    //Validate Username
    $usernameVal = str_replace(" ","", $username); // remove spaces
    $emailVal = str_replace(" ","", $email);
    $passwordVal = str_replace(" ","", $password);
    $phoneVal = str_replace(" ","", $phone);
    
    // check email & username in db
    $sql_emailCount = mysql_query("SELECT email FROM user WHERE email='$email' LIMIT 1");
    $emailCount = mysql_num_rows($sql_emailCount);
    
    $sql_usernameCount = mysql_query("SELECT username FROM user WHERE username='$username' LIMIT 1");
    $usernameCount = mysql_num_rows($sql_usernameCount);
    
    // check for missing data
    if ((!$usernameVal) || (!$emailVal) || (!$passwordVal) || (!$phoneVal))
    {
        echo'<div id="eMessage">You must fill in all fields.</div>';
    }
    // validate email address format
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        echo'<div id="eMessage">Your email doesn\'t seem to be valid.</div>';
    }
    else if ($usernameCount > 0){
        echo'<div id="eMessage">Your chosen username is already in use, please use another.</div>';
    }
    else if ($emailCount){
        echo'<div id="eMessage">Your email address is already on our records.</div>';
    }
    else if (strlen($username) > 12){
         echo'<div id="eMessage">Your username must be 12 characters or less</div>';
    }  
    else if ($password !== $password2){
        echo'<div id="eMessage">Your passwords don\'t match.</div>';
    }
    else{
        
        // hash password
        $password=md5($password);
        $randomEmailCode = rand(9999,99999);
        $phoneVerification = rand(9999,99999);
        
        // insert value into database
        $sqlInsertUser = mysql_query("INSERT INTO user (username, email, password, phone, phoneCode, emailCode) VALUES('$username', '$email', '$password', '$phone', '$phoneVerification', '$randomEmailCode')") or die (mysql_error("Could not insert data"));
        $insertId = mysql_insert_id(); // get the user id from the record inserted
        
        $_SESSION['tee']="" . $insertId . "";
        
        setcookie("registrationCode", $randomEmailCode); //setup id for rest of pages
        setcookie("id", $id); //setup id for rest of pages
        
       
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
        
        $mail->Subject = 'Activate Your Account';
        $mail->Body    = '
        <h4>Hi ' . $username . '<h4><br>
        <span>First of all, welcome to ClickCar. You may be still in the middle of creating your account. We have sent you this email because we need you to activate your account. <br>
        <h4>Your Code</h4><br>
        <span><b>' . $randomEmailCode . '</b></span>
        <br>
        Just copy the code into the activation page.<br><br>
        Glad to see you on board,<br>
        Kind Regards,<br>
        ClickCar</span>
        ';
        $mail->AltBody = 'Hi ' . $username . ', this is just a quick email to let you know you need to activate. Copy and paste the url or just click on it. <a href="http://samdr.co.uk/clickcar/active.php?u=' . $UserId . '&code=' . $randomEmailCode . '">
        http://samdr.co.uk/clickcar/active.php?u=' . $UserId . '&code=' . $randomEmailCode . '</a>. Glad to see you on board, Kind Regards, ClickCar.';
        
        if(!$mail->send()) {
           echo 'Message could not be sent.';
           echo 'Mailer Error: ' . $mail->ErrorInfo;
           exit;
        }
        //////////////////////\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        
        
    }
}

// script for step 2 of signup
if($_GET['r']==2){ //step 2
    $firstname=$_POST['firstname'];
    $surname=$_POST['surname'];
    $birthDay=$_POST['birthDay'];
    $birthMonth=$_POST['birthMonth'];
    $birthYear=$_POST['birthYear'];
    $gender=$_POST['gender'];
    $addressL1=$_POST['addressL1'];
    $addressL2=$_POST['addressL2'];
    $addressL3=$_POST['addressL3'];
    $postCode=$_POST['postCode'];
    
    
    // secure data for database
    //firstname
    $firstname = mysql_real_escape_string($firstname);
    $firstname = stripslashes($firstname);  
    $firstname = strip_tags($firstname);
    
    //surname
    $surname = mysql_real_escape_string($surname);
    $surname = stripslashes($surname);  
    $surname = strip_tags($surname);
    
    //birth Day
    $birthDay = mysql_real_escape_string($birthDay);
    $birthDay = stripslashes($birthDay);  
    $birthDay = strip_tags($birthDay);
    
    //birth Month
    $birthMonth = mysql_real_escape_string($birthMonth);
    $birthMonth = stripslashes($birthMonth);  
    $birthMonth = strip_tags($birthMonth);
    
    //birth Year
    $birthYear = mysql_real_escape_string($birthYear);
    $birthYear = stripslashes($birthYear);  
    $birthYear = strip_tags($birthYear);
    
    //gender
    $gender = mysql_real_escape_string($gender);
    $gender = stripslashes($gender);  
    $gender = strip_tags($gender);
    
    // address line 1 2 & 3
    $addressL1 = mysql_real_escape_string($addressL1);
    $addressL1 = stripslashes($addressL1);  
    $addressL1 = strip_tags($addressL1);
    $addressL2 = mysql_real_escape_string($addressL2);
    $addressL2 = stripslashes($addressL2);  
    $addressL2 = strip_tags($addressL2);  
    $addressL3 = mysql_real_escape_string($addressL3);
    $addressL3 = stripslashes($addressL3);  
    $addressL3 = strip_tags($addressL3);
    
    // postcode
    $postCode = mysql_real_escape_string($postCode);
    $postCode = stripslashes($postCode);  
    $postCode = strip_tags($postCode);
    
    // validate data formats
    $firstnameVal = str_replace(" ","", $firstname); // remove spaces
    $surnameVal = str_replace(" ","", $surname);
    $addressL1Val = str_replace(" ","", $addressL1);
    $addressL3Val = str_replace(" ","", $addressL3);
    $genderVal = str_replace(" ","", $gender);
    $postCodeVal = str_replace(" ","", $postCode);
    
    if ((!$firstnameVal) || (!$surnameVal) || (!$addressL1Val) || (!$addressL3Val) || (!$postCodeVal))
    {
        echo'<div id="eMessage">You must fill in all fields.</div>';
    }
    else {
        
        // check if postcode is in a valid format
        $postCode = strtoupper(str_replace(' ','',$postCode));
        if(preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/",$postCode) || preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/",$postCode) || preg_match("/^GIR0[A-Z]{2}$/",$postCode))
        {
            $postCodeGood = "true";
        }
        else
        {
           $postCodeGood = "false";
        }
    
        if($postCodeGood == "false"){
            echo'<div id="eMessage">Your post code doesn\'t look correct. <b>e.g AB12 3CD</b></div>';
        }
        else{
            // Construct birthday
            $birthString = '' . $birthYear. '-' . $birthMonth . '-' . $birthDay . '';
            // convert date to timestamp
            // copied from stack overflow http://stackoverflow.com/questions/3776682/php-calculate-age
            $birthdayAge = floor( (strtotime(date('Y-m-d')) - strtotime('' . $birthString . '')) / 31556926);
            
            // check if age is older than 18
            if(($birthdayAge) < 18){
                echo'<div id="eMessage">You must be <b>18</> to join.</div>';
            }
            else
            {
                session_start();
                $userId = $_COOKIE["id"];
                $usercode = $_COOKIE["registrationCode"];
                
                // update data
                $sqlStep2 = mysql_query("UPDATE user SET fName='$firstname', sName='$surname', addressLine1='$addressL1', addressLine2='$addressL2', town='$addressL3', gender='$gender', postcode='$postCode', birthDate='$birthString' WHERE id='$userId' AND emailCode='$usercode'") or die (mysql_error());
                
                // when complete show message to GUI page signup2.php
                echo'...';
               
            }
        }
    }
        
}


// script for step 3 of signup
if($_GET['r']==3){ //step 3
    $interests=$_POST['interests'];
    $pref=$_POST['pref'];
    $regularJourneys=$_POST['regularJourneys'];
    $bio=$_POST['bio'];
  
    // secure data for database
    $interests = mysql_real_escape_string($interests);
    $interests = stripslashes($interests);  
    $interests = strip_tags($interests);
    
    $regularJourneys = mysql_real_escape_string($regularJourneys);
    $regularJourneys = stripslashes($regularJourneys);  
    $regularJourneys = strip_tags($regularJourneys);
    
    $bio = mysql_real_escape_string($bio);
    $bio = stripslashes($bio);  
    $bio = strip_tags($bio);
    
    // validate data formats
    $interestsVal = str_replace(" ","", $interests); // remove spaces
    $bioVal = str_replace(" ","", $bio);
    
    if ((!$interestsVal) || (!$bioVal))
    {
        echo'<div id="eMessage">You must fill in all fields.</div>';
    }
    else
    {
        
         if(empty($pref)) 
          {
             $prefArray = "empty";
          } 
          else
          {
            $prefArray="";
            $N = count($pref);
            for($i=0; $i < $N; $i++)
            {
                $prefArray = '' . $prefArray . ',' . $pref[$i] . '';
            }
          }

        // insert preferences
        session_start();
        $userId = $_COOKIE["id"];
        $usercode = $_COOKIE["registrationCode"];
                
        // update data
        $sqlStep3 = mysql_query("UPDATE user SET interests='$interests', regularJourneys='$regularJourneys', preferences='$prefArray', about='$bio' WHERE id='$userId' AND emailCode='$usercode'") or die (mysql_error());
        
        
        // send conformation text
        
        // collect data
        $getPhoneVerification = mysql_query("SELECT phoneCode FROM user WHERE id='$userId' AND emailCode='$usercode'");
			while($row = mysql_fetch_array($getPhoneVerification))
			{ 
				$phoneCode= $row["phoneCode"];
                $phone= $row["phone"];
            }
        
            
            //Send text
        //mail("" . $phone . "@o2.co.uk", "", "Your activation code is " . $phoneCode . "", "From: ClipCar\r\n");
        
                // when complete show message to GUI page signup3.php

                echo'...';
            
    }
}

?>
