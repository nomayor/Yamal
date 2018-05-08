<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$FirewallToBeDeleteded = $_POST['FirewallToBeDeleteded'];


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


$sql = "DELETE from SIDIPADDRESS_Table_2 where InterouteSID = '$FirewallToBeDeleteded'";


if ($conn->query($sql) === TRUE) {
    $DBAction = "Record updated successfully";
} else {
    $DBAction = "Error updating record: " . $conn->error;
}

$conn->close(); 


echo $DBAction;


return;


?>