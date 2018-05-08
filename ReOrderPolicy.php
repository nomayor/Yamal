<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$PolicyTermA = $_POST['PolicyTermA'];

$PolicyTermB = $_POST['PolicyTermB'];

$TermMoveDirection = $_POST['TermMoveDirection'];

$SourceZone = file_get_contents('/var/www/html/Show_Version/SourceZone.txt', true);
$DestinationZone = file_get_contents('/var/www/html/Show_Version/DestinationZone.txt', true);

if ($TermMoveDirection === "Before" ) {

	$TermMoveDirection = "before";
}

if ($TermMoveDirection === "After" ) {

	$TermMoveDirection = "after";
}

$result = "insert security policies from-zone " . $SourceZone . " to-zone " . $DestinationZone . " policy " . $PolicyTermA . " " . $TermMoveDirection . " policy " . $PolicyTermB;

$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $result);

?>