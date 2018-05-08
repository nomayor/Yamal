<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$Config_from_vSRX = $_POST['Config_from_vSRX'];

$ret = file_put_contents('/var/www/html/Show_Version/Post_ICC_ID.txt', $Config_from_vSRX);
	
}

echo $Config_from_vSRX ;

?>
