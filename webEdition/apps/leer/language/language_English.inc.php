<?php
					
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/tools.inc.php');

$l_leer['save_group_ok'] = $l_tools['save_group_ok'];
$l_leer['save_ok'] = $l_tools['save_ok'];
$l_leer['save_group_failed'] = $l_tools['save_group_failed'];
$l_leer['save_failed'] = $l_tools['save_failed'];

$l_leer['leer'] = 'leer';
$l_leer['perm_group_title'] = $l_leer['leer'];


$l_leer["permission_titles"]["NEW_APP_LEER"] = "The user is allowed to create new items in leer";
$l_leer["permission_titles"]["DELETE_APP_LEER"] = "The user is allowed to delete items from leer";
$l_leer["permission_titles"]["EDIT_APP_LEER"] = "The user is allowed to edit items leer";


$l_leer["import_tool_leer_data"] = "Restore " . $l_leer['leer'] . " data";
$l_leer["export_tool_leer_data"] = "Save " . $l_leer['leer'] . " data";

		?>