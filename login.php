<?php
session_start();
include_once"./algorithm/connection.php";

// check if user is already logged in
if($_SESSION['tee']){
     header( 'Location: ./home.php?user=logged' ) ;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Login</title>
<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/login.css">
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
            <h2>Login</h2>
            <div id="loginHolder">
                 <center><img src="./styles/loader.gif" id="loader" width="100px" height="100px" style="display:none;"/></center>
                <form method="POST" action="#" name="loginForm" id="loginForm">
                <input type="text" name="carUsername" id="carUsername" placeHolder="Username or Email" class="loginInput"/>
                <br>
                  <input type="password" name="carPassword" id="carPassword" placeHolder="Password" class="loginInput"/>
                <br>
              <br>
                <span><a href="forgotCentre.php">Forgotten your login details?</a></span><br>
                <input type="submit" class="processButton" name="login" id="login" value="Login"/>
                </form>
            </div>
        </div>
        </div>
        <div id="footerOutside">
            <!-- align footer -->
            <?php include_once"./addon/footer.php"; ?>
        </div>
</body>
<script type="text/javascript">
        $('#loginForm').submit(function() {
            var carUsername = $( "#carUsername" ).val();
            var carPassword = $( "#carPassword" ).val();
            $( "#loader" ).show();
           
                    $.post("algorithm/login.php", { carUsername: carUsername, carPassword: carPassword})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)

                 if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "home.php";
                        }
                    });
             return false;
        });
    </script>
</html>