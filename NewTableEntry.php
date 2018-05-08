<?php
$servername = "localhost";
$username = "root";
$password = "1nterouteCPE";
$dbname = "SIDIPADDRESS";

$FirewallsInstalled = file_get_contents('/var/www/html/Show_Version/SIDIPAddress.txt', true);

$Array = explode(',', $FirewallsInstalled);

$Hostname = str_replace(" ", "", $Array[0]);
$IP_Addr = str_replace(" ", "", $Array[1]);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully.  ";


//$sql = "INSERT INTO SIDIPADDRESS_Table_2 (InterouteSID, FWLocalIdentifier, IPAddress)
//VALUES ('Alpha_Site_3', 'Alpha_Site_3', '172.31.22.145')";

$sql = "INSERT INTO SIDIPADDRESS_Table_2 (InterouteSID, FWLocalIdentifier, IPAddress)
VALUES ('$Hostname', '$Hostname', '$IP_Addr')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();


echo "  Connection closed";

?>