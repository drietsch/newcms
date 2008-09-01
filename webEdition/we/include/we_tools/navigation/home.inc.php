<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");


$we_button = new we_button();

$createNavigation = $we_button->create_button('new_item', "javascript:we_cmd('tool_navigation_new');", true, -1, -1, "", "", !we_hasPerm('EDIT_NAVIGATION'));
$createNavigationGroup = $we_button->create_button('new_folder', "javascript:we_cmd('tool_navigation_new_group');", true, -1, -1, "", "", !we_hasPerm('EDIT_NAVIGATION'));

$content = $createNavigation  . getPixel(2,14) . $createNavigationGroup;
$tool = "navigation";
$title = $GLOBALS['l_navigation']['navigation'];

include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/home.inc.php');

?>