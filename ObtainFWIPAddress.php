<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$Required_FW = $_POST['Required_FW'];
$Required_FW = str_replace(" ", "", $Required_FW);


$servername = "localhost";
$username = "root";
$password = "1nterouteCPE";
$dbname = "SIDIPADDRESS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "SELECT IPAddress FROM SIDIPADDRESS_Table_2 WHERE FWLocalIdentifier = '$Required_FW'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $Firewall_IP_Address = array_values($result->fetch_assoc())[0];
    $reslt = "Firewall Found in DB.";

} else {
    $reslt = "Firewall Not Found in DB.";
}

//mysql_free_result($reslt);
$conn->close(); 

$ret = file_put_contents('/var/www/html/Show_Version/FW_To_Configure.txt', $Firewall_IP_Address);
echo $reslt;










//$ICC_FW_Devices = file_get_contents('/var/www/html/Show_Version/SIDIPAddress.txt', true);

//$Array = explode(',', $ICC_FW_Devices);

//for ($i = 0, $size = count($Array); $i < $size; ++ $i) {

//$ExaminedValue = str_replace(" ", "", $Array[$i]);

//	if ($ExaminedValue === $Required_FW ) { 

//		$i = $i + 1;
//		$result = str_replace(" ", "", $Array[$i]);
//    }

//}

//$ret = file_put_contents('/var/www/html/Show_Version/FW_To_Configure.txt', $result);


//echo $result; 
return;

?>
