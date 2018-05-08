<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$network = $_POST['network']; 
$local = $_POST['local']; 
$IPadr = $_POST['IPadr'];


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


$sql = "INSERT INTO SIDIPADDRESS_Table_2 (InterouteSID, FWLocalIdentifier, IPAddress) VALUES ('$network', '$local', '$IPadr')";


if ($conn->query($sql) === TRUE) {
    $DBAction = "Record updated successfully";
} else {
    $DBAction = "Error updating record: " . $conn->error;
}

$conn->close(); 


echo $DBAction;


return;


?>