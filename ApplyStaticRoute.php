<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$RouteSUBNET = $_POST['RouteSUBNET'];
$RouteMASK = $_POST['RouteMASK'];
$RouteNextHop = $_POST['RouteNextHop'];


$NotNetworkAddress = "This is not a valid network address for this mask."; 

$RouteIsValid = 0;

$RouteNextHopArray = explode('.',  $RouteNextHop);

$RouteNextHopFirstByte = (int)$RouteNextHopArray[0];
$RouteNextHopSecondByte = (int)$RouteNextHopArray[1];
$RouteNextHopThirdByte = (int)$RouteNextHopArray[2];
$RouteNextHopFourthByte = (int)$RouteNextHopArray[3];

	if ( $RouteNextHopFirstByte == 0 ||
	     $RouteNextHopFirstByte == 127 ||
	     ( (224 <=  $RouteNextHopFirstByte) && ( $RouteNextHopFirstByte <= 240)) ||
	     $RouteNextHopFirstByte == 255 ) {

		$Result = "Next hop first byte illegal value.";
		echo $Result;
		return;
	}




$RouteSUBNETArray = explode('.', $RouteSUBNET);

$RouteSUBNETFirstByte = (int)$RouteSUBNETArray[0];
$RouteSUBNETSecondByte = (int)$RouteSUBNETArray[1];
$RouteSUBNETThirdByte = (int)$RouteSUBNETArray[2];
$RouteSUBNETFourthByte = (int)$RouteSUBNETArray[3];

	if ($RouteSUBNETFirstByte == 127 || 
	   ( (224 <=  $RouteSUBNETFirstByte) && ($RouteSUBNETFirstByte <= 240)) ||
	   $RouteSUBNETFirstByte == 255) {

		$Result = "Route subnet first byte illegal value.";
		echo $Result;
		return;
	}



$RouteMASK = str_replace(' ','',$RouteMASK);

$RouteMASK = (int)$RouteMASK;

if ($RouteMASK < 5 || $RouteMASK > 30) { 

	if ( ( $RouteSUBNETFirstByte != 0 ) ||
				 ( $RouteSUBNETSecondByte !=0 ) ||
					    ( $RouteSUBNETThirdByte !=0 ) ||
					    		($RouteSUBNETFourthByte ) ){
	
		$Result = "Prefix must be greater than 5 and smaller than 30.";
		echo $Result;
		return;
	}
}





	if (($RouteMASK == 0 ) && ($RouteSUBNETFirstByte != 0 ||
									 $RouteSUBNETSecondByte != 0 || 
									 	$RouteSUBNETThirdByte != 0 || 
											$RouteSUBNETFourthByte != 0)) { 
		$Result = $NotNetworkAddress;
		echo $Result;
		return;
	}



	if ( ($RouteSUBNETFirstByte == 0 &&
			 $RouteSUBNETSecondByte == 0 && 
				 	$RouteSUBNETThirdByte == 0 && 
							$RouteSUBNETFourthByte == 0) && 
												$RouteMASK != 0 ) { 

		$Result = "Only a mask of 0 is allowed for subnet 0.0.0.0.";
		echo $Result;
		return;
	}








    if ( (0 <  $RouteMASK) && ($RouteMASK < 8)) {


		if ($RouteSUBNETSecondByte != 0 ||
					  $RouteSUBNETThirdByte != 0 || 
					  		$RouteSUBNETFourthByte != 0) {
			$Result = $NotNetworkAddress;
			echo $Result;
			return;
		}

		$NumberOfSubnets = pow(2, $RouteMASK);
		$SubnetSizePower = 8 - $RouteMASK;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $RouteSUBNETSecondByte){

				$RouteIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($RouteIsValid == 0) {
			$Result = $NotNetworkAddress;
			echo $Result;
			return;
		}
	}






	if (($RouteMASK == 8 ) && ($RouteSUBNETSecondByte != 0 || 
									$RouteSUBNETThirdByte != 0 || 
										$RouteSUBNETFourthByte != 0)) { 
		$Result = $NotNetworkAddress;
		echo $Result;
		return;
	}

    if ( (8 <  $RouteMASK) && ($RouteMASK < 16)) {

		if ($RouteSUBNETThirdByte != 0 || $RouteSUBNETFourthByte != 0) {
		$Result = $NotNetworkAddress;
		echo $Result;
		return;
		}

		$MaskDifference = $RouteMASK - 8;      
		$NumberOfSubnets = pow(2, $MaskDifference);
		$SubnetSizePower = 16 - $RouteMASK;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $RouteSUBNETSecondByte){

				$RouteIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($RouteIsValid == 0) {
			$Result = $NotNetworkAddress;
			echo $Result;
			return;
		}
	}







	if (($RouteMASK == 16) && ($RouteSUBNETThirdByte != 0 || $RouteSUBNETFourthByte != 0)) { 
		$Result = $NotNetworkAddress;
		echo $Result;
		return;
	}

	if ( (16 <  $RouteMASK) && ($RouteMASK < 24)) {

		if ($RouteSUBNETFourthByte != 0) {
		$Result = $NotNetworkAddress;
		echo $Result;
		return;
		}

		$MaskDifference = $RouteMASK - 16;            
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 24 - $RouteMASK;                       
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $RouteSUBNETThirdByte){

				$RouteIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($RouteIsValid == 0) {
			$Result = $NotNetworkAddress;
			echo $Result;
			return;
		}
	}






	if (($RouteMASK == 24) && ($RouteSUBNETFourthByte != 0) ) { 
		$Result = $NotNetworkAddress;
		echo $Result;
		return;
	}

	if ($RouteMASK > 24 ) {

		$MaskDifference = $RouteMASK - 24;
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 32 - $RouteMASK;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $RouteSUBNETFourthByte){

				$RouteIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($RouteIsValid == 0) {
			$Result = $NotNetworkAddress;
			echo $Result;
			return;
		}
	}





$OverlapTestNetwork = str_replace(' ','', $RouteSUBNET);
$OverlapTestMask = str_replace(' ','', $RouteMASK);
$StaticRouteOverlapSubnet = $OverlapTestNetwork . "/" . $OverlapTestMask;

$RouteOverlapNextHop = str_replace(' ','', $RouteNextHop);



$ret = file_put_contents('/var/www/html/Show_Version/StaticRouteOverlapSubnet.txt', $StaticRouteOverlapSubnet); 

$ret = file_put_contents('/var/www/html/Show_Version/RouteOverlapNextHop.txt', $RouteOverlapNextHop);

exec('python /var/www/html/php/StaticRouteOverlapTest.py');

usleep(2000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/StaticRouteOverlapTest.txt', true);

    if ( ($IsItDuplicate === "Overlap") && ($RouteSUBNET != "0.0.0.0") ) {
        $Result = "Next hop cannot be part of the route subnet.";
        echo $Result;
        return;
    }









$StaticRouteConfig = "set routing-instances Service_VRF_1 routing-options static route " . $RouteSUBNET . "/" . 
						$RouteMASK . " next-hop " . $RouteNextHop . " resolve";

$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $StaticRouteConfig);
	
$Result = 1;
echo $Result;
return;

?>
