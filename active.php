<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Activate</title>
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
            <h2>Activate</h2>
            
        </div>
        <div id="signUp">
            <span>
                <b>Welcome to the party!</b><br>
            </span>
            <span>You need to active. We have already sent you an email with a personal code which can be used to activate your account. Once you've done that</span>
            <form method="POST" action="#" name="activeForm" id="activeForm">
                <br>
                <br>
                <center>
                    <img src="styles/loader.gif" title="loading"/>
                    <br><br>
                    <input type="text" name="activeNumber" id="activeNumber" class="signUpInput" placeHolder="Activation Code"/><br>
                     <input type="submit" class="processButton" name="joinToday" id="joinToday" value="Activate"/>
                </center>
                <br><br>
                <span>
                    <b>Having Problems</b><br>
                    If you're having trouble activating you can send the <a href="#resendEmail">email again.</a><br>
                    Don't forget to check your junk mail too.
                </span>
            </form>
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
<script type="text/javascript">
        $('#activeForm').submit(function() {
            var activeNumber = $( "#activeNumber" ).val();

                    $.post("algorithm/active.php", { activeNumber: activeNumber})
                    .done(function(data) {
                    $('#eMessageHolder').empty().append(data)
               
                   if($("#eMessageHolder:contains('...')").length)
                        {
                             window.location.href = "home.php?user=new";
                        }
                    });
             return false;
        });
    </script>
    
</html>