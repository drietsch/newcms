<?php

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