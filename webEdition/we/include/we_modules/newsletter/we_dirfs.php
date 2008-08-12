<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

	$id = isset($_REQUEST["we_cmd"][1]) ? $_REQUEST["we_cmd"][1] : "";
	$JSIDName = stripslashes(isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : "");
	$JSTextName = stripslashes(isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : "");
	$JSCommand = isset($_REQUEST["we_cmd"][4]) ? $_REQUEST["we_cmd"][4] : "";
	$sessionID = isset($_REQUEST["we_cmd"][5]) ? $_REQUEST["we_cmd"][5] : "";
	$rootDirID = isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : "";
	$filter = isset($_REQUEST["we_cmd"][7]) ? $_REQUEST["we_cmd"][7] : "";
	$multiple = isset($_REQUEST["we_cmd"][8]) ? $_REQUEST["we_cmd"][8] : "";

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/newsletter/we_newsletterDirSelector.php");

?>	