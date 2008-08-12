<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

protect();

// Load needed files for wizard
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/first_steps_wizard/includes/includes.inc.php');

// Load language file for first steps wizard
include_once($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] . '/tools/first_steps_wizard/master.inc.php');

$WizardCollection = new leWizardCollection('/we/include/we_tools/first_steps_wizard/master_wizards.inc.php');

if (isset($_REQUEST["leWizard"])) {
	print $WizardCollection->executeStep();

} else {
	include($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_tools/first_steps_wizard/includes/template.inc.php');

}

?>