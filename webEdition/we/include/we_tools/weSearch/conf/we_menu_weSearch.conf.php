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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/weSearch/conf/meta.conf.php");
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/searchtool.inc.php');

$we_menu_weSearch['000100']['text'] = $GLOBALS['l_weSearch']['menu_suche'];
$we_menu_weSearch['000100']['parent'] = '000000';
$we_menu_weSearch['000100']['perm'] = '';
$we_menu_weSearch['000100']['enabled'] = '1';

$we_menu_weSearch['000200']['text'] = $GLOBALS['l_weSearch']['menu_new'];
$we_menu_weSearch['000200']['parent'] = '000100';
$we_menu_weSearch['000200']['perm'] = '';
$we_menu_weSearch['000200']['enabled'] = '1';

if (we_hasPerm('CAN_SEE_DOCUMENTS')) {
	$we_menu_weSearch['000300']['text'] = $GLOBALS['l_weSearch']['forDocuments'];
	$we_menu_weSearch['000300']['parent'] = '000200';
	$we_menu_weSearch['000300']['cmd'] = 'tool_' . $metaInfo['name'] . '_new_forDocuments';
	$we_menu_weSearch['000300']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
	$we_menu_weSearch['000300']['enabled'] = '1';
}
if ($_SESSION["we_mode"] != "seem" && we_hasPerm('CAN_SEE_TEMPLATES')) {
	$we_menu_weSearch['000400']['text'] = $GLOBALS['l_weSearch']['forTemplates'];
	$we_menu_weSearch['000400']['parent'] = '000200';
	$we_menu_weSearch['000400']['cmd'] = 'tool_' . $metaInfo['name'] . '_new_forTemplates';
	$we_menu_weSearch['000400']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
	$we_menu_weSearch['000400']['enabled'] = '1';
}
if (defined('OBJECT_FILES_TABLE') && defined('OBJECT_TABLE') && we_hasPerm('CAN_SEE_OBJECTFILES')) {
	$we_menu_weSearch['000500']['text'] = $GLOBALS['l_weSearch']['forObjects'];
	$we_menu_weSearch['000500']['parent'] = '000200';
	$we_menu_weSearch['000500']['cmd'] = 'tool_' . $metaInfo['name'] . '_new_forObjects';
	$we_menu_weSearch['000500']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
	$we_menu_weSearch['000500']['enabled'] = '1';
}
$we_menu_weSearch['000600']['text'] = $GLOBALS['l_weSearch']['menu_advSearch'];
$we_menu_weSearch['000600']['parent'] = '000200';
$we_menu_weSearch['000600']['cmd'] = 'tool_' . $metaInfo['name'] . '_new_advSearch';
$we_menu_weSearch['000600']['perm'] = 'EDIT_NAVIGATION || ADMINISTRATOR';
$we_menu_weSearch['000600']['enabled'] = '1';

//$we_menu_weSearch['000700']['text'] = $GLOBALS['l_weSearch']['menu_new_group'];
//$we_menu_weSearch['000700']['parent'] = '000200';
//$we_menu_weSearch['000700']['cmd'] = 'tool_' . $metaInfo['name'] . '_new_group';
//$we_menu_weSearch['000700']['perm'] = 'ADMINISTRATOR';
//$we_menu_weSearch['000700']['enabled'] = '1';


$we_menu_weSearch['000800']['text'] = $GLOBALS['l_weSearch']['menu_save'];
$we_menu_weSearch['000800']['parent'] = '000100';
$we_menu_weSearch['000800']['cmd'] = 'tool_' . $metaInfo['name'] . '_save';
$we_menu_weSearch['000800']['perm'] = '';
$we_menu_weSearch['000800']['enabled'] = '1';

$we_menu_weSearch['000900']['text'] = $GLOBALS['l_weSearch']['menu_delete'];
$we_menu_weSearch['000900']['parent'] = '000100';
$we_menu_weSearch['000900']['cmd'] = 'tool_' . $metaInfo['name'] . '_delete';
$we_menu_weSearch['000900']['perm'] = '';
$we_menu_weSearch['000900']['enabled'] = '1';

$we_menu_weSearch['000950']['parent'] = '000100'; // separator


$we_menu_weSearch['001000']['text'] = $GLOBALS['l_weSearch']['menu_exit'];
$we_menu_weSearch['001000']['parent'] = '000100';
$we_menu_weSearch['001000']['cmd'] = 'tool_' . $metaInfo['name'] . '_exit';
$we_menu_weSearch['001000']['perm'] = '';
$we_menu_weSearch['001000']['enabled'] = '1';

$we_menu_weSearch['003000']['text'] = $GLOBALS['l_weSearch']['menu_help'];
$we_menu_weSearch['003000']['parent'] = '000000';
$we_menu_weSearch['003000']['perm'] = '';
$we_menu_weSearch['003000']['enabled'] = '1';

$we_menu_weSearch['003100']['text'] = $GLOBALS['l_weSearch']['menu_help'] . '...';
$we_menu_weSearch['003100']['parent'] = '003000';
$we_menu_weSearch['003100']['cmd'] = 'help_tools';
$we_menu_weSearch['003100']['perm'] = '';
$we_menu_weSearch['003100']['enabled'] = '1';

$we_menu_weSearch['003200']['text'] = $GLOBALS['l_weSearch']['menu_info'] . '...';
$we_menu_weSearch['003200']['parent'] = '003000';
$we_menu_weSearch['003200']['cmd'] = 'info_tools';
$we_menu_weSearch['003200']['perm'] = '';
$we_menu_weSearch['003200']['enabled'] = '1';

?>