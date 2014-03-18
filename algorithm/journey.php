<?php
session_start();
include_once"connection.php";

// check if user is logged in
if(!$_SESSION['tee']){
    echo'You do not have permission';
}
else
{
if($_POST['end']){
    $end=$_POST['end'];
    $start=$_POST['start'];
    $passingPlaces1=$_POST['passingPlaces1'];
    $passingPlaces2=$_POST['passingPlaces2'];
    $passingPlaces3=$_POST['passingPlaces3'];
    $maxDetour=$_POST['maxDetour'];
    $distance=$_POST['distance'];
    $dateLeaving=$_POST['dateLeaving'];
    $timeLeavingHours=$_POST['timeLeavingHours'];
    $timeLeavingMins=$_POST['timeLeavingMins'];
    
    // secure data for database
    //journey destination
    $end = mysql_real_escape_string($end);
    $end = stripslashes($end);  
    $end = strip_tags($end);
    
    //journey start
    $start = mysql_real_escape_string($start);
    $start = stripslashes($start);  
    $start = strip_tags($start);
    
    //passing Places
    $passingPlaces1 = mysql_real_escape_string($passingPlaces1);
    $passingPlaces1 = stripslashes($passingPlaces1);  
    $passingPlaces1 = strip_tags($passingPlaces1);
    $passingPlaces2 = mysql_real_escape_string($passingPlaces2);
    $passingPlaces2 = stripslashes($passingPlaces2);  
    $passingPlaces2 = strip_tags($passingPlaces2);
    $passingPlaces3 = mysql_real_escape_string($passingPlaces3);
    $passingPlaces3 = stripslashes($passingPlaces3);  
    $passingPlaces3 = strip_tags($passingPlaces3);
    
    //max detour
    $maxDetour = mysql_real_escape_string($maxDetour);
    $maxDetour = stripslashes($maxDetour);  
    $maxDetour = strip_tags($maxDetour);
    
    // distance
    $distance = mysql_real_escape_string($distance);
    $distance = stripslashes($distance);  
    $distance = strip_tags($distance);
    
    // contruct key places variable
    $keyPlaces = "";
    $keyPlaces = '{' . $passingPlaces1 . '},{' . $passingPlaces2 . '},{' . $passingPlaces3 . '';
    
    // construct a journey reference
    $cutStart = substr($start, 0, 3);
    $cutEnd = substr($end, 0, 3);
    $randomSelection = rand ('101','9999');
    
    $journeyRef = '' . $cutStart . '' . $randomSelection . '' . $cutEnd . '';
    
    // capitalise journey ref
    $jRef = strtoupper($journeyRef);
    //echo $jRef;

    // construct time
    $timeLeaving = '' . $timeLeavingHours . ':' . $timeLeavingMins . '';
    
    //construct date
    $dateLeaving = date("Y,m,d", strtotime($dateLeaving));
    
    // check for missing data
    if ((!$start) || (!$end) || (!$maxDetour) || (!$dateLeaving) || (!$timeLeaving))
    {
        echo'<div id="eMessage">You must have a destination and departure location</div>';
    }
    else if(!$distance){
        echo'<div id="eMessage">Click Map route to calculate a distance.</div>';
    }
    else
    {
        $userId = $_SESSION['tee']; //user session
        
        // check user is a driver
        $driverCheck = mysql_query("SELECT userId FROM driver WHERE userId='$userId' LIMIT 1");
        $countDriver = mysql_num_rows($driverCheck);
        
        if($countDriver < 1){
            echo'<div id="eMessage">You need to apply to be a driver. Apply <a href="./driver">here</a></div>';
        }
        else
        {
            // enter journey details into database
            $sqlInsertJourney = mysql_query("INSERT INTO userJourney (user, journeyRef, end, start, distance, detour, places, dateLeaving, timeLeaving) VALUES('$userId','$jRef','$end', '$start', '$distance', '$maxDetour', '$keyPlaces','$dateLeaving','$timeLeaving')") or die (mysql_error("Could not insert data"));
            echo'...';
        }
     }
}
}
if($_POST['priceTweak']){
    $luggage=$_POST['luggage'];
    $seats=$_POST['seats'];
    $priceTweak=$_POST['priceTweak'];
    
    // check price
    $priceTweak = mysql_real_escape_string($priceTweak);
    $priceTweak = stripslashes($priceTweak);  
    $priceTweak = strip_tags($priceTweak);
    
    // check luggage
    $luggage = mysql_real_escape_string($luggage);
    $luggage = stripslashes($luggage);  
    $luggage = strip_tags($luggage);
    
    // check seats
    $seats = mysql_real_escape_string($seats);
    $seats = stripslashes($seats);  
    $seats = strip_tags($seats);
    
    $userId = $_SESSION['tee'];
    
    if((!$seats) || (!$priceTweak)){
          echo'<div id="eMessage">Please fill in all fields.</div>';
    }
    else
    {
        // select journey
        $getJourney = mysql_query("SELECT * FROM userJourney WHERE user='$userId' ORDER BY id DESC LIMIT 1");
			while($row = mysql_fetch_array($getJourney))
			{ 
				$jId= $row["id"];
            }
        // update database
         $sqlStep2 = mysql_query("UPDATE userJourney SET luggage='$luggage', seats='$seats', price='$priceTweak' WHERE id='$jId'") or die (mysql_error());
        echo'...';
        
        
        
    }
}

?>