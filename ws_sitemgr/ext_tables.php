<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_hotels_productionserver.php");


if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_hotels_testserver.php");


if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_hotels_devserver.php");


if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_hotels_monitoring.php");

$TCA["tx_wssitemgr_hotels"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'name',	
		'default_sortby' => "ORDER BY name",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'starttime' => 'starttime',	
			'endtime' => 'endtime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_hotels.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, starttime, endtime, name, developers, productionserver, testserver, devserver, domains, dbdevmethod, hoteldatabases, monitoring",
	)
);


if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_domains_monitoring.php");

$TCA["tx_wssitemgr_domains"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_domains.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "name, aliases, monitoring",
	)
);


if (TYPO3_MODE=="BE")	include_once(t3lib_extMgm::extPath("ws_sitemgr")."class.tx_wssitemgr_tx_wssitemgr_domainaliases_monitoring.php");

$TCA["tx_wssitemgr_domainaliases"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainaliases',		
		'label'     => 'uid',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => "ORDER BY crdate",	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_wssitemgr_domainaliases.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "hidden, name, monitoring",
	)
);
?>