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
				$start= $row["start"];
                $end= $row["end"];
                $departDate= $row["dateLeaving"];
                $departTime= $row["timeLeaving"];
                $distance= $row["distance"];
            }

// select driver vehicle type
$vehicleTypeSQL = mysql_query("SELECT seatNumber,fuel FROM driver WHERE userId='$userId' ORDER BY id DESC LIMIT 1");
			while($row = mysql_fetch_array($vehicleTypeSQL))
			{ 
                $fuel= $row["fuel"];
                $seatNumber= $row["seatNumber"];
            }

// select mpg for fuel
if($fuel == "p"){
    $averageMPG = 37;
    $averagePrice = 1.30;
}
else if($fuel == "d"){
    $averageMPG = 47;
    $averagePrice = 1.35;
}

// calculate price
$averagePrice = 1.33;

$travelGallons = $distance / $averageMPG;
$travelLitres = $travelGallons * 4.54;
$travelCost = $travelLitres * $averagePrice;
$travelCost = ceil($travelCost);

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
            <h2>Offer A Journey / Price</h2>
        </div>
        <div id="pageHolder"> 
            <!-- status banner-->
            <div id="statusBanner">
                <center>
                    <span>Details - <b>Price &amp; Passengers</b> - Confirm</span>
                </center>
            </div>
            <!-- end status banner -->
            <div id="pageInner">
                <div id="journeyDeeds">
                    <h4>Travelling From <?php echo $start; ?></h4>
                    <h4>To <?php echo $end; ?></h4>
                    <h4>@ <?php echo $departTime; ?> on <?php echo $departDate; ?></h4>
                    <div id="priceSector">
                        &pound;<?php echo $travelCost; ?><br>
                        <span><?php echo $distance; ?> Miles</span>
                    </div>
                </div>
                <form method="POST" action="#" name="priceForm" id="priceForm">
                    <span>
                        <b>Price Check</b><br>
                        You may not agree with the calculated price, after all it's only an estimate. Thats why we let you tweak the price up to &pound;5 either way. <br>
                        If a passenger needs to be picked up out of the way don't worry. The extra cost will be weighted on their behalf.
                    </span>
                    <br><br>
                <span><b>Tweak The Price - </b></span><br><br>
                <select id="priceTweak" class="clickInputDropDown" style="width:110px;">
                     <?php
                        // calculate price 5 pounds up
                        $count = $travelCost - 6;
                        $low = $travelCost; 
                        while($count < $low){
                            echo $count;
                            echo'<option value="' . $count . '">' . $count . '</option>';
                            $count ++;
                        }
                    ?>
                    <option value="<?php echo $travelCost; ?>" selected="selected">&pound;<?php echo $travelCost; ?></option>
                    <?php
                        // calculate price 5 pounds up
                        $count2 = $travelCost+1;
                        $hi = $travelCost + 6; 
                        while($count2 < $hi){
                            echo'<option value="' . $count2 . '">' . $count2 . '</option>';
                            $count2 ++;
                        }
                    ?>
                </select><br>
               <span>You can tweak the price, however if you feel this price is way out you can <a href="changePrice()">enter your own</a></span>
                    <br><br>
                <span><b>Last Bits</b></span><br>
                <span>Number of seats availiable</span><br>
                <select id="seats" class="clickInputDropDown" style="width:110px;">
                        <?php
                        // calculate price 5 pounds up
                        $count3 = 1;
                        while($count3 < 4){
                            if($count3 == $seatNumber){
                                echo'<option selected="selected" value="' . $count3 . '">' . $count3 . '</option>';
                            }
                            else
                            {
                                echo'<option value="' . $count3 . '">' . $count3 . '</option>';
                            }
                            $count3 ++;
                        }
                    ?>
                </select>
                    <br><br>
                    <span>Amount of luggage per passenger</span><br>
                    <input type="text" name="luggage" id="luggage" class="clickInput" placeHolder="e.g. Rucksack"/><br>
                    <input type="submit" class="processButton" name="nextStep" id="nextStep" value="Finish"/>
                </form>
                
            </div>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#priceForm').submit(function() {
            var priceTweak = $( "#priceTweak" ).val();
            var luggage = $( "#luggage" ).val();
            var seats = $( "#seats" ).val();
           
                    $.post("algorithm/journey.php?r=2", {priceTweak: priceTweak, luggage: luggage, seats: seats})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                    if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "journey3.php";
                        }
                    });
            
             return false;
        });

            </script>
</html>