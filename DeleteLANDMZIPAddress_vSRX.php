<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$InterfaceName = $_POST['InterfaceName'];
$AddressforDeletion = $_POST['AddressforDeletion'];


$Address = str_replace(' ', '', $AddressforDeletion);
$Address = str_replace('-', '',$Address);
$Address = str_replace('Secondary', '',$Address);


$InterfaceName = str_replace(' ', '', $InterfaceName);
$ToInterface = explode('.', $InterfaceName);

$Int = $ToInterface[0] . " unit " . $ToInterface[1];


if (($ToInterface[0] === "reth1") || ($ToInterface[0] === "ge-0/0/2") ){

	$CheckIfLanOrDMZ = "VRF_1_Trust";


	}
if (($ToInterface[0] === "reth2") || ($ToInterface[0] === "ge-0/0/3")){

	$CheckIfLanOrDMZ = "VRF_1_DMZ";

	}

$result1 = "delete interfaces " . $Int;
$result2 = "delete routing-instances Service_VRF_1 interface " . $InterfaceName;
$result3 = "delete security zones security-zone " . $CheckIfLanOrDMZ . " interfaces " . $InterfaceName;

$result =  $result1 ."\r\n". $result2 ."\r\n". $result3;


unlink('/var/www/html/Show_Version/FW_Config.set');

$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $result);

?>
