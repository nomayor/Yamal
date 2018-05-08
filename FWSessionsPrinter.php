<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$FireWSessions = file_get_contents('/var/www/html/Show_Version/FireWSessionsFromvSRX.txt', true);

$FireWSessions_Array = explode(")]),", $FireWSessions);


echo "<table><tr><td>Session Direction</td><td>Session Protocol</td><td>Source Address</td><td>Source Port</td><td>Destination Address</td><td>Destination Port</td></tr>";

foreach($FireWSessions_Array as $One_D_Array)  {
	
    $One_D_Array = explode(',', $One_D_Array);
    $One_D_Array  = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  
  
    echo "<tr><td>".$One_D_Array[6]."</td><td>".$One_D_Array[14]."</td><td>".$One_D_Array[8]."</td><td>".$One_D_Array[10]."</td><td>".$One_D_Array[18]."</td><td>".$One_D_Array[2]."</td></tr>";

}

echo "</table></div>";

?>
