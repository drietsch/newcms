<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_update
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/*
 * In this file constants and variables determining the behaviour of the
 * Liveupdate are set
 */

$_REQUEST["betaVersion"] = 5903;

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

define('LIVEUPDATE_SERVER_SCRIPT', '/server/we/liveUpdate.p' . 'hp');

define('LIVEUPDATE_SOFTWARE_DIR', $_SERVER['DOCUMENT_ROOT']);
define('LIVEUPDATE_CLIENT_DOCUMENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/');

// if the software uses a tblprefix - assign it here
define('LIVEUPDATE_TABLE_PREFIX', TBL_PREFIX);

// liveupdater contains the following actions
$updatecmds = array('update', 'languages', 'updatelog', 'connect');
if(is_callable("set_time_limit") && strtolower(ini_get("safe_mode")) != "on" && ini_get("safe_mode") != "1") {
	@set_time_limit(180);
}
?>