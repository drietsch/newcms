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
 * map needed variables for the program here, for example map version number
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_version.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');

$LU_Variables = array(

	// always needed variables
	'clientVersion' => WE_VERSION,
	'clientUid' => (defined('UID') ? UID : false),
	'clientSyslng' => WE_LANGUAGE,
	'clientLng' => $GLOBALS['WE_LANGUAGE'],
	'clientExtension' => '.php',
	'clientDomain' => urlencode($_SERVER['SERVER_NAME']),
	'clientInstalledModules' => array_merge($_we_installed_modules, $_pro_modules),
	'clientInstalledLanguages' => liveUpdateFunctions::getInstalledLanguages(),
	'clientUpdateUrl' => liveUpdateHttp::getServerProtocol() . SERVER_NAME . (defined("HTTP_PORT") ? ":" . HTTP_PORT : "" ) . $_SERVER["PHP_SELF"],
	'clientContent' => false,
	'clientEncoding' => 'none'
);


// These request variables listed here are NOT submitted to the server - fill it
// to keep requests small
$LU_IgnoreRequestParameters = array(
	'we_mode',
	'cookie',
	'treewidth_main',
	session_name(),
	'we'.session_id()
);
?>