<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$servername = "localhost";
$username = "root";
$password = "1nterouteCPE";
$dbname = "SIDIPADDRESS";

$link = mysql_connect($servername, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

@mysql_select_db($dbname) or die( "Unable to select database");

$DBresult = mysql_query("SELECT * FROM SIDIPADDRESS_Table_2");
if (!$DBresult) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}

$numResults = mysql_num_rows($DBresult);
$counter = 0;


while ($row = mysql_fetch_array($DBresult)) {

    if (++$counter == $numResults) {
  		$SIDsFromDB .= $row['InterouteSID'];
   		$FWIPAddressesFromDB .= $row['IPAddress'];
   		$FWName = $row['FWLocalIdentifier'];
   		$FWName = str_replace(' ','', $FWName);
    	$UserFWNamesFromDB .= $FWName;
   		} 

   	else {
   		$SIDsFromDB .= $row['InterouteSID'] . " ";
	    $FWIPAddressesFromDB .= $row['IPAddress'] . " ";
    	$FWName = $row['FWLocalIdentifier'];
   		$FWName = str_replace(' ','', $FWName);
   		$UserFWNamesFromDB .= $FWName . " ";
    	}
}


mysql_free_result($DBresult);
mysql_close($link);

echo $UserFWNamesFromDB;
























//$Input_From_Python = file_get_contents('/var/www/html/Show_Version/SIDIPAddress.txt', true);

//$Array = explode(',', $Input_From_Python);

//$size = count($Array);

//if ($size == 0 || $size == 1) {

//	$CheckFirstLoad = "FirstLoad";
//	unlink('/var/www/html/Show_Version/FirstLoad.txt'); 
//	$ret = file_put_contents('/var/www/html/Show_Version/FirstLoad.txt', $CheckFirstLoad);
//}


//if ($size > 1) {

//	for ($i = 0, $size = count($Array) - 1; $i < $size; ++ $i) {

//	$result = $result . " " . $Array[$i];
//	$result1 = $result1 . "," . $Array[$i];

//	$i = $i + 1;
//	$FW_IP_Addresses = $FW_IP_Addresses . " " . $Array[$i];
//	}

//	$result = preg_replace('/ /', '', $result, 1);

//    unlink('/var/www/html/Show_Version/FW_IP_Addresses.txt');
//	$ret = file_put_contents('/var/www/html/Show_Version/FW_IP_Addresses.txt', $FW_IP_Addresses);

//	$result1 = preg_replace('/,/', '', $result1, 1);

//}

//////////////////////////////////////////////////////////////////////////////////////////////////////
//
// This part accomodates for the case this is the first time a user logs in.
//
//////////////////////////////////////////////////////////////////////////////////////////////////////



//$CheckFirstLoad = file_get_contents('/var/www/html/Show_Version/FirstLoad.txt', true);

//	if (($CheckFirstLoad === "FirstLoad") && ($size > 1)) {

//		$To_New_Old_File = explode(',', $result1);

//	    	for ($i = 0, $size = count($To_New_Old_File); $i < $size; ++ $i) {

//	    	$New_Old_File = $New_Old_File . "," . $To_New_Old_File[$i];
//	    	$New_Old_File = $New_Old_File . "," . $To_New_Old_File[$i];

//			}
		
//		$CheckFirstLoad = "Created";
//		$New_Old_File = preg_replace('/,/', '', $New_Old_File, 1);

//		$NewTest = $New_Old_File;

//		$ret = file_put_contents('/var/www/html/Show_Version/NEW_TEST_TO_DELETE.txt', $NewTest);

//		$ret = file_put_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', $NewTest);



//		unlink('/var/www/html/Show_Version/FirstLoad.txt'); 
//		

//		$ret = file_put_contents('/var/www/html/Show_Version/FirstLoad.txt', $CheckFirstLoad);
//		$ret = file_put_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', $New_Old_File);

//	}


//////////////////////////////////////////////////////////////////////////////////////////////////////
//
// This part accomodates for the case when the NOC has added new Firewalls since we last logged in.
// We take only the hostname and we append it twice to the New_Old_FW_Names.txt file. This is then
// used to populate the table in the Tab: RENAME DEVICE.
//
//////////////////////////////////////////////////////////////////////////////////////////////////////


//$New_Old_FW_Names = file_get_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', true);

//$ret = file_put_contents('/var/www/html/Show_Version/BEFORE_LAST_PART_TO_DELETE.txt', $New_Old_FW_Names);


//$New_Old_FW_Names_Array = explode(',', $New_Old_FW_Names);
//$sizeNew_Old = count($New_Old_FW_Names_Array);




//$Input_From_Python = $Input_From_Python[strlen($Input_From_Python)-1] == ',' ? substr($Input_From_Python, -1) : $Input_From_Python;


//$Input_From_Python = rtrim($Input_From_Python, ',');
//$Array = explode(',', $Input_From_Python);
//$SID_File_Size = count($Array);

//$Lengths = "Length of SIDIPAddress:  " . $SID_File_Size . " ,  Length of Old_New file:  " . $sizeNew_Old . " SID file:  " . $Input_From_Python;

//$ret = file_put_contents('/var/www/html/Show_Version/SID_AND_NEW_OLD_TEST_TO_DELETE.txt', $Lengths);

//if ($SID_File_Size > $sizeNew_Old) {

//	$Difference = $SID_File_Size - $sizeNew_Old;

//	for ($i = 0; $i < $Difference; ++ $i) {

//		$NewFWsPointer = $sizeNew_Old + $i;

//		$New_Old_FW_Names = $New_Old_FW_Names . ",". $Array[$NewFWsPointer];
//		$New_Old_FW_Names = $New_Old_FW_Names . ",". $Array[$NewFWsPointer];

//		$i = $i + 1;		

//	}

//}

//$ret = file_put_contents('/var/www/html/Show_Version/AFTER_LAST_PART_TO_DELETE.txt', $New_Old_FW_Names);

//$ret = file_put_contents('/var/www/html/Show_Version/New_Old_FW_Names.txt', $New_Old_FW_Names);


//echo $result; 

return;

?>
