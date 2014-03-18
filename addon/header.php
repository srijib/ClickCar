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
                <div id="myPhoto"></div>
                   <span style="margin-right:10px;">' . $myUsername . '</span>
                   <div id="menu">
                   <ul>
                    <a href="./profile"><li>My Profile</li></a>
                    <a href="./journey"><li>Offer A Journey</li></a>
                    <a href="./connect"><li>App Status</li></a>
                    <a href="./settings"><li>Settings</li></a>
                    <a href="./logout"><li>Logout</li></a>
                   </ul>
                </div>
                </div>
                ';
            }
        ?>
    </div>
</div>
<script type="text/javascript">
    $( "#myPhoto" ).click(function() {
        if ( $("#menu").is(":visible") ) {
            $( "#menu" ).slideUp("Slow");
        } else { 
           $( "#menu" ).slideDown("Slow");
        }
        
});
</script>