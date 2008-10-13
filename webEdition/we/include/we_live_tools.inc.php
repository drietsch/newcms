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

function saveFile($file_name, $sourceCode = "")
{
	createLocalFolderByPath(str_replace("\\", "/", dirname($file_name)));
	$fh = @fopen($file_name, "wb");
	if (!$fh) {
		return false;
	}
	if ($sourceCode) {
		$ret = fwrite($fh, $sourceCode);
	} else {
		$ret = true;
	}
	fclose($fh);
	return $ret;
}

function createLocalFolder($RootDir, $path = "")
{
	
	$completeDirPath = $RootDir . $path;
	
	return createLocalFolderByPath($completeDirPath);
}

function createLocalFolderByPath($completeDirPath)
{
	
	$returnValue = true;
	
	if (checkAndMakeFolder($completeDirPath))
		return $returnValue;
	
	$cf = array(
		$completeDirPath
	);
	
	$parent = dirname($completeDirPath);
	$parent = str_replace("\\", "/", $parent);
	
	while (!checkAndMakeFolder($parent)) {
		array_push($cf, $parent);
		$parent = dirname($parent);
		$parent = str_replace("\\", "/", $parent);
	}
	
	for ($i = (sizeof($cf) - 1); $i >= 0; $i--) {
		$oldumask = @umask(0000);
		
		if (defined("WE_NEW_FOLDER_MOD")) {
			eval('$mod = 0' . abs(WE_NEW_FOLDER_MOD) . ';');
		} else {
			$mod = 0755;
		}
		
		if (!@mkdir($cf[$i], $mod)) {
			insertIntoErrorLog(
					"Could not create local Folder at we_live_tools.inc.php/createLocalFolderByPath(): '" . $cf[$i] . "'");
			$returnValue = false;
		}
		@umask($oldumask);
	}
	
	return $returnValue;
}

function insertIntoCleanUp($path, $date)
{
	$DB_WE = new DB_WE();
	if (f("SELECT Date FROM " . CLEAN_UP_TABLE . " WHERE Path='".mysql_real_escape_string($path)."'", "Date", $DB_WE)) {
		$DB_WE->query("UPDATE " . CLEAN_UP_TABLE . " SET DATE='".mysql_real_escape_string($date)."' WHERE  Path='".mysql_real_escape_string($path)."'");
	} else {
		$DB_WE->query("INSERT INTO " . CLEAN_UP_TABLE . " (Path,Date) VALUES ('".mysql_real_escape_string($path)."','".mysql_real_escape_string($date)."')");
	}
}

function checkAndMakeFolder($path)
{
	/* if the directory exists, we have nothing to do and then we return true  */
	if (file_exists($path) && is_dir($path))
		return true;
	$docroot = ereg_replace('^(.*)/$', '\1', $_SERVER["DOCUMENT_ROOT"]);
	$path2 = ereg_replace('^(.*)/$', '\1', $path);
	if (strtolower($docroot) == strtolower($path2))
		return true;
		
	/* if instead of the directory a file exists, we delete the file and create the directory */
	if (file_exists($path) && (!is_dir($path))) {
		if (!deleteLocalFile($path)) {
			insertIntoErrorLog("Could not delete File '" . $path . "'");
		}
	}
	
	$oldumask = @umask(0000);
	
	if (defined("WE_NEW_FOLDER_MOD")) {
		eval('$mod = 0' . abs(WE_NEW_FOLDER_MOD) . ';');
	} else {
		$mod = 0755;
	}
	
	if (!@mkdir($path, $mod)) {
		@umask($oldumask);
		insertIntoErrorLog("Could not create local Folder at we_live_tools.inc.php/checkAndMakeFolder(): '" . $path . "'");
		return false;
	}
	@umask($oldumask);
	return true;
}

function insertIntoErrorLog($text)
{
	$DB_WE = new DB_WE();
	$time = time();
	$DB_WE->query("INSERT INTO " . ERROR_LOG_TABLE . " (Text,Date) VALUES('" . mysql_real_escape_string($text) . "','$time')");

}

function getContentDirectFromDB($id, $name, $db = "")
{
	$db = $db ? $db : new DB_WE();
	return f(
			"SELECT " . CONTENT_TABLE . ".Dat as Dat FROM " . LINK_TABLE . "," . CONTENT_TABLE . " WHERE " . LINK_TABLE . ".DID=".abs($id)." AND " . LINK_TABLE . ".CID=" . CONTENT_TABLE . ".ID AND " . LINK_TABLE . ".Name='".mysql_real_escape_string($name)."'", 
			"Dat", 
			$db);
}

function renameFile($old, $new)
{
	return rename($old, $new);
}

function deleteLocalFolder($filename, $delAll = 0)
{
	if (!file_exists($filename))
		return false;
	if ($delAll) {
		$foo = (substr($filename, -1) == "/") ? $filename : ($filename . "/");
		$d = dir($filename);
		while (false !== ($entry = $d->read())) {
			if ($entry != ".." && $entry != ".") {
				$path = $foo . $entry;
				if (is_dir($path)) {
					deleteLocalFolder($path, 1);
				} else {
					deleteLocalFile($path);
				}
			}
		}
		$d->close();
	}
	return @rmdir($filename);
}

?>
