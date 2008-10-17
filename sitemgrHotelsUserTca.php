<?php 

class user_sitemgr_hotels {
	function user_TCAform_name($PA, $fobj)    {
		GLOBAL $BE_USER;
		
		if (strstr($PA['itemFormElValue'], ":")) { return "Hotel is corrently being moved"; } 
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
        '*',         // SELECT ...
	    'tx_wssitemgr_servers',     // FROM ...
        'deleted=0',    // WHERE...
        '',            // GROUP BY...
        'name',    // ORDER BY...
        ''            // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
         );	
        
        
		while($row = mysql_fetch_assoc($res)) {
			$pageinfo = t3lib_BEfunc::readPageAccess($row['pid'],$BE_USER->getPagePermsClause(1));
		
			if ($BE_USER->doesUserHaveAccess($pageinfo,1) && $BE_USER->isInWebMount($row['pid'])) {
				//$servers[] = array("uid" => $row['uid'], "name" => $row['name']);
				//$PA['itemFormElValue'] . ':' .
				$selected = ($row['uid'] == $PA['itemFormElValue']) ? "selected" : '';
				$haveAssessToCurrentServer = ($selected) ? 1 : $haveAssessToCurrentServer;
				$servers .= "<option value=\"" . $PA['itemFormElValue'] . ':' . $row['uid'] . "\" ".$selected.">" . $row['name'] . "</option>";
				
			}
	    	
		}
		if ($haveAssessToCurrentServer != 1 && $PA['itemFormElValue']) return "No access";
		return '
		<div>
		<select name="'.$PA['itemFormElName'].'">
		   '.$servers.'
		</select>
		</div>';
		
	}
	function user_TCAform_server($PA, $fobj)    {
		GLOBAL $BE_USER;
		
		if (strstr($PA['itemFormElValue'], ":")) { return "Hotel is corrently being moved"; } 
		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
        '*',         // SELECT ...
	    'tx_wssitemgr_servers',     // FROM ...
        'deleted=0',    // WHERE...
        '',            // GROUP BY...
        'name',    // ORDER BY...
        ''            // LIMIT to 10 rows, starting with number 5 (MySQL compat.)
         );	
        
        
		while($row = mysql_fetch_assoc($res)) {
			$pageinfo = t3lib_BEfunc::readPageAccess($row['pid'],$BE_USER->getPagePermsClause(1));
		
			if ($BE_USER->doesUserHaveAccess($pageinfo,1) && $BE_USER->isInWebMount($row['pid'])) {
				//$servers[] = array("uid" => $row['uid'], "name" => $row['name']);
				//$PA['itemFormElValue'] . ':' .
				$selected = ($row['uid'] == $PA['itemFormElValue']) ? "selected" : '';
				$haveAssessToCurrentServer = ($selected) ? 1 : $haveAssessToCurrentServer;
				$servers .= "<option value=\"" . $PA['itemFormElValue'] . ':' . $row['uid'] . "\" ".$selected.">" . $row['name'] . "</option>";
				
			}
	    	
		}
		if ($haveAssessToCurrentServer != 1 && $PA['itemFormElValue']) return "No access";
		return '
		<div>
		<select name="'.$PA['itemFormElName'].'">
		   '.$servers.'
		</select>
		</div>';
		
	}
}
?>