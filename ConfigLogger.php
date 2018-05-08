<?php


$now = new DateTime();
$time = $now->format('d-m-y H:i:s');    


$ConfigToLog = file_get_contents('/var/www/html/Show_Version/FW_Config.set', true);
$IPofFWConfigured =  file_get_contents('/var/www/html/Show_Version/FW_To_Configure.txt',true); 

$TopDelimiter = "####################################################################";
$LowerDelimiter  = "==================================================================";

$servername = "localhost";
$username = "root";
$password = "1nterouteCPE";
$dbname = "SIDIPADDRESS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql = "SELECT InterouteSID FROM SIDIPADDRESS_Table_2 WHERE IPAddress = '$IPofFWConfigured'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $FWHostName = array_values($result->fetch_assoc())[0];
    $reslt = "Firewall Found in DB.";

} else {
    $reslt = "Firewall Not Found in DB.";
}
//mysql_free_result($reslt);
$conn->close(); 

$LogInfo = "\r\n" . "\r\n". $TopDelimiter ."\r\n". "Time of change: ". $time ."\r\n". 
					"ICC FW on which change was applied: " . $FWHostName ." ,  ". $IPofFWConfigured ."\r\n".
						"Change applied: " ."\r\n". $ConfigToLog ."\r\n". 
							$LowerDelimiter;

file_put_contents('/var/www/html/LOGGING/ConfigApplied.txt', $LogInfo, FILE_APPEND);

$filetotest = '/var/www/html/LOGGING/ConfigApplied.txt';

$size = filesize ( $filetotest );

if ($size > 100000 ) {

    exec ('sed -i \'1,100d\' /var/www/html/LOGGING/ConfigApplied.txt');
}



$WhichUser = file_get_contents('/var/www/html/LOGGING/WhichUser.txt', true);

$LogginLineInfo = "[" . $time . "] [" . $FWHostName . "] [" .  $IPofFWConfigured . "], Self_Care_Tool User: " . $WhichUser . ", Command: ";

foreach(preg_split('~[\r\n]+~', $ConfigToLog) as $line){

    if(empty($line) or ctype_space($line)) continue; 

    $line = $LogginLineInfo . $line . "\r\n" ;
    file_put_contents('/var/www/html/LOGGING/InterouteLOGGING.txt', $line , FILE_APPEND);

}



$filetotest = '/var/www/html/LOGGING/InterouteLOGGING.txt';

$size = filesize ( $filetotest );

if ($size > 2000000 ) {

    exec ('sed -i \'1,100d\' /var/www/html/LOGGING/InterouteLOGGING.txt');
}

$result = "Configuration change logged. Size: " . $size . " bytes.";

echo $result;

?>