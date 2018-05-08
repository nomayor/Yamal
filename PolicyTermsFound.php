<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$PolicyTermsFound = file_get_contents('/var/www/html/Show_Version/PolicyTermsFound.txt', true);


echo $PolicyTermsFound;

?>