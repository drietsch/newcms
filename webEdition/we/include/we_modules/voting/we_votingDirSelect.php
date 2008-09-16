<?php


// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/voting/we_votingDirSelector.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/voting.inc.php");

$_SERVER["PHP_SELF"] = "/webEdition/we/include/we_modules/voting/we_votingDirSelect.php";
$fs = new we_votingDirSelector(isset($id) ? $id : (isset($_REQUEST["id"]) ? $_REQUEST["id"] : ''),
							isset($JSIDName) ? $JSIDName : (isset($_REQUEST["JSIDName"]) ? $_REQUEST["JSIDName"] : ''),
							isset($JSTextName) ? $JSTextName : (isset($_REQUEST["JSTextName"]) ? $_REQUEST["JSTextName"] : ''),
							isset($JSCommand) ? $JSCommand : (isset($_REQUEST["JSCommand"]) ? $_REQUEST["JSCommand"] : ''),
							isset($order) ? $order : (isset($_REQUEST["order"]) ? $_REQUEST["order"] : ''),
							isset($we_editDirID) ? $we_editDirID : (isset($_REQUEST["we_editDirID"]) ? $_REQUEST["we_editDirID"] : ''),
							isset($we_FolderText) ? $we_FolderText : (isset($_REQUEST["we_FolderText"]) ? $_REQUEST["we_FolderText"] : ''));
							
$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>