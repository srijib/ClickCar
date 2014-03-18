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
if($countDriver>0){
    header( 'Location: ./journey' ) ;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Become A Driver</title>

<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/signup.css">
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
            <h2>Become A Driver</h2>
        </div>
        <div id="signUp">
            <h4 class="red">Take Note</h4>
            <span>You are required by law to have insurance, tax and a valid MOT. Make sure you have these before setting up a driver profile. ClickCar has no connections with the journeys themselves, only the process of setting up a journey with a passenger.</span><br>
            
            
            <form method="POST" action="#" name="driverForm" id="driverForm">
            <h3>Vehicle Details</h3>
                
                
            <select id="carMake" name="carMake" class="signUpInputDropDownLong">
                <option value="" disabled="disabled" selected="selected">Car Make</option>
            <!-- car make -->
            <?php
                // select car models from database
                $getModel = mysql_query("SELECT id, title FROM make");
                while($row = mysql_fetch_array($getModel)){  
                $code = $row["id"];
                $title = $row["title"];
                   echo'<option value="' . $code . '">' . $title . '</option>';
                }
            ?>
              </select>
            
                
                <br><br>
            <!-- car model -->
            <span id="modelResult">
                  <select name="carModel" id="carModel" class="signUpInputDropDownLong">
                      <option value="" disabled="disabled" selected="selected">Car Model</option>
                  </select>
            </span><br>
            <input type="text" name="otherVehicle" id="otherVehicle" class="signUpInput" placeHolder="Other"/>
                <span>If your vehicle is no listed type it here</span>
           
                <br><br>
             <select name="seats" id="seats" class="signUpInputDropDownLong">
                    <option value="" disabled="disabled" selected="selected">Seats</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
              </select>    
              <select name="colour" id="colour" class="signUpInputDropDownLong">
                    <option value="" disabled="disabled" selected="selected">Colour</option>
                    <option value="Black">Black</option>
                    <option value="White">White</option>
                    <option value="Blue">Blue</option>
                    <option value="Red">Red</option>
                    <option value="Green">Green</option>
                    <option value="Purple">Purple</option>
                    <option value="Purple">Yellow</option>
                    <option value="Orange">Orange</option>
                    <option value="Claret">Claret</option>
                    <option value="Silver">Silver</option>
                    <option value="Gold">Gold</option>
                    <option value="Brown">Brown</option>
              </select>       
                
                
                <select name="comfort" id="comfort" class="signUpInputDropDownLong">
                    <option value="" disabled="disabled" selected="selected">Comfort</option>
                    <option value="basic">Basic</option>
                    <option value="normal">Normal</option>
                    <option value="comfortable">Comfortable</option>
              </select>
                <br><br>
                <span><b>Your Registration.</b><br>
                    Why? - When picking up a passenger we may need to share the last part of your registration. We will never share this information.
                </span><br>
                <input type="text" name="registration" id="registration" class="signUpInput" placeHolder="e.g. AZ00 0ZA"/>
               <br>
                <h3>Final Checks</h3>
                <label>
                    <input type="checkbox" id="licence" value="tick"><span>I have a driving licence.</span>
                </label>
                <br>
                <label>
                    <input type="checkbox" id="insured" value="tick"><span>I am insured to drive this vehicle.</span>
                </label>
                
                <br>
                <label>
                    <input type="checkbox" id="mot" value="tick"><span>My car has a valid mot.</span>
                </label>
                <br>
                <label>
                    <input type="checkbox" id="tax" value="tick"><span>My car has valid tax.</span>
                </label>

                    <br>
                
                
            
                
                <input type="submit" class="processButton" name="becomeDriver" id="becomeDriver" value="Finish"/>
           
            </form>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#driverForm').submit(function() {
            var carMake = $( "#carMake" ).val();
            var carModel = $( "#carModel" ).val();
            var otherVehicle = $( "#otherVehicle" ).val();
            var seats = $( "#seats" ).val();
            var colour = $( "#colour" ).val();
            var comfort = $( "#comfort" ).val();
            var licence = "0";
            var insured = "0";
            var tax = "0";
            var mot = "0";
            
            var registration = $( "#registration" ).val();
            
            if ($('#licence').is(':checked')) {
                 var licence = "tick";
            }
            if ($('#insured').is(':checked')) {
                var insured = "tick";
            }
            if ($('#mot').is(':checked')) {
                var mot = "tick";
            }
            if ($('#tax').is(':checked')) {
                var tax = "tick";
            }
           
                    $.post("algorithm/driver.php", { carMake: carMake, carModel: carModel, otherVehicle: otherVehicle, seats: seats, colour:colour, comfort:comfort, insured:insured, licence:licence, mot: mot, tax:tax, registration: registration})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                    if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "connectApp.php";
                        }
                    });
            
             return false;
        });

                $('#carMake').on('change', function() {
                            $.post("testCar2.php", { html: this.value})
                            .done(function(data) {
                            $('#modelResult').empty().append(data)
                            });
                   return false;
                });
            </script>
</html>