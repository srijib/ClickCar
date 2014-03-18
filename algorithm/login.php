<?php
session_start();
include_once"connection.php";

// check if user is already logged in
//if($_SESSION['tee']){
   //  header( 'Location: ./home.php?user=logged' ) ;
//}

if($_POST['carUsername']){
    $carUsername=$_POST['carUsername'];
    $carPassword=$_POST['carPassword'];
    $remember=$_POST['remember'];
    
    
    // secure data for database
    //username
    $carUsername = mysql_real_escape_string($carUsername);
    $carUsername = stripslashes($carUsername);  
    $carUsername = strip_tags($carUsername);
    
    //password
    $carPassword = mysql_real_escape_string($carPassword);
    $carPassword = stripslashes($carPassword);  
    $carPassword = strip_tags($carPassword);
    
    //remember checkbox feature
    $remember = mysql_real_escape_string($remember);
    $remember = stripslashes($remember);  
    $remember = strip_tags($remember);
    
    if ((!$carUsername) || (!$carPassword))
    {
        echo'<div id="eMessage">You are missing a username or password.</div>';
    }
    else{
        
        // ecnrypt password into md5 for database
        $carPassword=md5($carPassword);
        
        // Check login details
        $sqlCheckLogin = mysql_query("SELECT id, email, username, password FROM user WHERE username='$carUsername' AND password='$carPassword' OR email='$carUsername' AND password='$carPassword'LIMIT 1");
        $countLoginSuccess = mysql_num_rows($sqlCheckLogin);
                
               
            
        // display error messages for incorrect login
        if($countLoginSuccess < 1){
            echo'<div id="eMessage">Either your username or password are incorrect.</div>';
        }
        
        else {
            // if login was successfull
            while($row = mysql_fetch_array($sqlCheckLogin))
            { 
                $userId= $row["id"];
            }
           
            
            //create session
            $_SESSION['tee'] = $userId;

            // redirect user
           echo'...';
        }
}
}

   

?>