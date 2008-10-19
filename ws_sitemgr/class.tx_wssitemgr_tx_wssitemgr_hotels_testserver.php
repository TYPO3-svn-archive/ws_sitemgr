<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2008 Bo Korshøj Andersen <bo@wildside.dk>
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
 * Class/Function which manipulates the item-array for table/field tx_wssitemgr_hotels_testserver.
 *
 * @author	Bo Korshøj Andersen <bo@wildside.dk>
 * @package	TYPO3
 * @subpackage	tx_wssitemgr
 */
class tx_wssitemgr_tx_wssitemgr_hotels_testserver {
	function main(&$params,&$pObj)	{
		GLOBAL $BE_USER;

		$type = 2;
							
		$params['items'][0] = array("Select a server", $row['uid']);
				
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
        '*',         // SELECT ...
	    'tx_wssitemgr_servers',     // FROM ...
        '`pid` = '. $params['row']['pid'] . " AND `type` like '%". $type ."%'",    // WHERE...
        '',            // GROUP BY...
        'name',    // ORDER BY...
        ''            // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
         );	
        
        while($row = mysql_fetch_assoc($res)) {
			$pageinfo = t3lib_BEfunc::readPageAccess($row['pid'],$BE_USER->getPagePermsClause(1));

			if ($BE_USER->doesUserHaveAccess($pageinfo,1) && $BE_USER->isInWebMount($row['pid'])) {
			
				$params['items'][] = array($row['name'], $row['uid']);
				$i++;
			}
	    	
		}
		$params['items'][0] = ($i > 0)  ? array("Select a server", 0) : array("No servers available", 0);
		
		
	}
}
	



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ws_sitemgr/class.tx_wssitemgr_tx_wssitemgr_hotels_testserver.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ws_sitemgr/class.tx_wssitemgr_tx_wssitemgr_hotels_testserver.php']);
}

?>