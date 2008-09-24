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


include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/glossary.inc.php");

$perm_group_name="glossary";
$perm_group_title[$perm_group_name]=$l_perm["glossary"]["perm_group_title"];

$perm_values[$perm_group_name]=array(
	"NEW_GLOSSARY",
	"EDIT_GLOSSARY",
  	"DELETE_GLOSSARY",
  	"EDIT_GLOSSARY_DICTIONARY",
);

//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name]=array(
	"NEW_GLOSSARY" => 1,
	"EDIT_GLOSSARY" => 1,
	"DELETE_GLOSSARY" => 1,
	"EDIT_GLOSSARY_DICTIONARY" => 1,
	);

?>