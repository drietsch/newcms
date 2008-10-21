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
* include connection with webEdition
*/
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");



/**
* name of table in database where will be stored all temporary documents
*
*  sturcture of the table :
* 
* CREATE TABLE TEMPRARY_DOC_TABLE (
*   ID bigint(20) NOT NULL auto_increment,
*   DocumentID bigint(20) NOT NULL default '0',
*   DocumentObject longtext NOT NULL,
*   Table varchar(64) NOT NULL,
*   UnixTimestamp bigint(20) NOT NULL default '0',
*   Active tinyint(1) NOT NULL default '0',
*   PRIMARY KEY  (ID)
* ) TYPE=MyISAM;
*
*/



/**
* Temporary document
* 
* all functions on this class is static, and please use it in static form :
*    we_temporaryDocument::function_name();
*
*
* @static
* @package WebEdition.Classes
* @version 1.1
* @date 06.07.2002
*/
class we_temporaryDocument
{
	/**
	* Default constructor. WARNING !!! (not usefull).
	*
	* All functions in this class is static, and there is no logic to create instance of this class
	*/
	function we_temporaryDocument()
	{
		die("Please don't create instance of class we_temporaryDocument"); 
	}


	/**
	* Save document in temporary table
	*   
	* @static
	* @access public
	* 
	* @param int documentID ID for document which will be stored in database
	* @param object mixed document object
	*/
	function save($documentID, $table="", $document="", $db="")
	{
	    if ($table == "") {
	        $table = FILE_TABLE;
	    }

		$db = $db ? $db : new DB_WE();

		$docSer = addslashes(serialize($document));
		$db->query("DELETE FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='".abs($documentID)."' AND ACTIVE=0 AND  DocTable='".mysql_real_escape_string($table)."'");
		$db->query("UPDATE " . TEMPORARY_DOC_TABLE . " SET Active=0 WHERE DocumentID='".abs($documentID)."' AND ACTIVE=1 AND  DocTable='".mysql_real_escape_string($table)."'");
		return $db->query("INSERT INTO " . TEMPORARY_DOC_TABLE . " (DocumentID,DocumentObject,Active,UnixTimestamp,DocTable) VALUES('".abs($documentID)."','".$docSer."',1,".time().",'".mysql_real_escape_string($table)."')");
	}


	function resave($documentID, $table="", $document="", $db="")
	{
	    if ($table == "") {
	        $table = FILE_TABLE;
	    }

		$db = $db ? $db : new DB_WE();
		$docSer = addslashes(serialize($document));
		return $db->query("UPDATE " . TEMPORARY_DOC_TABLE . " SET DocumentObject='".$docSer."',UnixTimestamp=".time()." WHERE DocumentID='".abs($documentID)."' AND ACTIVE=1 AND  DocTable='".mysql_real_escape_string($table)."'");
	}


	/**
	* Load document from temporary table
	*   
	* @static
	* @access public
	* 
	* @param int documentID Document ID
	* @return object mixed document object. if return value is flase, document doesn't exists in temporary table
	*/
	function load($documentID, $table="", $db="")
	{
	    if ($table == "") {
	        $table = FILE_TABLE;
	    }

		$db = $db ? $db : new DB_WE();
				
		$db->query("SELECT DocumentObject FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='".abs($documentID)."' AND Active=1 AND  DocTable='".mysql_real_escape_string($table)."'");

		if ($db->next_record())
		{
			return unserialize($db->f("DocumentObject"));
		}
		return false;
	}
	

	/**
	* Delete document from temporary table
	*   
	* @static
	* @access public
	* 
	* @param int documentID Document ID
	*/
	function delete($documentID, $table="", $db="")
	{
	    if ($table == "") {
	        $table = FILE_TABLE;
	    }

		$db = $db ? $db : new DB_WE();
		return $db->query("DELETE FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='".abs($documentID)."' AND  DocTable='".mysql_real_escape_string($table)."'");
	}
	
	/**
	* Revert document from temporary table
	*   
	* @static
	* @access public
	* 
	* @param int documentID Document ID
	*/
	function revert($documentID, $table="", $db="")
	{
	    if ($table == "") {
	        $table = FILE_TABLE;
	    }

		$db = $db ? $db : new DB_WE();
				
		$db->query("SELECT DocumentObject FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='".abs($documentID)."' AND  DocTable='".mysql_real_escape_string($table)."' AND Active=0");

		if ($db->next_record())
		{
			$foo = unserialize($db->f("DocumentObject"));
			$db->query("DELETE FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='".abs($documentID)."' AND Active=1 AND  DocTable='".mysql_real_escape_string($table)."'");
			$db->query("UPDATE " . TEMPORARY_DOC_TABLE . " SET Active=1 WHERE DocumentID='".abs($documentID)."' AND ACTIVE=0 AND  DocTable='".mysql_real_escape_string($table)."'");
			return $foo;
		}
		return false;
	}
	
	function isInTempDB($id, $table="", $db=""){
	    if ($table == "") {
	        $table = FILE_TABLE;
	    }

		if (isset($id)) {
			$db = $db ? $db : new DB_WE();
			$db->query("SELECT DocumentID FROM " . TEMPORARY_DOC_TABLE . " WHERE DocumentID='".abs($id)."' AND Active=1 AND  DocTable='".mysql_real_escape_string($table)."'");
			return $db->num_rows();
		} else {
			return 0;
		}
	}
	
}



?>