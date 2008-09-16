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

	function query($Query_String)
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

?>