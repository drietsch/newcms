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

if(empty($_SESSION["user"]["Username"]) && isset($_REQUEST['csid'])) {
	session_id($_REQUEST['csid']);
}

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_global.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_import_files.inc.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/import_files.inc.php");

protect();

$import_files = new we_import_files();

if(isset($_SESSION['_we_import_files'])){
	$import_files->loadPropsFromSession();
}

$_counter = 0;
foreach($_FILES as $_index=>$_file) {
	if(ereg('uploadedFiles'.$_counter,$_index)) {
		$_FILES['we_File'] = $_file;
		
		$error = $import_files->importFile();
			
		if(sizeof($error)){
			if(!isset($_SESSION["WE_IMPORT_FILES_ERRORs"])){
				$_SESSION["WE_IMPORT_FILES_ERRORs"] = array();
			}
			array_push($_SESSION["WE_IMPORT_FILES_ERRORs"],$error);
		}

		flush();
		unset($_FILES['we_File']);
		$_counter++;
	} else {
		break;		
	}
}

?>