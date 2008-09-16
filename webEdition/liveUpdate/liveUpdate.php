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

if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php");
}
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we5light.inc.php")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we5light.inc.php");
}

/*
 * Include all needed files
 */
	require_once('includes/includes.inc.php');
	protect();

/*
 * Deal with update_cmd
 */
if (isset($_REQUEST['update_cmd'])) {

	/*
	 * Gather all needed Variables for the update-Request
	 */
	$parameters = array();

	foreach ($LU_ParameterNames as $parameterName) {

		if (isset($_REQUEST[$parameterName])) {
			$parameters[$parameterName] = $_REQUEST[$parameterName];
		}
	}

	// this is flag to check if a response was received!
	$response = false;

	/*
	 * For command checkConnection, it is not needed to create a session on the
	 * server. Therefore treat this command in a special way.
	 */
	if ($_REQUEST['update_cmd'] == 'checkConnection') {

		$response = liveUpdateHttp::getHttpResponse(LIVEUPDATE_SERVER, LIVEUPDATE_SERVER_SCRIPT, $parameters);
		$liveUpdateResponse = new liveUpdateResponse();

		if ($liveUpdateResponse->initByHttpResponse($response)) {

			if ( $liveUpdateResponse->isError() ) {
				print liveUpdateFrames::htmlConnectionSuccess($liveUpdateResponse->getField('Message'));
			} else {
				print liveUpdateFrames::htmlConnectionSuccess();
			}
		} else {
			print liveUpdateFrames::htmlConnectionError();
		}
		exit();

	/*
	 * check connection befor trying to register:
	 */
	} else if($_REQUEST['update_cmd'] == 'register') {
		$parametersConnectionCheck = array("update_cmd" => "checkConnection", "clientLng" => $GLOBALS["WE_LANGUAGE"]);
		$responseConnectionCheck = liveUpdateHttp::getHttpResponse(LIVEUPDATE_SERVER, LIVEUPDATE_SERVER_SCRIPT, $parametersConnectionCheck);
		$liveUpdateResponseConnectionCheck = new liveUpdateResponse();

		if ($liveUpdateResponseConnectionCheck->initByHttpResponse($responseConnectionCheck)) {

			if ( $liveUpdateResponseConnectionCheck->isError() ) {
				print liveUpdateFrames::htmlConnectionSuccess($liveUpdateResponseConnectionCheck->getField('Message'));
				exit();
			}
		} else {
			print liveUpdateFrames::htmlConnectionError();
			exit();
		}
		
		
	/*
	 * normal command flow - execute command, or init the communication
	 */
	}

	/*
	 * Before an update_cmd is submitted to the server, there must be an
	 * existing session on the server. $_REQUEST[liveUpdateSession] contains
	 * the session_id of the server. If this id is missing, create a new
	 * session on the server.
	 */
	if (!isset($_REQUEST['liveUpdateSession'])) {

		/*
		 * exit after submitting the form
		 */
		print liveUpdateHttp::getServerSessionForm();
		exit;

	} else {
		/*
		 * $_REQUEST['liveUpdateSession'] exists => Session on server is up
		 * prepare all needed variables to submit to the updateServer
		 * These are stored in $LU_ParameterNames
		 */

		// add all other request parameters to the request
		$reqVars = array();
		foreach ($_REQUEST as $key => $value) {
			if (!isset($parameters[$key]) && !in_array($key, $LU_IgnoreRequestParameters)) {
				$reqVars[$key] = $value;
			}
		}
		$parameters['reqArray'] = base64_encode(serialize($reqVars));

		$response = liveUpdateHttp::getHttpResponse(LIVEUPDATE_SERVER, LIVEUPDATE_SERVER_SCRIPT, $parameters);
	}

	/*
	 * There is a response from the Update-Server.
	 */
	if ($response) {

		$liveUpdateResponse = new liveUpdateResponse();

		if ($liveUpdateResponse->initByHttpResponse($response)) {

			print $liveUpdateResponse->getOutput();

		} else {
			print liveUpdateFrames::htmlConnectionError();
		}

	} else {
		/*
		 * No response from the update-server. Error message
		 */
		print liveUpdateFrames::htmlConnectionError();
	}

} else {
	/*
	 * No update_cmd exists, show normal frameset
	 */
	$updateFrames = new liveUpdateFrames();
	print $updateFrames->getFrame();
}

?>