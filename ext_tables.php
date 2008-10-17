<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_wssitemgr_hotels"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		"default_sortby" => "ORDER BY name",	
		"delete" => "deleted",	
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wssitemgr_hotels.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "name, creationdate, developers, devdatabases, server, domains, status, reseterrorstatus",
	)
);

$TCA["tx_wssitemgr_databases"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases',		
		'label' => 'dbname',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		"default_sortby" => "ORDER BY dbname",	
		"delete" => "deleted",	
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wssitemgr_databases.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "dbname, dbuser, dbpass, developer, isdefault, isempty",
	)
);

$TCA["tx_wssitemgr_servers"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		"default_sortby" => "ORDER BY name",	
		"delete" => "deleted",	
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wssitemgr_servers.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "name, host, dbuser, dbpass, dirhotels",
	)
);

$TCA["tx_wssitemgr_domainsaliases"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainsaliases',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		"default_sortby" => "ORDER BY name",	
		"delete" => "deleted",	
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wssitemgr_domainsaliases.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "name",
	)
);

$TCA["tx_wssitemgr_domains"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains',		
		'label' => 'name',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		"default_sortby" => "ORDER BY name",	
		"delete" => "deleted",	
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wssitemgr_domains.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "name, aliases",
	)
);

$TCA["tx_wssitemgr_queue"] = Array (
	"ctrl" => Array (
		'title' => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_queue',		
		'label' => 'callclass',	
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'callclass',	
		"default_sortby" => "ORDER BY crdate",	
		"delete" => "deleted",	
		"enablecolumns" => Array (		
			"starttime" => "starttime",
		),
		"dynamicConfigFile" => t3lib_extMgm::extPath($_EXTKEY)."tca.php",
		"iconfile" => t3lib_extMgm::extRelPath($_EXTKEY)."icon_tx_wssitemgr_queue.gif",
	),
	"feInterface" => Array (
		"fe_admin_fieldList" => "starttime, callclass, parms, depend, server, status",
	)
);


if (TYPO3_MODE=="BE")	{
		
	t3lib_extMgm::addModule("txwssitemgrM1","","",t3lib_extMgm::extPath($_EXTKEY)."mod1/");
}


if (TYPO3_MODE=="BE")	{
		
	t3lib_extMgm::addModule("help","txwssitemgrM2","",t3lib_extMgm::extPath($_EXTKEY)."mod2/");
}


if (TYPO3_MODE=="BE")	{
		
	t3lib_extMgm::addModule("help","txwssitemgrM3","",t3lib_extMgm::extPath($_EXTKEY)."mod3/");
}
?>