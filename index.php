<?php
session_start();
include_once'./algorithm/connection.php';

if($_SESSION['tee']){
     header( 'Location: ./home' ) ;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App</title>
<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css">
<link rel="stylesheet" type="text/css" href="./styles/signup.css">
</head>
<header>
    <?php
        include_once"header.php";
    ?>
</header>
<body>
    <div id="banner">
        <div id="searchBox">
        </div>
    </div>
</body>

</html>