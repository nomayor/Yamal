<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);



$Input_From_Python =  $_POST['Input_From_Python'];

//$Input_From_Python = file_get_contents('/var/www/html/Show_Version/interfaceszonesips.txt', true);

$Python_to_2D_Array = explode("])(", $Input_From_Python);





$No_IP_Address = "None";

echo "<table><b><tr><td>Interface Name</td><td>Security Zone</td><td>VLAN Number</td><td>IP Address</td></b></tr>";

foreach($Python_to_2D_Array as $One_D_Array) {

    $One_D_Array = explode(',', $One_D_Array);
    $One_D_Array  = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  
    $One_D_Array  = str_replace(array('None'), "0",$One_D_Array);
    $One_D_Array  = str_replace(array('VRF_1_DMZ'), "1", $One_D_Array);
    $One_D_Array  = str_replace(array('VRF_1_Trust'), "2", $One_D_Array);

        $Interface_Name = 0; 
        $Security_Zone = 2;
        $VLAN_Pointer = 4;
        $IP_Address = 6;  
        
    

    if ($One_D_Array[$IP_Address] <> 0) {

            $To_VLAN = explode('.',$One_D_Array[$VLAN_Pointer]);
            $VLAN = $To_VLAN[1];
        
            if ($One_D_Array[$Security_Zone] == 1 ) {

                echo "<tr><td>".$One_D_Array[$Interface_Name]."</td><td>"."VRF_1_DMZ"."</td>
                <td>".$VLAN."</td><td>".$One_D_Array[$IP_Address]."</td></tr>";
            }


             if ($One_D_Array[$Security_Zone] == 2 ) {

                echo "<tr><td>".$One_D_Array[$Interface_Name]."</td><td>"."VRF_1_Trust"."</td>
                <td>".$VLAN."</td><td>".$One_D_Array[$IP_Address]."</td></tr>";
            }

       
    }   
      
}

echo "</table></div>";

?>
