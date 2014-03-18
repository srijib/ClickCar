<?php
// logout script
session_start();

// delete remember me cookie

    if (isset($_COOKIE['whoIsIt'])) {
            unset($_COOKIE['whoIsIt']);
        }
session_destroy();

 header( 'Location: http://www.samdr.co.uk/clickcar?logout=true' ) ;
?>