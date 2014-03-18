<?php
session_start();
include_once"connection.php";

if($_POST['activeNumber']){
    $activeNumber=$_POST['activeNumber'];
   
    // secure data for database
    //active code
    $activeNumber = mysql_real_escape_string($activeNumber);
    $activeNumber = stripslashes($activeNumber);  
    $activeNumber = strip_tags($activeNumber);
    
    $id = $_COOKIE["id"];
    $usercode = $_COOKIE["registrationCode"];
    
    // check activation code againts user id
    $sqlActivation = mysql_query("SELECT id,emailCode FROM user WHERE id='$id' AND emailCode='$activeNumber' LIMIT 1");
    $activationCount = mysql_num_rows($sqlActivation);
    
    if($activationCount<1){
        echo'<div id="eMessage">You\'re activation code doesn\'t match what\'s on record. Please try again.</div>';
    }
    else
    {
        // update the database
         $sqlActivateUpdate = mysql_query("UPDATE user SET emailCode='0'WHERE id='$id' AND emailCode='$usercode'") or die (mysql_error());
        echo"...";
    }
   
}

?>