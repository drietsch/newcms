<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/SEEM.inc.php");

$perm_group_name = "seem";
$perm_group_title[$perm_group_name] = $l_perm["seem"]["perm_group_title"];
 
$perm_values[$perm_group_name]=array(
	"CAN_SEE_MENUE",
	"CAN_WORK_NORMAL_MODE",
	"CHANGE_START_DOCUMENT"
 	);

//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name]=array(
	"CAN_SEE_MENUE" => 1,
	"CAN_WORK_NORMAL_MODE" => 1,
	"CHANGE_START_DOCUMENT" => 1
	);
?>