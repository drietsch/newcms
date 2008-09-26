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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_html_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");

$we_button = new we_button();

$createNavigation = $we_button->create_button(
		'new_item', 
		"javascript:we_cmd('tool_navigation_new');", 
		true, 
		-1, 
		-1, 
		"", 
		"", 
		!we_hasPerm('EDIT_NAVIGATION'));
$createNavigationGroup = $we_button->create_button(
		'new_folder', 
		"javascript:we_cmd('tool_navigation_new_group');", 
		true, 
		-1, 
		-1, 
		"", 
		"", 
		!we_hasPerm('EDIT_NAVIGATION'));

$content = $createNavigation . getPixel(2, 14) . $createNavigationGroup;
$tool = "navigation";
$title = $GLOBALS['l_navigation']['navigation'];

include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/home.inc.php');

?>