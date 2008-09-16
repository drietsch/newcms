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


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/rebuildpermissions.inc.php");

$perm_group_name="rebuildpermissions";

$perm_group_title[$perm_group_name] = $l_perm[$perm_group_name]["perm_group_title"];

$perm_values[$perm_group_name] = array(
	"REBUILD",
	"REBUILD_ALL",
	"REBUILD_TEMPLATES",
	"REBUILD_FILTERD",
	"REBUILD_OBJECTS",
	"REBUILD_INDEX",
	"REBUILD_THUMBS",
	"REBUILD_NAVIGATION",
	"REBUILD_META"
	);


//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name]=array(
	"REBUILD"=>1,
	"REBUILD_ALL"=>1,
	"REBUILD_TEMPLATES"=>1,
	"REBUILD_FILTERD"=>1,
	"REBUILD_OBJECTS"=>1,
	"REBUILD_INDEX"=>1,
	"REBUILD_THUMBS"=>1,
	"REBUILD_NAVIGATION"=>1,
	"REBUILD_META"=>1
	);
?>