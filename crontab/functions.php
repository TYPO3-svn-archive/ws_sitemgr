<?
/***************************************************************
*  Copyright notice
* 
*  (c) 2008 Bo Korshøj Andersen <t3_dev@netimage.dk>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Module 'Hotel manager tasks' for the 'ni_hotelmanager' extension.
 *
 * @author	Bo Korshøj Andersen <t3_dev@netimage.dk>
 */
function debug($debug_text, $a = 0, $error=0){
	global $DEBUG;
	global $debugmailcontent;

	$debug_text .= (($a != 3) && ($a != 2)) ? "\n" : "";
	$debug_text .= ($a == 1) ? "\n" : "";
	$debug_text = (($a != 2) && ($a != 4) && ($error == 0)) ? "[" . date("m/d y H:i:s") . "] " . $debug_text : $debug_text;
	$debug_text = ($error == 1) ? "[" . date("m/d y H:i:s") . "][ERROR] " . $debug_text : $debug_text;
	
	
	if ($DEBUG == 1 || $error == 1) {
		echo $debug_text;
		$debugmailcontent .= $debug_text;
	}	
}
function sendDebugMail () {
	global $debugmailcontent;
	global $debugmailsubject;
	$Name = "Site manager system"; //senders name
	$email = "system@sitemgr.wildside.dk"; //senders e-mail adress
	$recipient = "bo@wildside.dk"; //recipient
	$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

	mail($recipient, $debugmailsubject, $debugmailcontent, $header); //mail command :)
}
function generatePassword($length=9, $strength=0) {
    $vowels = 'aeuy';
    $consonants = 'bdghjmnpqrstvz';
    if ($strength & 1) {
        $consonants .= 'BDGHJLMNPQRSTVWXZ';
    }
    if ($strength & 2) {
        $vowels .= "AEUY";
    }
    if ($strength & 4) {
        $consonants .= '23456789';
    }
    if ($strength & 8) {
        $consonants .= '@#$%';
    }

    $password = '';
    $alt = time() % 2;
    for ($i = 0; $i < $length; $i++) {
        if ($alt == 1) {
            $password .= $consonants[(rand() % strlen($consonants))];
            $alt = 0;
        } else {
            $password .= $vowels[(rand() % strlen($vowels))];
            $alt = 1;
        }
    }
    return $password;
}
function getPilServerUser($hotelname, $pilserver) {
	$filename = "http://hotelmanager.". $pilserver. ".netimage.". $pilserver .".pil.dk/servedatabaseinfo.php?hotel=" . $hotelname;
		
	$handle = fopen($filename, "rb");
	$content = '';
	$content = fread($handle, 8192);
	fclose($handle);
	
	$data = explode(",",$content);
	
	return $data;
}
function pilServerDoCheckDatabases() {
	$handle = fopen("http://hotelmanager.nekat.netimage.nekat.pil.dk/runHotelManagerTasks.php?DO=checkDatabases", "r");
	fclose($handle);
	
	while (pilServerGetStatus("checkDatabases")) {
		debug(".",2);
		sleep(1);
	}	
	debug("",4);
}
function pilServerDoCheckout($hotelname) {
	$handle = fopen("http://hotelmanager.nekat.netimage.nekat.pil.dk/runHotelManagerTasks.php?DO=doCheckout&hotel=" . $hotelname, "r");
	fclose($handle);
	
	while (pilServerGetStatus("doCheckout")) {
		debug(".",2);
		sleep(3);
	}	
	debug("",4);
}

function pilServerGetStatus($status) {
	$handle = fopen("http://hotelmanager.nekat.netimage.nekat.pil.dk/runHotelManagerTasks.php?STATUS=" . $status, "r");
	$content = '';
	$content = fread($handle, 8192);
	fclose($handle);
	if ($content == '') { $content = 0; }
	return $content;
	
}
function strip_hotelname($hotel) {
	$stripedHotelname = $hotel;
	//$stripedHotelname = (substr($stripedHotelname,0,4) == "www.") ? substr($stripedHotelname,4) : $stripedHotelname; // Removing www. if its there
	$stripedHotelname = (substr($stripedHotelname,strlen($stripedHotelname)-3,3) == ".dk") ? str_replace(".dk","dk",$stripedHotelname) : $stripedHotelname; // Removing dot (.) in .dk if its there
	//$stripedHotelname = (substr($stripedHotelname,strlen($stripedHotelname)-4,4) == ".com") ? substr($stripedHotelname,0,strlen($stripedHotelname)-4) : $stripedHotelname; // Removing .com if its there
	$stripedHotelname = str_replace(".","_",$stripedHotelname); // Replacing "." with "_"
	return $stripedHotelname;
}

function putPilMailsInDatabase () {
	global $conf;
	
	$emails = getEmails();
	if (!isset($emails)) return 0;
	foreach ($emails as $email) {
		$cruser_id = 4;
		$sql = "SELECT * FROM `tx_nihotelmanager_hotels` WHERE `deleted` = '0' AND `name` = '". $email['name'] . "' AND `pid` = ". $conf['t3_hotel_sysfolder'];
		$res = mysql_query($sql,$link);
	
		$database_data = mysql_fetch_array($res);
		
		if (@$database_data['name'] == $email['name']) {
			echo $email['status'];
			if ($email['status'] == "nuked") {
				$sql = "UPDATE `tx_nihotelmanager_hotels` SET `status` = 'DELETE' WHERE `uid` = '". $database_data['uid'] ."'";
				mysql_query($sql,$link) or die(mysql_error());
			}
			deleteEmail($email['emailId']);	
		}
		else {
			if ($email['status'] == "created") {
				$sql = 'INSERT INTO `tx_nihotelmanager_hotels` (`uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `deleted`, `name`, `developers`, `databases`, `status`) VALUES (\'\', \''. $conf['t3_hotel_sysfolder'] .'\', \''. time() .'\', \''. time() .'\', \''. $cruser_id .'\', \'0\', \''. $email['name'] .'\', \'\', \'\', \'NEW_PIL\');';
				mysql_query($sql,$link) or die(mysql_error());
				
			}
			deleteEmail($email['emailId']);	
		}
	}
		
}
function implodeToCreateVhost($domains) {

	foreach ($domains as $domain) {
		$implodestring .= $domain['name'] . " ";
		if (!$domain['aliases']) continue;
		foreach ($domain['aliases'] as $alias) {
			$implodestring .= $alias['name']  . " ";
		}
	}
	return $implodestring;


}
function addDomainsToHostsfile ($domains, $host) {
	$edithostsfile = new editfile("/etc/", "hosts");
	$edithostsfile->add_markers("## Hotelmanager test hosts ##,## Hotelmanager END ##");
	foreach ($domains as $domain) {
		$edithostsfile->add_line($host ."	" . $domain['name']);
		
		if (!$domain['aliases']) continue;
		foreach ($domain['aliases'] as $alias) {
			$edithostsfile->add_line($host ."	" . $alias['name']);
		}
	}
	$edithostsfile->do_actions();
	$edithostsfile->close;
}
function cleanupHostsFile () {
	$edithostsfile = new editfile("/etc/", "hosts");
	$edithostsfile->add_markers("## Hotelmanager test hosts ##,## Hotelmanager END ##");
	$edithostsfile->do_actions();
	$edithostsfile->close;
}
function testdomain ($domains, $hotelname) {
	foreach ($domains as $domain) {
									
		$content = "";
		exec("wget ". $domain['name'] . "/HOTELNAME 2>&1");
		$handle = @fopen('HOTELNAME', "r");
		$content = @fread($handle, @filesize('HOTELNAME'));
		@fclose($handle);
		if (strstr($content, $hotelname)) { debug($domain['name'] . " is working");}
		else { debug($domain['name'] . " is NOT working"); $return++; }
		exec("rm HOTELNAME 2>&1");

		if (!$domain['aliases']) continue;		
		foreach ($domain['aliases'] as $alias) {
				
			$content = "";					
			exec("wget ". $alias['name'] ."/HOTELNAME 2>&1");
			$handle = @fopen('HOTELNAME', "r");
			$content = @fread($handle, @filesize('HOTELNAME'));
			@fclose($handle);
			if (strstr($content, $hotelname)) { debug($alias['name'] . " is working");}
			else { debug($alias['name'] . " is NOT working"); $return++; }
			exec("rm HOTELNAME 2>&1");
									
		}					
	}
	return $return;
}
