<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_docSelector.inc.php");

$_SERVER["PHP_SELF"] = "/webEdition/we_docSelect.php";
$fs = new we_docSelector(isset($id) ? $id : ( isset($_REQUEST["id"]) ? $_REQUEST["id"] : '' ),
							isset($table) ? $table : ( isset($_REQUEST["table"]) ? $_REQUEST["table"] : FILE_TABLE),
							isset($JSIDName) ? $JSIDName : ( isset($_REQUEST["JSIDName"]) ? $_REQUEST["JSIDName"] : ""),
							isset($JSTextName) ? $JSTextName : ( isset($_REQUEST["JSTextName"]) ? $_REQUEST["JSTextName"] : "" ),
							isset($JSCommand) ? $JSCommand : ( isset($_REQUEST["JSCommand"]) ? $_REQUEST["JSCommand"] : "" ),
							isset($order) ? $order : ( isset($_REQUEST["order"]) ? $_REQUEST["order"] : ""),
							isset($sessionID) ? $sessionID : ( isset($_REQUEST["sessionID"]) ? $_REQUEST["sessionID"] : ""),
							isset($we_editDirID) ? $we_editDirID : ( isset($_REQUEST["we_editDirID"]) ? $_REQUEST["we_editDirID"] : "" ),
							isset($we_FolderText) ? $we_FolderText : ( isset($_REQUEST["we_FolderText"]) ? $_REQUEST["we_FolderText"] : "" ),
							isset($filter) ? $filter : ( isset($_REQUEST["filter"]) ? $_REQUEST["filter"] : "" ),
							isset($rootDirID) ? $rootDirID : ( isset($_REQUEST["rootDirID"]) ? $_REQUEST["rootDirID"] : "" ),
							isset($open_doc) ? $open_doc : ( isset($_REQUEST["open_doc"]) ? $_REQUEST["open_doc"] : "" ),
							isset($multiple) ? $multiple : ( isset($_REQUEST["multiple"]) ? $_REQUEST["multiple"] : "" ),
							isset($canSelectDir) ? $canSelectDir : ( isset($_REQUEST["canSelectDir"]) ? $_REQUEST["canSelectDir"] : "" ));

$fs->printHTML(isset($_REQUEST["what"]) ? $_REQUEST["what"] : FS_FRAMESET);

?>