<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$result_from_function =  $_POST['result_from_function'];

$Input_From_Python = $result_from_function;

$Mask =  $_POST['Mask'];
$IP_Address =  $_POST['IP_Address'];
$ZoneToConfig =  $_POST['ZoneToConfig'];
$validatedVLAN =  $_POST['validatedVLAN'];


$CIRDSecAndVLAN = "The requested security zone is: " . $ZoneToConfig;

$NotAHost = "This is not a host IP address, cannot be applied.";


$IP_AddressArray = explode('.', $IP_Address);

$IP_AddressFirstByte = (int)$IP_AddressArray[0];
$IP_AddressSecondByte = (int)$IP_AddressArray[1];
$IP_AddressThirdByte = (int)$IP_AddressArray[2];
$IP_AddressFourthByte = (int)$IP_AddressArray[3];



    if ( $IP_AddressFirstByte == 0 ||
                $IP_AddressFirstByte == 127 || 
                    ( (224 <=  $IP_AddressFirstByte ) && ($IP_AddressFirstByte <= 240)) ||
                        $IP_AddressFirstByte == 255) {

        $Result = "IP address first byte illegal value.";
        echo $Result;
        return;
    }



$Mask = str_replace(' ','', $Mask);
$Mask = (int)$Mask;

    if ( $Mask < 8 || $Mask > 30 ) {

        $Result = "IP Address prefix must be between 8 and 30.";
        echo $Result;
        return;
    }

$AddressIsValid = 0;

    if ($Mask == 24 && ( $IP_AddressFourthByte == 0 || $IP_AddressFourthByte == 255 ) ) { 
        echo $NotAHost;
        return;
    }

        if ($Mask > 24 ) {

        $MaskDifference = $Mask - 24;
        $NumberOfSubnets = pow(2, $MaskDifference);   
        $SubnetSizePower = 32 - $Mask;                
        $SubnetSize = pow(2, $SubnetSizePower);                 
        $SubnetWorkAddress = 0;

        for ($i = 0; $i < $NumberOfSubnets; ++$i) {

            $BroadcastAddress = $SubnetWorkAddress + $SubnetSize - 1;

            if ( ($IP_AddressFourthByte == $SubnetWorkAddress)  || 
                    ($IP_AddressFourthByte == $BroadcastAddress) ) {

                echo $NotAHost;
                return;
            }

            $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
        }

    }



    if ( ($Mask == 16) &&  ($IP_AddressThirdByte == 0 && 
                                  $IP_AddressFourthByte == 0) || 

                           ($IP_AddressThirdByte == 255 && 
                                  $IP_AddressFourthByte == 255) ) { 
        echo $NotAHost;
        return;
    }


    if ( (16 < $Mask) && ($Mask < 24)) { 

        if ( $IP_AddressFourthByte == 0 ) {

                $MaskDifference = $Mask - 16;                  
                $NumberOfSubnets = pow(2, $MaskDifference);    
                $SubnetSizePower = 24 - $Mask;                       
                $SubnetSize = pow(2, $SubnetSizePower);                   
                $SubnetWorkAddress = 0;

                for ($i = 0; $i < $NumberOfSubnets; ++$i) {

                    if ($IP_AddressThirdByte == $SubnetWorkAddress){

                        echo $NotAHost;
                        return;
                    }

                    $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
                }

        }          

        if ($IP_AddressFourthByte == 255 ) {  

            $MaskDifference = $Mask - 16;                          
            $NumberOfSubnets = pow(2, $MaskDifference);      
            $SubnetSizePower = 24 - $Mask;                                               
            $SubnetSize = pow(2, $SubnetSizePower);                     
            $SubnetWorkAddress = 0;

            for ($i = 0; $i < $NumberOfSubnets; ++$i) {
            
            $BroadcastAddress = $SubnetWorkAddress + $SubnetSize - 1;
            
                if ($IP_AddressThirdByte == $BroadcastAddress ){

                    echo $NotAHost;
                    return;
                }

            $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
            
            }
        }
    }




    if ( ($Mask == 8) && ( ( $IP_AddressSecondByte == 0 && 
                                $IP_AddressThirdByte == 0 && 
                                    $IP_AddressFourthByte == 0 ) || 
                           ( $IP_AddressSecondByte == 255 && 
                                $IP_AddressThirdByte == 255 && 
                                    $IP_AddressFourthByte == 255 ) ) ) { 
        echo $NotAHost;
        return;
    }

    if ( (8 < $Mask) && ($Mask < 16)) { 

        if ( $IP_AddressThirdByte == 0 && $IP_AddressFourthByte == 0 ) {

                $MaskDifference = $Mask - 8;                  
                $NumberOfSubnets = pow(2, $MaskDifference);    
                $SubnetSizePower = 16 - $Mask;                       
                $SubnetSize = pow(2, $SubnetSizePower);                   
                $SubnetWorkAddress = 0;

                for ($i = 0; $i < $NumberOfSubnets; ++$i) {

                    if ($IP_AddressSecondByte == $SubnetWorkAddress){

                        echo $NotAHost;
                        return;
                    }

                    $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
                }

        }          

        if ($IP_AddressThirdByte == 255 && $IP_AddressFourthByte == 255 ) {  

            $MaskDifference = $Mask - 8;                                                              
            $NumberOfSubnets = pow(2, $MaskDifference);                                       
            $SubnetSizePower = 16 - $Mask;                                                                                
            $SubnetSize = pow(2, $SubnetSizePower);                           
            $SubnetWorkAddress = 0;

            for ($i = 0; $i < $NumberOfSubnets; ++$i) {
            
            $BroadcastAddress = $SubnetWorkAddress + $SubnetSize - 1;
            
                if ($IP_AddressSecondByte == $BroadcastAddress ){

                    echo $NotAHost;
                    return;
                }

            $SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
            
            }
        }
    }



$Python_to_2D_Array = explode("])(", $Input_From_Python);

$CIRDSubnet = 0;
$CIRDArrays = 0;

$MaxIntNum1 = "This ICC FW has already been configured with the";
$MaxIntNum2 = "maximum number allowed of LAN-DMZ interfaces (20).";
$MaxIntNum = $MaxIntNum1 . "\r\n". $MaxIntNum2;

foreach($Python_to_2D_Array as $One_D_Array) {

    $One_D_Array = explode(',', $One_D_Array);
    $One_D_Array = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  
    $One_D_Array = str_replace(array('None'), "0",$One_D_Array);
    
    $Interface_Name = 0; 
    $Security_Zone = 2;
    $VLAN_Pointer = 4;
    $IP_Addr = 6;
    $CIRD = 10;


   if ( $One_D_Array[$CIRD] <> 0 ) {

            $To_VLANcird = explode('.',$One_D_Array[$VLAN_Pointer]);
            $VLANcird = $To_VLANcird[1];


            $One_D_Array[$CIRD] = str_replace(" ", "", $One_D_Array[$CIRD]);


            $CheckIfIPArrayFourBytes = explode('.',$One_D_Array[$CIRD]);
            $CheckIfIPArrayPrefix = explode('/',$One_D_Array[$CIRD]);

            if ( ((count($CheckIfIPArrayFourBytes) == 4) || (count($CheckIfIPArrayFourBytes) == 3)  )&& (count($CheckIfIPArrayPrefix) == 2) ) {

                $CIRDsToTest = $CIRDsToTest . "," .  $One_D_Array[$CIRD];
                $CIRDVLAN [$CIRDArrays] = $VLANcird;

                $VLANcird = (int)$VLANcird;
                $CIRDSecurityZone [$CIRDArrays] = $One_D_Array[$Security_Zone];


                $zonelandmz = $One_D_Array[$Security_Zone];
                
                $zonelandmz = str_replace("VRF_1_DMZ", "DMZ", $zonelandmz);

                $zonelandmz = str_replace("VRF_1_Trust", "LAN",  $zonelandmz);
                

                $zonelandmz = str_replace(" ", "",  $zonelandmz);

                $CIRDArrays = $CIRDArrays + 1;

                
                $VLANcird = (int)$VLANcird;
                $validatedVLAN = (int)$validatedVLAN;
                

                if ( ( $zonelandmz === $ZoneToConfig) && ($VLANcird == $validatedVLAN)){

                    $Result = "VLAN " . $validatedVLAN . " in Zone " . $ZoneToConfig . " has an IP address already configured.";
                    echo $Result;
                    return;
                }

                if ( $CIRDArrays >= 23 ) {
                    echo $MaxIntNum;
                    return;

                }
            }
    }
}

$CIRDsToTest = str_replace("em0.0,", "",$CIRDsToTest);
$CIRDsToTest = str_replace("MASK,0,128.0.1.16,", "",$CIRDsToTest);
$CIRDsToTest = str_replace("MASK,", "",$CIRDsToTest);

$CIRDsToTest = preg_replace('/,/', '', $CIRDsToTest, 1);

$ret = file_put_contents('/var/www/html/Show_Version/ExistingIntIPAddressesCIRD.txt', $CIRDsToTest); 

$ret = file_put_contents('/var/www/html/Show_Version/DuplicationTestAddress.txt', $IP_Address);


$NoOverlap = "NoOverlap";
$Overlap = "Overlap";


exec('python /var/www/html/php/DirectPythonFromPHP.py');

usleep(2000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/DirectPythonTest.txt', true);

    if ( $IsItDuplicate === "Overlap") {
        $Result = "IP address overlaps with existing interface subnet.";
        echo $Result;
        return;
    }

$i = 0;
$j = 0;



$No_IP_Address = "None";

//
// We search to see if this is a Cluster. If yes, there will be a reth2.32767 unit-interface by default.
// So, if no other interface has an IP address in the DMZ zone, we will set the DMZ interface to reth2.
// Otherwise the DMZ interface will be ge-0/0/4, as a standalone device.
//

$DMZIntNoIPAddress = "ge-0/0/4";

if ($ZoneToConfig === "DMZ") {

    foreach($Python_to_2D_Array as $One_D_Array) {

        $One_D_Array = explode(',', $One_D_Array);
        $One_D_Array = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  

        $ToInterface1 = $One_D_Array[0];

        $ToInterface2 = explode('.', $ToInterface1);

        $ToInterface3 = str_replace(array('[',']','(',')','\'', ' '), " ",$ToInterface2); 

        $Interface4 = $ToInterface3[0];

        $Interface = str_replace(" ", "", $Interface4);
        

        $ret = file_put_contents('/var/www/html/Show_Version/ToInterface.txt', $ToInterface2);
        $ret = file_put_contents('/var/www/html/Show_Version/Interface.txt', $Interface);
       

        if ($Interface === "reth2") {

            $DMZIntNoIPAddress = "reth2";

        }
    }
}



$DMZ_Interface = "none";


foreach($Python_to_2D_Array as $One_D_Array) {

    $One_D_Array = explode(',', $One_D_Array);
    $One_D_Array  = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  
    $One_D_Array  = str_replace(array('None'), "0",$One_D_Array);
    $One_D_Array  = str_replace(array('VRF_1_DMZ'), "1", $One_D_Array);
    $One_D_Array  = str_replace(array('VRF_1_Trust'), "2", $One_D_Array);

    
    $Interface_Name = 0; 
    $Security_Zone = 2;
    $VLAN_Pointer = 4;
    $IP_Addr = 6;  
    
 

   if ($One_D_Array[$IP_Addr] <> 0) {

     
            if ($One_D_Array[$Security_Zone] == 1 ) {

                $To_DMZ_Interface = explode('.', $One_D_Array[$Interface_Name]);
                $DMZ_Interface = $To_DMZ_Interface[0];
                $DMZ_Unit[$i] = $To_DMZ_Interface[1];

                $To_DMZ_VLAN = explode('.',$One_D_Array[$VLAN_Pointer]);
                $DMZ_VLAN[$i] = $To_DMZ_VLAN[1];

                $i = $i + 1;    
            }


             if ($One_D_Array[$Security_Zone] == 2 ) {

                $To_LAN_Interface = explode('.', $One_D_Array[$Interface_Name]);
                $LAN_Interface = $To_LAN_Interface[0];
                $LAN_Unit[$j] = $To_LAN_Interface[1];

                $To_LAN_VLAN = explode('.',$One_D_Array[$VLAN_Pointer]);
                $LAN_VLAN[$j] = $To_LAN_VLAN[1];

                $j = $j + 1;
            }
       
    }   
      
}

if ($DMZ_Interface === "none") {

$DMZ_Interface = $DMZIntNoIPAddress;

}




$Configure_FW_Filter = 1;


if ($ZoneToConfig === "DMZ") {

$Unit_To_Configure = 250;
$VLAN_To_Configure = $validatedVLAN;


// Search in the found logical interfaces, to see if the required VLAN
// has already been configured in some logical Unit.
// If it has, record the logical Unit on which it has been assigned.
// Also no FW filter will be applied, so $Configure_FW_Filter is set
// to zero.



    for($i = 0, $size = count($DMZ_VLAN); $i < $size; ++$i) {

        if ((int)$DMZ_VLAN[$i] == (int)$validatedVLAN) {


        $Unit_To_Configure = $DMZ_Unit[$i];
        $Configure_FW_Filter = $Configure_FW_Filter + 1;

        $DMZ_Interface = str_replace(' ', '', $DMZ_Interface);

        $IP_Config = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure ."family inet address " . 
        $IP_Address . "/" . $Mask;

        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);

        }

    }



    if ($Configure_FW_Filter == 1) {

        for($i = 0, $size = count($DMZ_Unit); $i < $size; ++$i) {
                       
            if (($Unit_To_Configure == $DMZ_Unit[$i]) && ((int)$DMZ_VLAN[$i] != (int)$validatedVLAN)){

                $Unit_To_Configure = $Unit_To_Configure + 1;
            }
        }

        $DMZ_Interface = str_replace(' ', '', $DMZ_Interface);

        $IP_Config_1 = "set interfaces " . $DMZ_Interface . " unit " . $Unit_To_Configure . " vlan-id " . $validatedVLAN;
        $IP_Config_2 = "set interfaces " . $DMZ_Interface . " unit " . $Unit_To_Configure . " family inet no-redirects";
        $IP_Config_3 = "set interfaces " . $DMZ_Interface . " unit " . $Unit_To_Configure . " family inet address " . 
        $IP_Address . "/" . $Mask;
        $IP_Config_4 = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure . " family inet filter input DMZ_INBOUND";
        $IP_Config_5 = "set routing-instances Service_VRF_1 interface " . $DMZ_Interface . "." . $Unit_To_Configure;
        $IP_Config_6 = "set security zones security-zone VRF_1_DMZ interfaces " . $DMZ_Interface . "." . $Unit_To_Configure . " host-inbound-traffic system-services ping";
        $IP_Config_7 = "set security zones security-zone VRF_1_DMZ interfaces " . $DMZ_Interface . "." . $Unit_To_Configure . " host-inbound-traffic system-services traceroute";
        $IP_Config_8 = "set security zones security-zone VRF_1_DMZ interfaces " . $DMZ_Interface . "." . $Unit_To_Configure . " host-inbound-traffic system-services dhcp";


        $IP_Config =  $IP_Config_1 ."\r\n". $IP_Config_2 ."\r\n". $IP_Config_3 ."\r\n". $IP_Config_4 ."\r\n".
                        $IP_Config_5 ."\r\n". $IP_Config_6 ."\r\n". $IP_Config_7 ."\r\n". $IP_Config_8;

        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);               
    }

}



if ($ZoneToConfig === "LAN") {

//$VLAN_To_Configure = 210;
$Unit_To_Configure = 200;



// Search in the found logical interfaces, to see if the required VLAN
// has already been configured in some logical Unit.

// If it has, record the logical Unit on which it has been assigned.
// Also no FW filter will be applied, so $Configure_FW_Filter is set
// to zero.


    for($i = 0, $size = count($LAN_Unit); $i < $size; ++$i) {

        if ((int)$LAN_VLAN[$i] == (int)$validatedVLAN) {

        $Unit_To_Configure = $LAN_Unit[$i];
        $Configure_FW_Filter = $Configure_FW_Filter + 1;

        $LAN_Interface = str_replace(' ', '', $LAN_Interface);

        $IP_Config = "set interfaces " . $LAN_Interface . " unit " . $Unit_To_Configure . " family inet address " . 
        $IP_Address . "/" . $Mask;

        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);

        }

    }


// If the VLAN has not been configured yet, loop to find if the candidate Unit
// exists in the configuration of this interface:


    if ($Configure_FW_Filter == 1) {

        for($i = 0, $size = count($LAN_Unit); $i < $size; ++$i) {

            if (($Unit_To_Configure == $LAN_Unit[$i]) && ((int)$LAN_VLAN[$i] != (int)$validatedVLAN)){
            
            $Unit_To_Configure = $Unit_To_Configure + 1;
            
            }
        }

        $LAN_Interface = str_replace(' ', '', $LAN_Interface);

        $IP_Config_1 = "set interfaces " . $LAN_Interface . " unit ". $Unit_To_Configure . " vlan-id " . $validatedVLAN;
        $IP_Config_2 = "set interfaces " . $LAN_Interface . " unit ". $Unit_To_Configure . " family inet no-redirects";
        $IP_Config_3 = "set interfaces " . $LAN_Interface . " unit ". $Unit_To_Configure . " family inet address " . 
        $IP_Address . "/" . $Mask;
        $IP_Config_4 = "set interfaces " . $LAN_Interface . " unit ". $Unit_To_Configure . " family inet filter input LAN_INBOUND";
        $IP_Config_5 = "set routing-instances Service_VRF_1 interface " . $LAN_Interface . "." . $Unit_To_Configure;
        $IP_Config_6 = "set security zones security-zone VRF_1_Trust interfaces " . $LAN_Interface . "." . $Unit_To_Configure . " host-inbound-traffic system-services ping";
        $IP_Config_7 = "set security zones security-zone VRF_1_Trust interfaces " . $LAN_Interface . "." . $Unit_To_Configure . " host-inbound-traffic system-services traceroute";
        $IP_Config_8 = "set security zones security-zone VRF_1_Trust interfaces " . $LAN_Interface . "." . $Unit_To_Configure . " host-inbound-traffic system-services dhcp";

        $IP_Config =  $IP_Config_1 ."\r\n". $IP_Config_2 ."\r\n". $IP_Config_3 ."\r\n". $IP_Config_4 ."\r\n".
                        $IP_Config_5 ."\r\n". $IP_Config_6 ."\r\n". $IP_Config_7 ."\r\n". $IP_Config_8;

	unlink('/var/www/html/Show_Version/FW_Config.set');
        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);   

    }
}

$Result = 1;
echo $Result;
return;

?>
