<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_wssitemgr_hotels"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY name",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
		),
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_hotels.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, starttime, endtime, name, developers, domains, servers",
	)
);

$TCA["tx_wssitemgr_domains"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY name",	
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_domains.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "name, aliases",
	)
);

$TCA["tx_wssitemgr_domainaliases"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainaliases',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY name",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_domainaliases.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, name",
	)
);


if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_servers_type.php");

$TCA["tx_wssitemgr_servers"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers',		
		'label'     => 'name',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY name",	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_servers.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "name, host, sshuser, dbuser, dbpass, wwwrootdir, type, closeforhotels",
	)
);
?>
