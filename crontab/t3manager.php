<?
include_once("db.php");
class t3manager {
	
	function getHotels ($conf) {
		global $link;
		
		if ($this->hotelName) { $singleHotel = " AND `name` = '". $this->hotelName . "'"; } else { $singleHotel = ""; }
		$sql = "SELECT * FROM `tx_nihotelmanager_hotels` WHERE `deleted` = '0' AND `pid` = ". $conf['t3_hotel_sysfolder'] . $singleHotel;
		$res = mysql_query($sql,$link);
		$i = 1;
		while ($data = mysql_fetch_array($res)) {
			
			//Server information
			$return[$i] = $this->getServer($data['server']);
			
			//General information
			$return[$i]['uid'] = $data['uid'];
			$return[$i]['name'] = $data['name'];
			$return[$i]['status'] = $data['status'];
			$return[$i]['svnproductiontag'] = $data['svnproductiontag'];
			$return[$i]['svndevtesttag'] = $data['svndevtesttag'];
			$return[$i]['newtag'] = $data['newtag'];
			$return[$i]['newtagcomment'] = $data['newtagcomment'];
			//Domain information
			$return[$i]['domains'] = $this->getDomains($data['uid']);
			
			//Developers
			$return[$i]['developers'] = $this->getDevelopers($data['uid']);
			
			$i++;
		}
		return $return;
	
	}
	function getServer ($server_uid) {
		global $link;
		
		$sql = "SELECT * FROM `tx_nihotelmanager_servers` WHERE `uid` = '". $server_uid ."'";
		$res = mysql_query($sql,$link);
		$data = mysql_fetch_array($res);
		
		$return['server'] = $data['name'];
		$return['serverhost'] = $data['host'];
		$return['serverip'] = $data['ip'];
		
		return $return;
	}
	function getDomains ($hotel_uid) {
		global $link;
		
		$sql = "SELECT * FROM `tx_nihotelmanager_hotels_domains_mm` WHERE `uid_local` = '". $hotel_uid ."'";
		$res = mysql_query($sql,$link);
		$i = 1;
		while ($data = mysql_fetch_array($res)) {
			
			$sql2 = "SELECT * FROM `tx_nihotelmanager_domains` WHERE `uid` = '". $data['uid_foreign'] ."'";
			$res2 = mysql_query($sql2,$link);
			$data2 = mysql_fetch_array($res2);
			
			$return[$i]['name'] = $data2['name'];
			
			//Getting aliases
			$sql3 = "SELECT * FROM `tx_nihotelmanager_domains_aliases_mm` WHERE `uid_local` = '". $data2['uid'] ."'";
			$res3 = mysql_query($sql3,$link);
			$ii = 1;
			while ($data3 = mysql_fetch_array($res3)) {
				
				$sql4 = "SELECT * FROM `tx_nihotelmanager_domainsaliases` WHERE `uid` = '". $data3['uid_foreign'] ."'";
				$res4 = mysql_query($sql4,$link);
				$data4 = mysql_fetch_array($res4);
				
				$return[$i]['aliases'][$ii]['name'] = $data4['name'];
				
				
				
				$ii++;
			}	
			$return[$i]['hasAliases'] = $ii-1;
			
			
			$i++;
		}
		return $return;
	}
	function getDevelopers ($hotel_uid) {
		global $link;
		
		$sql = "SELECT * FROM `tx_nihotelmanager_hotels_developers_mm` WHERE `uid_local` = '". $hotel_uid ."'";
		$res = mysql_query($sql,$link);
		$i = 1;
		while ($data = mysql_fetch_array($res)) {
			 
			$sql2 = "SELECT * FROM `fe_users` WHERE `deleted` = '0' AND `disable` = '0' AND `uid` = '". $data['uid_foreign'] ."'";
			$res2 = mysql_query($sql2,$link);
			$data2 = mysql_fetch_array($res2);
			
			$return[$i]['username'] = $data2['username'];
			
			
			
			$i++;
		}
		return $return;
	}
	
	function setHotelStatus ($uid, $status) {
		global $link;
		$this->curHotelStatus = $status;
		$sql = "UPDATE `sitemgr`.`tx_nihotelmanager_hotels` SET `status` = '". $status ."' WHERE `uid` = '". $uid ."'";
		mysql_query($sql,$link) or die(mysql_error());
	}
	
	function insertDatabase ($conf,$db,$user,$pass,$default=1) {
		global $link;
		$sql = 'INSERT INTO `sitemgr`.`tx_nihotelmanager_databases` (`uid`, `pid`, `tstamp`, `crdate`, `cruser_id`, `deleted`, `dbname`, `dbuser`, `dbpass`, `isdefault`, `isempty`) VALUES (\'\', \''. $conf['t3_hotel_sysfolder'] .'\', \''. time() .'\', \''. time() .'\', \''. $conf['t3_hotel_cruser'] .'\', \'0\', \''. $db .'\', \''. $user .'\', \''. $pass .'\', \''. $default .'\', \'0\');';
		mysql_query($sql,$link) or die(mysql_error());
		return mysql_insert_id();
	}
	function linkDatabaseToHotel ($conf, $hotel_uid, $database_uid) {
		global $link;
		
		$sql = 'INSERT INTO `sitemgr`.`tx_nihotelmanager_hotels_hoteldatabases_mm` (`uid_local`, `uid_foreign`, `tablenames`, `sorting`) VALUES (\''. $hotel_uid .'\', \''. $database_uid .'\', \'\', \'\');';
		mysql_query($sql,$link) or die(mysql_error());
	}
	
	function ChangeDeletedFlagToStatusDelete ($conf) {
		global $link;
		$sql = 'SELECT * FROM `tx_nihotelmanager_hotels` WHERE `pid` = '. $conf['t3_hotel_sysfolder'] .' AND `deleted` = 1 AND `status` != \'DELETION FAILD\'';
		$res = mysql_query($sql,$link);
		while ($data = mysql_fetch_array($res)) {
			$updateSQL = "UPDATE `tx_nihotelmanager_hotels` SET `status` = 'DELETE', `deleted` = 0 WHERE `uid` = '". $data['uid'] ."'";
			mysql_query($updateSQL,$link) or die(mysql_error());		
		}
	}
	function changeHotelName ($conf, $hotel_uid, $hotel_newName) {
		global $link;
		$sql = "UPDATE `tx_nihotelmanager_hotels` SET `name` = '". $hotel_newName ."' WHERE `uid` = '". $hotel_uid ."'";
		mysql_query($sql,$link) or die(mysql_error());
	}
	function changeHotelPID ($conf, $hotel_uid, $hotel_newPid) {
		global $link;
		$sql = "UPDATE `tx_nihotelmanager_hotels` SET `pid` = '". $hotel_newPid ."' WHERE `uid` = '". $hotel_uid ."'";
		mysql_query($sql,$link) or die(mysql_error());
	}
	function changeHotelSvnproductiontag ($conf, $hotel_uid, $tag) {
		global $link;
		$sql = "UPDATE `tx_nihotelmanager_hotels` SET `svnproductiontag` = '". $tag ."' WHERE `uid` = '". $hotel_uid ."'";
		mysql_query($sql,$link) or die(mysql_error());
	}
	function changeHotelSvndevtesttag ($conf, $hotel_uid, $tag) {
		global $link;
		$sql = "UPDATE `tx_nihotelmanager_hotels` SET `svndevtesttag` = '". $tag ."' WHERE `uid` = '". $hotel_uid ."'";
		mysql_query($sql,$link) or die(mysql_error());
	}
	function getMysqlInfo ($conf, $hotel_uid, $onlyDefault=0) {
		global $link;
		$sql = 'SELECT uid_foreign FROM `sitemgr`.`tx_nihotelmanager_hotels_hoteldatabases_mm` WHERE `uid_local` = '. $hotel_uid;
		$res = mysql_query($sql,$link) or die(mysql_error());
		$i = 1;
		while ($data = mysql_fetch_array($res)) {
			
			$sqlOnlyDefault = ($onlyDefault == 1) ? " AND `isdefault` = '1'" : "";
			$databases_sql = 'SELECT uid,dbname,dbuser,dbpass FROM `sitemgr`.`tx_nihotelmanager_databases` WHERE `uid` = '. $data['uid_foreign'] . $sqlOnlyDefault;
			$databases_res = mysql_query($databases_sql,$link)or die(mysql_error());
			$databases_data = mysql_fetch_array($databases_res);
			if ($databases_data['uid']) {
				$return[$i]['uid']	= $databases_data['uid'];
				$return[$i]['name']	= $databases_data['dbname'];
				$return[$i]['user']	= $databases_data['dbuser'];
				$return[$i]['pass']	= $databases_data['dbpass'];	
				$i++;
			}
				
			
		}
		return @$return;
	}
	function deleteDatabase($conf,$database_uid) {
		global $link;
		$sql = 'DELETE FROM `tx_nihotelmanager_databases` WHERE `uid` = '. $database_uid;
		mysql_query($sql,$link);
		
		$sql = 'DELETE FROM `tx_nihotelmanager_hotels_hoteldatabases_mm` WHERE `uid_foreign` = '. $database_uid;
		mysql_query($sql,$link);		
	}
	function updateBaseurlConfig ($hotel) {
		foreach ($hotel['domains'] as $domain) {
			
				
		}
	}
	function CheckForDomainUpdates () {
		
		global $link;
		$sql = "SELECT * FROM `tx_nihotelmanager_domains` WHERE `tstamp` >=  '". $this->lastupdatetime ."' AND `tstamp` <= '". $this->nowtime ."'";
		$res = mysql_query($sql,$link);
		if (mysql_num_rows($res) > 0) {
			while ($data = mysql_fetch_array($res)) {
				$this->setHotelStatus($this->getHotelByDomain($data['uid']), "UPDATE-vhost");
			}
		}
		$sql = "SELECT * FROM `tx_nihotelmanager_domainsaliases` WHERE `tstamp` >=  '". $this->lastupdatetime ."' AND `tstamp` <= '". $this->nowtime ."'";
		$res = mysql_query($sql,$link);
		if (mysql_num_rows($res) > 0) {
			while ($data = mysql_fetch_array($res)) {
				$this->setHotelStatus($this->getHotelByDomain($this->getDomainByAlias($data['uid'])), "UPDATE-vhost");
			}
		}
	}
	function CheckForHotelUpdates () {
				
		global $link;
		$sql = "SELECT * FROM `tx_nihotelmanager_hotels` WHERE `tstamp` >=  '". $this->lastupdatetime ."' AND `tstamp` <= '". $this->nowtime ."' AND `status` = 'Running'";
		$res = mysql_query($sql,$link);
		if (mysql_num_rows($res) > 0) {
			while ($data = mysql_fetch_array($res)) {
				$this->setHotelStatus($data['uid'], "UPDATE-all");
			}
		}
	}
	function getHotelByDomain ($domainUid){
		global $link;
		$sql = "SELECT * FROM `tx_nihotelmanager_hotels_domains_mm` WHERE `uid_foreign` =  '".$domainUid."'";
		$res = mysql_query($sql,$link);
		$data = mysql_fetch_array($res);
		return $data['uid_local'];		
	}
	function getDomainByAlias ($aliasUid){
		global $link;
		$sql = "SELECT * FROM `tx_nihotelmanager_domains_aliases_mm` WHERE `uid_foreign` =  '".$aliasUid."'";
		$res = mysql_query($sql,$link);
		$data = mysql_fetch_array($res);
		return $data['uid_local'];		
	}
	function updateLastCheckData () {
		// Henter tidspunkt for sidste updatecheck
		
			$filename = "LASTUPDATECHECK";
			$nowdate = time();
			$handle = fopen($filename, "r");
			$content = fread($handle, filesize($filename));
			fclose($handle);
			unlink($filename);
			
			$content_write = fopen($filename, 'w');
			fwrite($content_write, $nowdate);
			fclose($content_write);
			
			$this->lastupdatetime = $content;
			$this->nowtime = $nowdate;
			
		
		// Alle tabel updaterings s�gninger sker ved en "tstamp>LastUpdate['last'] && tstamp<LastUpdate['now']
	}
	//$conf, $hotel['uid'], t3lib_div::_POST("tagname"), t3lib_div::_POST("comment")
	function createNewTag ($conf, $hotel_uid, $newTag, $newTagComment) {
		global $link;
		$sql = "UPDATE `tx_nihotelmanager_hotels` SET `newtag` = '". $newTag ."', `newtagcomment` = '". $newTagComment ."' WHERE `uid` = '". $hotel_uid ."'";
		mysql_query($sql,$link) or die(mysql_error());
		$this->setHotelStatus($hotel_uid,"CREATETAG");									
    			

	}
	function removeNewTagData ($conf, $hotel_uid) {
		global $link;
		$sql = "UPDATE `tx_nihotelmanager_hotels` SET `newtag` = '". "0" ."', `newtagcomment` = '". "" ."' WHERE `uid` = '". $hotel_uid ."'";
		mysql_query($sql,$link) or die(mysql_error());								
	}
}
