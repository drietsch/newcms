<?php
					
include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/abc/language/language_' . $GLOBALS['WE_LANGUAGE'] . '.inc.php');

$perm_group_name="abc";
$perm_group_title[$perm_group_name] = $l_abc["perm_group_title"];
 
 
$perm_values[$perm_group_name]=array(
 		"NEW_ABC",
 		"DELETE_ABC",
  		"EDIT_ABC"
);

$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_abc['permission_titles'][$perm_values[$perm_group_name][$i]];
}
 
$perm_defaults[$perm_group_name]=array(
 		"NEW_ABC" => 1,
 		"DELETE_ABC" => 0,
 		"EDIT_ABC" => 0);


		?>