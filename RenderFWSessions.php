<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$FirewallSessions = file_get_contents('/var/www/html/Show_Version/USessionsFromFW.txt', true);
$FireWSessions_Array = explode("ENDofITEM", $FirewallSessions);

$FireWSessions_Array_CUT = array_pop($FireWSessions_Array);

echo "<table><tr><td>Source Zone</td><td>Destination Zone</td><td>Protocol</td><td>Destination Port</td><td>Source Address</td><td>Destination Address</td><td>Permitted by Policy:</td></tr>";

foreach($FireWSessions_Array as $One_D_Array)  {

    $One_D_Array = str_replace(array('],',', ['), " ", $One_D_Array);
    $One_D_Array = str_replace(array('[',']','(',')','\''), " ", $One_D_Array);




    $One_D_Array = explode('next', $One_D_Array);



	$SessionPolicyStep1 = explode('/',$One_D_Array[6]);
	$SessionPolicy = $SessionPolicyStep1[0];
    $SessionPolicy = str_replace(",", "",$SessionPolicy);
	

    $SourceInterfaceStep1 = explode(',',$One_D_Array[4]);

    $SourceInterface = str_replace(array(' '), "", $SourceInterfaceStep1[0]);

    $ret = file_put_contents('/var/www/html/Show_Version/SourceInterfaceZERO_TO_DELETE.txt', $SourceInterfaceStep1[0]);
    $ret = file_put_contents('/var/www/html/Show_Version/SourceInterfaceONE_TO_DELETE.txt', $SourceInterfaceStep1[1]);
    $ret = file_put_contents('/var/www/html/Show_Version/SourceInterfaceTWO_TO_DELETE.txt', $SourceInterfaceStep1[2]);
    $ret = file_put_contents('/var/www/html/Show_Version/SourceInterfaceTHREE_TO_DELETE.txt', $SourceInterfaceStep1[3]);
    
    $SourceZoneStep1 = explode('.', $SourceInterface); 



    	if ($SourceZoneStep1[0] === "ge-0/0/3" || $SourceZoneStep1[0] === "reth1" ) {
    		$SourceZone = "LAN";
    	}

    	if ($SourceZoneStep1[0] === "ge-0/0/4" || $SourceZoneStep1[0] === "reth2" ) {
    		$SourceZone = "DMZ";
    	}

    	if ($SourceZoneStep1[0] === "ge-0/0/8" || $SourceZoneStep1[0] === "ge-7/0/8" ) {
    		$SourceZone = "WAN";
    	}

    	if ($SourceZoneStep1[0] === "ge-0/0/6" || $SourceZoneStep1[0] === "ge-7/0/6" ) {
    		$SourceZone = "Internet";
    	}



    $DestinationInterfaceStep1 = explode(',',$One_D_Array[4]);
    $DestinationInterface = str_replace(array(' '), "", $DestinationInterfaceStep1[1]);
    $DestinationZoneStep1 = explode('.', $DestinationInterface); 


    	if ($DestinationZoneStep1[0] === "ge-0/0/3" || $DestinationZoneStep1[0] === "reth1" ) {

    		$DestinationZone = "LAN";
    	}

    	if ($DestinationZoneStep1[0] === "ge-0/0/4" || $DestinationZoneStep1[0] === "reth2" ) {

    		$DestinationZone = "DMZ";
    	}

    	if ($DestinationZoneStep1[0] === "ge-0/0/8" || $DestinationZoneStep1[0] === "ge-7/0/8" ) {

    		$DestinationZone = "WAN";
    	}

    	if ($DestinationZoneStep1[0] === "ge-0/0/6" || $$DestinationZoneStep1[0] === "ge-7/0/6" ) {

    		$DestinationZone = "Internet";
    	}
 	
    
   $SessionPrefixes = explode(',',$One_D_Array[0]);
   $SessionProtocol = explode(',',$One_D_Array[2]);
   $SessionPort = explode(',',$One_D_Array[3]);

    echo "<tr><td>".$SourceZone."</td><td>".$DestinationZone."</td><td>".$SessionProtocol[0]."</td><td>".$SessionPort[0]."</td>

                    <td>". $SessionPrefixes[0]."</td><td>". $SessionPrefixes[1]."</td><td>".$SessionPolicy."</td></tr>";
}

echo "</table></div>";

//['172.31.22.137', '172.31.22.141'], 'next', ['172.31.22.141', '172.31.22.137'], 'next', ['tcp', 'tcp'], 'next', ['22', '52220'], 'next', 
//['reth1.354', 'reth1.354'], 
//'next', ['In', 'Out'], 'next', 'VRF_1_LAN_To_VRF_1_LAN/19', 'ENDofITEM',

return;

?>







