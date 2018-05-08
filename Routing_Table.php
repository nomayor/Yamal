<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

//$Input_From_Python =  $_POST['Input_From_Python'];
//$Python_to_2D_Array = explode(")])(", $Input_From_Python);

$FromFile = file_get_contents('/var/www/html/Show_Version/InterfacesOutputFromvSRX.txt', true);
$Python_to_2D_Array = explode(")]), (", $FromFile);

echo "<table><tr><td>Prefix</td><td>VRF Name</td><td>Next hop</td><td>Learned from</td><td>Delete</td></tr>";

foreach($Python_to_2D_Array as $One_D_Arr){

    $One_D_Array = explode(',', $One_D_Arr);
    $One_D_Array  = str_replace(array('[',']','(',')','\'','.inet.0'), " ",$One_D_Array);  

        $A = 0; 
        $B = 2;
        $C = 4;
        $D = 6;

      echo "<tr><td>".$One_D_Array[$A]."</td><td>".$One_D_Array[$B]."</td><td>".$One_D_Array[$C]."</td>
                                <td>".$One_D_Array[$D]."</td></tr>";
   
        }

echo "</table></div>";

?>