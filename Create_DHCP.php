<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$Config_from_vSRX = $_POST['Config_from_vSRX'];
$Interfaces_from_vSRX = $_POST['Interfaces_from_vSRX'];


$DHCP_Pool_Subnet = $_POST['DHCP_Pool_Subnet'];
$DHCP_Pool_Mask = $_POST['DHCP_Pool_Mask'];


$First_DHCP_Addr = $_POST['First_DHCP_Addr'];
$Last_DHCP_Addr = $_POST['Last_DHCP_Addr'];


$ZoneToConfig = $_POST['ZoneToConfig'];
$validatedVLAN = $_POST['validatedVLAN'];


$DNS_Server = $_POST['DNS_Server'];
$Default_GW = $_POST['Default_GW'];



$DHCP_Pool_MaskToInt = (int)$DHCP_Pool_Mask;

	if ( ($DHCP_Pool_MaskToInt < 24 ) || ($DHCP_Pool_MaskToInt > 28 ) )  {

		$Result = "DHCP Pool Prefix must be between /24 and /28 inclusive.";
		echo $Result;
		return;
	}





$DHCPPoolArray = explode('.', $DHCP_Pool_Subnet);

$DHCPPoolFirstByte = (int)$DHCPPoolArray[0];
$DHCPPoolSecondByte = (int)$DHCPPoolArray[1];
$DHCPPoolThirdByte = (int)$DHCPPoolArray[2];
$DHCPPoolFourthByte = (int)$DHCPPoolArray[3];

	if ( $DHCPPoolFirstByte == 0 ||
				$DHCPPoolFirstByte == 127 ||
	    	 		( (224 <=  $DHCPPoolFirstByte) && ( $DHCPPoolFirstByte <= 240)) ||
	   					  $DHCPPoolFirstByte == 255 ) {
		$Result = "DHCP Pool address first byte illegal value.";
		echo $Result;
		return;
	}


$DHCPSubnetIsValid = 0;
$NotNetworkAddressDHCP = "Not valid pool subnet for this mask."; 


	if ( ($DHCP_Pool_MaskToInt == 24) && ($DHCPPoolFourthByte != 0) ) { 
		$Result = $NotNetworkAddressDHCP;
		echo $Result;
		return;
	}

	if ($DHCP_Pool_MaskToInt > 24 ) {

		$MaskDifference = $DHCP_Pool_MaskToInt - 24;
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 32 - $DHCP_Pool_MaskToInt;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $DHCPPoolFourthByte){

				$DHCPSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($DHCPSubnetIsValid == 0) {
			$Result = $NotNetworkAddressDHCP;
			echo $Result;
			return;
		}
	}





$CIRDsToTest = $DHCP_Pool_Subnet . "/" . $DHCP_Pool_MaskToInt;



$DHCP_Pool_Start = str_replace(' ','', $First_DHCP_Addr);

$ret = file_put_contents('/var/www/html/Show_Version/DHCPPoolSubnet.txt', $CIRDsToTest); 

$ret = file_put_contents('/var/www/html/Show_Version/DHCPPoolStart.txt', $DHCP_Pool_Start);

exec('python /var/www/html/php/CheckIfFirstIPInPool.py');

usleep(1000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/CheckIfFirstIPInPool.txt', true);

    if ( $IsItDuplicate === "NoOverlap") {
        $Result = "Error: First assignable address not part of Pool.";
        echo $Result;
        return;
    }


$DHCP_Pool_Finish = str_replace(' ','', $Last_DHCP_Addr);

$ret = file_put_contents('/var/www/html/Show_Version/DHCPPoolFinish.txt', $DHCP_Pool_Finish);

exec('python /var/www/html/php/CheckIfLastIPInPool.py');

usleep(1000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/CheckIfLastIPInPool.txt', true);

    if ( $IsItDuplicate === "NoOverlap") {
        $Result = "Error: Last assignable address not part of Pool.";
        echo $Result;
        return;
    }




$FirstDHCPAddrArray = explode('.', $First_DHCP_Addr);

$FirstDHCPAddrFirstByte = (int)$FirstDHCPAddrArray[0];
$FirstDHCPAddrSecondByte = (int)$FirstDHCPAddrArray[1];
$FirstDHCPAddrThirdByte = (int)$FirstDHCPAddrArray[2];
$FirstDHCPAddrFourthByte = (int)$FirstDHCPAddrArray[3];


$AddressIsValid = 0;
$Result = "Assignable IP addresses cannot be the broadcast or network address.";

    if ($DHCP_Pool_MaskToInt == 24 && ( $FirstDHCPAddrFourthByte == 0 || $FirstDHCPAddrFourthByte == 255 ) ) { 

		echo $Result;
		return;

    }

        if ($DHCP_Pool_MaskToInt > 24 ) {

        $MaskDifference = $DHCP_Pool_MaskToInt - 24;
        $NumberOfSubnets = pow(2, $MaskDifference);   
        $SubnetSizePower = 32 - $DHCP_Pool_MaskToInt;                
        $SubnetSize = pow(2, $SubnetSizePower);                 
        $SubnetWorkAddress = 0;

        for ($i = 0; $i < $NumberOfSubnets; ++$i) {

            $BroadcastAddress = $SubnetWorkAddress + $SubnetSize - 1;

            if ( ($FirstDHCPAddrFourthByte == $SubnetWorkAddress)  || 
                    ($FirstDHCPAddrFourthByte == $BroadcastAddress) ) {
                echo $Result;
                return;
            }

            $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
        }

    }



$LastDHCPAddrArray = explode('.', $Last_DHCP_Addr);

$LastDHCPAddrFirstByte = (int)$LastDHCPAddrArray[0];
$LastDHCPAddrSecondByte = (int)$LastDHCPAddrArray[1];
$LastDHCPAddrThirdByte = (int)$LastDHCPAddrArray[2];
$LastDHCPAddrFourthByte = (int)$LastDHCPAddrArray[3];

    if ($DHCP_Pool_MaskToInt == 24 && ( $LastDHCPAddrFourthByte == 0 || $LastDHCPAddrFourthByte == 255 ) ) { 

		echo $Result;
		return;

    }

        if ($DHCP_Pool_MaskToInt > 24 ) {

        $MaskDifference = $DHCP_Pool_MaskToInt - 24;
        $NumberOfSubnets = pow(2, $MaskDifference);   
        $SubnetSizePower = 32 - $DHCP_Pool_MaskToInt;                
        $SubnetSize = pow(2, $SubnetSizePower);                 
        $SubnetWorkAddress = 0;

        for ($i = 0; $i < $NumberOfSubnets; ++$i) {

            $BroadcastAddress = $SubnetWorkAddress + $SubnetSize - 1;

            if ( ($LastDHCPAddrFourthByte == $SubnetWorkAddress)  || 
                    ($LastDHCPAddrFourthBytee == $BroadcastAddress) ) {
                echo $Result;
                return;
            }

            $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
        }

    }


$DefaultGWArray = explode('.', $Default_GW);

$DefaultGWFirstByte = (int)$DefaultGWArray[0];
$DefaultGWSecondByte = (int)$DefaultGWArray[1];
$DefaultGWThirdByte = (int)$DefaultGWArray[2];
$DefaultGWFourthByte = (int)$DefaultGWArray[3];

	if ( $DefaultGWFirstByte == 0 ||
				$DefaultGWFirstByte == 127 ||
	    	 		( (224 <=  $DefaultGWFirstByte) && ( $DefaultGWFirstByte <= 240)) ||
	   					  $DefaultGWFirstByte == 255 ) {
		$Result = "Default Gateway first byte illegal value.";
		echo $Result;
		return;
	}


$DefaultGWIfIncluded = str_replace(' ','', $Default_GW);

$ret = file_put_contents('/var/www/html/Show_Version/DHCPPoolDefaultGateway.txt', $DefaultGWIfIncluded);

exec('python /var/www/html/php/CheckIfDGWIPInPool.py');

usleep(1000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/CheckIfDGWIPInPool.txt', true);

    if ( $IsItDuplicate === "NoOverlap") {
        $Result = "Default Gateway must be included in the DHCP pool.";
        echo $Result;
        return;
    }




$AddressIsValid = 0;
$Result = "Default Gateway cannot be the broadcast or network address.";

    if ($DHCP_Pool_MaskToInt == 24 && ( $DefaultGWFourthByte == 0 || $DefaultGWFourthByte == 255 ) ) { 
		
		echo $Result;
		return;
    }

        if ($DHCP_Pool_MaskToInt > 24 ) {

        $MaskDifference = $DHCP_Pool_MaskToInt - 24;
        $NumberOfSubnets = pow(2, $MaskDifference);   
        $SubnetSizePower = 32 - $DHCP_Pool_MaskToInt;                
        $SubnetSize = pow(2, $SubnetSizePower);                 
        $SubnetWorkAddress = 0;

        for ($i = 0; $i < $NumberOfSubnets; ++$i) {

            $BroadcastAddress = $SubnetWorkAddress + $SubnetSize - 1;

            if ( ($DefaultGWFourthByte == $SubnetWorkAddress)  || 
                    ($DefaultGWFourthByte == $BroadcastAddress) ) {
                echo $Result;
                return;
            }

            $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
        }

    }



$DNSServerArray = explode ('.', $DNS_Server);

$DNSServerFirstByte = (int)$DNSServerArray[0];
$DNSServerSecondByte = (int)$DNSServerArray[1];
$DNSServerThirdByte = (int)$DNSServerArray[2];
$DNSServerFourthByte = (int)$DNSServerArray[3];

	if ( $DNSServerFirstByte == 0 ||
				$DNSServerFirstByte == 127 ||
	    	 		( (224 <=  $DNSServerFirstByte) && ( $DNSServerFirstByte <= 240)) ||
	   					  $DNSServerFirstByte == 255 ) {
		$Result = "DNS Server first byte illegal value.";
		echo $Result;
		return;
	}



$DNSServerIfIncluded = str_replace(' ','', $DNS_Server);

$ret = file_put_contents('/var/www/html/Show_Version/DHCPPoolDNSServer.txt', $DNSServerIfIncluded);

exec('python /var/www/html/php/CheckIfDNSIPInPool.py');

usleep(1000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/CheckIfDNSIPInPool.txt', true);

    if ( $IsItDuplicate === "Overlap") {
        $Result = "DNS cannot be part of the assignable IP address range.";
        echo $Result;
        return;
    }



if ( ($Default_GW === $First_DHCP_Addr) ||  ($Default_GW === $Last_DHCP_Addr) ) {

        $Result = "Default Gateway must be different than Assignable IPs.";
        echo $Result;
        return;
}


if ( $First_DHCP_Addr === $Last_DHCP_Addr ) {

        $Result = "First and last Assignable IPs cannot be equal.";
        echo $Result;
        return;
}




if ($ZoneToConfig == "DMZ") { 

	$Zone = "1";

}


if ($ZoneToConfig == "LAN") { 

	$Zone = "2";

}



//////////////////////////////////////////////////////////////////////////
//
// First we need to find the Unit to which this VLAN corresponds,
// in order to check if this has already been configured for  
// DHCP
//
//
$InterfaceNames = "0";


$DHCP_Status = 0;
$Output_Sent = 0;


$Interfaces_from_vSRX = str_replace(')])(','VVVVV',$Interfaces_from_vSRX);

$Python_to_2D_Array = explode("VVVVV", $Interfaces_from_vSRX);


foreach($Python_to_2D_Array as $One_D_Array) {


    $One_D_Array = explode(',', $One_D_Array);
    $One_D_Array = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  
    $One_D_Array = str_replace(array('None'), "0",$One_D_Array);


    
    $One_D_Array[$Security_Zone] = str_replace('VRF_1_DMZ', '1', $One_D_Array[$Security_Zone]);
    $One_D_Array[$Security_Zone] = str_replace('VRF_1_Trust','2', $One_D_Array[$Security_Zone]);


    $Interface_Name = 0; 
    $Security_Zone = 2;
    $VLAN_Pointer = 4;
    $IP_Addr = 6;  



 
$DEST_Adress_Book = str_replace('.','_',$DEST_Adress_Book);


$One_D_Array[$IP_Addr] = str_replace(' ','', $One_D_Array[$IP_Addr]);
$One_D_Array[$VLAN_Pointer] = str_replace(' ', '', $One_D_Array[$VLAN_Pointer]);
$One_D_Array[$Interface_Name] = str_replace(' ','', $One_D_Array[$Interface_Name]);
$One_D_Array[$Security_Zone] = str_replace(' ','', $One_D_Array[$Security_Zone]);



//   [('ZONE_NAME', 'VRF_1_DMZ'), ('VLAN', '[ 0x8100.400 ]'), ('IP_ADDRESS', '172.31.22.251'), ('Name', 'ge-0/0/4.250')])
//     ('ge-0/0/4.250', [('ZONE_NAME', 'VRF_1_DMZ'), ('VLAN', '[ 0x8100.400 ]'),
   





   if ($One_D_Array[$IP_Addr] <> 0) {  


 
        if ($One_D_Array[$Security_Zone] - $Zone == 0) {
	
        
            $To_Interface = explode('.', $One_D_Array[$Interface_Name]);
            $Interface = $To_Interface[0];
            $Unit = $To_Interface[1];

            $To_VLAN = explode('.',$One_D_Array[$VLAN_Pointer]);
            $VLAN = $To_VLAN[1];
 	
	    

            $VLAN = str_replace(' ','',$VLAN);
	        $validatedVLAN = str_replace(' ','',$validatedVLAN);


		
            if ($VLAN - $validatedVLAN == 0) {

           	$DHCP_Interface = $One_D_Array[$Interface_Name];
            $DHCP_Interface = str_replace(" ", "", $DHCP_Interface);

            $DHCP_Status = 1;
            $Int_Found = 1;
           	}   
           	
	    }
	}

}


///////////////////////////////////////////////////////////////////////////////
//
// Second, find if this VLAN is present in the indicated Zone
//
//


if ($DHCP_Status == 0 ) {

	$DHCP_Status = "VLAN not present in this Zone";
	$Output_Sent = 1;
	$Int_Found = 0; 
 }


///////////////////////////////////////////////////////////////////////////////
//
// Third, find if this Interface/Unit has already been configured for DHCP
//
//



if ($Int_Found == 1 ) {

	$Config_To_Array = explode(',', $Config_from_vSRX);

	$Config_To_Array = str_replace(array('[',']','(',')','\''), "", $Config_To_Array); 


	for ($i = 0, $size = count($Config_To_Array); $i < $size; ++$i) {

		$test = $Config_To_Array[$i];

		$test = str_replace(" ", "", $test);

	    if ($test == $DHCP_Interface) {
		
  	   		$DHCP_Status = "Interface already configured for DHCP";  	
		}
	}
}



if ($DHCP_Status == 1) {

	if ($Zone == 1) { $Zone = "VRF_1_DMZ"; }
	if ($Zone == 2) { $Zone = "VRF_1_Trust"; }

	$DHCP_Int = str_replace('/','_', $DHCP_Interface);

	$DHCP_Int = explode('.', $DHCP_Int);



	$DHCP_POOL_Network = $DHCP_Pool_Subnet . "/". $DHCP_Pool_Mask;

	
	$DHCP_Config_1 = "set routing-instances Service_VRF_1 system services dhcp-local-server group DHCP-VRF-1_" . 
						$DHCP_Int[0]. "_" . $DHCP_Int[1] . " interface " . $DHCP_Interface;
	

	$DHCP_Config_2 = "set routing-instances Service_VRF_1 access address-assignment pool ". $Zone . "_DHCP_POOL_". 
						$DHCP_Int[0]. "_" . $DHCP_Int[1] . " family inet network " . $DHCP_POOL_Network;
	
           
        $DHCP_Config_3 = "set routing-instances Service_VRF_1 access address-assignment pool ". $Zone . "_DHCP_POOL_". 
						$DHCP_Int[0]. "_" . $DHCP_Int[1] . " family inet range RANGE low " . $First_DHCP_Addr;


	$DHCP_Config_4 = "set routing-instances Service_VRF_1 access address-assignment pool ". $Zone . "_DHCP_POOL_". 
						$DHCP_Int[0]. "_" . $DHCP_Int[1] . " family inet range RANGE high " . $Last_DHCP_Addr;


	$DHCP_Config_5 = "set routing-instances Service_VRF_1 access address-assignment pool ". $Zone . "_DHCP_POOL_". 
						$DHCP_Int[0]. "_" . $DHCP_Int[1] . " family inet dhcp-attributes name-server " . $DNS_Server;


	$DHCP_Config_6 = "set routing-instances Service_VRF_1 access address-assignment pool ". $Zone . "_DHCP_POOL_". 
						$DHCP_Int[0]. "_" . $DHCP_Int[1] . " family inet dhcp-attributes router " . $Default_GW;


	$DHCP_Config_7 = "set security zones security-zone " . $Zone . " interfaces " . $DHCP_Interface . 
						" host-inbound-traffic system-services dhcp";
	$DHCP_Config_8 = "set security zones security-zone " . $Zone . " interfaces " . $DHCP_Interface . 
						" host-inbound-traffic system-services ping";					

	$DHCP_Config =  $DHCP_Config_1 ."\r\n". $DHCP_Config_2 . "\r\n". $DHCP_Config_3 . 
						"\r\n".  $DHCP_Config_4 . "\r\n". $DHCP_Config_5 . "\r\n". 
							$DHCP_Config_6 . "\r\n". $DHCP_Config_7 . "\r\n". $DHCP_Config_8;

	$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $DHCP_Config);
	
}


echo $DHCP_Status;
return;
?>
