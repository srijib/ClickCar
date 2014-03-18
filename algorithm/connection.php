<?php
//session_start();
// this page is in order to connect to the php database.
//By including it in it's own folder you only have to change login details once.



/*$db_host = "localhost";
$db_username = "root"; 
$db_pass = "root"; 
$db_name = "clipstring";*/

$db_host = "localhost";
$db_username = ""; 
$db_pass = ""; 
$db_name = "";

// Run the connection here 
@mysql_connect("$db_host","$db_username","$db_pass") or die ('Could not connect port 4');
@mysql_select_db("$db_name") or die ("500 Internal Error, no database could be located.");
?>