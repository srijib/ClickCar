<?php
// this page is in order to connect to the php database.
//By including it in it's own folder you only have to change login details once.



/*$db_host = "localhost";
$db_username = "root"; 
$db_pass = "root"; 
$db_name = "clipstring";*/

$db_host = "localhost";
$db_username = "root"; 
$db_pass = "erevveiogsdb"; 
$db_name = "samdr";

// Run the connection here 
@mysql_connect("$db_host","$db_username","$db_pass") or die ('Could not connect port 4');
@mysql_select_db("$db_name") or die ("500 Internal Error, no database could be located.");




 /*echo 'hello';
/// select make of car once
$getCar = mysql_query("ALTER IGNORE TABLE VehicleModelYear ADD UNIQUE INDEX model (make)");


$getCar = mysql_query("SELECT make, model FROM VehicleModelYear WHERE make='Ford'");
			while($row = mysql_fetch_array($getCar)){  
			$make = $row["make"];
			$model = $row["model"];
                echo "$make $model<br>";
                
            }*/

echo"<select id='hi'>";
$getCar = mysql_query("SELECT id, title FROM make");
			while($row = mysql_fetch_array($getCar)){  
			$code = $row["id"];
			$title = $row["title"];
               echo'<option value="' . $code . '">' . $title . '</option>';
            }
echo"</select>";
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

<script type="text/javascript">
$('#hi').on('change', function() {
            $.post("testCar2.php", { html: this.value})
            .done(function(data) {
            $('#result').empty().append(data)
            });
});
    
    
    

</script>
<div id="result">
</div>