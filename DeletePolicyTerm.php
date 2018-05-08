<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$TermToBeDeleteded = $_POST['TermToBeDeleteded'];





$Term_To_Delete = str_replace('<','', $TermToBeDeleteded);
$Term_To_Delete = str_replace('>','', $Term_To_Delete);



//$Term_To_Delete = str_replace('d','', $Term_To_Delete);
//$Term_To_Delete = str_replace('i','', $Term_To_Delete);
//$Term_To_Delete = str_replace('v','', $Term_To_Delete);


$Term_To_Delete = str_replace('div','', $Term_To_Delete);

$Term_To_Delete = str_replace('/','', $Term_To_Delete);



$ret = file_put_contents('/var/www/html/Show_Version/Term_To_Delete.txt', $Term_To_Delete);


$SourceZone = file_get_contents('/var/www/html/Show_Version/SourceZone.txt', true);
$DestinationZone = file_get_contents('/var/www/html/Show_Version/DestinationZone.txt', true);

$result = "delete security policies from-zone " . $SourceZone . " to-zone " . $DestinationZone . " policy " . $Term_To_Delete;

unlink('/var/www/html/Show_Version/FW_Config.set');

$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $result);

$result = 1;

echo $result;

?>