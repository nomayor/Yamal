<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$FromFile = file_get_contents('/var/www/html/Show_Version/BGPpeerStatusView.txt', true);
$Python_to_2D_Array = explode(")]), (", $FromFile);



echo "<table><tr><td>Peer Address</td><td>Peer AS</td><td>Peer Type</td><td>Peer State</td> <td>Import Policy</td> <td>Export Policy</td> <td>Flap Count</td> </tr>";

foreach($Python_to_2D_Array as $One_D_Arr){

//[('100.100.100.100', [('peer-type', 'Internal'), ('peer-as', '65532'), ('peer-state', 'Active'), ('peer-address', '100.100.100.100')]),

    $One_D_Array = explode(',', $One_D_Arr);
    $One_D_Array  = str_replace(array('[',']','(',')','\''), " ",$One_D_Array);  

        $A = 0; 
        $B = 10;
        $C = 8;
        $D = 12;
        $E = 4;
        $F = 6;
        $G = 2;  
      echo "<tr><td>".$One_D_Array[$A]."</td><td>".$One_D_Array[$B]."</td><td>".$One_D_Array[$C]."</td>
                                <td>".$One_D_Array[$D]."</td>  <td>".$One_D_Array[$E]."</td> <td>".$One_D_Array[$F]."</td> <td>".$One_D_Array[$G]."</td> </tr>";
   
        }

echo "</table></div>";

return;

?>







