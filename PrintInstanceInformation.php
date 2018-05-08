<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$FromFile = file_get_contents('/var/www/html/Show_Version/GetInstanceInformation.txt', true);
$Python_to_2D_Array = explode(")]), (", $FromFile);



echo "<table><tr><td>VRF Name</td><td>Route Distinguisher</td><td>Import VRF Policy</td><td>Export VRF Policy</td><td>Member Interfaces</td></tr>";



foreach($Python_to_2D_Array as $One_D_Arr){

    $One_D_Array = explode(',', $One_D_Arr);

	$P = 1;
    $One_D_Ar = explode('interface-name', $One_D_Arr);


    if (strpos($One_D_Ar[$P], 'ge-') !== false) {


    	$Interface_Array = explode(',', $One_D_Ar[$P]);

    	$InterfacesArrayLength = count($Interface_Array);

    	$Interface_Array  = str_replace(array('[',']','(',')','\''), " ",$Interface_Array);  

        $One_D_Array = str_replace(array('[',']','(',')','\''), " ", $One_D_Array);

        $A = 0; 
        $B = 6;
        $C = 2;
        $D = 4;

        $E = 4;

        $al = $InterfacesArrayLength;




            
                echo "<tr><td>".$One_D_Array[$A]."</td><td>".$One_D_Array[$B]."</td><td>".$One_D_Array[$C]."</td>
                                            <td>".$One_D_Array[$D]."</td><td><div><table>"; 


            

 			for ($v = 1; $v < $InterfacesArrayLength; ++ $v) {

      			echo "<tr><td>".$Interface_Array[$v]."</td></tr>";

            	}
   

              echo  "</td></tr>";

            echo "</table></div></td>";
        }

}

echo "</table></div>";

return;

?>







