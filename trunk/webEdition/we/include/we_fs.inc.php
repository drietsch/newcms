<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


switch($_REQUEST["we_cmd"][0]) {
	case "openCatselector":
		$noChoose = isset($_REQUEST["we_cmd"][8]) ? $_REQUEST["we_cmd"][8] : "";
	case "openDirselector":
	case "openSelector":
	case "openCatselector":
	case "openDelSelector":
		$id = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : "";
		$table = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : "";
		$JSIDName = isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : "";
		$JSTextName = isset($_REQUEST["we_cmd"][4]) ? $_REQUEST["we_cmd"][4] : "";
		$JSCommand = isset($_REQUEST["we_cmd"][5]) ? $_REQUEST["we_cmd"][5] : "";
		$sessionID = isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : "";
		$rootDirID = isset($_REQUEST["we_cmd"][7]) ? $_REQUEST["we_cmd"][7] : "";
		$filter = isset($_REQUEST["we_cmd"][8]) ? $_REQUEST["we_cmd"][8] : "";
		$multiple = isset($_REQUEST["we_cmd"][9]) ? $_REQUEST["we_cmd"][9] : "";

		break;
	case "openDocselector":
		$id = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : "";
		$table = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : "";
		$JSIDName = isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : "";
		$JSTextName = isset($_REQUEST["we_cmd"][4]) ? $_REQUEST["we_cmd"][4] : "";
		$JSCommand = isset($_REQUEST["we_cmd"][5]) ? $_REQUEST["we_cmd"][5] : "";
		$sessionID = isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : "";
		$rootDirID = isset($_REQUEST["we_cmd"][7]) ? $_REQUEST["we_cmd"][7] : "";
		$filter = isset($_REQUEST["we_cmd"][8]) ? $_REQUEST["we_cmd"][8] : "";
		$open_doc = isset($_REQUEST["we_cmd"][9]) ? $_REQUEST["we_cmd"][9] : "";
		$multiple = isset($_REQUEST["we_cmd"][10]) ? $_REQUEST["we_cmd"][10] : "";
		$canSelectDir = isset($_REQUEST["we_cmd"][11]) ? $_REQUEST["we_cmd"][11] : "";
		break;
}

switch($_REQUEST["we_cmd"][0]) {
	case "openDirselector":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we_dirSelect.php");
		break;
	case "openSelector":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we_fs.php");
		break;
	case "openDocselector":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we_docSelect.php");
		break;
	case "openCatselector":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we_catSelect.php");
		break;
	case "openDelSelector":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we_delSelect.php");
		break;
}

?>	