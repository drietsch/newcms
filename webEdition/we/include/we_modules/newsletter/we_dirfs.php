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