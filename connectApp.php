<?php
session_start();
include_once'./algorithm/connection.php';

if(!$_SESSION['tee']){
     header( 'Location: ./login' ) ;
}

?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Connect an app</title>

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
            <h2>connect the app</h2>
        </div>
        <div id="signUp">
            <h4 class="red">Take Note</h4>
            <span>Currently there is no app. Oh dear. It's coming soon though :)</span><br>
            
            
           
            <?php include_once"./addon/footer.php"; ?>
        </div>
    </div>
</body>
</html>