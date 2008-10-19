<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_wssitemgr_hotels"] = array (
	"ctrl" => $TCA["tx_wssitemgr_hotels"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,starttime,endtime,name,developers,productionserver,testserver,devserver,domains,dbdevmethod,hoteldatabases,monitoring"
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
				"type" => "select",	
				"foreign_table" => "fe_users",	
				"foreign_table_where" => "AND fe_users.pid=###CURRENT_PID### ORDER BY fe_users.uid",	
				"size" => 10,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_developers_mm",
			)
		),
		"productionserver" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.productionserver",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.productionserver.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_hotels_productionserver->main",	
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"testserver" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.testserver",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.testserver.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_hotels_testserver->main",	
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"devserver" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.devserver",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.devserver.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_hotels_devserver->main",	
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"domains" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.domains",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_wssitemgr_domains",	
				"foreign_table_where" => "AND tx_wssitemgr_domains.pid=###CURRENT_PID### ORDER BY tx_wssitemgr_domains.uid",	
				"size" => 5,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_domains_mm",	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_wssitemgr_domains",
							"pid" => "###CURRENT_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
				),
			)
		),
		"dbdevmethod" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.dbdevmethod",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.dbdevmethod.I.0", "0"),
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.dbdevmethod.I.1", "1"),
				),
				"size" => 1,	
				"maxitems" => 1,
			)
		),
		"hoteldatabases" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.hoteldatabases",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"monitoring" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.monitoring",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.monitoring.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_hotels_monitoring->main",	
				"size" => 1,	
				"maxitems" => 1,
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, name, developers, productionserver, testserver, devserver, domains, dbdevmethod, hoteldatabases, monitoring")
	),
	"palettes" => array (
		"1" => array("showitem" => "starttime, endtime")
	)
);



$TCA["tx_wssitemgr_domains"] = array (
	"ctrl" => $TCA["tx_wssitemgr_domains"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "name,aliases,monitoring"
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
				"type" => "select",	
				"foreign_table" => "tx_wssitemgr_domainaliases",	
				"foreign_table_where" => "AND tx_wssitemgr_domainaliases.pid=###CURRENT_PID### ORDER BY tx_wssitemgr_domainaliases.uid",	
				"size" => 5,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_domains_aliases_mm",	
				"wizards" => Array(
					"_PADDING" => 2,
					"_VERTICAL" => 1,
					"add" => Array(
						"type" => "script",
						"title" => "Create new record",
						"icon" => "add.gif",
						"params" => Array(
							"table"=>"tx_wssitemgr_domainaliases",
							"pid" => "###CURRENT_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
				),
			)
		),
		"monitoring" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains.monitoring",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains.monitoring.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_domains_monitoring->main",	
				"size" => 1,	
				"maxitems" => 1,
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "name;;;;1-1-1, aliases, monitoring")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_domainaliases"] = array (
	"ctrl" => $TCA["tx_wssitemgr_domainaliases"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "hidden,name,monitoring"
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
		"monitoring" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainaliases.monitoring",		
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainaliases.monitoring.I.0", "0"),
				),
				"itemsProcFunc" => "tx_wssitemgr_tx_wssitemgr_domainaliases_monitoring->main",	
				"size" => 1,	
				"maxitems" => 1,
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "hidden;;1;;1-1-1, name, monitoring")
	),
	"palettes" => array (
		"1" => array("showitem" => "")
	)
);
?>