<?php
session_start();
include_once'./algorithm/connection.php';

if(!$_SESSION['tee']){
     header( 'Location: ./login' ) ;
}


// get profile details
if($_GET['username']){
    // get id relating to username
    $tempUsername = $_GET['username'];
    $getUsername = mysql_query("SELECT id FROM user WHERE username='$tempUsername' LIMIT 1");
    $countGetUsername = mysql_num_rows($getUsername);
    
    if($countGetUsername > 0 ){
			while($row = mysql_fetch_array($getUsername))
			{ 
				$userId= $row["id"];
            }
    }
    else
    {
         header( 'Location: ./404' ) ;
    }
}
else
{
    $userId = $_SESSION['tee'];
}


$getProfile = mysql_query("SELECT * FROM user WHERE id='$userId' LIMIT 1");
			while($row = mysql_fetch_array($getProfile))
			{ 
				$username= $row["username"];
                $firstname= $row["fName"];
                $surname= $row["sName"];
                $city= $row["town"];
            }
$getDriver = mysql_query("SELECT userId, carMake, carModel FROM driver WHERE userId='$userId' LIMIT 1");
$countGetDriver = mysql_num_rows($getDriver);
if($countGetDriver > 0){
			while($row = mysql_fetch_array($getDriver))
			{ 
                $carMake= $row["carMake"];
                $carModel= $row["carModel"];
            }
            // select car make from db
    $getMake = mysql_query("SELECT * FROM make WHERE id='$carMake' LIMIT 1");
    while($row = mysql_fetch_array($getMake))
			{ 
                $carTitle= $row["title"];
            }
    // construct car tagline
    $carTagline .= '<h4>Drives a ' . $carTitle . ' ' . $carModel . '</h4>';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>ClickCar App / Become A Driver</title>

<link rel="stylesheet" type="text/css" href="./addon/header.css">
<link rel="stylesheet" type="text/css" href="./styles/profile.css">
<link rel="stylesheet" type="text/css" href="./styles/home.css"> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>    

</head>
<header>
    <?php
        include_once"./addon/header.php";
    ?>
</header>
<body>
    <div id="profileCover">
        <div id="profileCoverInner">
            <div id="profilePhoto"></div>
            <div id="profileDetails">
                <h3><?php echo $username;?></h3>
                <h4><?php echo $firstname;?> <?php echo $surname;?></h4>
                <h4><?php echo $city;?></h4>
                <?php echo $carTagline;?>
            </div>
            
            <div id="messageHolder">
                <?php
                if($_SESSION['tee']!==$userId){
                    ?>
                <form method="POST" action="#" id="messageForm" name="messageForm">
                    <input type="submit" id="messageUser" class="messageButton" value="Send Message"/>
                </form>
                <?php
                }else{
                    ?>
                <form method="POST" action="#" id="editForm" name="editForm">
                    <input type="submit" id="editProfile" class="messageButton" value="Edit Profile"/>
                </form>
                <?php
                }
                    ?>
            </div>
        </div>
    </div>
    <div id="profilePage">
        <div id="rightSide">
            <h2>Recent Trips</h2>
        </div>
        
        <div id="statHolder">
            <h2>Stats</h2>
            <ul>
                <li><div class="circle"><div class="pie"></div></div><span>50% Broken System</span></li>
                <li><div class="circle"><div class="pie"></div></div><span>50% Broken System</span></li>
                <li><div class="circle"><div class="pie"></div></div><span>50% Broken System</span></li>
                <li><div class="circle"><div class="pie"></div></div><span>50% Broken System</span></li>
            </ul>
        </div>
        
        
    </div>
</body>
</html>