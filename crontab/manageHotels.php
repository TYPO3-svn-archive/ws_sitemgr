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



// svn switch --relocate https://dev.netimage.dk:4443/typo3/ file:///svn/typo3/ /dana/data/typo3/hoteller/typo3hotelmanager_netimage/docs/
include("db.php");
include("getEmails.php");
include("functions.php");
include("t3manager.php");
include("editfile.php");
include("conf.php");





GLOBAL $link;

$t3manager = NEW t3manager();


$t3manager->updateLastCheckData();
$t3manager->ChangeDeletedFlagToStatusDelete($conf);
$t3manager->CheckForDomainUpdates();
$t3manager->CheckForHotelUpdates();



//### Starting ssh-agent and feeting it! ###
exec(". /root/.ssh-agent 2>&1");
exec("/usr/bin/ssh-add 2>&1");



$DEBUG = 1;
/*
$productiondb = mysql_connect("starscream.wildside.dk", $conf['database_production_user'], $conf['database_production_pass']);
$sql = 'CREATE DATABASE '. "Testdatabasebka";
echo mysql_query($sql, $productiondb)or die(mysql_error());      								
*/
/*
//### DELETE TEST HOTEL ###

debug("Deleting test dir",1);
//exec("sudo chown -R ".$conf['dir_test_rights']." ". $conf['dir_test'] . "labkatestsite.dk");
//exec("sudo chmod -R 777 ". $conf['dir_test'] . "t3creatortest");
$t3manager->setHotelStatus(11,"NEW");					
exec("/usr/bin/svn rm --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] ."". $conf['svn_hoteldir'] ."labkatestsite.dk -m \"rm ". "Removing test dir" . "\" 2>&1 ", $execRmTestOutput);
exec("rm -rf ". "/var/www/starscream/typo3/hoteller/" ."labkatestsite.dk");
exec("ssh -l root starscream.wildside.dk rm -rf /var/www/starscream/typo3/hoteller/labkatestsite.dk 2>&1 ", $execRmOutput);

mysql_query('DROP DATABASE t3_starscream_labkatestsitedk');
mysql_query('DROP USER st_labkatestsite@localhost');

$productiondb = mysql_connect("starscream.wildside.dk", $conf['database_production_user'], $conf['database_production_pass']);
mysql_query('DROP DATABASE t3_starscream_labkatestsitedk',$productiondb);
mysql_query('DROP USER st_labkatestsite@localhost',$productiondb);
mysql_close($productiondb);




debug("test user and db deleted",1);

//## DELETE TEST HOTEL #END# ###
*/





$hotels = $t3manager->getHotels($conf);

/*
var_dump($hotels);


exec("ssh -l root ". $hotels[1]['server'] .".wildside.dk ls /var/www/ 2>&1 ", $execLsOutput);
var_dump($execLsOutput);
die();
*/

if (!isset($hotels)) { die(); }	

 
foreach ($hotels as $hotel) {
	global $debugmailsubject;
	$debugmailsubject = $hotel['name'] . " - Status: " . $hotel['status'];

	if (strstr($conf['actionStatusList'], $hotel['status']) == FALSE) continue; 
	debug("",4);
	debug("",4);
	debug("### JOB STARTED - ". $hotel['name'] . " - Status: " . $hotel['status'] . " ###");
	debug("",4);
	
	//Crappy FIX - Somebody correct this soon !!
	//########
	$conf['dir_test'] = str_replace("/www/typo3/","/www/". $hotel['server'] . "/typo3/", $conf['dir_test']);
	
	if ($hotel['status'] == "DELETE") {
	
		//	svn ls --username xx --password xx  https://192.168.1.213:4443/typo3/hoteller/www.t3creatortest.dk
		
		//var_dump($execLsOutput);
		
		if (@strstr($execLsOutput[0], "non-existent in that revision") == FALSE) {
			
			//Improvments:
			// Making a download of live version before making mysqldump and filedump 
			// Deleting live version (files and databases)
			// Deleting vhosts on dev and production - Jesper might be able to make a quick shell script for this ;)
			// Delete domains linked to hotel
			// Delete database users on production and dev
					
			$hotelDatabases = $t3manager->getMysqlInfo($conf,$hotel['uid']);
			
			
			exec("mkdir " . $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . "mysqldumps");
			foreach ($hotelDatabases as $hotelDatabase) {
				debug("Making mysqldump of " . $hotelDatabase['name']);
				exec('/usr/bin/mysqldump -u'. $hotelDatabase['user'] .' -p'. $hotelDatabase['pass'] .' '. $hotelDatabase['name'] .'>'. $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . "mysqldumps/" . $hotelDatabase['name'] . ".sql 2>&1"); 
				debug("mysqldump done");
				
				$sql = 'DROP DATABASE ' . $hotelDatabase['name'];
				mysql_query($sql) or die(mysql_error());
				debug("Database deleted on server");

				$t3manager->deleteDatabase($conf,$hotelDatabase['uid']);			
				debug("Database deleted in hotelmanager",1);
			}
			exec("/usr/bin/svn add ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']."mysqldumps 2>&1");
			debug("Dumps added to SVN");
			
			exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']." -m \"Mysqldump(s) before delete\" 2>&1");
			debug("Dumps committed to SVN",1);
			
			
			debug("Deleting " . $hotel['name'] . " in SVN (or just moving to \"deleted\" folder)");
			exec("/usr/bin/svn mv --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "  " . $conf['svn_server'] . $conf['svn_hoteldir'] . $conf['svn_deletedfolder'] . $hotel['name'] ."_" . date("m_d_y_H_i") . " -m \"Deleting ". $hotel['name'] . "\"");
			
			
			debug("Deleting test hotel folder on DEV",1);
			
			exec("rm -rf ". $conf['dir_test'] . $hotel['name']);
			
			
			
			$t3manager->changeHotelName($conf,$hotel['uid'], $hotel['name'] . "_" . date("d_m_y_H_i"));
			$t3manager->changeHotelPID($conf,$hotel['uid'],$conf['t3_hotel_sysfolder_deleted']);
			
			//date("m_d_y_H_i")
			
			$t3manager->setHotelStatus($hotel['uid'],"Successfully deleted");
		}
		else {
			debug($hotel['name'] . " dosent exist in SVN - no action will be taken",1,1);
			
			$t3manager->setHotelStatus($hotel['uid'],"DELETION FAILD");
			//$t3manager->changeHotelName($conf,$hotel['uid'], $hotel['name'] . " - DELETION FAILD");
			
		}
	}
	if ($hotel['status'] == "NEW")  {
		
				
			//Improvments:
			// Send mail
			// Do something else when a error happens. ( now just setting status to ERROR )
			// Put info into a hotel database - status: on its way

		
		$t3manager->setHotelStatus($hotel['uid'],"CREATING HOTEL");
				
    	//### Creating hotel dir in SVN###
    	debug("Creating hotel dir in SVN", 1);
    	exec("/usr/bin/svn mkdir --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . " -m \"mkdir ". $hotel['name'] . "\" 2>&1 ", $execMkdirOutput);
		
    	if (@strstr($execMkdirOutput[1], "Committed revision") != FALSE) { 
	    	
    		
    		//### Copying Typo3template to dir in SVN ###
    		debug("Copy template to new hotel in SVN");
    		exec("/usr/bin/svn cp --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] ."typo3template/branches/". $conf['svn_templateversion'] ." ". $conf['svn_server'] ."". $conf['svn_hoteldir'] ."". $hotel['name'] . "/trunk -m \"Copying Typo3 templatehotel version ". $conf['svn_templateversion'] ." to ". $hotel['name'] . "\"");
	    	
    		//### Creating branches and xtags  in SVN###
    		debug("Creating branches and tags in SVN", 1);
    		exec("/usr/bin/svn mkdir --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "/branches -m \"mkdir branches on ". $hotel['name'] . "\"");
	    	exec("/usr/bin/svn mkdir --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "/tags -m \"mkdir tags on ". $hotel['name'] . "\"");
	    	
	    	
	    	//### Making TEST hotel on DEV ###
			$devDirName = $hotel['name'];
			
			//### Making TEST hotel dir ###
			debug("Creating main test dir on DEV");
			exec("mkdir ". $conf['dir_test'] ."".$hotel['name'] ." 2>&1", $output);
			
			//### If no errors in creating TEST hotel dir - proceed
			if (@$output[0] == "") { 

				//### Making docs folder in TEST hotel dir ###
				debug("Creating docs folder in testdir on DEV");
				exec("mkdir ". $conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs']); 
								
				//### Making checkout to TEST hotel dir ###
				debug("Making checkout to testdir on DEV", 1);
				exec("/usr/bin/svn checkout --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "/trunk ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']);
								
				//### Setting "propset svn:ignore" on upload and temp folders ###
				if ($conf['ignoreFolders']) {
					debug("Setting ignores on testdir on DEV");
					
					foreach ($conf['ignoreFolders'] as $folder) {
						debug("Setting ignore on: ". $folder);
						exec("/usr/bin/svn propset --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" svn:ignore \"*\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs'].$folder." -R 2>&1");
					}
					debug("Ignore set done");	
					$ignoredFolders = implode(", ", $conf['ignoreFolders']);
					exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']." -m \"Ignore folders: ". $ignoredFolders ." \" 2>&1");
					debug("Committed ignores to SVN",1);			
				}	
				if (is_file($conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . $conf['mysqldumpFileName'])){
					
					debug("Connecting to Mysql");
					$devdb = @mysql_connect($conf['database_dev_host'], $conf['database_dev_user'], $conf['database_dev_pass']);
					if (!mysql_error()) {
						debug("Connected to Mysql",1);	
						
					
						
						
						//## Making name, username and password for databases... ##
						
						debug("Making mysql database name, user and pass");

						$newDB_name =  $conf['database_prefix'] . $hotel['server'] . "_";
						$newDB_name .= substr(strip_hotelname($hotel['name']),0,64-strlen($newDB_name));
						debug("Mysql database name: " . $newDB_name);
						
						$newDB_user = $conf['database_dev_prefix'] . substr($hotel['server'],0,2) . "_";
						$newDB_user .= substr(strip_hotelname($hotel['name']),0,16-strlen($newDB_user)) . "";
						debug("Mysql database user: " . $newDB_user);
						
						$newDB_pass = generatePassword(9,4);
						debug("Mysql database pass: " . $newDB_pass, 1);
						
						debug("Checking if database or user already exists on DEV");
						
						@mysql_select_db($newDB_name);
						if (mysql_error()) {
							
							
							debug("Database dosen't exist - now created");
							$sql = 'CREATE DATABASE '. $newDB_name;
               				mysql_query($sql);      
				
               				$sql = 'CREATE USER '. $newDB_user .'@localhost IDENTIFIED BY \''. $newDB_pass .'\'';	
							mysql_query($sql);      
							if (!mysql_error()) {
							
								debug("Database user dosen't exist - now created");
								
								$sql = 'GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,ALTER,INDEX,DROP,CREATE TEMPORARY TABLES,CREATE VIEW,SHOW VIEW,CREATE ROUTINE,ALTER ROUTINE,EXECUTE,LOCK TABLES  ON '. $newDB_name .'.* TO '. $newDB_user .'@localhost IDENTIFIED BY \''. $newDB_pass .'\'';
								mysql_query($sql);      
								debug("Rights set on database user");

								exec('/usr/bin/mysql -u'. $conf['database_dev_user'] .' -p'.  $conf['database_dev_pass'] .' '. $newDB_name .'<'. $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . $conf['mysqldumpFileName']);
								debug("Data inserted to DB",1);
								
								$t3manager->linkDatabaseToHotel($conf,$hotel['uid'],$t3manager->insertDatabase($conf,$newDB_name,$newDB_user,$newDB_pass));
								
								mysql_close($devdb);
								
								exec("/usr/bin/svn rm ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs'].$conf['mysqldumpFileName'] . " 2>&1");
								exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']." -m \"Removing mysqldump\" 2>&1");	

								debug("Editing localconf.php and localconf_dev.php");
								
								
								//## Edit of localconf.php ##
								
							
								
								exec('mv ' . $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . 'typo3conf/localconf.php' . ' ' . $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] .'typo3conf/localconf.php.temp');
															
								$handle = fopen($conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . 'typo3conf/localconf.php.temp', "r");
								$typo3conf_content = fread($handle, filesize($conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . 'typo3conf/localconf.php.temp'));
								fclose($handle);
								$typo3conf_content = explode("\n",$typo3conf_content);
								
								$typo3conf_content_write = fopen($conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . 'typo3conf/localconf.php', 'w');
								
								foreach ($typo3conf_content as $line) {
									
									$line = (strstr($line, '$typo_db_username =')) 						? '$typo_db_username = \''. $newDB_user .'\';' : $line;
									$line = (strstr($line, '$typo_db_password =')) 						? '$typo_db_password = \''. $newDB_pass .'\';' : $line;
									$line = (strstr($line, '$typo_db_host     =')) 						? '$typo_db_host     = \''. 'localhost' .'\';' : $line;
									$line = (strstr($line, '$typo_db          =')) 						? '$typo_db          = \''. $newDB_name .'\';' : $line;
									$line = (strstr($line, '$TYPO3_CONF_VARS["SYS"]["sitename"] =')) 	? '$TYPO3_CONF_VARS["SYS"]["sitename"] = \''. $hotel['name'] .'\';' : $line;
									
									fwrite($typo3conf_content_write, $line . "\n");
								
								}
								fclose($typo3conf_content_write);
								unlink($conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . 'typo3conf/localconf.php.temp');
								
																
								debug("Edit of localconf.php done");
								
								
								//## Edit of localconf_dev.php ##
								/*
								exec('mv ' . $conf['dir_test'] . $devDirName . $conf['dir_test_docs'] . 'typo3conf/localconf_dev.php' . ' ' . $conf['dir_test'] . $devDirName . $conf['dir_test_docs'] .'typo3conf/localconf_dev.php.temp');
															
								$handle = fopen($conf['dir_test'] . $devDirName . $conf['dir_test_docs'] . 'typo3conf/localconf_dev.php.temp', "r");
								$typo3conf_dev_content = fread($handle, filesize($conf['dir_test'] . $devDirName . $conf['dir_test_docs'] . 'typo3conf/localconf_dev.php.temp'));
								fclose($handle);
								$typo3conf_dev_content = explode("\n",$typo3conf_dev_content);
								
								$typo3conf_dev_content_write = fopen($conf['dir_test'] . $devDirName . $conf['dir_test_docs'] . 'typo3conf/localconf_dev.php', 'w');
								
								foreach ($typo3conf_dev_content as $line) {
									
									$line = (strstr($line, '$typo_db_username =')) 	? '	$typo_db_username = \''. $newDB_user .'\';' : $line;
									$line = (strstr($line, '$typo_db_password =')) 	? '	$typo_db_password = \''. $newDB_pass .'\';' : $line;
									$line = (strstr($line, '$typo_db_host     =')) 	? '	$typo_db_host     = \''. $conf['database_dev_host'] .'\';' : $line;
									$line = (strstr($line, '$typo_db          =')) 	? '	$typo_db          = \''. $newDB_name .'\';' : $line;
									
									fwrite($typo3conf_dev_content_write, $line . "\n");
								
								}
								fclose($typo3conf_dev_content_write);
								unlink($conf['dir_test'] . $devDirName . $conf['dir_test_docs'] . 'typo3conf/localconf_dev.php.temp');
								debug("Edit of localconf_dev.php done");
								*/
								exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']."typo3conf -m \"Changes in localconf.php and localconf_dev.php\" 2>&1");
								debug("Changes in localconf.php and localconf_dev.php committed",1);
								
								exec("echo " . $hotel['name'] . ">" . $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . "HOTELNAME");
								exec("/usr/bin/svn add ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']."HOTELNAME 2>&1");
								exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']." -m \"Added HOTELNAME file\" 2>&1");
								
								debug("All file writing done - now removing all files from DEV test hotel");
								
								//Removing all files and folders from devtest dir
								exec("/bin/rm -rf ". $conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs']."/*"); 
												
								//Creating HOTELNAME file in devtest dir
								exec("echo " . $hotel['name'] . ">" . $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . "HOTELNAME");
								exec("chown -R ".$conf['dir_test_rights']." ". $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs']);
								
						
								debug("Creating hoteldir on production server (". $hotel['server'] .")");
								
								exec("ssh -l root ". $hotel['server'] .".wildside.dk mkdir /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ." 2>&1 ", $execMkdirOutput);
								exec("ssh -l root ". $hotel['server'] .".wildside.dk mkdir /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs 2>&1 ", $execMkdirOutput);
								exec("ssh -l root ". $hotel['server'] .".wildside.dk echo \"". $hotel['name'] ." > /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs/HOTELNAME\" 2>&1 ", $execEchoOutput);
								exec("ssh -l root ". $hotel['server'] .".wildside.dk chown -R ".$conf['dir_prod_rights']." /var/www/". $hotel['server'] ."/typo3/hoteller/". $hotel['name'] ."/htdocs 2>&1 ");
								
								debug("Creating database on production server (". $hotel['server'] .")");
								$productiondb = @mysql_connect($hotel['serverhost'], $conf['database_production_user'], $conf['database_production_pass']);
								
								$sql = 'CREATE DATABASE '. $newDB_name;
               					mysql_query($sql, $productiondb);      
				  				
				  				$sql = 'CREATE USER '. $newDB_user .'@localhost IDENTIFIED BY \''. $newDB_pass .'\'';	
								mysql_query($sql, $productiondb);      
							
								$sql = 'GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,ALTER,INDEX,DROP,CREATE TEMPORARY TABLES,CREATE VIEW,SHOW VIEW,CREATE ROUTINE,ALTER ROUTINE,EXECUTE,LOCK TABLES  ON '. $newDB_name .'.* TO '. $newDB_user .'@localhost IDENTIFIED BY \''. $newDB_pass .'\'';
								mysql_query($sql, $productiondb);   
								mysql_close($productiondb);   
								  
								debug("Creation of user and database done",1);
																
								
								
								
								$t3manager->setHotelStatus($hotel['uid'],"UPDATE-all");
								
								
																
                           	}	
							else {
								debug("User already exists on DEV",1,1);
								$t3manager->setHotelStatus($hotell['uid'],"ERROR - Check log");
							}
						}
						else {
							debug("Database already exists on DEV",1,1);
							$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
						}
						
						
						
					}
					else {
						debug("Could not connect to database on DEV",1,1);
						$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
					}
                 	                    
					
					
					

	
				}
				else{
					debug("cant find ". $conf['mysqldumpFileName'] ." in docs folder - Cannot make database then",1,1);
					$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
				}
				
				
			} else {
				$fejl = implode("\n", $output);
				debug($fejl,1,1);
				$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
			}
	    	
	    	//deleteEmail($hotel['emailId']);
    	} else {
    		$fejl = implode("\n", $execMkdirOutput);
    		debug($fejl,1,1);
			$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
    	}
    	
    	
    	
    }
    if (strstr($hotel['status'], "UPDATE")) {
    	
    	$update = (substr($hotel['status'],7,3) == "all") ? substr($hotel['status'],11) : substr($hotel['status'],7);
    	$all = (substr($hotel['status'],7,3) == "all") ? 1 : 0;
    	if ($all == 1 && !$update){
    		$update = "adminusers"; 
    		$t3manager->setHotelStatus($hotel['uid'],"UPDATE-all-vhost"); 
    		$debugmailsubject = $hotel['name'] . " - Status: " . "UPDATE-all-adminusers";
    	}
    	
    	switch ($update) {
    		case "adminusers":
				
				if ($all == 1) { $t3manager->setHotelStatus($hotel['uid'],"UPDATE-all-baseurlconf"); } 
				else { $t3manager->setHotelStatus($hotel['uid'],"Running");	}
    			break;
			
			case "baseurlconf":
			
				//Making a checkout to a tempdir of only baseurl config file.
				//Then writing a new baseurl file - and if its different from the file in svn do overwrite and commit
				@mkdir("/tmp/baseurlconf");
				exec("/usr/bin/svn checkout --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server'] . $conf['svn_hoteldir'] . $hotel['name'] . "/trunk/". $conf['svn_baseurlfile_dir']  . " ". "/tmp/baseurlconf/", $checkoutOutput);
		
				if (is_file("/tmp/baseurlconf/" . $conf['svn_baseurlfile'])) {
					debug("Making new baseurl conf file",1);
					
					//Adding production urls
					//Sitename with and without www will be added
					//Feture to make: make option to select if domain goes in baseurl when domains are created
					
					$baseurls[] = "www". "." .$hotel['name']; // This is the default url
					$baseurls[] = $hotel['name'];
					debug("Default url:". $baseurls[0],1);
					
					//Adding production alternativ url (Is used if no domains are pointing to the domain)
					$strip_hotelname = str_replace(".","",$hotel['name']);
    				$baseurls[] = $strip_hotelname . "." . $hotel['serverhost'];
					
					//Adding devtest url (Used to test development before releasing)
					$baseurls[] = $strip_hotelname . "." . "dev.wildside.dk";
					
					if ($hotel['developers']) {
						foreach ($hotel['developers'] as $developer) {
							$baseurls[] = $strip_hotelname . "." . $developer['username'] . ".dev.wildside.dk";
						}
					}
					
										
					//Making FILE
					$tempfile = fopen($filedir . "/tmp/baseurlconf/baseurlconf.tmp", 'w');
					
					foreach ($baseurls as $baseurl) {
						if (!$firstlinecheck) {
							fwrite($tempfile, "config.baseURL = http://". $baseurl . "/\n\n");	
						} else {
							debug("Condition added for ". $baseurl);
							fwrite($tempfile, "[globalString = ENV:HTTP_HOST=". $baseurl . "]\n");	
							fwrite($tempfile, "config.baseURL = http://". $baseurl . "/\n");	
							fwrite($tempfile, "[global]\n\n");
						}
																
						$firstlinecheck = 1;
					}	
					fclose($tempfile);
					debug("Conditions added",1);
					
					
					exec("/usr/bin/diff /tmp/baseurlconf/baseurlconf.tmp /tmp/baseurlconf/". $conf['svn_baseurlfile'],$diffOutput);
					
					if ($diffOutput) {
						debug("Diff from current baseurl conf detected - Committing new conf to svn",1);
						exec("/bin/cp /tmp/baseurlconf/baseurlconf.tmp /tmp/baseurlconf/". $conf['svn_baseurlfile']);
						exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" /tmp/baseurlconf/ -m \"Baseurlconf updated\"", $commitOutput);
					} else { debug("No diff from current baseurl - nothing done"); }
					
				} 
				else { debug("Baseurl configuration file dosen't exist",1); }
				
				exec("/bin/rm -rf /tmp/baseurlconf");
								
				
				if ($all == 1) { $t3manager->setHotelStatus($hotel['uid'],"UPDATE-all-devhotels"); } 
				else { $t3manager->setHotelStatus($hotel['uid'],"Running");	}
				break;
				
			case "devhotels":
				
				foreach ($hotel['developers'] as $developer) {
						
					if (!is_dir($conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'])) {
					debug("Creating developer hotel for ". $hotel['name'] ." to ". $developer['username'],1);
						
						if (!is_dir($conf['dir_dev'] . $developer['username'])) { 
							exec("mkdir " . $conf['dir_dev'] . $developer['username']); 
							exec("mkdir " . $conf['dir_dev'] . $developer['username'] . "/customconf"); 
						}
						exec("mkdir " . $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'] ." 2>&1", $output);
						debug("Hotel folder created");
						
						exec("mkdir " . $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'] ." 2>&1", $output);
						debug("docs folder created",1);
						
						debug("Making checkout");
						exec("/usr/bin/svn checkout --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['svn_server_file'] . $conf['svn_hoteldir'] . $hotel['name'] . "/trunk ". $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs']." 2>&1", $output);
						debug("Checkout done",1);
						
						exec('find '. $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'] .' -type f -print | while read line; do chmod 660 $line; echo $line; done');
						exec('find '. $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'] .' -type d -print | while read line; do chmod 770 $line; echo $line; done');
						exec("chown -R ".$conf['dir_dev_rights']." ". $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs']);
								
						
						debug("Making mysql database name");
						$newDB_name =  $conf['database_prefix'] . $developer['username'] . "_" . $hotel['server'] . "_";
						$newDB_name .= substr(strip_hotelname($hotel['name']),0,64-strlen($newDB_name));
						debug("Mysql database name: " . $newDB_name);
						
						@mysql_select_db($newDB_name);
						if (mysql_error()) {
							
							$sql = 'CREATE DATABASE '. $newDB_name;
               				mysql_query($sql);    
               				debug("Database diden't exist - now created");  
							
							$default_database = $t3manager->getMysqlInfo($conf, $hotel['uid'], 1);
							$default_database = $default_database[1];
							
							$sql = 'GRANT SELECT,INSERT,UPDATE,DELETE,CREATE,ALTER,INDEX,DROP,CREATE TEMPORARY TABLES,CREATE VIEW,SHOW VIEW,CREATE ROUTINE,ALTER ROUTINE,EXECUTE,LOCK TABLES  ON '. $newDB_name .'.* TO '. $default_database['user'] .'@localhost IDENTIFIED BY \''. $default_database['pass'] .'\'';
							mysql_query($sql);      
							debug("Rights on databse set (User: ". $default_database['user'] .")",1);
							  
							debug("Making database dump from test site");
							
							exec('/usr/bin/mysqldump -u'. $conf['database_dev_user'] .' -p'.  $conf['database_dev_pass'] .' '. $default_database['name'] .'>'. $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'] . $conf['mysqldumpFileName']);
							debug("Dump done - Now importing to new database");

							exec('/usr/bin/mysql -u'. $conf['database_dev_user'] .' -p'.  $conf['database_dev_pass'] .' '. $newDB_name .'<'. $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'] . $conf['mysqldumpFileName']);
							debug("Import done",1);
							
							exec("/bin/rm ". $conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'] . $conf['mysqldumpFileName']);
							
							$t3manager->linkDatabaseToHotel($conf,$hotel['uid'],$t3manager->insertDatabase($conf,$newDB_name,$default_database['user'],$default_database['pass'],0));

						
						} else { debug("Database already exists - nothing done",1); }
						
						
						
					}
				
				
				}
				
					
			    if ($all == 1) { $t3manager->setHotelStatus($hotel['uid'],"UPDATE-all-vhost"); } 
				else { $t3manager->setHotelStatus($hotel['uid'],"Running");	}
    		
			    break;
			    		
    		case "vhost":

	
				//Checking if documentroot exists before writing vhost files
				if (!is_dir($conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs'])) {
					debug("Test hotel - documentroot dosen't exist (" . $conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs'] . ")",1,1);
					$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
					break;
				}
				exec('ssh -l root '. $hotel['serverhost'] .' ls '. $conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs']. " 2>&1",$lsOutput);
				if (strstr($lsOutput[0], "No such file or directory") == "No such file or directory") {
					debug("Production hotel - documentroot dosen't exist (" . $conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs'] . ")",1,1);
					$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
					break;
				}
				
				
				
				// Write vhosts for main hotels
    			if (!$hotel['domains']) { 
					// if no domains are linked - "servername" will be set to hotelname.server.wildside.dk
					$strip_hotelname = str_replace(".","",$hotel['name']);
    				exec("/var/www/sitemgr.wildside.dk/typo3conf/ext/ni_hotelmanager/crontab/create_vhost.sh ". $hotel['server'] . " " . $hotel['name'] . " " . $strip_hotelname . "." . $hotel['serverhost'] . " " . $vHostAliases . " 2>&1");
					debug("New hosts file written and apache restarted (DEV & PRODUCTION)",1);
				
					debug("No domains linked",1);
    				
    			} else {
					$vHostAliases = implodeToCreateVhost($hotel['domains']);
					
	    			exec("/var/www/sitemgr.wildside.dk/typo3conf/ext/ni_hotelmanager/crontab/create_vhost.sh ". $hotel['server'] . " " . $hotel['name'] . " " . $hotel['name'] . " " . $vHostAliases . " 2>&1");
					debug("New hosts file written and apache restarted (DEV & PRODUCTION)",1);
					
	    			addDomainsToHostsfile($hotel['domains'], "127.0.0.1");
					debug("Now testing on DEV");
					$devdomaintest = testdomain($hotel['domains'], $hotel['name']);  
					debug("Testing on DEV done", 1);
									
									
					debug("Now testing on production (". $hotel['server'] .")");
					addDomainsToHostsfile($hotel['domains'], $hotel['serverip']);
													
					$productiondomaintest = testdomain($hotel['domains'], $hotel['name']);  
					debug("Testing on production done",1);
	
					if (($devdomaintest > 0) || ($productiondomaintest > 0)) { 
						debug($devdomaintest+$productiondomaintest . " domain tests faild...",1,1);
	    				$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
					    break;
					}
					cleanupHostsFile();
				}
				
				// Writing vhosts for developer hotels (One for each developer thats connected to the hotel)
				
				
				if ($hotel['developers']) {
					debug("Now writing developer vhosts");
					foreach ($hotel['developers'] as $developer) {
						if (!is_dir($conf['dir_dev'] . $developer['username'] . "/" . $hotel['name'].$conf['dir_dev_docs'])) {
							debug("Dev hotel - documentroot dosen't exist (" . $conf['dir_test'] ."".$hotel['name'].$conf['dir_test_docs'] . ")",1,1);
							$t3manager->setHotelStatus($hotel['uid'],"ERROR - Check log");
							break;
						}
						
						exec("/var/www/sitemgr.wildside.dk/typo3conf/ext/ni_hotelmanager/crontab/create_dev_vhost.sh ". $developer['username'] . " " . $hotel['name'] . " 2>&1");
						debug("vhost for ". $developer['username'] ." written");
						$strip_hotelname = str_replace(".","",$hotel['name']);
						$developerhosts[]['name'] = $strip_hotelname . "." . $developer['username'] . ".dev.wildside.dk";					
						
					}
					debug("Developer vhosts writing done",1);
					
					exec("/usr/sbin/apache2ctl graceful 2>&1");
					debug("Apache restarted",1);
					
					debug("Now testing developer hotels");
					addDomainsToHostsfile($developerhosts, "127.0.0.1");
														
					$developerhotelstest = testdomain($developerhosts, $hotel['name']);  
					debug("Testing of developer hotels done",1);
				} else {
					debug("No developers linked",1);
				}
				
				if ($all == 1) { $t3manager->setHotelStatus($hotel['uid'],"Running"); } 
				else { 
					$t3manager->setHotelStatus($hotel['uid'],"UPDATE-baseurlconf"); //Running update-baseurl after running UPDATE-vhost
				}
    		
    			break;
							
				
			default:
    			break;
    	}
    }
     if ($hotel['status'] == "CREATETAG") {
     
     	$database = $t3manager->getMysqlInfo($conf,$hotel['uid'],1);
		$database = $database[1];
		
		
		//If newtag version is 1.0.0 we are making a full export from current database on devtest hotel to tag
//Buuuut not working for now - the code below will make a dump from the right database but will commit it the wrong place - therefore disabled
/*
		if ($hotel['newtag'] == "1.0.0") {
			debug("Tag = 1.0.0 - Therefore making full mysqldump from current devtest database");
			exec('/usr/bin/mysqldump -u'. $conf['database_dev_user'] .' -p'.  $conf['database_dev_pass'] .' '. $database['name'] .'>'. $conf['dir_test'] . $hotel['name'] . $conf['dir_test_docs'] . $conf['mysqldumpFileName'] . " 2>&1");
			exec("/usr/bin/svn add ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs'].$conf['mysqldumpFileName'] . " 2>&1");
			exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']." -m \"Mysqldump before committing version 1.0.0\" 2>&1");				
			debug("Mysqldump done",1);
		}
		
*/
		//If newtag version is 0.1.0 we are making a full export from current database from developer how committed the tag to new beta tag
	
		if ($hotel['newtag'] == "0.1.0") {
			debug("Tag = 0.1.0 - Therefore making full mysqldump from current developer databse");
			
			//For now we are not using individual developer database - Therefore we'r just making a little hack here.
			
			$developer = "bka";
			 
			
			$typo_db_tmp = explode("_", $database['name']);
			//Fix this
			echo $developer_database = $typo_db_tmp[0] . "_" . "dev" . "_" . $typo_db_tmp[1] . "_" . $typo_db_tmp[2];

			exec('/usr/bin/mysqldump -u'. $conf['database_dev_user'] .' -p'.  $conf['database_dev_pass'] .' '. $developer_database .'>'. $conf['dir_dev'] . $developer . "/" . $hotel['name'].$conf['dir_dev_docs'] . $conf['mysqldumpFileName'] . " 2>&1");
			exec("/usr/bin/svn add ". $conf['dir_dev'] . $developer . "/" . $hotel['name'].$conf['dir_dev_docs'] . $conf['mysqldumpFileName'] . " 2>&1");
			exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_dev'] . $developer . "/" . $hotel['name'].$conf['dir_dev_docs']." -m \"Mysqldump before committing version 0.1.0\" 2>&1");				
			debug("Mysqldump done",1);
		}
		
		
		debug("Now creating tag");
		$comment = str_replace("\r", "", $comment);
		exec("/usr/bin/svn cp ". "file:///svn" . $conf['svn_hoteldir'] . $hotel['name'] . "/trunk " . "file:///svn" . $conf['svn_hoteldir'] . $hotel['name'] . "/tags/" . $hotel['newtag'] ." -m \"". $comment ."\" 2>&1 ", $execCpOutput);
		debug('Tag created',1);
		
		exec("/usr/bin/svn rm ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs'].$conf['mysqldumpFileName'] . " 2>&1");
		exec("/usr/bin/svn commit --username \"". $conf['svn_user'] ."\" --password \"". $conf['svn_pass'] ."\" ". $conf['dir_test'].$hotel['name'].$conf['dir_test_docs']." -m \"Removing mysqldump\" 2>&1");				

		$t3manager->setHotelStatus($hotel['uid'],"Running");									
    				
		
     }	
    	debug("### JOB DONE - ". $hotel['name'] . " - New status: " . $t3manager->curHotelStatus . " ###");
		sendDebugMail();

}
