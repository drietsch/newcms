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

	$tableKeys = array();

	$tableKeys[strtolower(CLEAN_UP_TABLE)] = array('Path');

	$tableKeys[strtolower(LINK_TABLE)] = array('DID','CID');

	$tableKeys[strtolower(PASSWD_TABLE)] = array('username');

	$tableKeys[strtolower(PREFS_TABLE)] = array('userID');

	$tableKeys[strtolower(METADATA_TABLE)] = array('id');

	if(defined('NEWSLETTER_CONFIRM_TABLE')) {
		$tableKeys[strtolower(NEWSLETTER_CONFIRM_TABLE)] = array('confirmID');
	}

	if(defined('NEWSLETTER_PREFS_TABLE')) {
		$tableKeys[strtolower(NEWSLETTER_PREFS_TABLE)] = array('pref_name');
	}

	if(defined('SHOP_TABLE')) {
		$tableKeys[strtolower(SHOP_TABLE)] = array('IntID');
	}

	if(defined('SCHEDULE_TABLE')) {
		$tableKeys[strtolower(SCHEDULE_TABLE)] = array('DID','Wann');
	}

	if(defined('CUSTOMER_ADMIN_TABLE')) {
		$tableKeys[strtolower(CUSTOMER_ADMIN_TABLE)] = array('Name');
	}

	if(defined('BANNER_PREFS_TABLE')) {
		$tableKeys[strtolower(BANNER_PREFS_TABLE)] = array('pref_name');
	}

	if(defined('BANNER_VIEWS_TABLE')) {
		$tableKeys[strtolower(BANNER_VIEWS_TABLE)] = array('viewid');
	}

	if(defined('BANNER_CLICKS_TABLE')) {
		$tableKeys[strtolower(BANNER_CLICKS_TABLE)] = array('clickid');
	}

	if(defined('WE_SHOP_VAT_TABLE')) {
		$tableKeys[strtolower(WE_SHOP_VAT_TABLE)] = array('id');
	}

	if(defined('GLOSSARY_TABLE')) {
		$tableKeys[strtolower(GLOSSARY_TABLE)] = array('ID');
	}

	if(defined('CUSTOMER_FILTER_TABLE')) {
		$tableKeys[strtolower(CUSTOMER_FILTER_TABLE)] = array('id');
	}

	if(defined('VALIDATION_SERVICES_TABLE')) {
		$tableKeys[strtolower(VALIDATION_SERVICES_TABLE)] = array('PK_tblvalidationservices');
	}

?>