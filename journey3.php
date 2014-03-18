<?php
session_start();
include_once'./algorithm/connection.php';

if(!$_SESSION['tee']){
     header( 'Location: ./login' ) ;
}

// check if user already has a driver account
$userId = $_SESSION['tee'];
$checkDriver = mysql_query("SELECT userId FROM driver WHERE userId='$userId'");
$countDriver = mysql_num_rows($checkDriver);

// redirect to the "create journey" page
if($countDriver<1){
    header( 'Location: ./driver' ) ;
}

// collect data about journey
$userId = $_SESSION['tee'];
$getJourney = mysql_query("SELECT * FROM userJourney WHERE user='$userId' ORDER BY id DESC LIMIT 1");
			while($row = mysql_fetch_array($getJourney))
			{ 
                $journeyRef= $row["journeyRef"];
                $userId= $row["user"];
				$start= $row["start"];
                $end= $row["end"];
                $departDate= $row["dateLeaving"];
                $departTime= $row["timeLeaving"];
                $distance= $row["distance"];
                $price= $row["price"];
                $seats= $row["seats"];
                $detour= $row["detour"];
            }

// select driver vehicle type
$vehicleTypeSQL = mysql_query("SELECT * FROM driver WHERE userId='$userId' ORDER BY id DESC LIMIT 1");
			while($row = mysql_fetch_array($vehicleTypeSQL))
			{ 
                $fuel= $row["fuel"];
                $seatNumber= $row["seatNumber"];
                $carMake= $row["carMake"];
                $carModel= $row["carModel"];
                $colour= $row["colour"];
            }
$getVehicleModel = mysql_query("SELECT title FROM make WHERE id='$carMake' LIMIT 1");
			while($row = mysql_fetch_array($getVehicleModel))
			{ 
                $carMake= $row["title"];
            }

// get user details
$getUserDetails = mysql_query("SELECT * FROM user WHERE id='$userId' LIMIT 1");
			while($row = mysql_fetch_array($getUserDetails))
			{ 
                $firstname= $row["fName"];
                $surname= $row["sName"];
                $phone= $row["phone"];
                $interests= $row["interests"];
                $gender= $row["gender"];
            }
if($gender == "m"){
    $gender="Male";
}
else if($gender == "f"){
    $gender="Female";
}
else{
    $gender="N/A";
}
// calculate cheapest price
$cheapPrice = $price / ($seats + 1);
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Offer A Journey</title>

<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/journey.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css"> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>    

</head>
<header>
    <?php
        include_once"./addon/header.php";
    ?>
</header>
<body>
    <div id="banner">
        <div id="eMessageHolder"></div>
        <div id="bannerInner">
            <h2>Offer A Journey / Confirmation</h2>
        </div>
        <div id="pageHolder"  style="height:850px;"> 
            <!-- status banner-->
            <div id="statusBanner">
                <center>
                    <span>Details - Price &amp; Passengers - <b>Confirm</b></span>
                </center>
            </div>
            <!-- end status banner -->
            <div id="pageInner">
                <div id="journeyDeeds">
                    <h4>Travelling From <?php echo $start; ?></h4>
                    <h4>To <?php echo $end; ?></h4>
                    <h4>@ <?php echo $departTime; ?> on <?php echo $departDate; ?></h4>
                    <div id="priceSector">
                        &pound;<?php echo $price; ?><br>
                        <span><?php echo $distance; ?> Miles</span>
                    </div>
                </div>
                <div id="promo">
                    <h4 class="promo">This Journey Could Be As Cheap As <b> &pound;<?php echo $cheapPrice; ?></b></h4>
                </div>
                <div id="journeyD">
                    <span>The following details will be shared publicly when a passenger joins your jourey.</span><br><br>
                    <h5><?php echo $journeyRef; ?></h5>
                    <br>
                    <span><b>Journey Details</b></span>
                    <br><br>
                    <span>Traveling From: <?php echo $start; ?></span><br>
                    <span>Travelling To: <?php echo $end; ?></span><br>
                    <span>Travel Date: <?php echo $departDate; ?></span><br>
                    <span>Travel Time: <?php echo $departTime; ?></span><br>
                    <span>Maximum Detour: <?php echo $detour; ?> miles</span><br>
                    <br>
                    <span><b>Journey Details</b></span><br>
                    <span>Vehicle Make: <?php echo $carMake; ?></span><br>
                    <span>Vehicle Model: <?php echo $carModel; ?></span><br>
                    <span>Vehicle Colour: <?php echo $colour; ?></span><br>
                    <br>
                    <span><b>Contact Details</b></span><br>
                    <span>Driver Name: <?php echo $firstname; ?> <?php echo $surname; ?></span><br>
                    <span>Contact Number: <?php echo $phone; ?></span><br>
                    <span>Gender: <?php echo $gender; ?></span><br><br>
                    <span>Interests: <br><?php echo $interests; ?></span><br>
                     <br>
                    <form method="POST" action="./home?confirm=complete" name="confirmForm" id="confirmForm">
                    <input type="submit" class="processButton" name="finish" id="finish" value="Confirm"/>
                </form>
                </div>
               
                
            </div>
        </div>
        <center>
            <?php include_once"./addon/footer.php"; ?>
        </center>
    </div>
</body>
</html>