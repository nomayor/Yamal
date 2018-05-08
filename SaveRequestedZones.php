<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$SaveRequestedZones = $_POST['SaveRequestedZones'];

$SaveRequestedZones  = str_replace('LAN', "VRF_1_Trust", $SaveRequestedZones);
$SaveRequestedZones  = str_replace('DMZ', "VRF_1_DMZ", $SaveRequestedZones);
$SaveRequestedZones  = str_replace('WAN', "VRF_1_Untrust", $SaveRequestedZones);

$PolicyZones = explode(" to ", $SaveRequestedZones);

$Source = str_replace(' ','',$PolicyZones[0]);
$Destination = str_replace(' ','',$PolicyZones[1]);

$retSZ = file_put_contents('/var/www/html/Show_Version/SourceZone.txt', $Source);
$retDZ = file_put_contents('/var/www/html/Show_Version/DestinationZone.txt', $Destination);

?>

