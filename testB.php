 <?php
 $birthString = '1993-11-7';
            // convert date to timestamp
            $timestamp = strtotime($birthString);
            
            
           

$age = floor( (strtotime(date('Y-m-d')) - strtotime('' . $birthString . '')) / 31556926);
echo $age;

 // check if age is older than 18
            if(($age) < 18){
                echo'<div id="eMessage">You must be <b>18</> to join.</div>';
            }

?>
