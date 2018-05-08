<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/text", true);


$policy = $_POST['policy'];

$source = $_POST['source'];
$destination = $_POST['destination'];

$Source_Mask = $_POST['Source_Mask'];
$Dest_Mask = $_POST['Dest_Mask'];

$port = $_POST['port'];
$PolicyPorts = $_POST['PolicyPorts'];
$LastPolicyPort = $_POST['LastPolicyPort'];

$port = str_replace(' ','',$port); 
$port = (int)$port;

        if ( ! is_int ( $port ) ) {
		$Result = "Error: Port entered not a number.";
		echo $Result;
		return;
	}

        if ( ( $port < 1 || $port > 65535 )  && ($PolicyPorts != "any") )  {
		$Result = "Error: Port outside 1 - 65535 range.";
		echo $Result;
		return;
	}
$LastPolicyPort = str_replace(' ','',$LastPolicyPort); 
$LastPolicyPort = (int)$LastPolicyPort;

        if ( ! is_int ( $LastPolicyPort ) ) {
		$Result = "Error: Last port entered not a number.";
		echo $Result;
		return;
	}

        if ( $PolicyPorts === "Range" && ( $LastPolicyPort < 1 || $LastPolicyPort > 65535 ) ) {
		$Result = "Error: Last port outside 1 - 65535 range.";
		echo $Result;
		return;
	}



$protocol = $_POST['protocol'];

$Action = $_POST['Action'];

$ToPolicySrcName = explode('.', $source);
$PolicySrcName = $ToPolicySrcName[3];

$ToPolicyDestName = explode('.', $destination);
$PolicyDestName = $ToPolicyDestName[3];



$SourceIPAddrArray = explode('.', $source);

$SourceIPAddrFirstByte = (int)$SourceIPAddrArray[0];
$SourceIPAddrSecondByte = (int)$SourceIPAddrArray[1];
$SourceIPAddrThirdByte = (int)$SourceIPAddrArray[2];
$SourceIPAddrFourthByte = (int)$SourceIPAddrArray[3];



$JuniperDefaultAppsProto[1]="TCP";
$JuniperDefaultAppsProto[2]="UDP";
$JuniperDefaultAppsProto[3]="TCP";
$JuniperDefaultAppsProto[4]="TCP";
$JuniperDefaultAppsProto[5]="TCP";
$JuniperDefaultAppsProto[6]="TCP";
$JuniperDefaultAppsProto[7]="TCP";
$JuniperDefaultAppsProto[8]="TCP";
$JuniperDefaultAppsProto[9]="TCP";
$JuniperDefaultAppsProto[10]="TCP";
$JuniperDefaultAppsProto[11]="UDP";
$JuniperDefaultAppsProto[12]="UDP";
$JuniperDefaultAppsProto[13]="TCP";
$JuniperDefaultAppsProto[14]="TCP";
$JuniperDefaultAppsProto[15]="TCP";
$JuniperDefaultAppsProto[16]="TCP";
$JuniperDefaultAppsProto[17]="TCP";
$JuniperDefaultAppsProto[18]="TCP";
$JuniperDefaultAppsProto[19]="UDP";
$JuniperDefaultAppsProto[20]="TCP";
$JuniperDefaultAppsProto[21]="TCP";
$JuniperDefaultAppsProto[22]="TCP";
$JuniperDefaultAppsProto[23]="TCP";
$JuniperDefaultAppsProto[24]="TCP";
$JuniperDefaultAppsProto[25]="UDP";
$JuniperDefaultAppsProto[26]="UDP";
$JuniperDefaultAppsProto[27]="UDP";
$JuniperDefaultAppsProto[28]="TCP";
$JuniperDefaultAppsProto[29]="UDP";
$JuniperDefaultAppsProto[30]="UDP";
$JuniperDefaultAppsProto[31]="UDP";
$JuniperDefaultAppsProto[32]="TCP";
$JuniperDefaultAppsProto[33]="UDP";
$JuniperDefaultAppsProto[34]="TCP";
$JuniperDefaultAppsProto[35]="TCP";
$JuniperDefaultAppsProto[36]="UDP";
$JuniperDefaultAppsProto[37]="TCP";
$JuniperDefaultAppsProto[38]="TCP";
$JuniperDefaultAppsProto[39]="UDP";
$JuniperDefaultAppsProto[40]="UDP";
$JuniperDefaultAppsProto[41]="UDP";
$JuniperDefaultAppsProto[42]="UDP";
$JuniperDefaultAppsProto[43]="UDP";
$JuniperDefaultAppsProto[44]="TCP";
$JuniperDefaultAppsProto[45]="UDP";
$JuniperDefaultAppsProto[46]="TCP";
$JuniperDefaultAppsProto[47]="UDP";
$JuniperDefaultAppsProto[48]="TCP";
$JuniperDefaultAppsProto[49]="TCP";
$JuniperDefaultAppsProto[50]="UDP";
$JuniperDefaultAppsProto[51]="UDP";
$JuniperDefaultAppsProto[52]="TCP";
$JuniperDefaultAppsProto[53]="TCP";
$JuniperDefaultAppsProto[54]="TCP";
$JuniperDefaultAppsProto[55]="UDP";
$JuniperDefaultAppsProto[56]="TCP";
$JuniperDefaultAppsProto[57]="TCP";
$JuniperDefaultAppsProto[58]="TCP";
$JuniperDefaultAppsProto[59]="TCP";
$JuniperDefaultAppsProto[60]="UDP";
$JuniperDefaultAppsProto[61]="UDP";
$JuniperDefaultAppsProto[62]="TCP";
$JuniperDefaultAppsProto[63]="TCP";
$JuniperDefaultAppsProto[64]="UDP";
$JuniperDefaultAppsProto[65]="TCP";
$JuniperDefaultAppsProto[66]="UDP";
$JuniperDefaultAppsProto[67]="UDP";
$JuniperDefaultAppsProto[68]="UDP";
$JuniperDefaultAppsProto[69]="TCP";
$JuniperDefaultAppsProto[70]="UDP";
$JuniperDefaultAppsProto[71]="UDP";
$JuniperDefaultAppsProto[72]="TCP";
$JuniperDefaultAppsProto[73]="TCP";
$JuniperDefaultAppsProto[74]="TCP";
$JuniperDefaultAppsProto[75]="UDP";
$JuniperDefaultAppsProto[76]="TCP";
$JuniperDefaultAppsProto[77]="TCP";
$JuniperDefaultAppsProto[78]="TCP";
$JuniperDefaultAppsProto[79]="TCP";
$JuniperDefaultAppsProto[80]="UDP";
$JuniperDefaultAppsProto[81]="TCP";
$JuniperDefaultAppsProto[82]="TCP";
$JuniperDefaultAppsProto[83]="TCP";
$JuniperDefaultAppsProto[84]="UDP";
$JuniperDefaultAppsProto[85]="UDP";
$JuniperDefaultAppsProto[86]="TCP";
$JuniperDefaultAppsProto[87]="UDP";
$JuniperDefaultAppsProto[88]="TCP";
$JuniperDefaultAppsProto[89]="UDP";
$JuniperDefaultAppsProto[90]="TCP";
$JuniperDefaultAppsProto[91]="TCP";
$JuniperDefaultAppsProto[92]="TCP";
$JuniperDefaultAppsProto[93]="TCP";
$JuniperDefaultAppsProto[94]="TCP";
$JuniperDefaultAppsProto[95]="TCP";
$JuniperDefaultAppsProto[96]="TCP";
$JuniperDefaultAppsProto[97]="UDP";



$JuniperDefaultAppsPort[1]=21;
$JuniperDefaultAppsPort[2]=69;
$JuniperDefaultAppsPort[3]=554;
$JuniperDefaultAppsPort[4]=139;
$JuniperDefaultAppsPort[5]=445;
$JuniperDefaultAppsPort[6]=22;
$JuniperDefaultAppsPort[7]=23;
$JuniperDefaultAppsPort[8]=25;
$JuniperDefaultAppsPort[9]=49;
$JuniperDefaultAppsPort[10]=65;
$JuniperDefaultAppsPort[11]=68;
$JuniperDefaultAppsPort[12]=67;
$JuniperDefaultAppsPort[13]=79;
$JuniperDefaultAppsPort[14]=80;
$JuniperDefaultAppsPort[15]=443;
$JuniperDefaultAppsPort[16]=110;
$JuniperDefaultAppsPort[17]=113;
$JuniperDefaultAppsPort[18]=119;
$JuniperDefaultAppsPort[19]=123;
$JuniperDefaultAppsPort[20]=143;
$JuniperDefaultAppsPort[21]=993;
$JuniperDefaultAppsPort[22]=179;
$JuniperDefaultAppsPort[23]=389;
$JuniperDefaultAppsPort[24]=444;
$JuniperDefaultAppsPort[25]=512;
$JuniperDefaultAppsPort[26]=513;
$JuniperDefaultAppsPort[27]=514;
$JuniperDefaultAppsPort[28]=515;
$JuniperDefaultAppsPort[29]=520;
$JuniperDefaultAppsPort[30]=1812;
$JuniperDefaultAppsPort[31]=1813;
$JuniperDefaultAppsPort[32]=2049;
$JuniperDefaultAppsPort[33]=2049;
$JuniperDefaultAppsPort[34]=2401;
$JuniperDefaultAppsPort[35]=646;
$JuniperDefaultAppsPort[36]=646;
$JuniperDefaultAppsPort[37]=3220;
$JuniperDefaultAppsPort[38]=3221;
$JuniperDefaultAppsPort[39]=500;
$JuniperDefaultAppsPort[40]=19;
$JuniperDefaultAppsPort[41]=67;
$JuniperDefaultAppsPort[42]=9;
$JuniperDefaultAppsPort[43]=53;
$JuniperDefaultAppsPort[44]=53;
$JuniperDefaultAppsPort[45]=7;
$JuniperDefaultAppsPort[46]=70;
$JuniperDefaultAppsPort[47]=2123;
$JuniperDefaultAppsPort[48]=7001;
$JuniperDefaultAppsPort[49]=389;
$JuniperDefaultAppsPort[50]=4500;
$JuniperDefaultAppsPort[51]=1701;
$JuniperDefaultAppsPort[52]=515;
$JuniperDefaultAppsPort[53]=25;
$JuniperDefaultAppsPort[54]=1720;
$JuniperDefaultAppsPort[55]=1719;
$JuniperDefaultAppsPort[56]=1503;
$JuniperDefaultAppsPort[57]=389;
$JuniperDefaultAppsPort[58]=522;
$JuniperDefaultAppsPort[59]=1731;
$JuniperDefaultAppsPort[60]=2427;
$JuniperDefaultAppsPort[61]=2727;
$JuniperDefaultAppsPort[62]=1863;
$JuniperDefaultAppsPort[63]=135;
$JuniperDefaultAppsPort[64]=135;
$JuniperDefaultAppsPort[65]=1433;
$JuniperDefaultAppsPort[66]=137;
$JuniperDefaultAppsPort[67]=138;
$JuniperDefaultAppsPort[68]=111;
$JuniperDefaultAppsPort[69]=15397;
$JuniperDefaultAppsPort[70]=69;
$JuniperDefaultAppsPort[71]=5632;
$JuniperDefaultAppsPort[72]=1723;
$JuniperDefaultAppsPort[73]=554;
$JuniperDefaultAppsPort[74]=2000;
$JuniperDefaultAppsPort[75]=5060;
$JuniperDefaultAppsPort[76]=5060;
$JuniperDefaultAppsPort[77]=514;
$JuniperDefaultAppsPort[78]=139;
$JuniperDefaultAppsPort[79]=445;
$JuniperDefaultAppsPort[80]=1434;
$JuniperDefaultAppsPort[81]=1525;
$JuniperDefaultAppsPort[82]=1521;
$JuniperDefaultAppsPort[83]=111;
$JuniperDefaultAppsPort[84]=111;
$JuniperDefaultAppsPort[85]=517;
$JuniperDefaultAppsPort[86]=517;
$JuniperDefaultAppsPort[87]=518;
$JuniperDefaultAppsPort[88]=518;
$JuniperDefaultAppsPort[89]=540;
$JuniperDefaultAppsPort[90]=5800;
$JuniperDefaultAppsPort[91]=210;
$JuniperDefaultAppsPort[92]=43;
$JuniperDefaultAppsPort[93]=1494;
$JuniperDefaultAppsPort[94]=5050;
$JuniperDefaultAppsPort[95]=3578;
$JuniperDefaultAppsPort[96]=705;
$JuniperDefaultAppsPort[97]=28672;



$JuniperDefaultAppName[1]="junos-ftp";
$JuniperDefaultAppName[2]="junos-tftp";
$JuniperDefaultAppName[3]="junos-rtsp";
$JuniperDefaultAppName[4]="junos-netbios-session";
$JuniperDefaultAppName[5]="junos-smb-session";
$JuniperDefaultAppName[6]="junos-ssh";
$JuniperDefaultAppName[7]="junos-telnet";
$JuniperDefaultAppName[8]="junos-smtp";
$JuniperDefaultAppName[9]="junos-tacacs";
$JuniperDefaultAppName[10]="junos-tacacs-ds";
$JuniperDefaultAppName[11]="junos-dhcp-client";
$JuniperDefaultAppName[12]="junos-dhcp-server";
$JuniperDefaultAppName[13]="junos-finger";
$JuniperDefaultAppName[14]="junos-http";
$JuniperDefaultAppName[15]="junos-https";
$JuniperDefaultAppName[16]="junos-pop3";
$JuniperDefaultAppName[17]="junos-ident";
$JuniperDefaultAppName[18]="junos-nntp";
$JuniperDefaultAppName[19]="junos-ntp";
$JuniperDefaultAppName[20]="junos-imap";
$JuniperDefaultAppName[21]="junos-imaps";
$JuniperDefaultAppName[22]="junos-bgp";
$JuniperDefaultAppName[23]="junos-ldap";
$JuniperDefaultAppName[24]="junos-snpp";
$JuniperDefaultAppName[25]="junos-biff";
$JuniperDefaultAppName[26]="junos-who";
$JuniperDefaultAppName[27]="junos-syslog";
$JuniperDefaultAppName[28]="junos-printer";
$JuniperDefaultAppName[29]="junos-rip ";
$JuniperDefaultAppName[30]="junos-radius";
$JuniperDefaultAppName[31]="junos-radacct";
$JuniperDefaultAppName[32]="junos-nfsd-TCP";
$JuniperDefaultAppName[33]="junos-nfsd-UDP";
$JuniperDefaultAppName[34]="junos-cvspserver";
$JuniperDefaultAppName[35]="junos-ldp-TCP";
$JuniperDefaultAppName[36]="junos-ldp-UDP";
$JuniperDefaultAppName[37]="junos-xnm-ssl";
$JuniperDefaultAppName[38]="junos-xnm-clear-text";
$JuniperDefaultAppName[39]="junos-ike";
$JuniperDefaultAppName[40]="junos-chargen";
$JuniperDefaultAppName[41]="junos-dhcp-relay";
$JuniperDefaultAppName[42]="junos-discard";
$JuniperDefaultAppName[43]="junos-dns-UDP";
$JuniperDefaultAppName[44]="junos-dns-TCP";
$JuniperDefaultAppName[45]="junos-echo";
$JuniperDefaultAppName[46]="junos-gopher";
$JuniperDefaultAppName[47]="junos-gtp";
$JuniperDefaultAppName[48]="junos-http-ext";
$JuniperDefaultAppName[49]="junos-internet-locator-service";
$JuniperDefaultAppName[50]="junos-ike-nat";
$JuniperDefaultAppName[51]="junos-l2tp";
$JuniperDefaultAppName[52]="junos-lpr";
$JuniperDefaultAppName[53]="junos-mail";
$JuniperDefaultAppName[54]="junos-h323";
$JuniperDefaultAppName[55]="junos-h323";
$JuniperDefaultAppName[56]="junos-h323";
$JuniperDefaultAppName[57]="junos-h323";
$JuniperDefaultAppName[58]="junos-h323";
$JuniperDefaultAppName[59]="junos-h323";
$JuniperDefaultAppName[60]="junos-mgcp-ua";
$JuniperDefaultAppName[61]="junos-mgcp-ca";
$JuniperDefaultAppName[62]="junos-msn";
$JuniperDefaultAppName[63]="junos-ms-rpc-TCP";
$JuniperDefaultAppName[64]="junos-ms-rpc-UDP";
$JuniperDefaultAppName[65]="junos-ms-sql";
$JuniperDefaultAppName[66]="junos-nbname";
$JuniperDefaultAppName[67]="junos-nbds";
$JuniperDefaultAppName[68]="junos-nfs";
$JuniperDefaultAppName[69]="junos-ns-global";
$JuniperDefaultAppName[70]="junos-nsm";
$JuniperDefaultAppName[71]="junos-pc-anywhere";
$JuniperDefaultAppName[72]="junos-pptp";
$JuniperDefaultAppName[73]="junos-realaudio";
$JuniperDefaultAppName[74]="junos-sccp";
$JuniperDefaultAppName[75]="junos-sip";
$JuniperDefaultAppName[76]="junos-sip";
$JuniperDefaultAppName[77]="junos-rsh";
$JuniperDefaultAppName[78]="junos-smb";
$JuniperDefaultAppName[79]="junos-smb";
$JuniperDefaultAppName[80]="junos-sql-monitor";
$JuniperDefaultAppName[81]="junos-sqlnet-v1";
$JuniperDefaultAppName[82]="junos-sqlnet-v2";
$JuniperDefaultAppName[83]="junos-sun-rpc-TCP";
$JuniperDefaultAppName[84]="junos-sun-rpc-UDP";
$JuniperDefaultAppName[85]="junos-talk";
$JuniperDefaultAppName[86]="junos-talk";
$JuniperDefaultAppName[87]="junos-ntalk";
$JuniperDefaultAppName[88]="junos-ntalk";
$JuniperDefaultAppName[89]="junos-uucp t";
$JuniperDefaultAppName[90]="junos-vnc";
$JuniperDefaultAppName[91]="junos-wais";
$JuniperDefaultAppName[92]="junos-whois";
$JuniperDefaultAppName[93]="junos-winframe";
$JuniperDefaultAppName[94]="junos-ymsg";
$JuniperDefaultAppName[95]="junos-wxcontrol";
$JuniperDefaultAppName[96]="junos-snmp-agentx";
$JuniperDefaultAppName[97]="junos-r2cp";

$JuniperDefaultAppsProtoRANGE[1]="TCP";
$JuniperDefaultAppsProtoRANGE[2]="UDP";
$JuniperDefaultAppsProtoRANGE[3]="TCP";
$JuniperDefaultAppsProtoRANGE[4]="UDP";
$JuniperDefaultAppsProtoRANGE[5]="TCP";
$JuniperDefaultAppsProtoRANGE[6]="UDP";
$JuniperDefaultAppsProtoRANGE[7]="TCP";

$JuniperDefaultAppsPortRANGE[1]="5190-5193";
$JuniperDefaultAppsPortRANGE[2]="6346-6347";
$JuniperDefaultAppsPortRANGE[3]="6660-6669";
$JuniperDefaultAppsPortRANGE[4]="7000-7010";
$JuniperDefaultAppsPortRANGE[5]="6000-6063";
$JuniperDefaultAppsPortRANGE[6]="3478-3479";
$JuniperDefaultAppsPortRANGE[7]="3478-3479";

$JuniperDefaultAppNameRANGE[1]="junos-aol";
$JuniperDefaultAppNameRANGE[2]="junos-gnutella";
$JuniperDefaultAppNameRANGE[3]="junos-irc";
$JuniperDefaultAppNameRANGE[4]="junos-vdo-live";
$JuniperDefaultAppNameRANGE[5]="junos-x-windows";
$JuniperDefaultAppNameRANGE[6]="junos-stun";
$JuniperDefaultAppNameRANGE[7]="junos-stun";






$PolicyAppRequested = "no";
$PolicyAppName = "No Match with Juniper default apps.";

$PortAsInteger = (int)$port;

if ($PolicyPorts === "Specific") {

	for ($k = 1; $k < 98; ++$k) {

		if ($JuniperDefaultAppsProto[$k] === $protocol && $JuniperDefaultAppsPort[$k] == $PortAsInteger ) {

			$ApplicationName = $JuniperDefaultAppName[$k];
			$PolicyAppRequested = "yes";
			break;
		}
	}

	if ($PolicyAppRequested === "no") {

		for ($k = 1; $k < 8; ++$k) {

			if ($JuniperDefaultAppsProtoRANGE[$k] === $protocol) {

			$ExplodedJuniperApps = explode('-', $JuniperDefaultAppsPortRANGE[$k]);
			$size = count($ExplodedJuniperApps);

				for ($loop = 0; $loop < $size; ++$loop) {

					if ($ExplodedJuniperApps[$loop] == $PortAsInteger) {

					$ApplicationName = $JuniperDefaultAppNameRANGE[$k];
					$PolicyAppRequested = "yes";
					break 2;

					}
				}
			}
		}
	}
}

if ($PolicyAppRequested === "no" && $PolicyPorts === "Range") {

	for ($k = 1; $k < 8; ++$k) {

		if ($JuniperDefaultAppsProtoRANGE[$k] === $protocol) {
		$ExplodedJuniperApps = explode('-', $JuniperDefaultAppsPortRANGE[$k]);
		$LastJuniperPort = count($ExplodedJuniperApps) - 1; 

		$FirstPortInRange = (int)$ExplodedJuniperApps[0];
		$LastPortInRange = (int)$ExplodedJuniperApps[$LastJuniperPort];

			if ($FirstPortInRange == $PortAsInteger && $LastPortInRange == $LastPolicyPort) {

			$ApplicationName = $JuniperDefaultAppNameRANGE[$k];
			$PolicyAppRequested = "yes";
			break;
			}
		}
	}
}

 



$retUPD = file_put_contents('/var/www/html/Show_Version/JuniperDefaultAppsPortArr.txt', $PolicyAppName);



	if ( $SourceIPAddrFirstByte == 127 ||
	     		( (224 <=  $SourceIPAddrFirstByte) && ( $SourceIPAddrFirstByte <= 240)) ||
	   			  $SourceIPAddrFirstByte == 255 ) {
		$Result = "Source IP address first byte illegal value.";
		echo $Result;
		return;
	}

	if ($SourceIPAddrFirstByte == 0 && ( 
						 	($SourceIPAddrSecondByte !=0) ||
						 		($SourceIPAddrThirdByte !=0) || 
						 			($SourceIPAddrFourthByte !=0) ) ) {
		$Result = "Source IP address illegal value.";
		echo $Result;
		return;
	}




$DestinationIPAddrArray = explode('.', $destination);

$DestinationIPAddrFirstByte = (int)$DestinationIPAddrArray[0];
$DestinationIPAddrSecondByte = (int)$DestinationIPAddrArray[1];
$DestinationIPAddrThirdByte = (int)$DestinationIPAddrArray[2];
$DestinationIPAddrFourthByte = (int)$DestinationIPAddrArray[3];

	if ( $DestinationIPAddrFirstByte == 127 ||
	     		( (224 <=  $DestinationIPAddrFirstByte) && ( $DestinationIPAddrFirstByte <= 240)) ||
	    			$DestinationIPAddrFirstByte == 255 ) {

		$Result = "Destination IP address first byte illegal value.";
		echo $Result;
		return;
	}


 if ($DestinationIPAddrFirstByte == 0 && ( 
						 	($DestinationIPAddrSecondByte !=0) ||
						 		($DestinationIPAddrThirdByte !=0) || 
						 			($DestinationIPAddrFourthByte !=0) ) ) {
		$Result = "Destination IP address illegal value.";
		echo $Result;
		return;
	}



$Source_MaskToInt = (int)$Source_Mask;

	if ( ($Source_MaskToInt < 8 ) && ($Source_MaskToInt != 0 ) )  {

		$Result = "Prefix must be greater than 8. Use '0' only for 'any'.";
		echo $Result;
		return;

	}

	if ( ($Source_MaskToInt == 0) && (
						 ($SourceIPAddrFirstByte !=0) ||
						 	($SourceIPAddrSecondByte !=0) ||
						 		($SourceIPAddrThirdByte !=0) || 
						 			($SourceIPAddrFourthByte !=0) ) ) {
		$Result = "Prefix of '0' only valid for 'any' Source, '0.0.0.0'.";
		echo $Result;
		return;		
	}


 

$Dest_MaskToInt = (int)$Dest_Mask;

	if ( ($Dest_MaskToInt < 8 ) && ($Dest_MaskToInt != 0 ) )  {

		$Result = "Prefix must be greater than 8. Use '0' only for 'any'.";
		echo $Result;
		return;

	}

	if (  ($Dest_MaskToInt==0) && (
						($DestinationIPAddrFirstByte !=0) || 
							($DestinationIPAddrSecondByte !=0) || 
								($DestinationIPAddrThirdByte !=0) || 
									($DestinationIPAddrFourthByte !=0) ) ) {

		$Result = "Prefix of '0' only valid for 'any' Destination, '0.0.0.0'.";
		echo $Result;
		return;		
	}



$SourceSubnetIsValid = 0;
$NotNetworkAddressSRC = "Not valid source subnet for this mask."; 


	if ( ($Source_MaskToInt == 24) && ($SourceIPAddrFourthByte != 0) ) { 
		$Result = $NotNetworkAddressSRC;
		echo $Result;
		return;
	}

	if ($Source_MaskToInt > 24 ) {

		$MaskDifference = $Source_MaskToInt - 24;
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 32 - $Source_MaskToInt;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $SourceIPAddrFourthByte){

				$SourceSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($SourceSubnetIsValid == 0) {
			$Result = $NotNetworkAddressSRC;
			echo $Result;
			return;
		}
	}




	if (($Source_MaskToInt == 16) && ($SourceIPAddrThirdByte != 0 || $SourceIPAddrFourthByte != 0)) { 
		$Result = $NotNetworkAddressSRC;
		echo $Result;
		return;
	}

	if ( (16 <  $Source_MaskToInt) && ($Source_MaskToInt < 24)) {

		if ($SourceIPAddrFourthByte != 0) {
		$Result = $NotNetworkAddressSRC;
		echo $Result;
		return;
		}

		$MaskDifference = $Source_MaskToInt - 16;            
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 24 - $Source_MaskToInt;                       
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $SourceIPAddrThirdByte){

				$SourceSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($SourceSubnetIsValid == 0) {
			$Result = $NotNetworkAddressSRC;
			echo $Result;
			return;
		}
	}




	if (($Source_MaskToInt == 8 ) && ($SourceIPAddrSecondByte != 0 || 
										$SourceIPAddrThirdByte != 0 || 
										   $SourceIPAddrFourthByte != 0)) { 
			$Result = $NotNetworkAddressSRC;
			echo $Result;
			return;
	}

    if ( (8 <  $Source_MaskToInt) && ($Source_MaskToInt < 16)) {

		if ($SourceIPAddrThirdByte != 0 || $SourceIPAddrFourthByte != 0) {
			$Result = $NotNetworkAddressSRC;
			echo $Result;
			return;
		}

		$MaskDifference = $Source_MaskToIn - 8;      
		$NumberOfSubnets = pow(2, $MaskDifference);
		$SubnetSizePower = 16 - $Source_MaskToIn;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $SourceIPAddrSecondByte){

				$SourceSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($SourceSubnetIsValid == 0) {
			$Result = $NotNetworkAddressSRC;
			echo $Result;
			return;
		}
	}


$DestinationSubnetIsValid = 0;
$NotNetworkAddressDest = "Not valid destination subnet for this mask."; 


	if ( ($Dest_MaskToInt == 24) && ($DestinationIPAddrFourthByte != 0) ) { 
		$Result = $NotNetworkAddressDest;
		echo $Result;
		return;
	}

	if ($Dest_MaskToInt > 24 ) {

		$MaskDifference = $Dest_MaskToInt - 24;
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 32 - $Dest_MaskToInt;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $DestinationIPAddrFourthByte){

				$DestinationSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($DestinationSubnetIsValid == 0) {
			$Result = $NotNetworkAddressDest;
			echo $Result;
			return;
		}
	}




	if (($Dest_MaskToInt == 16) && ($DestinationIPAddrThirdByte != 0 || $DestinationIPAddrFourthByte != 0)) { 
		$Result = $NotNetworkAddressDest;
		echo $Result;
		return;
	}

	if ( (16 < $Dest_MaskToInt) && ($Dest_MaskToInt < 24)) {

		if ($DestinationIPAddrFourthByte != 0) {
		$Result = $NotNetworkAddressDest;
		echo $Result;
		return;
		}

		$MaskDifference = $Dest_MaskToInt - 16;            
		$NumberOfSubnets = pow(2, $MaskDifference);   
		$SubnetSizePower = 24 - $Dest_MaskToInt;                       
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $DestinationIPAddrThirdByte){

				$DestinationSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($DestinationSubnetIsValid == 0) {
			$Result = $NotNetworkAddressDest;
			echo $Result;
			return;
		}
	}






	if (($Dest_MaskToInt == 8 ) && ($DestinationIPAddrSecondByte != 0 || 
										$DestinationIPAddrThirdByte != 0 || 
										   $DestinationIPAddrFourthByte != 0)) { 
			$Result = $NotNetworkAddressDest;
			echo $Result;
			return;
	}

    if ( (8 < $Dest_MaskToInt) && ($Dest_MaskToInt < 16) ) {

		if ($DestinationIPAddrThirdByte != 0 || $DestinationIPAddrFourthByte != 0) {
			$Result = $NotNetworkAddressDest;
			echo $Result;
			return;
		}

		$MaskDifference = $Dest_MaskToInt - 8;      
		$NumberOfSubnets = pow(2, $MaskDifference);
		$SubnetSizePower = 16 - $Dest_MaskToInt;                
		$SubnetSize = pow(2, $SubnetSizePower);                 
		$SubnetWorkAddress = 0;

		for ($i = 0; $i < $NumberOfSubnets; ++$i) {

			if ($SubnetWorkAddress == $DestinationIPAddrSecondByte){

				$DestinationSubnetIsValid = 1;
			}

			$SubnetWorkAddress = $SubnetWorkAddress + $SubnetSize;
		}

		if ($DestinationSubnetIsValid == 0) {
			$Result = $NotNetworkAddressDest;
			echo $Result;
			return;
		}
	}





$CIRDsToTest = $source . "/". $Source_Mask;

$CIRDsToTest = str_replace(' ','', $CIRDsToTest);
$DestInSource = str_replace(' ','', $destination);

$ret = file_put_contents('/var/www/html/Show_Version/PolicySourceSubnet.txt', $CIRDsToTest); 

$ret = file_put_contents('/var/www/html/Show_Version/PolicyDestination.txt', $DestInSource);

exec('python /var/www/html/php/CheckIfDestInSource.py');

usleep(2000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/CheckIfDestInSource.txt', true);

    if ( ($IsItDuplicate === "Overlap") && ($source != "0.0.0.0") ) {
        $Result = "Error: Destination overlaps with Source.";
        echo $Result;
        return;
    }




$CIRDsToTest = $destination . "/". $Dest_Mask;

$CIRDsToTest = str_replace(' ','', $CIRDsToTest);
$SourceInDest = str_replace(' ','', $source);

$ret = file_put_contents('/var/www/html/Show_Version/PolicyDestinationSubnet.txt', $CIRDsToTest); 

$ret = file_put_contents('/var/www/html/Show_Version/PolicySource.txt', $SourceInDest);

exec('python /var/www/html/php/CheckIfSourceInDest.py');

usleep(2000000);

$IsItDuplicate = file_get_contents('/var/www/html/Show_Version/CheckIfSourceInDest.txt', true);

    if ( ($IsItDuplicate === "Overlap") && ($destination != "0.0.0.0") ) {
        $Result = "Error: Source overlaps with Destination.";
        echo $Result;
        return;
    }






if ($policy === "LAN to DMZ") {

	$result = "VRF_1_Trust to-zone VRF_1_DMZ";
	$SRC_Adr_Book = "VRF_1_Trust";
	$DEST_Adr_Book = "VRF_1_DMZ";
	$ReApply = "VRF_1_Trust_to_DMZ";   
}

elseif ($policy === "WAN to DMZ") {

	$result = "VRF_1_Untrust to-zone VRF_1_DMZ";
	$SRC_Adr_Book = "VRF_1_Untrust";
	$DEST_Adr_Book = "VRF_1_DMZ";
	$ReApply = "VRF_1_Untrust_to_DMZ";
}

elseif ($policy === "DMZ to LAN") {

	$result = "VRF_1_DMZ to-zone VRF_1_Trust";
	$SRC_Adr_Book = "VRF_1_DMZ";
	$DEST_Adr_Book = "VRF_1_Trust";
	$ReApply = "VRF_1_DMZ_to_Trust";
}

elseif ($policy === "DMZ to WAN") {

	$result = "VRF_1_DMZ to-zone VRF_1_Untrust";
	$SRC_Adr_Book = "VRF_1_DMZ";
	$DEST_Adr_Book = "VRF_1_Untrust";
	$ReApply = "VRF_1_DMZ_to_Untrust";
}


elseif ($policy === "LAN to WAN") {

	$result = "VRF_1_Trust to-zone VRF_1_Untrust";
	$SRC_Adr_Book = "VRF_1_Trust";
	$DEST_Adr_Book = "VRF_1_Untrust";
	$ReApply = "VRF_1_Trust_to_Untrust";
}

elseif ($policy === "WAN to LAN") {

	$result = "VRF_1_Untrust to-zone VRF_1_Trust";
	$SRC_Adr_Book = "VRF_1_Untrust";
	$DEST_Adr_Book = "VRF_1_Trust";
	$ReApply = "VRF_1_Untrust_to_Trust";
}


if ($source === "0.0.0.0" && $Source_Mask === "0") {

	$SRC = "any";
	} 
if ($source === "0.0.0.0" && $Source_Mask != "0") {

		$Result = "Illegal mask for source: 0.0.0.0 (Please use 0).";
		echo $Result;
		return;	
	}

else {
	 $SRC = $source . '/' . $Source_Mask ;
}




if ($destination === "0.0.0.0" && $Dest_Mask === "0") {

	$DEST = "any" ;
	} 
if ($destination === "0.0.0.0" && $Dest_Mask != "0") {

		$Result = "Illegal mask for destination: 0.0.0.0 (Please use 0).";
		echo $Result;
		return;	
	}

else {
	 $DEST = $destination . '/' . $Dest_Mask ;
}




$SRC_Adress_SET = $SRC;
$SRC_Adress_SET = str_replace('/','-',$SRC_Adress_SET);
$SRC_Adress_SET = str_replace('.','_',$SRC_Adress_SET);
$SRC_Adress_of_Book = $SRC_Adress_SET;
$SRC_Adress_SET = "AS_" . $SRC_Adress_SET;

$DEST_Adress_SET = $DEST;
$DEST_Adress_SET = str_replace('/','-',$DEST_Adress_SET);
$DEST_Adress_SET = str_replace('.','_',$DEST_Adress_SET);
$DEST_Adress_of_Book = $DEST_Adress_SET;
$DEST_Adress_SET = "AS_" . $DEST_Adress_SET;



if ($PolicyPorts === "any" && $protocol === "TCP") {

	$ApplicationName = "ALL_TCP";
}

if ($PolicyPorts === "any" && $protocol === "UDP") {

	$ApplicationName = "ALL_UDP";
}


if ($PolicyPorts === "Range" && ( ($protocol === "TCP") || ($protocol === "UDP") ) ) {

	$port = $port."-".$LastPolicyPort;
	
	}


if ($protocol === "ICMP") {

	$ApplicationName = "junos-icmp-all";

	}


$CreatedNewApp = "no";

if ( $PolicyAppRequested === "no" ) {

	if ($protocol === "TCP" && ( ($PolicyPorts === "Specific") || ($PolicyPorts === "Range")))  {

		$ApplicationName = "ICC-IAAS-" . $protocol . '-' . $port;

		$Application_1 = "set applications application " . $ApplicationName . " term t1 protocol " . 6;
		$Application_2 = "set applications application " . $ApplicationName . " term t1 destination-port " . $port;
		$Application_3 = "set applications application " . $ApplicationName . " term t1 inactivity-timeout 28800";
		$Application = $Application_1 ."\r\n". $Application_2 ."\r\n". $Application_3;

		}

	if ($protocol === "UDP" && ( ($PolicyPorts === "Specific") || ($PolicyPorts === "Range"))) {

		$ApplicationName = "ICC-IAAS-" . $protocol . '-' . $port;

		$Application_1 = "set applications application " . $ApplicationName . " term t1 protocol " . 17;
		$Application_2 = "set applications application " . $ApplicationName . " term t1 destination-port " . $port;
		$Application_3 = "set applications application " . $ApplicationName . " term t1 inactivity-timeout 28800";
		$Application = $Application_1 ."\r\n". $Application_2 ."\r\n". $Application_3;

		}
	$CreatedNewApp = "yes";
	}



$PolicySource = str_replace('/','-',$SRC);
$PolicySource = str_replace('.','_',$PolicySource);


$PolicyDestination = str_replace('/','-',$DEST);
$PolicyDestination = str_replace('.','_',$PolicyDestination);

$policy_term = $PolicySource . "-to-" . $PolicyDestination . '_' . $protocol . "_" . $port;

if ($SRC !== "any") {
                                 
	$FW_Policy_1 = "set security address-book " . $SRC_Adr_Book . " address " . $SRC_Adress_of_Book . " " . $SRC;     
	$FW_Policy_2 = "set security address-book " . $SRC_Adr_Book . " address-set " . $SRC_Adress_SET . " address " . $SRC_Adress_of_Book; 

	} 

if ($DEST !== "any") {

	$FW_Policy_3 = "set security address-book " . $DEST_Adr_Book . " address " . $DEST_Adress_of_Book . " " . $DEST;     
	$FW_Policy_4 = "set security address-book " . $DEST_Adr_Book . " address-set " . $DEST_Adress_SET . " address " . $DEST_Adress_of_Book; 

	}

if ($SRC === "any") {

	$SRC_Adress_SET = "any";

	}

if ($DEST === "any") {

	$DEST_Adress_SET = "any";

	}

$FW_Policy_5 = "set security policies from-zone " . $result. " policy " . $policy_term . " match source-address " . $SRC_Adress_SET ;
$FW_Policy_6 = "set security policies from-zone " . $result. " policy " . $policy_term . " match destination-address " . $DEST_Adress_SET;
$FW_Policy_7 = "set security policies from-zone " . $result. " policy " . $policy_term . " match application " . $ApplicationName;
$FW_Policy_8 = "set security policies from-zone " . $result. " policy " . $policy_term . " then " . $Action;

if (($SRC !== "any") &&  ($DEST !== "any")) {
	$FW_Policy =  $FW_Policy_1 ."\r\n". $FW_Policy_2 . "\r\n". $FW_Policy_3 . "\r\n".  $FW_Policy_4 . "\r\n". $FW_Policy_5 . "\r\n" . $FW_Policy_6 . "\r\n" . $FW_Policy_7 . "\r\n" . $FW_Policy_8;
	}


if (($SRC === "any") &&  ($DEST === "any")) {
$FW_Policy =  $FW_Policy_5 . "\r\n".  $FW_Policy_6 . "\r\n". $FW_Policy_7 . "\r\n" . $FW_Policy_8;
}


if (($SRC === "any") &&  ($DEST !== "any")) {
$FW_Policy =  $FW_Policy_3 ."\r\n". $FW_Policy_4 . "\r\n".  $FW_Policy_5 . "\r\n". $FW_Policy_6 . "\r\n" . $FW_Policy_7 . "\r\n" . $FW_Policy_8;
}


if (($SRC !== "any") &&  ($DEST === "any")) {
$FW_Policy =  $FW_Policy_1 ."\r\n". $FW_Policy_2 ."\r\n" . $FW_Policy_3 . "\r\n".  $FW_Policy_4 . "\r\n". $FW_Policy_5 . "\r\n" . $FW_Policy_6;
}



$UpdatePolicy_1 = "delete security policies from-zone " . $result . " policy " . $ReApply;

$UpdatePolicy_2 = "set security policies from-zone " . $result . " policy " . $ReApply . " match source-address any";
$UpdatePolicy_3 = "set security policies from-zone " . $result . " policy " . $ReApply . " match destination-address any";
$UpdatePolicy_4 = "set security policies from-zone " . $result . " policy " . $ReApply . " match application any";
$UpdatePolicy_5 = "set security policies from-zone " . $result . " policy " . $ReApply . " then reject";


$UpdatePolicy = $UpdatePolicy_1 ."\r\n". $UpdatePolicy_2 ."\r\n". $UpdatePolicy_3 ."\r\n". $UpdatePolicy_4 ."\r\n". $UpdatePolicy_5;


if ($protocol === "ICMP") {

	$FW_Config = $FW_Policy; 

	}



if ((($protocol === "TCP") || ($protocol === "UDP"))   && $PolicyPorts === "any") {

	$FW_Config = $FW_Policy;

	}



if (  (($protocol === "TCP") || ($protocol === "UDP")) && $CreatedNewApp === "no") {

	$FW_Config = $FW_Policy;

	}



if (  (($protocol === "TCP") || ($protocol === "UDP")) && $CreatedNewApp === "yes") {

	$FW_Config = $Application ."\r\n" . $FW_Policy;

	}





$ret = file_put_contents('/var/www/html/Show_Version/FW_Config.set', $FW_Config);
$retUPD = file_put_contents('/var/www/html/Show_Version/UpdatePolicy.set', $UpdatePolicy);

$Result = 1;
echo $Result;
return;

?>

