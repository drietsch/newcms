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
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * This class contains all functions needed for the update process
 * TBD if we divide this class in several classes
 */
class liveUpdateFunctions {

	var $QueryLog = array();

	/*
	 * Functions for updatelog
	 */
	function insertUpdateLogEntry($action, $version, $errorCode) {

		global $DB_WE;

		$query =
			"INSERT INTO " . UPDATE_LOG_TABLE . "
			(datum, aktion, versionsnummer, error)
			VALUES (NOW(), \"" . addslashes($action) . "\", \"$version\", $errorCode);";

		$DB_WE->query($query);
	}

	/**
	 * @param string $type
	 * @param string $premessage
	 * @param integer $errorCode
	 * @param string $version
	 */
	function insertQueryLogEntries($type, $premessage='', $errorCode, $version) {

		// insert notices first
		$message = $premessage;

		if (isset($this->QueryLog[$type])) {

			foreach ($this->QueryLog[$type] as $noticeMessage) {
				$message .= "<br />$noticeMessage\n";
			}
			$this->insertUpdateLogEntry($message, $version, $errorCode);
		}
	}

	/**
	 * Decode encoded strings submit from liveupdater
	 *
	 * @param string $string
	 * @return string
	 */
	function decodeCode($string) {

		return base64_decode($string);
	}


	/**
	 * prepares given php-code
	 * - replaces doc_root
	 * - edits extension of all containing files
	 *
	 * @return string
	 */
	function preparePhpCode($content, $needle, $replace) {

		$content = $this->replaceExtensionInContent($content, $needle, $replace);
		$content = $this->checkReplaceDocRoot($content);

		return $content;
	}


	/**
	 * replaces extension of content
	 *
	 * @param unknown_type $content
	 * @param unknown_type $replace
	 * @param unknown_type $needle
	 * @return unknown
	 */
	function replaceExtensionInContent($content, $needle, $replace) {

		$content = str_replace($needle, $replace, $content);
		return $content;
	}

	/**
	 * checks if document root exists, and replaces $_SERVER['DOCMENT_ROOT'] in
	 * $content if needed
	 *
	 * @param string $content
	 * @return string
	 */
	function checkReplaceDocRoot($content) {

		if (!(isset($_SERVER['DOCUMENT_' . 'ROOT']) && $_SERVER['DOCUMENT_' . 'ROOT'] == LIVEUPDATE_SOFTWARE_DIR) ) {

			$content = str_replace('$_SERVER[\'DOCUMENT_' . 'ROOT\']', '"' . LIVEUPDATE_SOFTWARE_DIR . '"', $content);
			$content = str_replace('$_SERVER["DOCUMENT_' . 'ROOT"]', '"' . LIVEUPDATE_SOFTWARE_DIR . '"', $content);
			$content = str_replace('$GLOBALS[\'DOCUMENT_' . 'ROOT\']', '"' . LIVEUPDATE_SOFTWARE_DIR . '"', $content);
			$content = str_replace('$GLOBALS["DOCUMENT_' . 'ROOT"]', '"' . LIVEUPDATE_SOFTWARE_DIR . '"', $content);
		}
		return $content;
	}

	/*
	 * Functions for manipulating files
	 */

	/**
	 * fills given array with all files in given dir
	 *
	 * @param array $allFiles
	 */
	function getFilesOfDir(&$allFiles, $baseDir) {

		if (file_exists($baseDir)) {

			$dh = opendir($baseDir);
			while( $entry = readdir($dh) ){

				if( $entry != "" && $entry != "." && $entry != ".." ){

					$_entry = $baseDir . "/" . $entry;

		            if( !is_dir( $_entry ) ){
		                $allFiles[] = $_entry;
		            }

					if(is_dir( $_entry )){
						$this->getFilesOfDir( $allFiles, $_entry);
					}
				}
			}
			closedir($dh);
		}
	}

	/**
	 * deletes $dir and all files/dirs inside
	 *
	 * @param string $dir
	 */
	function deleteDir($dir) {

		if (strpos($dir, './') !== false) {
			return true;
		}

		if (!file_exists($dir)) {
			return true;
		}

		$dh = opendir($dir);
		if ($dh) {

			while( $entry = readdir($dh) ){

				if( $entry != "" && $entry != "." && $entry != ".." ){

					$_entry = $dir . "/" . $entry;

					if (is_dir($_entry)) {
						$this->deleteDir($_entry);
					} else {
						unlink($_entry);
					}

				}
			}
			closedir($dh);
			return rmdir($dir);
		} else {
			return true;
		}
	}

	/**
	 * Reads filecontent in a string and returns it
	 *
	 * @param string $filePath
	 * @return string
	 */
	function getFileContent($filePath) {

		$content = '';

		if ($fh = fopen($filePath, 'rb')) {
			$content = fread($fh, filesize($filePath));
			fclose($fh);
		}

		return $content;
	}

	/**
	 * writes filecontent in a file
	 *
	 * @param string $filePath
	 * @param string $newContent
	 * @return boolean
	 */
	function filePutContent($filePath, $newContent) {

		if ($this->checkMakeDir( dirname($filePath) )) {

			if ($fh = fopen($filePath, 'wb')) {

				fwrite($fh, $newContent, strlen($newContent));
				fclose($fh);
				return true;
			}
		}
		return false;
	}

	/**
	 * This function checks if given dir exists, if not tries to create it
	 *
	 * @param string $dirPath
	 * @return boolean
	 */
	function checkMakeDir($dirPath, $mod=0755) {

		// open_base_dir - seperate document-root from rest
		if (strpos($dirPath, LIVEUPDATE_SOFTWARE_DIR) === 0) {
			$preDir = LIVEUPDATE_SOFTWARE_DIR;
			$dir = substr($dirPath, strlen(LIVEUPDATE_SOFTWARE_DIR));
		} else {
			$preDir = '';
			$dir = $dirPath;
		}

		$pathArray = explode('/', $dir);
		$path = $preDir;

		for($i=0;$i<sizeof($pathArray); $i++){

			$path .= $pathArray[$i];
			if($pathArray[$i] != "" && !is_dir($path)){

				if( !(file_exists($path) || mkdir($path, $mod)) ){
					return false;
				}
			}
			$path .= "/";
		}
		
		if(!is_writable($dirPath)) {
			if(!chmod($dirPath, $mod)) {
				return false;
			}
		}
		return true;
	}

	/**
	 * @param string $file
	 * @return boolean
	 */
	function deleteFile($file) {

		if ( @unlink($file) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * moves $source file to new $destination
	 *
	 * @param string $source
	 * @param string $destination
	 * @return boolean
	 */
	function moveFile($source, $destination) {


		if ($this->checkMakeDir(dirname($destination))) {

			$this->deleteFile($destination);
			if (rename($source, $destination)) {
				return true;
			} else {
				return false;
			}

		} else {
			return false;
		}
	}

	/**
	 * returns if selected file is a php file or not, important also check html files
	 *
	 * @param string $path
	 * @return boolean
	 */
	function isPhpFile($path) {

		$pattern = "/\.([^\..]+)$/";

		if (preg_match($pattern, $path, $matches)) {

			$ext = strtolower($matches[1]);

			if ( ($ext == 'jpg' || $ext == 'gif' || $ext == 'jpeg' || $ext == 'sql') ) {
				return false;
			}
		}
		return true;
	}

	/**
	 * This file searchs $needle in given file and replaces it with $replace
	 * If needle is empty the whole file is overwritten. Also
	 * $_SERVER[DOCUMENT_ROOT] is replaced if necessary
	 *
	 * @param string $filePath
	 * @param string $replace
	 * @param string $needle
	 * @return boolean
	 */
	function replaceCode($filePath, $replace, $needle='') {

		// decode parameters
		$needle = $this->decodeCode($needle);
		$replace = $this->decodeCode($replace);

		if (file_exists($filePath)) {

			$oldContent = $this->getFileContent($filePath);

			$replace = $this->checkReplaceDocRoot($replace);

			if ($needle) {
				$newContent = ereg_replace($needle, $replace, $oldContent);
			} else {
				$newContent = $replace;
			}

			if (!$this->filePutContent($filePath, $newContent)) {
				return false;
			}
		} else {
			return false;
		}
		return true;
	}

	/*
	 * Functions for patches
	 */

	/**
	 * executes patch.
	 *
	 * @param string $path
	 * @return boolean
	 */
	function executePatch($path) {

		if (file_exists($path)) {

			$code = $this->getFileContent($path);
			$patchSuccess = eval('?>' . escapeshellcmd($code));
			if ($patchSuccess === false) {
				return false;
			} else {
				return true;
			}
		}
		return true;
	}

	/*
	 * Functions for manipulating database
	 */

	/**
	 * returns array with all columns of given tablename
	 *
	 * @param string $tableName
	 * @return array
	 */
	function getFieldsOfTable($tableName) {

		$db = new DB_WE();

		$fieldsOfTable = array();

		$db->query("DESCRIBE $tableName");

		while ($db->next_record()) {
			$fieldsOfTable[$db->f('Field')] = array(
				'Field' => $db->f('Field'),
				'Type' => $db->f('Type'),
				'Null' => $db->f('Null'),
				'Key' => $db->f('Key'),
				'Default' => $db->f('Default'),
				'Extra' => $db->f('Extra')
			);
		}
		return $fieldsOfTable;
	}

	/**
	 * returns array with key information of a table by tablename
	 *
	 * @param string $tableName
	 * @return array
	 */
	function getKeysFromTable($tableName) {

		$db = new DB_WE();

		$keysOfTable = array();

		$db->query("SHOW INDEX FROM $tableName");

		while ($db->next_record()) {

			$indexType = '';

			if ($db->f('Key_name') == 'PRIMARY') {
				$indexType = 'PRIMARY';
			} else if ( $db->f('Comment') == 'FULLTEXT' || $db->f('Index_type') == 'FULLTEXT' ) {// this also depends from mysqlVersion
				$indexType = 'FULLTEXT';
			} else if ( $db->f('Non_unique') == '0' ) {
				$indexType = 'UNIQUE';
			} else {
				$indexType = 'INDEX';
			}

			if (!isset($keysOfTable[$db->f('Column_name')]) || !in_array($indexType, $keysOfTable[$db->f('Column_name')])) {
				$keysOfTable[$db->f('Column_name')][] = $indexType;
			}
		}

		return $keysOfTable;
	}

/**
    * expects array from getFieldsOfTable and returns generated queries to
    * alter these fields
    *
    * @param array $fields
    * @param string $tableName
    * @param boolean $newField
    * @return unknown
    */
   function getAlterTableForFields($fields, $tableName, $isNew=false) {

       $queries = array();

       foreach ($fields as $fieldName => $fieldInfo) {

           $null = '';
           $extra = '';
           $default = '';

           if (strtoupper($fieldInfo['Null']) == "YES") {
               $null = ' NULL';
           } else {
               $null = ' NOT NULL';
           }

           if (($fieldInfo['Default']) != "") {
               $default = ' default \'' . $fieldInfo['Default'] . '\'';
           } else {
               if (strtoupper($fieldInfo['Null']) == "YES") {
                   $default = ' default NULL';
               }
           }
           $extra = strtoupper($fieldInfo['Extra']);

           if ($isNew) {

               $queries[] = "ALTER TABLE $tableName ADD " . mysql_real_escape_string($fieldInfo['Field']) . " " . mysql_real_escape_string($fieldInfo['Type']) . " $null $default $extra";
           } else {

               $queries[] = "ALTER TABLE $tableName CHANGE " . mysql_real_escape_string($fieldInfo['Field']) . " " . mysql_real_escape_string($fieldInfo['Field']) . " " . mysql_real_escape_string($fieldInfo['Type']) . " $null $default $extra";
           }
       }
       return $queries;
   }

	/**
	 * returns array with queries to update keys of table
	 *
	 * @param array $fields
	 * @param string $tableName
	 * @param boolean $isNew
	 * @return array
	 */
	function getAlterTableForKeys($fields, $tableName, $isNew=true) {

		$queries = array();

		foreach ($fields as $key => $indexes) {

			for ($i=0; $i<sizeof($indexes); $i++) {

				$index = '';
				switch ($indexes[$i]) {
					case 'PRIMARY':
						$index = 'PRIMARY KEY';
					break;
					default:
						$index = strtoupper($indexes[$i]);
					break;
				}

				$queries[] = "ALTER TABLE $tableName ADD " . addslashes($index) . " (".addslashes($key).")";
			}
		}
		return $queries;
	}

	/**
	 * Enter description here...
	 *
	 * @param string $path
	 * @return boolean
	 */
	function isInsertQueriesFile($path) {

		return preg_match("/^(.){3}_insert_(.*).sql/", basename($path));
	}

	/**
	 * executes all queries in a single file
	 * - there is one query, if create-statement
	 * - many queris, if insert statements
	 *
	 *
	 * @param string $path
	 * @return boolean
	 */
	function executeQueriesInFiles($path) {

		if ($this->isInsertQueriesFile($path)) {

			$success = true;

			if ($queryArray = file($path)) {

				foreach ($queryArray as $query) {

					if (trim($query)) {
						if (!$this->executeUpdateQuery($query)) {
							$success = false;
						}
					}
				}
			}

		} else {
			$content = $this->getFileContent($path);
			$queries = explode("/* query separator */",$content);
			//$success = $this->executeUpdateQuery($content);
			$success = true;
			foreach($queries as $query) {
				$success = $this->executeUpdateQuery($query);
				if(!$success) $success = false;
			}
			
		}
		return $success;
	}
	

	/**
	 * updates the database with given dump.
	 *
	 * @param string $query
	 */
	function executeUpdateQuery($query) {

		$db = new DB_WE();

		// when executing a create statement, try to create table,
		// change fields when needed.

		$query = trim($query);

		// first of all we need to check if there is a tblPrefix
		if (LIVEUPDATE_TABLE_PREFIX) {

			$query = preg_replace("/^INSERT INTO /", "INSERT INTO " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			$query = preg_replace("/^CREATE TABLE /", "CREATE TABLE " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			$query = preg_replace("/^DELETE FROM /", "DELETE FROM " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			$query = preg_replace("/^ALTER TABLE /", "ALTER TABLE " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			$query = preg_replace("/^RENAME TABLE /", "RENAME TABLE " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			$query = preg_replace("/^TRUNCATE TABLE /", "TRUNCATE TABLE " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			$query = preg_replace("/^DROP TABLE /", "DROP TABLE " . LIVEUPDATE_TABLE_PREFIX, $query, 1);
			
			$query = @str_replace(LIVEUPDATE_TABLE_PREFIX.'`', '`'.LIVEUPDATE_TABLE_PREFIX, $query);
		}

		// second, we need to check if there is a collation
		if (defined("DB_CHARSET") && DB_CHARSET != "" && defined("DB_COLLATION") && DB_COLLATION != "") {
			if(eregi("^CREATE TABLE ", $query)) {
				$Charset = DB_CHARSET;
				$Collation = DB_COLLATION;
				$query = preg_replace("/;$/", " CHARACTER SET " . $Charset . " COLLATE " . $Collation . ";", $query, 1);
			}

		}

		if ($db->query($query) ) {

			return true;

		} else {

			switch ($db->Errno) {

				case '1050': // this table already exists

					// the table already exists,
					// make tmptable and check these tables ...
					$namePattern = "/CREATE TABLE (\w+) \(/";
					preg_match($namePattern, $query, $matches);

					if ($matches[1]) {

						// get name of table and build name of temptable

						// realname of the new table
						$tableName = $matches[1];

						// tmpname - this table is to compare the incoming dump
						// with existing table
						$tmpName = '__we_delete_update_temp_table__';

						$db->query("DROP TABLE IF EXISTS $tmpName;"); // delete table if already exists

						// create temptable
						$tmpQuery = preg_replace($namePattern, "CREATE TABLE $tmpName (", $query);
						$db->query(trim($tmpQuery));

						// get information from existing and new table
						$origTable = $this->getFieldsOfTable($tableName);
						$newTable = $this->getFieldsOfTable($tmpName);

						// get keys from existing and new table
						$origTableKeys = $this->getKeysFromTable($tableName);
						$newTableKeys = $this->getKeysFromTable($tmpName);


						// determine changed and new fields.
						$changeFields = array(); // array with changed fields
						$addFields = array(); // array with new fields

						foreach ($newTable as $fieldName => $newField) {

							if (isset($origTable[$fieldName])) { // field exists
								if ( !($newField['Type'] == $origTable[$fieldName]['Type'] && $newField['Null'] == $origTable[$fieldName]['Null'] && $newField['Default'] == $origTable[$fieldName]['Default'] && $newField['Extra'] == $origTable[$fieldName]['Extra']) ) {
									$changeFields[$fieldName] = $newField;
								}
							} else { // field does not exist
								$addFields[$fieldName] = $newField;
							}
						}

						// determine new keys
						$addKeys = array();
						foreach ($newTableKeys as $keyName => $indexes) {

							if (isset($origTableKeys[$keyName])) {

								for ($i=0;$i<sizeof($indexes);$i++) {
									if (!in_array($indexes[$i], $origTableKeys[$keyName])) {
										$addKeys[$keyName][] = $indexes[$i];
									}
								}
							} else {
								$addKeys[$keyName] = $indexes;
							}
						}

						// get all queries to add/change fields, keys
						$alterQueries = array();

						// get all queries to change existing fields
						if (sizeof($addFields)) {
							$alterQueries = array_merge($alterQueries, $this->getAlterTableForFields($addFields, $tableName, true));
						}

						// get all queries to change existing keys
						if (sizeof($addKeys)) {
							$alterQueries = array_merge($alterQueries, $this->getAlterTableForKeys($addKeys, $tableName, true));
						}

						if (sizeof($changeFields)) {
							$alterQueries = array_merge($alterQueries, $this->getAlterTableForFields($changeFields, $tableName));
						}

						if (sizeof($alterQueries)) {
							// execute all queries
							$success = true;
							foreach ($alterQueries as $_query) {

								if ($db->query(trim($_query))) {
									$this->QueryLog['success'][] = $_query;
								} else {
									$this->QueryLog['error'][] = $db->Errno . ' ' . $db->Error . "\n<!-- $_query -->";
									$success = false;
								}
							}
							if ($success) {
								$this->QueryLog['tableChanged'][] = $tableName . "\n<!--$query-->";
							}

						} else {
							$this->QueryLog['tableExists'][] = $tableName;
						}

						$db->query("DROP TABLE $tmpName");
					}
				break;
				case '1062':
					$this->QueryLog['entryExists'][] = $db->Errno . ' ' . $db->Error . "\n<!-- $query -->";
				break;
				default:
					$this->QueryLog['error'][] = $db->Errno . ' ' . $db->Error . "\n<!-- $query -->";
					return false;
				break;
			}
			return false;
		}
		return true;
	}

	/**
	 * returns log array for db-queries
	 * @return array
	 */
	function getQueryLog() {

		return $this->QueryLog;
	}

	/**
	 * resets query log, this is done after each query file.
	 */
	function clearQueryLog() {

		$this->QueryLog = array();
	}

	/*
	 * Functions for error handler, etc
	 */


	/**
	 * returns array with all installed languages
	 *
	 * @return array
	 */
	function getInstalledLanguages() {

		clearstatcache();

		//	Get all installed Languages ...
		$_installedLanguages = array();
		//	Look which languages are installed ...
		$_language_directory = dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language");

		while (false !== ($entry = $_language_directory->read())) {
			if ($entry != "." && $entry != "..") {
				if (is_dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry) &&
					is_file($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry."/translation.inc.php")) {
					$_installedLanguages[] = $entry;
				}
			}
		}
		$_language_directory->close();

		return $_installedLanguages;
	}

	/**
	 * This file sets another errorhandler - to make specific error-messages
	 *
	 * @param integer $errno
	 * @param string $errstr
	 * @param string $errfile
	 * @param integer $errline
	 * @param string $errcontext
	 */
	function liveUpdateErrorHandler($errno, $errstr , $errfile , $errline, $errcontext) {

		global $liveUpdateError;

		$liveUpdateError["errorNr"] = $errno;
		$liveUpdateError["errorString"] = $errstr;
		$liveUpdateError["errorFile"] = $errfile;
		$liveUpdateError["errorLine"] = $errline;

//		ob_start('error_log');
//		var_dump($liveUpdateError);
//		ob_end_clean();
	}
}
?>