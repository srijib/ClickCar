<?php
    session_start();
    include_once"./algorithm/connection.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App</title>
<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/signup.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<header>
    <?php
       include_once"header.php";
    ?>
</header>
<body>
<?php
    // journey added completion form
    if($_GET['confirm']=="complete"){
        echo'<div id="comfirmationDiv">
        <div id="confirmationDivIn">
            <h4>Journey Confirmation</h4><br>
            <span>Your journey has been confirmed and will appear in our listings. You may not cancel your journey any less than 24 hours before your expected travel. Cancelling will affect your driver rating.</span>
        <div id="closeDiv"></div>
        </div>
        </div>';
    }
?>
    <div id="banner">
        <div id="searchBox">
            <h2>Need A Lift?</h2>
            <div id="underline"></div>
            <form method="POST" action="#" name="journeyForm" id="journeyForm">
            <div id="searchTop">
                <input type="text" name="start" id="start" class="searchInput" placeHolder="Travelling From">
                
                <!-- "to" div tag -->
                <div id="to">
                    <span>To</span>
                </div>
                <input type="text" name="end" id="end" class="searchInput" placeHolder="Travelling To" style="margin-right:0px; float:right">
                </div>
                
                <input type="text" name="date" id="dateTravel" class="searchInputDate" placeHolder="When?">
                <select id="timeTravel" class="homeInputDropDownLong" style="width:110px;">
                    <option value="00" disabled="disabled" selected="selected">Time</option>
                    <option value="any">Anytime</option>
                    <?php
                        // generate hours
                        $h=00;
                        while($h<=24){
                            echo'<option value="' . $h . '">' . $h . ':00</option>';
                            $h++;
                        }
                    ?>
                 </select>
                <input type="submit" class="processButtonSearch" name="searchButton" id="searchButton" value="Search"/>
            </form>
        </div>
        
        <!-- white box on page -->
       
        <div id="whitePage">
            <h3>Availiable Lifts For You</h3>
            
            <div id="searchResults">
                <span>These are recomended lifts that you may be interested in, based on past journeys and the information you have told us.</span>
            <br><br>
                <?php
                    // collect recomended journeys
                    $userId = $_SESSION['tee'];
                    $regJourneys = mysql_query("SELECT regularJourneys FROM user WHERE id='$userId' LIMIT 1");
                    while($row = mysql_fetch_array($regJourneys))
                    { 
                        $regularJourneys= $row["regularJourneys"];
                    }
                    $regularJourneysArray = explode(",n", $regularJourneys);
                    // for each regular journey found search the database
                    foreach ($regularJourneysArray as $key => $value) {
                        
                          $valueArray = explode(" to ", $value);
                          $start = $valueArray[0];
                         
                          $end = $valueArray[1];
                      
                       //echo 'Before search' . $start . ' to ' . $end . '<br>';
                        $journeyFind = mysql_query("SELECT * FROM userJourney WHERE start='$start' AND end='$end'");
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
                    }

                ?>
            </div>
            
            <!-- edit here-->
            <h3>No Service</h3>
            <h3>We are having problems connecting to anything.</h3>
            
            
        </div>
        
        <!-- message inbox-->
        <div id="messageHolder">
            <div id="messageAlert">
                <div id="messageBanner">Messages</div>
                 <div id="messageContent">
                <br><span>No Messages To Display</span>
            </div>
            </div>
        
        <!-- end message alert -->
        
        <!-- feedback -->
        
            <div id="messageAlert">
                <div id="messageBanner">Your Reviews</div>
                 <div id="messageContent">
                <br><span>No Reviews To Display</span>
            </div>
            </div>
        </div>
        <!-- end message alert -->
        
    </div>
    <?php
    if($_GET['user']=="new"){
    ?>
    <div class="overlay">
        <div id="overlayHolder">
            <h3>Welcome</h3>
            <span>You are now ready to look for lifts, offer your own or edit your personal profile.</span>
             <?php echo $_SESSION['userNumber']; ?>
            <br><br>
            <input type="submit" class="processButtonSearch" name="takeTour" id="takeTour" value="Finish"/>
        </div>
    </div>
    <?php
    }
    ?>
</body>
<script type="text/javascript">
        $('#takeTour').click(function() {
            window.location.href = "home.php";
         });
    
        $( "#closeDiv" ).click(function() {
          $( "#confirmationDivIn" ).hide( "fast")
          $( "#comfirmationDiv" ).slideUp( "fast")
        });
    </script>
<script type="text/javascript">
        $('#journeyForm').submit(function() {
            var start = $( "#start" ).val();
            var end = $( "#end" ).val();
            var dateTravel = $( "#dateTravel" ).val();
            var timeTravel = $( "#timeTravel" ).val();

                    $.post("algorithm/search.php", { start: start, end: end, dateTravel: dateTravel, timeTravel: timeTravel})
                    .done(function(data) {
                    $('#searchResults').empty().append(data)
               
                    /*if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "signup3.php";
                        }*/
                    });
             return false;
        });
    </script>
</html>