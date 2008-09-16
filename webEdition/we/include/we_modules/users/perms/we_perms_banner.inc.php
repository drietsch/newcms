<?php
             
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/banner.inc.php");
$perm_group_name="banner";
$perm_group_title[$perm_group_name] = $l_perm["banner"]["perm_group_title"];
 
 
 $perm_values[$perm_group_name]=array(
 		"NEW_BANNER",
 		"DELETE_BANNER",
  		"EDIT_BANNER");
 
//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}
 		
 
$perm_defaults[$perm_group_name]=array(
 		"NEW_BANNER" => 1,
 		"DELETE_BANNER" => 0,
 		"EDIT_BANNER" => 0);

?>