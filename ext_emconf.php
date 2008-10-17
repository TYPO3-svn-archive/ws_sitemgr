<?php

########################################################################
# Extension Manager/Repository config file for ext: "ws_sitemgr"
#
# Auto generated 17-10-2008 01:22
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Typo3 Hotel manager - with SVN integration',
	'description' => 'Extension for TYPO3 hotel management. Can create multiply developer hotels and production hotel. Extension is using SVN as "backbone" for making hotels - and afterwords SVN can be used to version control',
	'category' => 'module',
	'author' => 'Bo Korshøj Andersen',
	'author_email' => 't3_dev@netimage.dk',
	'shy' => '',
	'dependencies' => 'cms',
	'conflicts' => '',
	'priority' => '',
	'module' => 'mod1,mod2,mod3',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:146:{s:9:"ChangeLog";s:4:"9c1b";s:10:"README.txt";s:4:"9fa9";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"1a46";s:14:"ext_tables.php";s:4:"3c33";s:14:"ext_tables.sql";s:4:"bbdf";s:40:"icon_tx_wssitemgr_database_relations.gif";s:4:"d41d";s:31:"icon_tx_wssitemgr_databases.gif";s:4:"475a";s:29:"icon_tx_wssitemgr_domains.gif";s:4:"475a";s:36:"icon_tx_wssitemgr_domainsaliases.gif";s:4:"475a";s:28:"icon_tx_wssitemgr_hotels.gif";s:4:"475a";s:27:"icon_tx_wssitemgr_queue.gif";s:4:"475a";s:29:"icon_tx_wssitemgr_servers.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"8959";s:24:"sitemgrHotelsUserTca.php";s:4:"b4db";s:19:"sitemgrSettings.php";s:4:"ff97";s:7:"tca.php";s:4:"a3a7";s:13:"untitled file";s:4:"d41d";s:14:"mod1/clear.gif";s:4:"cc11";s:13:"mod1/conf.php";s:4:"9cf5";s:14:"mod1/index.php";s:4:"b3f3";s:18:"mod1/locallang.xml";s:4:"c98f";s:22:"mod1/locallang_mod.xml";s:4:"65ac";s:19:"mod1/moduleicon.gif";s:4:"8074";s:14:"mod3/clear.gif";s:4:"cc11";s:13:"mod3/conf.php";s:4:"c3ce";s:14:"mod3/index.php";s:4:"6602";s:18:"mod3/locallang.xml";s:4:"861e";s:22:"mod3/locallang_mod.xml";s:4:"172e";s:19:"mod3/moduleicon.gif";s:4:"8074";s:35:"pi1/class.tx_nihotelmanager_pi1.php";s:4:"0dfe";s:30:"pi1/class.tx_wssitemgr_pi1.php";s:4:"8733";s:23:"crontab/LASTUPDATECHECK";s:4:"2215";s:10:"crontab/aa";s:4:"6eef";s:16:"crontab/conf.php";s:4:"d246";s:25:"crontab/create_awstats.sh";s:4:"5775";s:39:"crontab/create_awstats_oldhostcreate.sh";s:4:"b7e7";s:27:"crontab/create_dev_vhost.sh";s:4:"b440";s:23:"crontab/create_vhost.sh";s:4:"4214";s:14:"crontab/db.php";s:4:"ae29";s:20:"crontab/editfile.php";s:4:"d6a1";s:21:"crontab/functions.php";s:4:"9458";s:27:"crontab/getAllHotelInfo.php";s:4:"d41d";s:21:"crontab/getEmails.php";s:4:"4be8";s:20:"crontab/getUsers.php";s:4:"b720";s:18:"crontab/index.html";s:4:"c050";s:20:"crontab/index.html.1";s:4:"c050";s:30:"crontab/makeDeveloporHotel.php";s:4:"7674";s:22:"crontab/makeHotels.log";s:4:"b8e2";s:24:"crontab/manageHotels.php";s:4:"7838";s:23:"crontab/manageHotels.sh";s:4:"7c97";s:17:"crontab/nohup.out";s:4:"a104";s:22:"crontab/pop3.class.inc";s:4:"5cf7";s:22:"crontab/svn-commit.tmp";s:4:"f322";s:25:"crontab/svnPostCommit.php";s:4:"0f1d";s:23:"crontab/syncDomains.php";s:4:"0068";s:21:"crontab/t3manager.php";s:4:"2740";s:35:"crontab/maatkit/maatkit-2152.tar.gz";s:4:"2ab2";s:36:"crontab/maatkit/maatkit-2152/COPYING";s:4:"477a";s:38:"crontab/maatkit/maatkit-2152/Changelog";s:4:"0099";s:36:"crontab/maatkit/maatkit-2152/INSTALL";s:4:"3dc0";s:37:"crontab/maatkit/maatkit-2152/MANIFEST";s:4:"55cb";s:37:"crontab/maatkit/maatkit-2152/Makefile";s:4:"a051";s:40:"crontab/maatkit/maatkit-2152/Makefile.PL";s:4:"8a54";s:35:"crontab/maatkit/maatkit-2152/README";s:4:"ce23";s:41:"crontab/maatkit/maatkit-2152/maatkit.spec";s:4:"1075";s:39:"crontab/maatkit/maatkit-2152/pm_to_blib";s:4:"d41d";s:53:"crontab/maatkit/maatkit-2152/blib/man1/mk-archiver.1p";s:4:"9aef";s:50:"crontab/maatkit/maatkit-2152/blib/man1/mk-audit.1p";s:4:"97a8";s:60:"crontab/maatkit/maatkit-2152/blib/man1/mk-checksum-filter.1p";s:4:"d265";s:60:"crontab/maatkit/maatkit-2152/blib/man1/mk-deadlock-logger.1p";s:4:"823f";s:66:"crontab/maatkit/maatkit-2152/blib/man1/mk-duplicate-key-checker.1p";s:4:"8ee3";s:49:"crontab/maatkit/maatkit-2152/blib/man1/mk-find.1p";s:4:"27bb";s:54:"crontab/maatkit/maatkit-2152/blib/man1/mk-heartbeat.1p";s:4:"0fa1";s:58:"crontab/maatkit/maatkit-2152/blib/man1/mk-parallel-dump.1p";s:4:"0416";s:61:"crontab/maatkit/maatkit-2152/blib/man1/mk-parallel-restore.1p";s:4:"0597";s:60:"crontab/maatkit/maatkit-2152/blib/man1/mk-profile-compact.1p";s:4:"862b";s:59:"crontab/maatkit/maatkit-2152/blib/man1/mk-query-profiler.1p";s:4:"f27c";s:56:"crontab/maatkit/maatkit-2152/blib/man1/mk-show-grants.1p";s:4:"88b4";s:56:"crontab/maatkit/maatkit-2152/blib/man1/mk-slave-delay.1p";s:4:"6bce";s:55:"crontab/maatkit/maatkit-2152/blib/man1/mk-slave-find.1p";s:4:"f54a";s:55:"crontab/maatkit/maatkit-2152/blib/man1/mk-slave-move.1p";s:4:"95ea";s:59:"crontab/maatkit/maatkit-2152/blib/man1/mk-slave-prefetch.1p";s:4:"66b4";s:58:"crontab/maatkit/maatkit-2152/blib/man1/mk-slave-restart.1p";s:4:"b48c";s:59:"crontab/maatkit/maatkit-2152/blib/man1/mk-table-checksum.1p";s:4:"6904";s:55:"crontab/maatkit/maatkit-2152/blib/man1/mk-table-sync.1p";s:4:"db51";s:59:"crontab/maatkit/maatkit-2152/blib/man1/mk-visual-explain.1p";s:4:"da00";s:52:"crontab/maatkit/maatkit-2152/blib/script/mk-archiver";s:4:"b551";s:49:"crontab/maatkit/maatkit-2152/blib/script/mk-audit";s:4:"3b6e";s:59:"crontab/maatkit/maatkit-2152/blib/script/mk-checksum-filter";s:4:"477f";s:59:"crontab/maatkit/maatkit-2152/blib/script/mk-deadlock-logger";s:4:"c1e7";s:65:"crontab/maatkit/maatkit-2152/blib/script/mk-duplicate-key-checker";s:4:"5c9a";s:48:"crontab/maatkit/maatkit-2152/blib/script/mk-find";s:4:"29e1";s:53:"crontab/maatkit/maatkit-2152/blib/script/mk-heartbeat";s:4:"7695";s:57:"crontab/maatkit/maatkit-2152/blib/script/mk-parallel-dump";s:4:"9dd5";s:60:"crontab/maatkit/maatkit-2152/blib/script/mk-parallel-restore";s:4:"47ef";s:59:"crontab/maatkit/maatkit-2152/blib/script/mk-profile-compact";s:4:"ab53";s:58:"crontab/maatkit/maatkit-2152/blib/script/mk-query-profiler";s:4:"fd3c";s:55:"crontab/maatkit/maatkit-2152/blib/script/mk-show-grants";s:4:"6bdb";s:55:"crontab/maatkit/maatkit-2152/blib/script/mk-slave-delay";s:4:"ad63";s:54:"crontab/maatkit/maatkit-2152/blib/script/mk-slave-find";s:4:"02ae";s:54:"crontab/maatkit/maatkit-2152/blib/script/mk-slave-move";s:4:"31ca";s:58:"crontab/maatkit/maatkit-2152/blib/script/mk-slave-prefetch";s:4:"feed";s:57:"crontab/maatkit/maatkit-2152/blib/script/mk-slave-restart";s:4:"7dc3";s:58:"crontab/maatkit/maatkit-2152/blib/script/mk-table-checksum";s:4:"c1d0";s:54:"crontab/maatkit/maatkit-2152/blib/script/mk-table-sync";s:4:"f939";s:58:"crontab/maatkit/maatkit-2152/blib/script/mk-visual-explain";s:4:"29d6";s:48:"crontab/maatkit/maatkit-2152/blib/lib/maatkit.pm";s:4:"70c8";s:51:"crontab/maatkit/maatkit-2152/blib/lib/maatkitdsn.pm";s:4:"4255";s:50:"crontab/maatkit/maatkit-2152/blib/man3/maatkit.3pm";s:4:"7ee1";s:53:"crontab/maatkit/maatkit-2152/blib/man3/maatkitdsn.3pm";s:4:"19e4";s:43:"crontab/maatkit/maatkit-2152/udf/fnv_udf.cc";s:4:"470c";s:44:"crontab/maatkit/maatkit-2152/bin/mk-archiver";s:4:"0ae7";s:41:"crontab/maatkit/maatkit-2152/bin/mk-audit";s:4:"2ac1";s:51:"crontab/maatkit/maatkit-2152/bin/mk-checksum-filter";s:4:"11d3";s:51:"crontab/maatkit/maatkit-2152/bin/mk-deadlock-logger";s:4:"997c";s:57:"crontab/maatkit/maatkit-2152/bin/mk-duplicate-key-checker";s:4:"67c4";s:40:"crontab/maatkit/maatkit-2152/bin/mk-find";s:4:"6f91";s:45:"crontab/maatkit/maatkit-2152/bin/mk-heartbeat";s:4:"eab0";s:49:"crontab/maatkit/maatkit-2152/bin/mk-parallel-dump";s:4:"d001";s:52:"crontab/maatkit/maatkit-2152/bin/mk-parallel-restore";s:4:"44f2";s:51:"crontab/maatkit/maatkit-2152/bin/mk-profile-compact";s:4:"1ce8";s:50:"crontab/maatkit/maatkit-2152/bin/mk-query-profiler";s:4:"5da3";s:47:"crontab/maatkit/maatkit-2152/bin/mk-show-grants";s:4:"2cd1";s:47:"crontab/maatkit/maatkit-2152/bin/mk-slave-delay";s:4:"97b3";s:46:"crontab/maatkit/maatkit-2152/bin/mk-slave-find";s:4:"789b";s:46:"crontab/maatkit/maatkit-2152/bin/mk-slave-move";s:4:"fa56";s:50:"crontab/maatkit/maatkit-2152/bin/mk-slave-prefetch";s:4:"5884";s:49:"crontab/maatkit/maatkit-2152/bin/mk-slave-restart";s:4:"b42a";s:50:"crontab/maatkit/maatkit-2152/bin/mk-table-checksum";s:4:"f67d";s:46:"crontab/maatkit/maatkit-2152/bin/mk-table-sync";s:4:"795b";s:50:"crontab/maatkit/maatkit-2152/bin/mk-visual-explain";s:4:"dd8e";s:43:"crontab/maatkit/maatkit-2152/lib/maatkit.pm";s:4:"70c8";s:46:"crontab/maatkit/maatkit-2152/lib/maatkitdsn.pm";s:4:"4255";s:14:"mod2/clear.gif";s:4:"cc11";s:13:"mod2/conf.php";s:4:"ca21";s:14:"mod2/index.php";s:4:"fd77";s:18:"mod2/locallang.xml";s:4:"af1a";s:22:"mod2/locallang_mod.xml";s:4:"f38a";s:19:"mod2/moduleicon.gif";s:4:"8074";s:20:"classes/db.class.php";s:4:"8498";s:19:"classes/sitemgr.php";s:4:"642b";s:26:"classes/Actions/tester.php";s:4:"50b2";s:26:"cronjob/sitemgrCronjob.php";s:4:"39c0";s:19:"doc/wizard_form.dat";s:4:"3128";s:20:"doc/wizard_form.html";s:4:"d071";}',
);

?>