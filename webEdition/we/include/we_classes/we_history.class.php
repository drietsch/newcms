<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * Class we_history
 *
 * Provides functions determined to handle a list of last modified files required by
 * the 'personalized desktop'.
 */

class we_history
{

	function userHasPerms($creatorid,$owners,$restricted){
		if(!defined('BIG_USER_MODULE') || !in_array('busers',$GLOBALS['_pro_modules'])){
			return true;
		}
		if($_SESSION['perms']['ADMINISTRATOR']){
			return true;
		}
		if(!$restricted){
			return true;
		}
		if(we_isOwner($owners) || we_isOwner($creatorid)) {
			return true;
		}
		return false;
	}


	function insertIntoHistory(&$object){
		//print $object->Table;
		$_username = isset($_SESSION['user']['Username']) ? $_SESSION['user']['Username'] : '';
		$_query = "SELECT * FROM " . HISTORY_TABLE . " WHERE " . HISTORY_TABLE . ".DID='".$object->ID.
							"' AND " . HISTORY_TABLE . ".DocumentTable='".str_replace(TBL_PREFIX,'',$object->Table)."';";
		$object->DB_WE->query($_query);
		$_db = new DB_WE();
		while($object->DB_WE->next_record()){
			$_row = "DELETE FROM " . HISTORY_TABLE . " WHERE " . HISTORY_TABLE . ".ID = '" . $object->DB_WE->f("ID") . "';";
			$_db->query($_row);
		} 

		$_query = 'INSERT INTO ' . HISTORY_TABLE . ' (DID,DocumentTable,ContentType,ModDate,Act,UserName) VALUES("'.$object->ID.'","'.str_replace(TBL_PREFIX,'',$object->Table).'","'.$object->ContentType.'","'.$object->ModDate.'","save","'.$_username.'");';
		$object->DB_WE->query($_query);

	}
	
	/**
	 * Deletes a model from navigation History
	 *
	 * @param array $modelIds
	 * @param string $table
	 */
	function deleteFromHistory( $modelIds, $table ) {
		
		$_db = new DB_WE();
		
		$query = "
			DELETE FROM " . HISTORY_TABLE . "
			WHERE DID in (" . implode(", ", $modelIds) . ")
			AND DocumentTable = \"" . substr($table, strlen(TBL_PREFIX)) . "\"
		";
		$_db->query( $query );
		
	}

} 
		
?>