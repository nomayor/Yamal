<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$servername = "localhost";
$username = "root";
$password = "1nterouteCPE";
$dbname = "SIDIPADDRESS";



$link = mysql_connect($servername, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

@mysql_select_db($dbname) or die( "Unable to select database");

$result = mysql_query("SELECT * FROM SIDIPADDRESS_Table_2");
if (!$result) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}


echo "<table><b><tr><td>Fusion PE Hostname</td><td>Current Local Identifier</td><td>New Required Identifier</td><td>Rename this device</td></tr>";

while ($row = mysql_fetch_array($result)) {

echo "<tr><td>" . $row['InterouteSID'] . "</td><td>" . $row['FWLocalIdentifier'] . "</td></tr>";

}


mysql_free_result($result);
mysql_close($link);











//$FW_Names = file_get_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', true);

//$Array = explode(',', $FW_Names);

//echo "<table><b><tr><td>Interoute Service Identifier</td><td>Current Local Identifier</td><td>New Required Identifier</td><td>Rename this device</td></tr>";

//for ($i = 0, $size = count($Array); $i < $size; ++ $i) {

//$j = $i + 1;
//	echo "<tr><td>".$Array[$i]."</td><td>".$Array[$j]."</td></tr>";

//$i = $i + 1;

//}

$result = "Done";

?>
