<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+


class leWizard {

	var $IsCurrent = false;
	var $Name = "";

	var $LastStep    = null;
	var $CurrentStep = null;
	var $NextStep    = null;

	var $WizardSteps = array();

	function leWizard($Name, $Path) {
		$this->__construct($Name, $Path);

	}

	function __construct($Name, $Path) {
		$this->Name = $Name;

		if (file_exists($Path . $this->Name . "/steps.inc.php")) {

			// get names of steps in the wizard
			require_once($Path . $this->Name . "/steps.inc.php");

			foreach ($leInstallerSteps as $Step) {
				if (file_exists($Path . $this->Name . "/" . $Step . ".class.php")) {
					require_once($Path . $this->Name . "/" . $Step . ".class.php");
					$Classname = $Step;

				} else {
					die("Cannot load class '" . $Step . "'!");

				}

				$Language = array();
				if(array_key_exists($Step, $GLOBALS['lang']['Step'])) {
					$Language = $GLOBALS['lang']['Step'][$Step];

				}
				$this->WizardSteps[] = new $Classname($Classname, $this, $Language);

			}
		}

	}

	/**
	 * sets this wizard current, calls function to determine current step
	 */
	function setCurrent() {
		$this->IsCurrent = true;
		$this->initialize();

	}

	/**
	 * @param string $name
	 * @return leWizardStep
	 */
	function getWizardStepIndexByName($Name) {
		for ($i = 0; $i < sizeof($this->WizardSteps); $i++) {
			if ($this->WizardSteps[$i]->Name == $Name) {
				return $i;

			}

		}
		return null;

	}

	/**
	 * @param string $name
	 * @return leWizardStep
	 */
	function getWizardStepByName($Name) {
		return $this->WizardSteps[$this->getWizardStepIndexByName($Name)];

	}

	/**
	 * selects current active step, regarding request variables
	 */
	function initialize() {

		// detect current wizard regarding request-var "leWizard"
		if (isset($_REQUEST["leStep"])) {
			if ( is_int($index = $this->getWizardStepIndexByName($_REQUEST["leStep"])) ) {
				$this->CurrentStep = & $this->WizardSteps[$index];

			}

		}

		if (!$this->CurrentStep) {
			$this->CurrentStep = & $this->WizardSteps[0];

		}

	}

	/**
	 * @return string
	 */
	function getName() {
		return $this->Name;

	}

}

?>