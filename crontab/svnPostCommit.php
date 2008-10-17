#!/usr/bin/php
<?php

@$repos = $argv[1];
@$rev = $argv[2];

exec("/usr/bin/svnlook changed $repos -r $rev 2>&1", $svnlookOutput);
foreach ($svnlookOutput as $svnlookLine) {
	if (substr($svnlookLine,0,1) != "A") { continue; }
	$svnlookLine = explode("/", $svnlookLine);
	if ($svnlookLine[2] == "tags") {
		$i++;
		$newTags[$i]['tag'] = $svnlookLine[3];
		$newTags[$i]['hotel'] = $svnlookLine[1];
	}
}
if (!$newTags) die(); 

require_once ("../crontab/t3manager.php");
require_once ("../crontab/conf.php");


foreach ($newTags as $newTag) {


	global $conf;
	$t3manager = NEW t3manager();
	$t3manager->hotelName = $newTag['hotel'];
	$hotel = $t3manager->getHotels($conf);
	$hotel = $hotel[1];
	
	$productiontag = explode(".", $hotel['svnproductiontag']);
	$svndevtesttag = explode(".", $hotel['svndevtesttag']);
	$newTag['tag'] = explode(".", $newTag['tag']);
	
	//New stable release to relase at production??
	if ($newTag['tag'][0] > $productiontag[0]) {
		$output = "NEW STABLE - Releasing to production and testserver\n";	
		
		exec("ssh -l root ". $hotel['server'] .".wildside.dk /usr/bin/svn export --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" --force ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "/tags/". implode(".", $newTag['tag']) . " /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/ 2>&1");
		exec("ssh -l root ". $hotel['server'] .".wildside.dk /bin/chown -R www-data:www-data /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs 2>&1");
		exec("ssh -l root ". $hotel['server'] .".wildside.dk /bin/ls /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql 2>&1", $execLsOutput);
		if ($execLsOutput[0] == "/var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql") {
			//mysqldump.sql exists therefore making mysqlimport
			$database = $t3manager->getMysqlInfo($conf,$hotel['uid'],1);
			$database = $database[1];
			exec('ssh -l root '. $hotel['server'] .'.wildside.dk /usr/bin/mysql "-u'. $conf['database_production_user'] .' -p'.  $conf['database_production_pass'] .' -h'. $hotel['serverhost'] .' '. $database['name'] .'<'. "/var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql\"");					
		}
		
		exec("ssh -l root ". $hotel['server'] .".wildside.dk /bin/rm /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql 2>&1", $execLsOutput);
		
		
		
		$t3manager->changeHotelSvnproductiontag($conf, $hotel['uid'], implode(".", $newTag['tag']));	
		$t3manager->changeHotelSvndevtesttag($conf, $hotel['uid'], implode(".", $newTag['tag']));
		
		$mailoutput = "New stable version of " . $hotel['name'] . " released - version: ". $hotel['newtag'] ."\n" . "Comments: \n". $hotel['newtagcomment'];
		$mailsubject = "New stable release - " . $hotel['name'] . " - " . $hotel['newtag'];
		$t3manager->removeNewTagData($conf, $hotel['uid']);
	} 
	
	//New beta release to relase at testserver??
	if (($newTag['tag'][0] == $productiontag[0]) && ($newTag['tag'][1] > $productiontag[1])) {
		$output = "NEW BETA - Releasing to testserver\n";		
	
		exec("/usr/bin/svn export --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" --force ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "/tags/". implode(".", $newTag['tag']) . " /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/ 2>&1");
		exec("/bin/chown -R www-data:www-data /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs 2>&1");
		exec("/bin/ls /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql 2>&1", $execLsOutput);
		if ($execLsOutput[0] == "/var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql") {
			//mysqldump.sql exists therefore making mysqlimport
			$database = $t3manager->getMysqlInfo($conf,$hotel['uid'],1);
			$database = $database[1];
			exec('/usr/bin/mysql -u'. $conf['database_production_user'] .' -p'.  $conf['database_production_pass'] .' -h'. "localhost" .' '. $database['name'] .'<'. "/var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql");					
		}
		
		//exec("/bin/rm /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/mysqldump.sql 2>&1", $execLsOutput);
		
		
		
		$t3manager->changeHotelSvndevtesttag($conf, $hotel['uid'], implode(".", $newTag['tag']));
		
		$mailoutput = "New beta version of " . $hotel['name'] . " released - version: ". $hotel['newtag'] ."\n" . "Comments: \n". $hotel['newtagcomment'];
		$mailsubject = "New beta release - " . $hotel['name'] . " - " . $hotel['newtag'];
		$t3manager->removeNewTagData($conf, $hotel['uid']);
	
	
	
	}

	 
	echo $output;
/*	
	echo $hotel['svnproductiontag'] . "\n";
	echo $hotel['svndevtesttag'] . "\n";
*/

}



if ($mailoutput && $mailsubject) {
$Name = "Site manager system"; //senders name
$email = "system@sitemgr.wildside.dk"; //senders e-mail adress
$recipient = "bo@wildside.dk"; //recipient
$header = "From: ". $Name . " <" . $email . ">\r\n"; //optional headerfields

mail($recipient, $mailsubject, $mailoutput, $header); //mail command :)
}