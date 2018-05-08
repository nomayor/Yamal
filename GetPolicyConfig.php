<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);

$DataFromFW = $_POST['DataFromFW'];


$PolicyTerms = explode("....", $DataFromFW);

$PolicyTerms = array_slice($PolicyTerms, 0, -1);

echo "<table><tr><td>Policy Term Name</td><td>Source</td><td>Destination</td><td>Application</td><td>Action</td><td>Delete Term</td></tr>";


foreach($PolicyTerms as $Term) {

 $Term = explode(',', $Term);



 if ($Term[3] === "junos-icmp-all") {

	$Term[3] = "ICMP";
 }

 if ($Term[4] === "None") {

	$Term[4] = "reject";
 }
	

    $sourc = str_replace('_', '.', $Term[1]);
    $sourc = str_replace('-', '/', $sourc);
    $destinat = str_replace('_', '.', $Term[2]);
    $destinat = str_replace('-', '/', $destinat);


#    echo "<tr><td><div>".$Term[0]."</div></td><td><div>".$Term[1]."</div></td><td><div>".$Term[2]."</div></td>
#    								<td><div>".$Term[3]."</div></td><td>".$Term[4]."</td></tr>";

    echo "<tr><td><div>".$Term[0]."</div></td><td><div>".$sourc."</div></td><td><div>".$destinat."</div></td>
    								<td><div>".$Term[3]."</div></td><td>".$Term[4]."</td></tr>";


    $result = $result. " " . $Term[0];

	    if ($Pointer == 0) {

	    	$result = str_replace(' ', '', $result);
	    }

	$Pointer = $Pointer + 1;    
}


$ret = file_put_contents('/var/www/html/Show_Version/PolicyTermsFound.txt', $result);

?>

