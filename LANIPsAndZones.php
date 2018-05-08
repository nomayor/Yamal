<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);



$Input_From_Python =  $_POST['Input_From_Python'];

$Zone = $_POST['Zone'];


$Python_to_2D_Array = explode("])(", $Input_From_Python);



$No_IP_Address = "None";

echo "<table><b><tr><td>Interface Name</td><td>Security Zone</td><td>VLAN Number</td><td>IP Address</td><td>Delete</td></b></tr>";

foreach($Python_to_2D_Array as $One_D_Array) {

    $One_D_Array = explode(',', $One_D_Array);
    $One_D_Array  = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  
    $One_D_Array  = str_replace(array('None'), "0",$One_D_Array);
    $One_D_Array  = str_replace(array('VRF_1_DMZ'), "1", $One_D_Array);
    $One_D_Array  = str_replace(array('VRF_1_Trust'), "2", $One_D_Array);

    $One_D_Array  = str_replace(array('Name'), "44444", $One_D_Array);

        $Interface_Name = 0; 
        $Security_Zone = 2;
        $VLAN_Pointer = 4;
        $IP_Address = 6;  
        $Secondary_Reference = 6;
        $Secondary_IP = 7;
        $Mask = 10;
        $NumberOfSecondaryIPs = 0;

    if ($One_D_Array[$IP_Address] <> 0) {

            $To_VLAN = explode('.',$One_D_Array[$VLAN_Pointer]);
            $VLAN = $To_VLAN[1];
        
            $To_Mask = explode('/',$One_D_Array[$Mask]);
            $M = $To_Mask[1];
       
            $IP_ADDR = $One_D_Array[$IP_Address]."/" . $M;     
                

            if ($One_D_Array[$Security_Zone] == 2 ) {

           
                while ($One_D_Array[$Secondary_IP] != 44444) {

                    $NumberOfSecondaryIPs = $NumberOfSecondaryIPs + 1;
                    $Secondary_IP = $Secondary_IP + 1;

                }

                
                
                if ($NumberOfSecondaryIPs == 0) { 
                
                echo "<tr><td>".$One_D_Array[$Interface_Name]."</td><td>"."LAN"."</td>
                <td>".$VLAN."</td><td>".$IP_ADDR."</td></tr>";

                }

                if ($NumberOfSecondaryIPs > 0) {            

                $MaskPointer = $IP_Address + $NumberOfSecondaryIPs + 4;
                $To_Mask = explode('/',$One_D_Array[$MaskPointer]);
                $M = $To_Mask[1];
           
                $IP_ADDR = $One_D_Array[$IP_Address]."/" . $M;

                echo "<tr><td>".$One_D_Array[$Interface_Name]."</td><td>"."LAN"."</td>
                <td>".$VLAN."</td><td>".$IP_ADDR."</td></tr>";

                    for ($x = 1; $x <= $NumberOfSecondaryIPs; $x++) {

                        $SecondaryMaskPointer = $Secondary_Reference + $NumberOfSecondaryIPs + 4 + $x;
                        $To_SecondaryMask = explode('/',$One_D_Array[$SecondaryMaskPointer]);
                        $SecondaryMask = $To_SecondaryMask[1];

                        $SecondAddrPointer = $Secondary_Reference + $x;
                        $SecondaryIPAddress = $One_D_Array[$SecondAddrPointer];

                        $Second = $SecondaryIPAddress ."/" . $SecondaryMask;

                        $Second = $Second . " - Secondary";

                        echo "<tr><td>".$One_D_Array[$Interface_Name]."</td><td>"."LAN"."</td>
                        <td>".$VLAN."</td><td>".$Second."</td></tr>";
                      
                    }

                }

            }
       
    }   
      
}

echo "</table></div>";

?>