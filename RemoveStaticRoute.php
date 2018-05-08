<?php 

$ipToDelete = "213.39.111.210";

//sed -i '/213.39.111.194/d' /etc/network/interfaces

$ip = "127.0.0.1";
$username = "interoute";
$password = "1nterouteCPE";




$subCommand = "sed -i '/" . $ipToDelete . "/d' /etc/network/interfaces";

	$connection = ssh2_connect('127.0.0.1');

	
	if (ssh2_auth_password($connection, $username, $password))  {

			//echo "Connected to VM.";

			$command = "echo 1nterouteCPE |  /usr/bin/sudo -S  $subCommand";

			//print("$command\r\n");
			$stream = ssh2_exec($connection, $command);
			sleep(1);
			stream_set_blocking($stream, true);

				$data = '';
				
				while($buffer = stream_get_contents($stream)) {
					$data .= $buffer;
				}

		
			fclose($stream);

	}

		
$WhatWeEchoed = "    The STREAM was:     " . $data . "     " ."\r\n" ."\r\n" .  "  The Command was:     " . $command;

echo $WhatWeEchoed;

echo "Done Deleting.";


?>




