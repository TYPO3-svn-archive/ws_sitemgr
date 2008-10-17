<?php 

define("SITEMGR_DIR","/var/www/sitemgr.wildside.dk/typo3conf/ext/ws_sitemgr/");
define("SITEMGR_CRONTABDIR", SITEMGR_DIR . "crontab/");
define("SITEMGR_CLASSDIR", SITEMGR_DIR . "classes/");

include(SITEMGR_CLASSDIR."sitemgr.php");
include(SITEMGR_CLASSDIR."db.class.php");

// Open the base (construct the object):
$dbSitemgr = new DB("sitemgr", "localhost", "root", "sl56qpsql");


$queue = $dbSitemgr->queryUniqueObject("SELECT * FROM tx_wssitemgr_queue WHERE `status` = 0 ORDER BY uid ASC");
if ($queue->uid) $dbSitemgr->execute("UPDATE `sitemgr`.`tx_wssitemgr_queue` SET `status` = '1' WHERE `tx_wssitemgr_queue`.`uid` =".$queue->uid." LIMIT 1 ;"); 

if (is_file(SITEMGR_CLASSDIR."Actions/". $queue->callclass . ".php")) {
	include(SITEMGR_CLASSDIR."Actions/". $queue->callclass . ".php");
	$action = new $queue->callclass ("Det virker");

	
	
	echo $action->echoout();
	
}




?>	