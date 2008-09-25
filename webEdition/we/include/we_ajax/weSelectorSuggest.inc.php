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

header('Content-type: text/plain');

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php");

if (!isset($_REQUEST["we_cmd"][1]) || !isset($_REQUEST["we_cmd"][2])) exit();

$selectorSuggest = new weSelectorQuery();
$contentTypes = isset($_REQUEST["we_cmd"][3]) ? explode(",",$_REQUEST["we_cmd"][3]) : null;
$selectorSuggest->search($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],$contentTypes);
$suggests = $selectorSuggest->getResult();
$return = "";
if (is_array($suggests)) {
	foreach ($suggests as $sug) {
		$return .= $sug['Path'] . "	" . $sug['ID'] . "\n";
	}
}
echo $return;
?>