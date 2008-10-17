#!/usr/bin/php
<?php
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
@$svn_hotel = $argv[1];
@$developer = $argv[2];

if (!$svn_hotel || !$developer) { echo "\nUsage: makeDeveloperHotel <Hotel> <Developer>\nex: makeDeveloperHotel www.testhotel.dk bka\n\n"; die(); } 

$developer .= "/";

$conf['svn_hoteldir'] = "/svn/typo3/hoteller/";

$conf['dir_developers'] = "/dana/data/developers/"; // Path to TEST hotel - in most cases used for test of everything together before put to production
$conf['dir_developers_docs'] = "/docs/";
$conf['dir_developers_rights'] = "apache:internal";

$conf['downloadFolders'][] = "fileadmin/_temp_/";
$conf['downloadFolders'][] = "fileadmin/user_upload/";
$conf['downloadFolders'][] = "typo3temp/";
$conf['downloadFolders'][] = "uploads/";

$DEBUG = 1;

debug("Creating/updating developer dir for " . $svn_hotel . " to developer " . $developer,1);

exec("/usr/bin/svn ls file:///". $conf['svn_hoteldir'] . $svn_hotel . " 2>&1 ", $execLsOutput);
//var_dump($execLsOutput);

if (@strstr($execLsOutput[0], "non-existent in that revision") == FALSE) {
	
	$strip_hotelname = strip_hotelname($svn_hotel);
	
	exec("sudo mkdir " . $conf['dir_developers'] . $developer . $strip_hotelname . " 2>&1", $mkdir_status);
	
	if (strstr($mkdir_status[0], "mkdir: cannot create directory") == FALSE) {
		debug("Making developer dir");	
		exec("sudo mkdir " . $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] . " 2>&1");
		exec("sudo chown -R ".$conf['dir_developers_rights']." ". $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] . " 2>&1");
		exec('sudo find '. $conf['dir_developers'] . $developer . $strip_hotelname  .' -type f -print | while read line; do sudo chmod 660 $line; echo $line; done'. " 2>&1");
		exec('sudo find '. $conf['dir_developers'] . $developer . $strip_hotelname  .' -type d -print | while read line; do sudo chmod 770 $line; echo $line; done');
	
		debug("Making checkout of last revision");
		exec("/usr/bin/svn checkout file:///". $conf['svn_hoteldir'] . $svn_hotel ."/trunk ". $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] ." 2>&1", $TEST);
		var_dump($TEST);
		exec("sudo chown -R ".$conf['dir_developers_rights']." ". $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs']);
		debug("svn checkout done",1);
	} 
/*	else {
		debug("Updating developer dir");
		exec("/usr/bin/svn up " . $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] . " 2>&1", $test);
		var_dump($test);
		debug("svn update done");
	}
*/
	debug("Setting file rights 660 on files and 770 on dirs - my take some minuts",1);
	exec('sudo find '. $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] .' -type f -print | while read line; do sudo chmod 660 $line; echo $line; done'. " 2>&1");
	exec('sudo find '. $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] .' -type d -print | while read line; do sudo chmod 770 $line; echo $line; done');
	debug("Now downloading data from \"live\" site");
	exec("rsync -azvO --exclude-from '". $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs']."rsync_exclude' netimage@nekat.pil.dk:/dana/data/". $svn_hotel ."/docs/ ". $conf['dir_developers'] . $developer . $strip_hotelname . $conf['dir_developers_docs'] . " 2>&1", $TEST);
var_dump($TEST);
	debug("Download done");
	
	
	
}
else {
	debug($svn_hotel . " dosent exist in SVN - no action will be taken",1,1);
}




function debug($debug_text, $a = 0, $error=0){
	global $DEBUG;
	
	$debug_text .= (($a != 3) && ($a != 2)) ? "\n" : "";
	$debug_text .= ($a == 1) ? "\n" : "";
	$debug_text = (($a != 2) && ($a != 4) && ($error == 0)) ? "[" . date("m/d y H:i:s") . "] " . $debug_text : $debug_text;
	$debug_text = ($error == 1) ? "[" . date("m/d y H:i:s") . "][ERROR] " . $debug_text : $debug_text;
	
	
	if ($DEBUG == 1 || $error == 1) {
		echo $debug_text;
	}	
}
function strip_hotelname($hotel) {
	$stripedHotelname = $hotel;
	$stripedHotelname = (substr($stripedHotelname,0,4) == "www.") ? substr($stripedHotelname,4) : $stripedHotelname; // Removing www. if its there
	$stripedHotelname = (substr($stripedHotelname,strlen($stripedHotelname)-3,3) == ".dk") ? substr($stripedHotelname,0,strlen($stripedHotelname)-3) : $stripedHotelname; // Removing .dk if its there
	$stripedHotelname = (substr($stripedHotelname,strlen($stripedHotelname)-4,4) == ".com") ? substr($stripedHotelname,0,strlen($stripedHotelname)-4) : $stripedHotelname; // Removing .com if its there
	$stripedHotelname = str_replace(".","_",$stripedHotelname); // Replacing "." with "_"
	return $stripedHotelname;
}