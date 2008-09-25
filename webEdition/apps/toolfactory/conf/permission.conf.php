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
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/lib/we/core/autoload.php');

$isUTF8 = substr($GLOBALS['WE_LANGUAGE'], -5) == 'UTF-8';

$translate = we_core_Local::addTranslation('default.xml', 'toolfactory');

$perm_group_name = "toolfactory";
$perm_group_title[$perm_group_name] = $isUTF8 ? $translate->_('toolfactory') : utf8_decode($translate->_('toolfactory'));

$perm_values[$perm_group_name] = array(
	"NEW_APP_TOOLFACTORY", "DELETE_APP_TOOLFACTORY", "EDIT_APP_TOOLFACTORY"
);

$perm_titles[$perm_group_name] = array();

$translated = array(
	
		$translate->_('The user is allowed to create new items in toolfactory'), 
		$translate->_('The user is allowed to delete items from toolfactory'), 
		$translate->_('The user is allowed to edit items toolfactory')
);

foreach ($translated as $i => $value) {
	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $isUTF8 ? $value : utf8_decode($value);
}

$perm_defaults[$perm_group_name] = array(
	"NEW_APP_TOOLFACTORY" => 1, "DELETE_APP_TOOLFACTORY" => 0, "EDIT_APP_TOOLFACTORY" => 0
);
