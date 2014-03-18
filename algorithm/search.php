<?php
session_start();
include_once"connection.php";

if($_POST['start']){
    $start=$_POST['start'];
    $end=$_POST['end'];
    $dateTravel=$_POST['dateTravel'];
    $timeTravel=$_POST['timeTravel'];
    
    // secure for database
    $start = mysql_real_escape_string($start);
    $start = stripslashes($start);  
    $start = strip_tags($start);
    
    $end = mysql_real_escape_string($end);
    $end = stripslashes($end);  
    $end = strip_tags($end);
    
    $dateTravel = mysql_real_escape_string($dateTravel);
    $dateTravel = stripslashes($dateTravel);  
    $dateTravel = strip_tags($dateTravel);
    
    $timeTravel = mysql_real_escape_string($timeTravel);
    $timeTravel = stripslashes($timeTravel);  
    $timeTravel = strip_tags($timeTravel);
    
    // check for absent data
    if ((!$start) || (!$end) || (!$dateTravel))
    {
        echo"shake"; // perform animation on homepage for absent data
    }
    else
    {
        $returnResults = 0;
        if($timeTravel == "any"){
            // search query withouit time
            $journeyFind = mysql_query("SELECT * FROM userJourney WHERE start='$start' AND end='$end' AND dateLeaving='$dateTravel'");
             $journeyFindCount = mysql_num_rows($journeyFind);
             if($journeyFindCount > 0){
                 $returnResults = 1;
             }
        }
        else
        {
             $journeyFind = mysql_query("SELECT * FROM userJourney WHERE start='$start' AND end='$end' AND dateLeaving='$dateTravel' AND timeLeaving='$timeTravel'");
            $journeyFindCount = mysql_num_rows($journeyFind);
            if($journeyFindCount > 0){
                 $returnResults = 1;
             }
        }
        
        // display output
        // while loop to echo results
        while($row = mysql_fetch_array($journeyFind))
        { 
            $start= $row["start"];
            $end =  $row["end"];
            $jTime =  $row["timeLeaving"];
            $jDate =  $row["dateLeaving"];
            $jPrice =  $row["price"];
            $seats =  $row["seats"];    
            $jPrice = $jPrice / $seats;
            $jPrice = ceil($jPrice);
            echo '
            <div class="journeyDisplay">
                <h4>' . $start . ' To ' . $end . '</h4>
                <h6>@' . $jTime . ' On ' . $jDate . '</h6>
                <div class="journeyPrice">
                    <span>Prices From</span>
                    <h5>&pound; ' . $jPrice . '</h5>
                </div>
            </div>
            ';
        }
        
        // display "no results found" message if nothing was found
        if($returnResults == 0){
            echo'<span id="nill">No matches could be found.</span>';
        }
    }
    
}
    