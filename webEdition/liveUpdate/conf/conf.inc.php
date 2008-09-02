<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/*
 * In this file constants and variables determining the behaviour of the
 * Liveupdate are set
 */

$_REQUEST["betaVersion"] = 5490;

// include files -> mainly stored in the application
define('LIVEUPDATE_LANGUAGE', $GLOBALS['WE_LANGUAGE']);
//define('LIVEUPDATE_LANGUAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/includes/language/' . LIVEUPDATE_LANGUAGE . '/');
define('LIVEUPDATE_LANGUAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . LIVEUPDATE_LANGUAGE . '/');

// include some files
define('LIVEUPDATE_CSS', '<link rel="stylesheet" href="/webEdition/liveUpdate/css/liveupdate.css" />');
define('LIVEUPDATE_TEMPLATE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/templates/');

define('LIVEUPDATE_SERVER', 'update.webedition.de');

if(isset($_REQUEST['section'])) {
	$_SESSION['liveUpdateSection'] = $_REQUEST['section'];

}

define('LIVEUPDATE_SERVER_SCRIPT', '/we55/liveUpdate.p' . 'hp');

define('LIVEUPDATE_SOFTWARE_DIR', $_SERVER['DOCUMENT_ROOT']);
define('LIVEUPDATE_CLIENT_DOCUMENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/');

// if the software uses a tblprefix - assign it here
define('LIVEUPDATE_TABLE_PREFIX', TBL_PREFIX);

// liveupdater contains the following actions
if ( defined('UID') ) {
	$updatecmds = array('update', 'modules', 'languages', 'updatelog', 'connect');
} else {
	$updatecmds = array('register', 'connect');
}

if(is_callable("set_time_limit") && strtolower(ini_get("safe_mode")) != "on" && ini_get("safe_mode") != "1") {
	@set_time_limit(180);
}
?>