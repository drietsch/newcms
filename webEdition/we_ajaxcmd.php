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

if(!isset($_REQUEST["we_cmd"])){
	exit();
}

$include = "";

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

protect();

switch($_REQUEST["we_cmd"][0]){
	case "selectorSuggest" :
		$include = "we_ajax/weSelectorSuggest.inc.php";
		break;
}
if ($include) {
	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/".$include);
}
?>