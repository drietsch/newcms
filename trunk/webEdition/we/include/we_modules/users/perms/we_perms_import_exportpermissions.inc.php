<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/import_exportpermissions.inc.php");

$perm_group_name="import_exportpermissions";

$perm_group_title[$perm_group_name] = $l_perm[$perm_group_name]["perm_group_title"];

$perm_values[$perm_group_name] = array(
	"FILE_IMPORT",
	"SITE_IMPORT",
	"WXML_IMPORT",
	"GENERICXML_IMPORT",
	"CSV_IMPORT",
	"NEW_EXPORT",
	"DELETE_EXPORT",
  	"EDIT_EXPORT",
	"MAKE_EXPORT",
	"GENERICXML_EXPORT",
	"CSV_EXPORT"
);


//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for ($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){
	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name]=array(
	"FILE_IMPORT"=>1,
	"SITE_IMPORT"=>1,
	"WXML_IMPORT"=>0,
	"GENERICXML_IMPORT"=>0,
	"CSV_IMPORT"=>0,
	"NEW_EXPORT" => 0,
	"DELETE_EXPORT" => 0,
	"EDIT_EXPORT" => 0,
	"MAKE_EXPORT" => 0,
	"GENERICXML_EXPORT"=>1,
	"CSV_EXPORT"=>1
);

?>