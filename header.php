<?php
session_start();
include_once'./algorithm/connection.php';
?>
<div id="headerHolder">
    <div id="headerInner">
        <div id="logoHolder">
            <a href="http://samdr.co.uk/clickcar">
                <div id="logo">
                </div>
            </a>
        </div>
        <?php
            // show if not logged in
            if(!$_SESSION['tee']){
        
                echo'<div id="loginHeaderHolder">    
                    <a href="./login">Login</a>  <a href="./signup">Join</a>
                </div>';
            } else if($_SESSION['tee']){
                $myId = $_SESSION['tee'];
                // select username from database
                $getUsernameH = mysql_query("SELECT username FROM user WHERE id='$myId'");
			while($row = mysql_fetch_array($getUsernameH))
			{ 
				$myUsername= $row["username"];
            }
                echo'<div id="loginHeaderHolder">    
                   ' . $myUsername . ' | <a href="./journey">Offer A Journey</a> | <a href="./logout">Logout</a>
                </div>';
            }
        ?>
    </div>
</div>