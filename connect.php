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
<title>ClickCar App / Connect Mobile App</title>

<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/connect.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css"> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>    

</head>
<header>
    <?php
        include_once"./addon/header.php";
    ?>
</header>
<body>
    <div id="appCover">
        <div id="appCoverInner">
            <h1>App Status</h1>
            <span>The ClickCar App makes your journey smoother &amp; safer.</span>
        </div>
    </div>
    <div id="statusHolder">
        <h2>The App is currently not connected</h2>
    </div>
</body>
</html>