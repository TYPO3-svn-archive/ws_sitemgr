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
$link = mysql_connect('localhost', 'root', 'poli10ker');
mysql_select_db('typo3hotelmanager') or die('Database');

$sql = 'SELECT * FROM `users` LIMIT 0, 30 ';
$res = mysql_query($sql);
while ($data = mysql_fetch_row($res)) {
	$user[] = implode(",",$data);
}
$users = implode(";",$user);

echo $users;
