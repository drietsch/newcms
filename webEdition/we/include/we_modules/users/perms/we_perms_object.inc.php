<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/object.inc.php");

$perm_group_name="object";
$perm_group_title[$perm_group_name] = $l_perm["object"]["perm_group_title"];

$perm_values[$perm_group_name]=array(
	"CAN_SEE_OBJECTFILES",
	"NEW_OBJECTFILE",
	"NEW_OBJECTFILE_FOLDER",
	"DELETE_OBJECTFILE",
	"MOVE_OBJECTFILE",
	"CAN_SEE_OBJECTS",
	"NEW_OBJECT",
	"DELETE_OBJECT",
	"CAN_SELECT_OTHER_USERS_OBJECTS"
    );

//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}


$perm_defaults[$perm_group_name]=array(
	"NEW_OBJECTFILE"=>1,
	"NEW_OBJECT"=>0,
	"NEW_OBJECTFILE_FOLDER"=>1,
	"DELETE_OBJECTFILE"=>1,
	"DELETE_OBJECT"=>0,
	"MOVE_OBJECTFILE"=>1,
	"CAN_SEE_OBJECTS"=>0,
	"CAN_SEE_OBJECTFILES"=>1,
	"CAN_SELECT_OTHER_USERS_OBJECTS"=>1
	);

?>