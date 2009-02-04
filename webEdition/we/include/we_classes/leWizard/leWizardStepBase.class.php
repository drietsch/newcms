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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


class leWizardStepBase {

	/**
	 * The name of the step
	 *
	 * @var string
	 */
	var $Name = "";

	/**
	 * The wizard object of the step
	 *
	 * @var object
	 */
	var $Wizard = null;

	/**
	 * This array define all buttons which are enabled per default
	 *
	 * @var array
	 */
	var $EnabledButtons = array('back', 'next');

	/**
	 * Should the progress bar shown at this step
	 *
	 * @var boolean
	 */
	var $ProgressBarVisible = false;

	/**
	 * This step is a screen which could autocontinue (only information
	 * screen)
	 *
	 * @var integer
	 */
	var $AutoContinue = -1;

	/**
	 * This step is a iteration step and repeats until a break criteria is
	 * reached
	 *
	 * @var boolean
	 */
	var $IterationStep = false;

	/**
	 * Should this step be shown in the status bar / naviagtion
	 *
	 * @var boolean
	 */
	var $ShowInStatusBar = true;

	/**
	 * This step is a server controlled step
	 *
	 * @var boolean
	 */
	var $ServerControlled = true;

	/**
	 * Headline to display in template
	 *
	 * @var string
	 */
	var $Headline = "";

	/**
	 * Content to display in template
	 *
	 * @var string
	 */
	var $Content = "";

	/**
	 * Language
	 *
	 * @var array
	 */
	var $Language = array();

	/**
	 * Did the check failed
	 *
	 * @var boolean
	 */
	var $CheckFailed = false;

	/**
	 * @var liveUpdateResponse
	 */
	var $liveUpdateHttpResponse = null;


	/**
	 * PHP4 Constructor
	 *
	 */
	function leWizardStepBase($Name, $WizardObj, $Language = array()) {
		$this->__construct($Name, $WizardObj, $Language);

	}


	/**
	 * PHP5 Constructor
	 *
	 */
	function __construct($Name, $WizardObj, $Language = array()) {
		$this->Name = $Name;
		$this->Wizard = $WizardObj;
		$this->Language = $Language;

	}


	/**
	 * set the headline
	 *
	 * @param string $Headline
	 */
	function setHeadline($Headline) {
		$this->Headline = $Headline;

	}


	/**
	 * set the content
	 *
	 * @param string $Content
	 */
	function setContent($Content) {
		$this->Content = $Content;

	}


	/**
	 * return the name of the step
	 *
	 * @return string
	 */
	function getName() {
		return $this->Name;

	}


	/**
	 * return the name of the wizard
	 *
	 * @return string
	 */
	function getWizardName() {
		return $this->Wizard->getName();

	}


	/**
	 * get the url for this step
	 *
	 * @return string
	 */
	function getUrl() {

		$debug = "";
		if(isset($_REQUEST['debug'])) {
			$debug = "&debug=" . $_REQUEST['debug'];

		}
		return  WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=" . $_REQUEST['we_cmd'][0] . "&leWizard=" . $this->getWizardName() . "&leStep=" . $this->Name . $debug;

	}


	/**
	 * Execute the preparation of the step, liek setting cookies for example
	 *
	 * @return booelan
	 */
	function prepare() {
		return true;

	}


	function execute(&$Template) {
		return LE_WIZARDSTEP_NEXT;

	}


	/**
	 * executes a step at the live update / online installation server
	 *
	 * @param leWizardTemplateBase $Template
	 * @param string $UpdateCmd
	 * @param string $UpdateCmdDetail
	 * @return integer
	 */
	function executeOnline(&$Template, $UpdateCmd = "", $UpdateCmdDetail = "") {

		if($UpdateCmd != "") {
			$_REQUEST['update_cmd'] = $UpdateCmd;

		} else {
			$_REQUEST['update_cmd'] = $this->Wizard->Name;

		}

		if($UpdateCmdDetail != "") {
			$_REQUEST['detail'] = $UpdateCmdDetail;

		} else {
			$_REQUEST['detail'] = $this->Name;

		}

		$this->liveUpdateHttpResponse = $this->getLiveUpdateHttpResponse();

		if($this->liveUpdateHttpResponse) {

			if($this->liveUpdateHttpResponse->Type == "executeOnline") {

				$code = $this->liveUpdateHttpResponse->Code;
				$this->liveUpdateHttpResponse = null;

				return eval('?>' . $code);

			}

		}

		return LE_WIZARDSTEP_NEXT;

	}


	/**
	 * Do some validation
	 *
	 * @return boolean
	 */
	function check(&$Template) {
		return true;

	}

	/**
	 * @return liveUpdateResponse
	 */
	function getLiveUpdateHttpResponse() {

		global $LU_IgnoreRequestParameters, $LU_ParameterNames;

		$parameters = array();

		foreach ($LU_ParameterNames as $parameterName) {

			if (isset($_REQUEST[$parameterName])) {
				$parameters[$parameterName] = $_REQUEST[$parameterName];
			}
		}

		// add nextWizardStep to parameters.
		$parameters["nextLeWizard"] = $GLOBALS["WizardCollection"]->NextStep->getWizardName();
		$parameters["nextLeStep"] = $GLOBALS["WizardCollection"]->NextStep->getName();
		$parameters["update_cmd"] = $_REQUEST['update_cmd'];
		$parameters["detail"] = $_REQUEST['detail'];

		// add all other request parameters to the request
		$reqVars = array();
		foreach ($_REQUEST as $key => $value) {
			if (!isset($parameters[$key]) && !in_array($key, $LU_IgnoreRequestParameters)) {
				$reqVars[$key] = $value;
			}
		}

		$parameters['reqArray'] = serialize($reqVars);
		$response = liveUpdateHttpWizard::getHttpResponse(LIVEUPDATE_SERVER, LIVEUPDATE_SERVER_SCRIPT, $parameters);
		$liveUpdateResponse = new liveUpdateResponse();

		$liveUpdateResponse->initByHttpResponse($response);

		return $liveUpdateResponse;
	}

}

?>