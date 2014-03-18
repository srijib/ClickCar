<?php
session_start();
include_once'./algorithm/connection.php';
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / 404 Not Found</title>
<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css">
<link rel="stylesheet" type="text/css" href="./addon/404.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
</head>
<header>
    <?php
        include_once"header.php";
    ?>
</header>
<body>
    <div id="tudalen">
        <h1>Well, This is abit bad</h1>
        <span>It appears this page doesn't exist. Try re-typing the url or go back a page and try again. Sorry</span>
    </div>
</body>

</html>