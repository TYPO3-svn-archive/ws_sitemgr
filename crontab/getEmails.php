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
include('pop3.class.inc');

function getEmails() {
	$pop3 = new POP3;
	$pop3->server = "pop3.pil.dk";
	$pop3->user = "t3_create.netimage.dk";
	$pop3->passwd = "poli10ker";
	$pop3->debug = FALSE; // So you can see the commands and server answers

	if($pop3->pop3_connect()) {
		$pop3->pop3_login();
		$pop3->pop3_stat();
		$i = 1;
		while($pop3->pop3_retr($i))  {
			while($real_line = $pop3->nextAnswer()) {
				if ($line = strstr($real_line, "Subject:")) {
					$line = explode(" ", $line);
					$hotel[$i]['name'] = $line[1];
					$hotel[$i]['status'] = trim($line[4]);
				}
				if ($line = strstr($real_line, "From:")) {
					$line = explode(" ", $line);
					$line = explode("@", $line[1]);
					$hotel[$i]['serverhost'] = $line[1];
					$line = explode(".",$line[1]);
					$hotel[$i]['server'] = $line[0];
				}
				if ($line = strstr($real_line, "Message-Id:")) {
					$line = explode(" ", $line);
					$line = explode("@", $line[1]);
					$line = $line[0];
					$line = str_replace("<", "", $line);
					$hotel[$i]['emailId'] = $line;
				}
		
			}
			if (strstr($hotel[$i]['serverhost'], "pil.dk") != "pil.dk") { 
				// Email is not from a PIL.dk server
				$pop3->pop3_dele($i); //Deleting mail
				unset($hotel[$i]); //Deleting row
			}
			$i++;
		}
		//var_dump($hotel);
		$pop3->pop3_disconnect();
	}
	
	if (isset($hotel)) return $hotel;
	
}

function deleteEmail($emailId) {
	$pop3 = new POP3;
	$pop3->server = "pop3.pil.dk";
	$pop3->user = "t3_create.netimage.dk";
	$pop3->passwd = "poli10ker";
	$pop3->debug = FALSE; // So you can see the commands and server answers

	if($pop3->pop3_connect()) {
		$pop3->pop3_login();
		$pop3->pop3_stat();
		$i = 1;
		while($pop3->pop3_retr($i))  {
			
			while($real_line = $pop3->nextAnswer()) {

				if ($line = strstr($real_line, "Message-Id:")) {
					$line = explode(" ", $line);
					$line = explode("@", $line[1]);
					$line = $line[0];
					$line = str_replace("<", "", $line);

					if ($line == $emailId) {
						$pop3->pop3_dele($i);
						break;
					}

				}
		
			}
			$i++;
			
		}
		//echo "test";
		$pop3->pop3_disconnect();
	}
}