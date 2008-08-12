<?php
					
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_html_tools.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_htmlTable.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_button.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/apps/abc/language/language_' . $GLOBALS['WE_LANGUAGE'] . '.inc.php');

$we_button = new we_button();

$createDoctype = $we_button->create_button('new_item', "javascript:we_cmd('tool_abc_new');", true, -1, -1, "", "" ,!we_hasPerm('EDIT_ABC'));
$createDoctypeGroup = $we_button->create_button('new_folder', "javascript:we_cmd('tool_abc_new_group');", true, -1, -1, "", "" ,!we_hasPerm('EDIT_ABC'));

$content = $createDoctype  . getPixel(2,14) . $createDoctypeGroup;
$tool = "abc";
$title = $GLOBALS['l_abc']['abc'];

include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/home.inc.php');

		?>