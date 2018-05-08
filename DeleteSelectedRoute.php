<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$RouteType = $_POST['RouteType'];
$Interface = $_POST['Interface'];
$LocalAddress = $_POST['LocalAddress'];
$RouteToBeDeleted = $_POST['RouteToBeDeleted'];



if ($RouteType === "Static") {

$result = "delete routing-instances Service_VRF_1 routing-options static route " . $RouteToBeDeleted;

}


if ($RouteType === "Direct") {

$ToPrefix = explode('/', $LocalAddress);
$Prefix = $ToPrefix[0];

$ToSubnetMask = explode('/', $RouteToBeDeleted);
$SubnetMask =$ToSubnetMask[1];

$RouteforDeletion = $Prefix . "/" . $SubnetMask;

$ToInterface = explode('.', $Interface);

$Int = $ToInterface[0] . " unit " . $ToInterface[1];


$result = "delete interfaces " . $Int . " family inet address " . $RouteforDeletion;

}


unlink('/var/www/html/Show_Version/FW_Config.set');

$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $result);

//$result = "Done";

//echo $result;

?>