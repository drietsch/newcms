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



include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/perms/customer.inc.php");

$perm_group_name="customer";

$perm_group_title[$perm_group_name] = $l_perm["customer"]["perm_group_title"];

$perm_values[$perm_group_name] = array(
	'NEW_CUSTOMER',
	'DELETE_CUSTOMER',
	'EDIT_CUSTOMER',
	'SHOW_CUSTOMER_ADMIN',
	'CUSTOMER_PASSWORD_VISIBLE',
	'CAN_EDIT_CUSTOMERFILTER',
	'CAN_CHANGE_DOCS_CUSTOMER');

//	Here the array of the permission-titles is set.
//	$perm_titles[$perm_group_name]["NAME OF PERMISSION"] = $l_perm[$perm_group_name]["NAME OF PERMISSION"]
$perm_titles[$perm_group_name] = array();

for($i = 0; $i < sizeof($perm_values[$perm_group_name]); $i++){

	$perm_titles[$perm_group_name][$perm_values[$perm_group_name][$i]] = $l_perm[$perm_group_name][$perm_values[$perm_group_name][$i]];
}

$perm_defaults[$perm_group_name] = array(
	'NEW_CUSTOMER' => 0,
 	'DELETE_CUSTOMER' => 0,
 	'EDIT_CUSTOMER' => 0,
 	'SHOW_CUSTOMER_ADMIN' => 0,
 	'CUSTOMER_PASSWORD_VISIBLE' => 0,
 	'CAN_EDIT_CUSTOMERFILTER' => 1,
 	'CAN_CHANGE_DOCS_CUSTOMER' => 1);
?>