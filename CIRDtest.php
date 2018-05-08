<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

//$cird = "10.12.26.12/30";

//$ip = "10.12.26.1";
//list($subnet, $mask) = explode('/', $cidr);

//    if ((ip2long($ip) & ~((1 << (32 - $mask)) - 1) ) == ip2long($subnet)) { 
     //   return true;
     //}

$cidr = "Direct PHP Works!";

$ret = file_put_contents('/var/www/html/Show_Version/CIRD_TEST_TO_DELETE.txt', $cidr);

 
echo "Done";

?>
