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
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Offer A Journey</title>

<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/journey.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css"> 
<link rel="stylesheet" type="text/css" href="./styles/start.css"> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>    
<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD9G2X3qTmwaUihtMg67e0ja87JnVETkxo&sensor=false&amp;libraries=places">
</script>

<script type="text/javascript">
var rendererOptions = {
  draggable: true
};
var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  //directionsDisplay = new google.maps.DirectionsRenderer();
  var uk = new google.maps.LatLng(55.279115, -1.098633);
  var mapOptions = {
    zoom:5,
    center: uk
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
    
    
   google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
    computeTotalDistance(directionsDisplay.directions);
  });

  calcRoute();
}

function calcRoute() {
  var start = document.getElementById('departure').value;
  var end = document.getElementById('destination').value;
  var dest1 = document.getElementById("passingPlaces1").value;
    
  if(dest1.length < 2){dest1 = end;}

  var request = {
      origin:start,
      destination:end,
      waypoints:[{location: dest1}],
      travelMode: google.maps.TravelMode.DRIVING,
      unitSystem: google.maps.UnitSystem.IMPERIAL
  };

    
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}

// calculate distance
function computeTotalDistance(result) {
  var total = 0;
  var myroute = result.routes[0];
  for (i = 0; i < myroute.legs.length; i++) {
    total += myroute.legs[i].distance.value;
  }
  total = total / 1000;
  total = total/ 1.6;
  total = Math.round(total);
  // display total miles
  document.getElementById("total").innerHTML = total + " miles";   
  
 // set distance hidden field value
 var distance = document.getElementById("distance");
 distance.value = total;
    
}
    
google.maps.event.addDomListener(window, 'load', initialize);

    </script>

    <script>
    $(function() {
        $( "#dateLeaving" ).datepicker();
    });
    </script>

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
            <h2>Offer A Journey</h2>
        </div>
        <div id="pageHolder"> 
            <!-- status banner-->
            <div id="statusBanner">
                <center>
                    <span><b>Details</b> - Price &amp; Passengers - Confirm</span>
                </center>
            </div>
            <!-- end status banner -->
            <div id="pageInner">
            <form method="POST" action="#" name="journeyForm" id="journeyForm">
                 <input type="text" name="departure" id="departure" class="clickInput" placeHolder="From" onkeyup=""/>
                <br>
                 <input type="text" name="destination" id="destination" class="clickInput" placeHolder="Travelling To"/>
                <br>
                <span><b>Via..</b> Optional, however useful.</span>
                <br>
                 <input type="text" name="passingPlaces" id="passingPlaces1" class="clickInput"/><br>
                <input type="button" class="processButton" name="calcR" id="calcR" value="Map Route" onclick="calcRoute();"/>
               <br>
                <input type="text" name="dateLeaving" id="dateLeaving" class="clickInput" placeHolder="Date"/><br>
                <span>Only an approximate time.</span><br>
                <select id="timeLeavingHours" class="clickInputDropDown" style="width:110px;">
                    <option value="" disabled="disabled" selected="selected">hh</option>
                    <?php
                        // generate hours
                        $h=00;
                        while($h<=24){
                            echo'<option value="' . $h . '">' . $h . '</option>';
                            $h++;
                        }
                    ?>
                    </select>
                <span>: </span>
                <select id="timeLeavingMins" class="clickInputDropDown" style="width:110px;">
                    <option value="" disabled="disabled" selected="selected">mm</option>
                    <option value="0">00</option>
                    <option value="15">15</option>
                    <option value="20">30</option>
                    <option value="45">45</option>
                </select>
                   
               
                <br>
                <span>Maximum detour you are willing to make. Charges will be weighted on their behalf.
                     <a href="#">More...</a></span><br>
                
                 <select name="maxDetour" id="maxDetour" class="clickInputDropDown" style="width:110px;">
                    <option value="" disabled="disabled" selected="selected">Detour</option>
                    <option value="0">None</option>
                    <option value="2">2 Miles</option>
                    <option value="5">5 Miles</option>
                    <option value="10">10 Miles</option>
                    <option value="15">15 Miles</option>
                    <option value="20">20 Miles</option>
                    <option value="30">30 Miles</option>
                </select>
                <br><br>
                <span><b>Estimate Distance is <span id="total">/\</span></b></span>
                <input type="hidden" name="distance" id="distance" value=""/>
                <br>
                 <input type="submit" class="processButton" name="nextStep" id="nextStep" value="Next"/>
            </form>
            <div id="mapHolder">
                <div id="map-canvas">
                </div>
            </div>
            </div>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#journeyForm').submit(function() {
            var end = $( "#destination" ).val();
            var start = $( "#departure" ).val();
            var passingPlaces1 = $( "#passingPlaces1" ).val();
            var passingPlaces2 = $( "#passingPlaces2" ).val();
            var passingPlaces3 = $( "#passingPlaces3" ).val();
            var maxDetour = $( "#maxDetour" ).val();
            var distance = $( "#distance" ).val();
            var dateLeaving = $( "#dateLeaving" ).val();
            var timeLeavingHours = $( "#timeLeavingHours" ).val();
            var timeLeavingMins = $( "#timeLeavingMins" ).val();
            
           
                    $.post("algorithm/journey.php", {end: end, start: start, passingPlaces1: passingPlaces1, passingPlaces2: passingPlaces2, passingPlaces3:passingPlaces3, maxDetour:maxDetour, distance:distance, dateLeaving: dateLeaving, timeLeavingHours: timeLeavingHours, timeLeavingMins:timeLeavingMins})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                    if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "journey2.php";
                        }
                    });
            
             return false;
        });
            </script>
    
<script src="./algorithm/jquery.geocomplete.min.js"></script>
    <script type="text/javascript">
         $(function(){
        $("#departure").geocomplete({
        });

        $("#destination").geocomplete({
        });
         });
        
        </script>
      <script type="text/javascript">
      $('#statusBanner').click(function() {
         
var address = 'LL4';
//var address = 'LS2';    
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
    alert(results[0].formatted_address);
}
});
 });

</script>
</html>