<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_wssitemgr_hotels"] = array (
	"ctrl" => $TCA["tx_wssitemgr_hotels"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,starttime,endtime,name,developers,domains,servers"
	),
	"feInterface" => $TCA["tx_wssitemgr_hotels"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(0, 0, 0, 12, 31, 2020),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "unique",
			)
		),
		"developers" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.developers",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "fe_users",	
				"size" => 10,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_developers_mm",
			)
		),
		"domains" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.domains",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wssitemgr_domains",	
				"size" => 5,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_domains_mm",
			)
		),
		"servers" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.servers",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wssitemgr_servers",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_servers_mm",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, name, developers, domains, servers")
	),
	"palettes" => array (
		"1" => array("showitem" => "starttime, endtime")
	)
);



$TCA["tx_wssitemgr_domains"] = array (
	"ctrl" => $TCA["tx_wssitemgr_domains"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "name,aliases"
	),
	"feInterface" => $TCA["tx_wssitemgr_domains"]["feInterface"],
	"columns" => array (
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,unique",
			)
		),
		"aliases" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains.aliases",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_wssitemgr_domainaliases",	
				"size" => 4,	
				"minitems" => 0,
				"maxitems" => 9,	
				"MM" => "tx_wssitemgr_domains_aliases_mm",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "name;;;;1-1-1, aliases")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_domainaliases"] = array (
	"ctrl" => $TCA["tx_wssitemgr_domainaliases"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,name"
	),
	"feInterface" => $TCA["tx_wssitemgr_domainaliases"]["feInterface"],
	"columns" => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainaliases.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "unique",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, name")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_servers"] = array (
	"ctrl" => $TCA["tx_wssitemgr_servers"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "name,host,sshuser,dbuser,dbpass,wwwrootdir,type,closeforhotels"
	),
	"feInterface" => $TCA["tx_wssitemgr_servers"]["feInterface"],
	"columns" => array (
		"name" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required",
			)
		),
		"host" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.host",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim,uniqueInPid",
			)
		),
		"sshuser" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.sshuser",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"dbuser" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.dbuser",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"dbpass" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.dbpass",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"wwwrootdir" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.wwwrootdir",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"type" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.type",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.type.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_servers_type->main",	
				"size" => 5,	
				"maxitems" => 50,
			)
		),
		"closeforhotels" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.closeforhotels",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"checkbox" => "",	
				"eval" => "trim",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "name;;;;1-1-1, host, sshuser, dbuser, dbpass, wwwrootdir, type, closeforhotels")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>