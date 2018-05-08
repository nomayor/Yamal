<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$result_from_function =  $_POST['result_from_function'];

$Input_From_Python = $result_from_function;

$Mask =  $_POST['Mask'];
$IP_Address =  $_POST['IP_Address'];
$ZoneToConfig =  $_POST['ZoneToConfig'];
$validatedVLAN =  $_POST['validatedVLAN'];
                               

$Python_to_2D_Array = explode("])(", $Input_From_Python);


$i = 0;
$j = 0;



$No_IP_Address = "None";




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





$Configure_FW_Filter = 1;

if ($ZoneToConfig === "DMZ") {

$Unit_To_Configure = 251;
$VLAN_To_Configure = $validatedVLAN;


// Search in the found logical interfaces, to see if the required VLAN
// has already been configured in some logical Unit.
// If it has, record the logical Unit on which it has been assigned.
// Also no FW filter will be applied, so $Configure_FW_Filter is set
// to zero.



    for($i = 0, $size = count($DMZ_VLAN); $i < $size; ++$i) {
    

//
        if ((int)$DMZ_VLAN[$i] == (int)$validatedVLAN) {

        $Unit_To_Configure = $DMZ_Unit[$i];
        $Configure_FW_Filter += 1;

        $IP_Config = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure ." family inet address " . 
        $IP_Address . "/" . $Mask;

        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);
        }

    }



    if ($Configure_FW_Filter == 1) {

        for($i = 0, $size = count($DMZ_Unit); $i < $size; ++$i) {

            if ($Unit_To_Configure  == $DMZ_Unit[$i] ) {

                $Unit_To_Configure = $Unit_To_Configure + 1;
            }
        }

        $IP_Config_1 = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure . " vlan-id " . $validatedVLAN;
        $IP_Config_2 = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure . " family inet no-redirects";
        $IP_Config_3 = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure ." family inet address " . 
        $IP_Address . "/" . $Mask;
        $IP_Config_4 = "set interfaces " . $DMZ_Interface . " unit ". $Unit_To_Configure ." family inet filter input DMZ_INBOUND";
        $IP_Config_5 = "set routing-instances Service_VRF_1 interface " . $DMZ_Interface . "." . $Unit_To_Configure;
        $IP_Config_6 = "set security zones security-zone VRF_1_DMZ interfaces" . $DMZ_Interface . "." . $Unit_To_Configure;


        $IP_Config =  $IP_Config_1 ."\r\n". $IP_Config_2 ."\r\n". $IP_Config_3 ."\r\n". $IP_Config_4 ."\r\n".
                        $IP_Config_5 ."\r\n". $IP_Config_6;

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
            $Configure_FW_Filter += 1;

        $IP_Config = "set interfaces " . $LAN_Interface . " unit ". $Unit_To_Configure ." family inet address " . 
        $IP_Address . "/" . $Mask;

        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);


        }

    }

// If the VLAN has not been configured yet, loop to find if the candidate Unit
// exists in the configuration of this interface:

    if ($Configure_FW_Filter = 1) {

        for($i = 0, $size = count($LAN_Unit); $i < $size; ++$i) {

            if ($Unit_To_Configure = $LAN_Unit[$i]){

                $Unit_To_Configure = $Unit_To_Configure + 1;
            }
        }


        $IP_Config_1 = "set interfaces" . $LAN_Interface . " unit ". $Unit_To_Configure . " vlan-id " . $validatedVLAN;
        $IP_Config_2 = "set interfaces" . $LAN_Interface . " unit ". $Unit_To_Configure . " family inet no-redirects";
        $IP_Config_3 = "set interfaces" . $LAN_Interface . " unit ". $Unit_To_Configure ." family inet address " . 
        $IP_Address . "/" . $Mask;
        $IP_Config_4 = "set interfaces" . $LAN_Interface . " unit ". $Unit_To_Configure ." family inet filter input LAN_INBOUND";
        $IP_Config_5 = "set routing-instances Service_VRF_1 interface" . $LAN_Interface . "." . $Unit_To_Configure;
        $IP_Config_6 = "set security zones security-zone VRF_1_Trust interfaces" . $LAN_Interface . "." . $Unit_To_Configure;

        $IP_Config =  $IP_Config_1 ."\r\n". $IP_Config_2 ."\r\n". $IP_Config_3 ."\r\n". $IP_Config_4 ."\r\n".
                        $IP_Config_5 ."\r\n". $IP_Config_6;

        $ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $IP_Config);   

    }
}

echo "Done";

?>
