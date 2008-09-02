<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * Class we_usersOnline
 *
 * This class handles the users online for the personalized desktop (Cockpit).
 */

class usersOnline
{
	var $num_uo = 0;
	var $users = '';

	function usersOnline(){
		global $DB_WE;
		$_row = '';
		$_u = '';
		$_color = array('red','blue','green','orange');
		$_i = $_k = 0;

		$_query = "SELECT ID,username,Ping  FROM " . USER_TABLE . " WHERE Ping>" . (time() - PING_TIME - PING_TOLERANZ) . " ORDER BY Ping DESC";
		$DB_WE->query($_query);

		while($DB_WE->next_record()){
			$this->num_uo++;
			$_fontWeight = ($_SESSION["user"]["ID"] == $DB_WE->f("ID"))? 'bold' : 'bold';
			if ($_k != 0) $_row .= '<tr><td height="8">'.getpixel(1,8).'</td></tr>';
			$_row .= '<tr><td width="30"><img src="'.IMAGE_DIR.'pd/usr/user_'.$_color[$_i].'.gif" width="24" height="29"></td>';
			$_row .= '<td valign="middle" class="middlefont" style="font-weight:'.$_fontWeight.';">'.$DB_WE->f("username").'</td>';
			if(defined("MESSAGES_TABLE")) {
				$_row .= '<td valign="middle" width="24"><a href="javascript:newMessage(\''.$DB_WE->f("username").'\');">';
				$_row .= '<img src="'.IMAGE_DIR.'pd/usr/user_mail.gif" border="0" width="24" height="20" alt=""></a><td>';
			}
			$_row .= '</tr>';
			if ($_i < count($_color)-1) {
				$_i++;
			}
			else {
				$_i = 0;
			}
			$_k++;
		}

		$_u .= '<div style="height:187px;overflow:auto;">';
		$_u .= '<table width="100%" cellpadding="0" cellspacing="0" border="0">'.$_row.'</table>';
		$_u .= '</div>';

		$this->users = $_u;
	}

	function getNumUsers(){
		return $this->num_uo;
	}

	function getUsers(){
		return $this->users;
	}
}
?>