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

// Database wrapper class of webEdition
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "db_mysql.inc.php");

### Datenbankklasse ableiten
class DB_WE extends DB_Sql
{

	var $Host = DB_HOST;

	var $Database = DB_DATABASE;

	var $User = DB_USER;

	var $Password = DB_PASSWORD;

	var $Auto_Free = 0;

	var $Halt_On_Error = "no";

	/* public: connection management */
	
	function connect($Database = "", $Host = "", $User = "", $Password = "")
	{
		/* Handle defaults */
		if ("" == $Database)
			$Database = $this->Database;
		if ("" == $Host)
			$Host = $this->Host;
		if ("" == $User)
			$User = $this->User;
		if ("" == $Password)
			$Password = $this->Password;
			
		/* establish connection, select database */
		if (0 == $this->Link_ID) {
			if (defined("DB_CONNECT") && DB_CONNECT == "connect") {
				$this->Link_ID = @mysql_connect($Host, $User, $Password);
				if (!$this->Link_ID) {
					$this->halt("pconnect/connect($Host, $User, \$Password) failed.");
					return 0;
				}
			} else {
				$this->Link_ID = @mysql_pconnect($Host, $User, $Password);
				if (!$this->Link_ID) {
					$this->Link_ID = @mysql_connect($Host, $User, $Password);
					if (!$this->Link_ID) {
						$this->halt("pconnect/connect($Host, $User, \$Password) failed.");
						return 0;
					}
				}
			}
			//$this->storeLinkID();
			if (!@mysql_select_db($Database, $this->Link_ID))
				if (!@mysql_select_db($Database, $this->Link_ID))
					if (!@mysql_select_db($Database, $this->Link_ID))
						if (!@mysql_select_db($Database, $this->Link_ID)) {
							$this->halt("cannot use database " . $this->Database);
							return 0;
						}
				// deactivate MySQL strict mode #185
			$this->query(" SET SESSION sql_mode='' ");
			if (defined("DB_SET_CHARSET") && DB_SET_CHARSET != "") {
				$this->query(" SET NAMES '" . DB_SET_CHARSET . "' ");
			}
		
		}
		return $this->Link_ID;
	}

	function close()
	{
		if ($this->Link_ID) {
			@mysql_close($this->Link_ID);
			$this->Link_ID = "";
		}
	}

	function storeLinkID()
	{
		if ($this->Link_ID) {
			if (!isset($GLOBALS["WE_LINK_IDS"]))
				$GLOBALS["WE_LINK_IDS"] = array();
			if (!in_array($this->Link_ID, $GLOBALS["WE_LINK_IDS"]))
				array_push($GLOBALS["WE_LINK_IDS"], $this->Link_ID);
		}
	}

	function query($Query_String, $allowUnion=false)
	{
		/* No empty queries, please, since PHP4 chokes on them. */
		if ($Query_String == "")
		/* The empty query string is passed on from the constructor,
		* when calling the class without a query, e.g. in situations
		* like these: '$db = new DB_Sql_Subclass;'
		*/
		return 0;
		if (!$this->connect())
			return 0;
			/* we already complained in connect() about that. */
			
		// check for union This is the fastest check
		// if union is found in query, then take a closer look
		if ($allowUnion == false && preg_match('/union/i', $Query_String)) {
			if (preg_match('/^(.+)\sunion\s+select\s(.+)$/i', $Query_String) || preg_match('/\sunion\s+all\s+select\s/i', $Query_String)) {

				$queryToCheck = str_replace("\\\"", "", $Query_String);
				$queryToCheck = str_replace("\\'", "", $queryToCheck);

				$singleQuote = false;
				$doubleQuote = false;
				
				$queryWithoutStrings = "";
				
				for ($i=0; $i<strlen($queryToCheck); $i++) {
					$char = $queryToCheck[$i];
					if ($char == "\"" && $doubleQuote == false && $singleQuote == false) {
						$doubleQuote = true;
					} else if ($char == "'" && $doubleQuote == false && $singleQuote == false) {
						$singleQuote = true;
					} else if ($char == "\"" && $doubleQuote == true) {
						$doubleQuote = false;
					} else if ($char == "'" && $singleQuote == true) {
						$singleQuote = false;
					}
					if ($doubleQuote == false && $singleQuote == false && $char !== "'"  && $char !== "\"") {
						$queryWithoutStrings .= $char;
					}
				}
				
				if (preg_match('/^(.+)\sunion\s+select\s(.+)$/i', $queryWithoutStrings) || preg_match('/\sunion\s+all\s+select\s/i', $queryWithoutStrings)) {
					exit('Bad SQL statement! For security reasons, the UNION operator is not allowed within SQL statements per default! You need to set the second parameter of the query function to true if you want to use the UNION operator!');
				}
				
			}
		}
						
		# New query, discard previous result.
		if ($this->Query_ID)
			$this->free();
		
		if ($this->Debug)
			printf("Debug: query = %s<br>\n", $Query_String);
		$this->Query_ID = @mysql_query($Query_String, $this->Link_ID);
		
		if (!$this->Query_ID && preg_match("/alter table|drop table/i", $Query_String)) {
			@mysql_query("FLUSH TABLES", $this->Link_ID);
			$this->Query_ID = @mysql_query($Query_String, $this->Link_ID);
		} else 
			if (preg_match("/insert |update /i", $Query_String)) {
				// delete getHash DB Cache
				$GLOBALS['WE_GET_HASH_CACHE'] = array();
			}
		$this->Row = 0;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		if (!$this->Query_ID) {
			$this->halt("Invalid SQL: " . $Query_String);
			if (defined("WE_SQL_DEBUG") && WE_SQL_DEBUG == 1) {
				error_log(
						"
MYSQL-ERROR
Fehler: " . $this->Errno . "
Detail: " . $this->Error . "
Query: " . $Query_String . "
");
			}
		}
		
		# Will return nada if it fails. That's fine.
		return $this->Query_ID;
	}
}

function we_closeConnections()
{
	if (isset($GLOBALS["WE_LINK_IDS"]) && is_array($GLOBALS["WE_LINK_IDS"]))
		foreach ($GLOBALS["WE_LINK_IDS"] as $linkID)
			@mysql_close($linkID);
}

### Instanz der DB-Klasse erzeugen und in der globalen Variablen $DB_WE speichern


$DB_WE = new DB_WE();
$DB_WE->connect();

?>