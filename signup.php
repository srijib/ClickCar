<?php
session_start();
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
    <div id="banner">
        <div id="eMessageHolder"></div>
        <div id="bannerInner">
            <h2>Join For Free</h2>
            
        </div>
        <div id="signUp">
            <span>Yes it really is free to join &amp; could save you money!</span><br>
            <span>We just need a few details basic from you.</span>
            <form method="POST" action="#" name="step1" id="step1">
            <input type="text" name="username" id="username" class="signUpInput" placeHolder="Username"/>
                <br>
            <input type="text" name="email" id="email" class="signUpInput" placeHolder="Email Address"/>
                <br>
            <input type="password" name="password" id="password" class="signUpInput" placeHolder="Password"/>
                <br>
            <input type="password" name="password2" id="password2" class="signUpInput" placeHolder="Confirm Password"/>
                <br>
            <input type="text" name="phone" id="phone" class="signUpInput" placeHolder="Mobile Phone Number"/>
                <br>
            <input type="submit" class="processButton" name="joinToday" id="joinToday" value="Join"/>
            </form>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#step1').submit(function() {
            var username = $( "#username" ).val();
            var email = $( "#email" ).val();
            var password = $( "#password" ).val();
            var password2 = $( "#password2" ).val();
            var phone = $( "#phone" ).val();
                   
           
                    $.post("algorithm/signup.php", { username: username, email: email, password: password, password2: password2, phone: phone})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                     if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "signup2.php";
                        }
                    });
             return false;
        });
    </script>
    
</html>