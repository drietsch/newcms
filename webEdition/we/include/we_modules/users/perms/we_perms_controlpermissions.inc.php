<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/controlpermissions.inc.php");

$perm_group_name="controlpermissions";

$perm_group_title[$perm_group_name] = $l_perm["controlpermissions"]["perm_group_title"];  
 
 
$perm_values[$perm_group_name] = array(
	"NEW_GROUP",
	"NEW_USER",
	"SAVE_GROUP",
	"SAVE_USER",
	"DELETE_GROUP",
	"DELETE_USER",
	"PUBLISH",
	"EDIT_SETTINGS_DEF_EXT",
	"EDIT_SETTINGS",
	"EDIT_PASSWD");
 
//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name] = array(
	"NEW_GROUP"=>0,
	"NEW_USER"=>0,
	"SAVE_GROUP"=>0,
	"SAVE_USER"=>0,
	"DELETE_GROUP"=>0,
	"DELETE_USER"=>0,
	"PUBLISH"=>0,
	"EDIT_SETTINGS_DEF_EXT"=>0,
	"EDIT_SETTINGS"=>1,
	"EDIT_PASSWD"=>1
	);     
 
?>