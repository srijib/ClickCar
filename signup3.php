<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Signup</title>
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
    <div id="banner">
        <div id="eMessageHolder"></div>
        <div id="bannerInner">
            <h2>Preferences</h2>
        </div>
        <div id="signUp">
            <span><b>Things you like.</b></span><br>
            <span>We aim to match you with driver &amp; passengers with similar preferences.</span>
            <form method="POST" action="#" name="step3" id="step3">
            <input type="text" name="interests" id="interests" class="signUpInput" placeHolder="Your Interests"/><span> * Seperate by comma (,)</span>
                <br><br>
                <div id="prefHolder">
                <span><b>Driving Preferences</b></span><br>
                <span>Select as many desired preferences as you like.</span><br>
                <!-- Display preferences checkboxes-->
                <div id="prefs">
                <label>
                    <input type="checkbox" name="pref[]" id="pref[]" value="music" ><span>No Music</span>
                </label>
                <label>
                    <input type="checkbox" name="pref[]" id="pref[]" value="smoking"><span>No Smoking</span>
                </label>
                <label>
                    <input type="checkbox" name="pref[]" id="pref[]" value="pets"><span>No Pets</span>
                </label>
                <label>
                    <input type="checkbox" name="pref[]" id="pref[]" value="disabled"><span>Disabled Access</span>
                </label>
                </div>
                </div>
                
                <!-- regular journeys -->
                <span>
                    <b>Your regular Jounreys?</b><br>
                    Do you make any regular journeys? Perhaps as a passenger or driver?<br>
                    If so, list a few, it can make your experience better.
                </span>
                <br>
                <textarea name="regularJourneys" id="regularJourneys" class="signUpTextarea" placeHolder="E.g. Birmingham to Swansea,
                                                                                                          Swansea to Cardiff"></textarea>
                <br>
                
                <!-- bio journeys -->
                <span>
                    <b>Something About You</b><br>
                </span>
                 <textarea name="bio" id="bio" class="signUpTextarea" placeHolder="E.g. I enjoy long journeys with good music."></textarea>
                <br>
                
                <input type="submit" class="processButton" name="joinToday" id="joinToday" value="Finish"/>
           
            </form>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#step3').submit(function() {
            var interests = $( "#interests" ).val();
            var pref = document.getElementsByName('pref').value;
            var regularJourneys = $( "#regularJourneys" ).val();
            var bio = $( "#bio" ).val();
            
           
                    $.post("algorithm/signup.php?r=3", { interests: interests, pref: pref, regularJourneys: regularJourneys, bio: bio})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                    if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "active.php";
                        }
                    });
             return false;
        });
    </script>
</html>