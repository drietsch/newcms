<?php
					
include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/tools.inc.php');

$l_abc['save_group_ok'] = $l_tools['save_group_ok'];
$l_abc['save_ok'] = $l_tools['save_ok'];
$l_abc['save_group_failed'] = $l_tools['save_group_failed'];
$l_abc['save_failed'] = $l_tools['save_failed'];

$l_abc['abc'] = 'abc';
$l_abc['perm_group_title'] = $l_abc['abc'];


$l_abc["permission_titles"]["NEW_ABC"] = "The user is allowed to create new items in abc";
$l_abc["permission_titles"]["DELETE_ABC"] = "The user is allowed to delete items from abc";
$l_abc["permission_titles"]["EDIT_ABC"] = "The user is allowed to edit items abc";


$l_abc["import_tool_abc_data"] = "Restore " . $l_abc['abc'] . " data";
$l_abc["export_tool_abc_data"] = "Save " . $l_abc['abc'] . " data";

		?>