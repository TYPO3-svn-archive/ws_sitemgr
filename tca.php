<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_wssitemgr_hotels"] = Array (
	"ctrl" => $TCA["tx_wssitemgr_hotels"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "name,creationdate,developers,devdatabases,server,domains,status,reseterrorstatus"
	),
	"feInterface" => $TCA["tx_wssitemgr_hotels"]["feInterface"],
	"columns" => Array (
		"name" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"creationdate" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.creationdate",		
			"config" => Array (
				"type" => "input",
				"size" => "12",
				"max" => "20",
				"eval" => "datetime",
				"checkbox" => "0",
				"default" => "0"
			)
		),
		"developers" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.developers",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "fe_users",	
				"foreign_table_where" => "ORDER BY fe_users.uid",	
				"size" => 10,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_developers_mm",
			)
		),
		"devdatabases" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.devdatabases",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "tx_nihotelmanager_databases",	
				"size" => 10,	
				"minitems" => 0,
				"maxitems" => 99,	
				"MM" => "tx_wssitemgr_hotels_devdatabases_mm",
			)
		),
		"server" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.server",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_nihotelmanager_servers",	
				"foreign_table_where" => "ORDER BY tx_nihotelmanager_servers.uid",	
				"size" => 1,	
				"minitems" => 0,
				"maxitems" => 1,
			)
		),
		"domains" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.domains",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_nihotelmanager_domains",	
				"foreign_table_where" => "ORDER BY tx_nihotelmanager_domains.uid",	
				"size" => 4,	
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
							"table"=>"tx_nihotelmanager_domains",
							"pid" => "###CURRENT_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"list" => Array(
						"type" => "script",
						"title" => "List",
						"icon" => "list.gif",
						"params" => Array(
							"table"=>"tx_nihotelmanager_domains",
							"pid" => "###CURRENT_PID###",
						),
						"script" => "wizard_list.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
		"status" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.status",		
			"config" => Array (
				"type" => "none",
			)
		),
		"reseterrorstatus" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_hotels.reseterrorstatus",		
			"config" => Array (
				"type" => "check",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "name;;;;1-1-1, creationdate, developers, devdatabases, server, domains, status, reseterrorstatus")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_databases"] = Array (
	"ctrl" => $TCA["tx_wssitemgr_databases"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "dbname,dbuser,dbpass,developer,isdefault,isempty"
	),
	"feInterface" => $TCA["tx_wssitemgr_databases"]["feInterface"],
	"columns" => Array (
		"dbname" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases.dbname",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"dbuser" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases.dbuser",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"dbpass" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases.dbpass",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"developer" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases.developer",		
			"config" => Array (
				"type" => "group",	
				"internal_type" => "db",	
				"allowed" => "fe_users",	
				"size" => 10,	
				"minitems" => 0,
				"maxitems" => 99,
			)
		),
		"isdefault" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases.isdefault",		
			"config" => Array (
				"type" => "check",
				"default" => 1,
			)
		),
		"isempty" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_databases.isempty",		
			"config" => Array (
				"type" => "none",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "dbname;;;;1-1-1, dbuser, dbpass, developer, isdefault, isempty")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_servers"] = Array (
	"ctrl" => $TCA["tx_wssitemgr_servers"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "name,host,dbuser,dbpass,dirhotels"
	),
	"feInterface" => $TCA["tx_wssitemgr_servers"]["feInterface"],
	"columns" => Array (
		"name" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
		"host" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.host",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,lower,nospace,unique",
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
		"dirhotels" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_servers.dirhotels",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",	
				"eval" => "required,trim",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "name;;;;1-1-1, host, dbuser, dbpass, dirhotels")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_domainsaliases"] = Array (
	"ctrl" => $TCA["tx_wssitemgr_domainsaliases"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "name"
	),
	"feInterface" => $TCA["tx_wssitemgr_domainsaliases"]["feInterface"],
	"columns" => Array (
		"name" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domainsaliases.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "name;;;;1-1-1")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_domains"] = Array (
	"ctrl" => $TCA["tx_wssitemgr_domains"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "name,aliases"
	),
	"feInterface" => $TCA["tx_wssitemgr_domains"]["feInterface"],
	"columns" => Array (
		"name" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains.name",		
			"config" => Array (
				"type" => "input",	
				"size" => "30",
			)
		),
		"aliases" => Array (		
			"exclude" => 0,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_domains.aliases",		
			"config" => Array (
				"type" => "select",	
				"foreign_table" => "tx_wssitemgr_domainsaliases",	
				"foreign_table_where" => "ORDER BY tx_wssitemgr_domainsaliases.uid",	
				"size" => 10,	
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
							"table"=>"tx_wssitemgr_domainsaliases",
							"pid" => "###CURRENT_PID###",
							"setValue" => "prepend"
						),
						"script" => "wizard_add.php",
					),
					"list" => Array(
						"type" => "script",
						"title" => "List",
						"icon" => "list.gif",
						"params" => Array(
							"table"=>"tx_wssitemgr_domainsaliases",
							"pid" => "###CURRENT_PID###",
						),
						"script" => "wizard_list.php",
					),
					"edit" => Array(
						"type" => "popup",
						"title" => "Edit",
						"script" => "wizard_edit.php",
						"popup_onlyOpenIfSelected" => 1,
						"icon" => "edit2.gif",
						"JSopenParams" => "height=350,width=580,status=0,menubar=0,scrollbars=1",
					),
				),
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "name;;;;1-1-1, aliases")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);



$TCA["tx_wssitemgr_queue"] = Array (
	"ctrl" => $TCA["tx_wssitemgr_queue"]["ctrl"],
	"interface" => Array (
		"showRecordFieldList" => "starttime,callclass,parms,depend,server,status"
	),
	"feInterface" => $TCA["tx_wssitemgr_queue"]["feInterface"],
	"columns" => Array (
		"starttime" => Array (		
			"exclude" => 1,
			"label" => "LLL:EXT:lang/locallang_general.xml:LGL.starttime",
			"config" => Array (
				"type" => "input",
				"size" => "8",
				"max" => "20",
				"eval" => "date",
				"default" => "0",
				"checkbox" => "0"
			)
		),
		"callclass" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_queue.callclass",		
			"config" => Array (
				"type" => "none",
			)
		),
		"parms" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_queue.parms",		
			"config" => Array (
				"type" => "none",
			)
		),
		"depend" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_queue.depend",		
			"config" => Array (
				"type" => "none",
			)
		),
		"server" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_queue.server",		
			"config" => Array (
				"type" => "none",
			)
		),
		"status" => Array (		
			"exclude" => 1,		
			"label" => "LLL:EXT:ws_sitemgr/locallang_db.xml:tx_wssitemgr_queue.status",		
			"config" => Array (
				"type" => "none",
			)
		),
	),
	"types" => Array (
		"0" => Array("showitem" => "starttime;;;;1-1-1, callclass, parms, depend, server, status")
	),
	"palettes" => Array (
		"1" => Array("showitem" => "")
	)
);
?>