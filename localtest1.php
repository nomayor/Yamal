<?php 

function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}



$url = get_data('http://127.0.1.1/AddressOverlap/');

$gotanswer = "Obtained PHP answer: " . $url;



$ret = file_put_contents('/var/www/html/Show_Version/urlfromphp.txt', $gotanswer);


?>