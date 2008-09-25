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



class leWizardCollection {

	/**
	 * @var array
	 */
	var $Wizards = array();

	/**
	 * @var array
	 */
	var $WizardNames = array();

	/**
	 * @var array
	 */
	var $WizardStepNames = array();

	/**
	 * @var leWizard
	 */
	var $CurrentWizard = null;

	/**
	 * @var leWizardStep
	 */
	var $CurrentStep   = null;

	/**
	 * @var leWizardStep
	 */
	var $BackStep   = null;

	/**
	 * @var leWizardStep
	 */
	var $NextStep   = null;


	function leWizardCollection($WizardsFile) {
		$this->__construct($WizardsFile);

	}

	function __construct($WizardsFile) {

		unset($leInstallerWizards);
		if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/webEdition" . $WizardsFile)) {
			require($_SERVER["DOCUMENT_ROOT"] . "/webEdition" . $WizardsFile);

			$WizardPath = dirname($_SERVER["DOCUMENT_ROOT"] . "/webEdition" . $WizardsFile) . '/';

			for ($i = 0; $i<sizeof($leInstallerWizards); $i++) {
				$temp = new leWizard($leInstallerWizards[$i], $WizardPath);

				// array with all steps
				foreach ($temp->WizardSteps as $Step) {
					$this->WizardStepNames[][$leInstallerWizards[$i]] = $Step->Name;

				}
				$this->Wizards[] = $temp;

			}

		} else {
			die("Cannot load Wizard File '" . $WizardsFile . "'!");

		}

		$this->initialize();

	}


	/**
	 * returns index (position) of wizard by name
	 *
	 * @param string $name
	 * @return integer
	 */
	function getWizardIndexByName($name) {
		for ($i=0; $i<sizeof($this->Wizards); $i++) {
			if ($this->Wizards[$i]->Name == $name) {
				return $i;

			}

		}
		return null;
	}


	/**
	 * @param string $name
	 * @return leWizard
	 */
	function getWizardByName($name) {
		return $this->Wizards[$this->getWizardIndexByName($name)];

	}


	function initialize() {

		if (isset($_REQUEST["leWizard"])) {

			if ( is_int($index = $this->getWizardIndexByName($_REQUEST["leWizard"])) ) {
				$this->CurrentWizard = & $this->Wizards[$index];

			}

		}

		if (!$this->CurrentWizard) {
			$this->CurrentWizard = & $this->Wizards[0];

		}

		// now set a wizard as current
		if ($this->CurrentWizard) {

			$this->CurrentWizard->setCurrent();
			$this->CurrentStep = $this->CurrentWizard->CurrentStep;

			// init next Step
			$this->BackStep = $this->getLastWizardStep();

			// init last Step
			$this->NextStep = $this->getNextWizardStep();

		}

	}

	function getFirstStepUrl() {
		
		$debug = "";
		if(isset($_REQUEST['debug'])) {
			$debug = "&debug=1";
		}

		if ( isset($_REQUEST["binaryInstaller"]) ) {
			return WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=" . $_REQUEST['we_cmd'][0] . "&leWizard=Welcome&leStep=ConnectionHint" . $debug;

		} else {
			$WizardName = $this->Wizards[0]->Name;
			$StepName = $this->Wizards[0]->WizardSteps[0]->Name;
			return WEBEDITION_DIR . "we_cmd.php?we_cmd[0]=" . $_REQUEST['we_cmd'][0] . "&leWizard=" . $WizardName . "&leStep=" . $StepName . $debug;

		}

	}


	/**
	 * @return leStep
	 */
	function getNextWizardStep() {

		$wizardStepInformation = $this->_getCurrentWizardStepInformation();
		$currentPosition = $wizardStepInformation["position"];

		$nextPosition = ($currentPosition + 1);

		if (isset($this->WizardStepNames[$nextPosition])) {

			$nextStep = $this->WizardStepNames[$nextPosition];

			list ($wizardName, $wizardStepName) = each($nextStep);

			$nextWizard = $this->getWizardByName($wizardName);
			$nextWizardStep = $nextWizard->getWizardStepByName($wizardStepName);
			return $nextWizardStep;

		}
		return null;
	}


	/**
	 * @return leWizardStep
	 */
	function getLastWizardStep() {

		$wizardStepInformation = $this->_getCurrentWizardStepInformation();
		$currentPosition = $wizardStepInformation["position"];

		$lastPosition = ($currentPosition - 1);

		if (isset($this->WizardStepNames[$lastPosition])) {

			$nextStep = $this->WizardStepNames[$lastPosition];

			list ($wizardName, $wizardStepName) = each($nextStep);

			$nextWizard = $this->getWizardByName($wizardName);
			$nextWizardStep = $nextWizard->getWizardStepByName($wizardStepName);

			return $nextWizardStep;
		}
		return null;
	}


	/**
	 * @access private
	 * @return array
	 */
	function _getCurrentWizardStepInformation() {

		$i=0;

		$current = null;

		foreach ($this->WizardStepNames as $wizStep) {
			foreach ($wizStep as $wizard => $wizardStep) {

				if ($this->CurrentWizard->Name == "$wizard" && $this->CurrentStep->Name == "$wizardStep") {

					$current = array(
						"position" => $i,
						"wizard" => $wizard,
						"wizardStep" => $wizardStep
					);
					return $current;
				}
				$i++;
			}
		}
		return null;
	}


	/**
	 * @return string
	 */
	function executeStep() {

		$Template = new leWizardTemplateBase();

		if ( $this->BackStep && !isset($_REQUEST["backStep"]) && !$this->BackStep->check($Template) ) {


			$this->BackStep->CheckFailed = true;

			$this->CurrentWizard = & $this->BackStep->Wizard;
			$this->CurrentStep = clone ($this->BackStep);

			$this->CurrentStep->execute($Template);

			$this->BackStep = $this->getLastWizardStep();
			$this->NextStep = $this->getNextWizardStep();

		} else { // excute current step

			switch ($this->CurrentStep->execute($Template)) {

				// all was fine, open next step
				case LE_WIZARDSTEP_NEXT:
					if ($this->NextStep) {
						$this->NextStep->prepare();

					}
					break;

				case LE_WIZARDSTEP_ITERATE:
					break;

				// error with step repeat it
				case LE_WIZARDSTEP_ERROR:
					$this->NextStep = $this->CurrentStep;
					break;

				// only back button is enabled
				case LE_WIZARDSTEP_FATAL_ERROR:
					$this->CurrentStep->EnabledButtons = array('back');
					break;

			}

		}


		$Template->setButtons($this->NextStep, $this->BackStep);

		print $Template->getOutput($this->CurrentStep);


	}


}


?>