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