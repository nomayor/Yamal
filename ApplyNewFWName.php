<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$Old_FW_Name = $_POST['Old_FW_Name'];
$New_FW_Name = $_POST['New_FW_Name'];
$RenamingSID = $_POST['RenamingSID'];

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

// Check if the new name which the User is requesting, is already used.

$sql = "SELECT IPAddress FROM SIDIPADDRESS_Table_2 WHERE FWLocalIdentifier = '$New_FW_Name'";

$Length= $conn->query($sql);

if ($Length->num_rows > 0) {

    $DBAction = "Required name already in use.";
    $ret = file_put_contents('/var/www/html/Show_Version/DBAction.txt', $DBAction);
    echo $DBAction;
    return;
} 

// Rename the device in the Database. Use the SID to identify it.
$sql = "UPDATE SIDIPADDRESS_Table_2 SET FWLocalIdentifier = '$New_FW_Name' WHERE InterouteSID = '$RenamingSID'";

if ($conn->query($sql) === TRUE) {
    $DBAction = "Record updated successfully";
} else {
    $DBAction = "Error updating record: " . $conn->error;
}

$conn->close(); 

$ret = file_put_contents('/var/www/html/Show_Version/DBAction.txt', $DBAction);

echo "Done";
return;

//$SIDIPAddress = file_get_contents('/var/www/html/Show_Version/SIDIPAddress.txt', true);
//$SIDIPAddress = str_replace($Old_FW_Name, $New_FW_Name, $SIDIPAddress);

//unlink('/var/www/html/Show_Version/SIDIPAddress.txt'); 
//$ret = file_put_contents('/var/www/html/Show_Version/SIDIPAddress.txt', $SIDIPAddress);




//$New_Old_FW_Names = file_get_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', true);

//$Array = explode(',', $New_Old_FW_Names);

//for ($i = 1, $size = count($Array); $i < $size; ++ $i) {

//////     //if($i == 80){

//	if ($Array[$i] === $Old_FW_Name) {

//	if ($i % 2 != 0) {
		
//			$Array[$i] = $New_FW_Name;
//		}
//	}
//}

//for ($i = 0, $size = count($Array); $i < $size; ++ $i) {

//$New_Old_File = $New_Old_File . "," . $Array[$i];

//}


//$New_Old_File = preg_replace('/,/', '', $New_Old_File, 1);

//unlink('/var/www/html/Show_Version/New_Old_FW_Names.txt');

//$ret = file_put_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', $New_Old_File);

//$result = "Done";

//echo $result; 

?>