<?php
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
echo "Connected successfully.  ";

usleep(1000000);

$sql = "CREATE TABLE SIDIPADDRESS_Table_2 ( 
InterouteSID VARCHAR(30) NOT NULL PRIMARY KEY,
FWLocalIdentifier VARCHAR(30) NOT NULL,
IPAddress VARCHAR(30) NOT NULL,
Change_Date TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table SIDIPADDRESS_Table_2 created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$conn->close();

usleep(1000000);

echo "  Connection closed";

?>