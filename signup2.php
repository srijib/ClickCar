<?php
session_start();
?>
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
            <h2>About You</h2>
        </div>
        <div id="signUp">
            <span><b>Why?</b></span><br>
            <span>It's important for you to have a clear profile to make lift sharing more plesant.</span>
            <form method="POST" action="#" name="step2" id="step2">
            <input type="text" name="firstname" id="firstname" class="signUpInput" placeHolder="Your First Name"/>
                <br>
            <input type="text" name="surname" id="surname" class="signUpInput" placeHolder="Your Last Name"/>
                <br><br>
            <select name="birthDay" id="birthDay" class="signUpInputDropDown">
                <option value="" disabled="disabled" selected="selected">Date</option>
                <?php
                    // print birth dates
                    $i=1;
                    while($i <= 31){
                        echo'<option value="' . $i . '">' . $i . '</option>';
                        $i++;
                    }
                ?>
            </select>
            <select name="birthMonth" id="birthMonth" class="signUpInputDropDown">
                <option value="" disabled="disabled" selected="selected">Of</option>
                <?php
                    // print birth dates
                    $m=1;
                    while($m <= 12){
                        echo'<option value="' . $m . '">' . $m . '</option>';
                        $m++;
                    }
                ?>
            </select>
            <select name="birthYear" id="birthYear" class="signUpInputDropDown">
                <option value="" disabled="disabled" selected="selected">Birth</option>
                <?php
                    // print birth dates
                    $y=1930;
                    // work out age for being 18
                    $todayYear = date("Y");
                    $legalAge = $todayYear - 18;
                    while($y <= $legalAge){
                        echo'<option value="' . $y . '">' . $y . '</option>';
                        $y++;
                    }
                ?>
            </select>
                <span>*You must be 18 or over to join.</span>
                <br><br>
            <!-- gender select box -->
            <div id="signUpGender">
                <select name="gender" id="gender" class="signUpInputDropDown" style="width:100px;">
                    <option value="" disabled="disabled" selected="selected">Gender?</option>
                    <option value="m">Male</option>
                    <option value="f">Female</option>
                    <option value="n">NA</option>
                </select>
            </div>
            <br><br>
                <span>
                    <b>Contact Address</b><br>
                    While this will not be shared on your profile, we need a contact address for our records.
                </span>
                <br>
                <input type="text" name="addressL1" id="addressL1" class="signUpInput" placeHolder="House Name / Number"/><br>
                <input type="text" name="addressL2" id="addressL2" class="signUpInput" placeHolder="Street"/><br>
                <input type="text" name="addressL3" id="addressL3" class="signUpInput" placeHolder="Town"/><br>
                <input type="text" name="postCode" id="postCode" class="signUpInput" placeHolder="Post Code"/><br>
                <input type="submit" class="processButton" name="joinToday" id="joinToday" value="Next"/>
           
            </form>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#step2').submit(function() {
            var firstname = $( "#firstname" ).val();
            var surname = $( "#surname" ).val();
            var birthDay = $( "#birthDay" ).val();
            var birthMonth = $( "#birthMonth" ).val();
            var birthYear = $( "#birthYear" ).val();
            var gender = $( "#gender" ).val();
            var addressL1 = $( "#addressL1" ).val();
            var addressL2 = $( "#addressL2" ).val();
            var addressL3 = $( "#addressL3" ).val();
            var postCode = $( "#postCode" ).val();
            
           
                    $.post("algorithm/signup.php?r=2", { firstname: firstname, surname: surname, birthDay: birthDay, birthMonth: birthMonth, birthYear: birthYear, gender: gender, addressL1: addressL1, addressL2: addressL2, addressL3: addressL3, postCode: postCode})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                    if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "signup3.php";
                        }
                    });
             return false;
        });
    </script>
</html>