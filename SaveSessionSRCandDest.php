<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$SessionSRC = $_POST['SessionSRC'];
$SessionDST = $_POST['SessionDST'];
$SessionSpec = $_POST['SessionSpec'];

$NotNetworkAddress = "This is not a valid network address for this mask."; 

$RouteIsValid = 0;


if ($SessionSRC === $SessionDST) {

	$Result = "Session source cannot be same as session destination.";
	echo $Result;
	return;
}



if ($SessionSpec === "SourceDestination") {

$SessionSRCArray = explode('.',  $SessionSRC);

$SessionSRCFirstByte = (int)$SessionSRCArray[0];
$SessionSRCSecondByte = (int)$SessionSRCArray[1];
$SessionSRCThirdByte = (int)$SessionSRCArray[2];
$SessionSRCFourthByte = (int)$SessionSRCArray[3];

	if ( $SessionSRCFirstByte == 0 ||
	     $SessionSRCFirstByte == 127 ||
	     ( (224 <=  $SessionSRCFirstByte) && ( $SessionSRCFirstByte <= 240)) ||
	     $SessionSRCFirstByte == 255 ) {

		$Result = "Source IP address illegal value.";
		echo $Result;
		return;
	}

$SessionDSTArray = explode('.',  $SessionDST);

$SessionDSTFirstByte = (int)$SessionDSTArray[0];
$SessionDSTSecondByte = (int)$SessionDSTArray[1];
$SessionDSTThirdByte = (int)$SessionDSTArray[2];
$SessionDSTFourthByte = (int)$SessionDSTArray[3];

	if ( $SessionDSTFirstByte == 0 ||
	     $SessionDSTFirstByte == 127 ||
	     ( (224 <=  $SessionDSTFirstByte) && ( $SessionDSTFirstByte <= 240)) ||
	     $SessionDSTFirstByte == 255 ) {

		$Result = "Destination IP address illegal value.";
		echo $Result;
		return;
	}

}


if ($SessionSpec === "SourceOnly") {

$SessionSRCArray = explode('.',  $SessionSRC);

$SessionSRCFirstByte = (int)$SessionSRCArray[0];
$SessionSRCSecondByte = (int)$SessionSRCArray[1];
$SessionSRCThirdByte = (int)$SessionSRCArray[2];
$SessionSRCFourthByte = (int)$SessionSRCArray[3];

	if ( $SessionSRCFirstByte == 0 ||
	     $SessionSRCFirstByte == 127 ||
	     ( (224 <=  $SessionSRCFirstByte) && ( $SessionSRCFirstByte <= 240)) ||
	     $SessionSRCFirstByte == 255 ) {

		$Result = "Source IP address illegal value.";
		echo $Result;
		return;
	}

$SessionDST = "0.0.0.0/0";

}



if ($SessionSpec === "DestinationOnly") {

$SessionDSTArray = explode('.',  $SessionDST);

$SessionDSTFirstByte = (int)$SessionDSTArray[0];
$SessionDSTSecondByte = (int)$SessionDSTArray[1];
$SessionDSTThirdByte = (int)$SessionDSTArray[2];
$SessionDSTFourthByte = (int)$SessionDSTArray[3];

	if ( $SessionDSTFirstByte == 0 ||
	     $SessionDSTFirstByte == 127 ||
	     ( (224 <=  $SessionDSTFirstByte) && ( $SessionDSTFirstByte <= 240)) ||
	     $SessionDSTFirstByte == 255 ) {

		$Result = "Destination IP address illegal value.";
		echo $Result;
		return;
	}

$SessionSRC = "0.0.0.0/0";

}


$ret = file_put_contents('/var/www/html/Show_Version/USessionSource.txt', $SessionSRC);
$ret = file_put_contents('/var/www/html/Show_Version/USessionDestination.txt', $SessionDST);

$Result = 1;
echo $Result;
return;

?>
