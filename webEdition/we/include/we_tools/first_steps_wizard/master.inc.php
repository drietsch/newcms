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

protect();

// Load needed files for wizard
require_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/first_steps_wizard/includes/includes.inc.php');

// Load language file for first steps wizard
include_once ($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_language/' . $GLOBALS["WE_LANGUAGE"] . '/tools/first_steps_wizard/master.inc.php');

$WizardCollection = new leWizardCollection('/we/include/we_tools/first_steps_wizard/master_wizards.inc.php');

if (isset($_REQUEST["leWizard"])) {
	print $WizardCollection->executeStep();

} else {
	include ($_SERVER["DOCUMENT_ROOT"] . '/webEdition/we/include/we_tools/first_steps_wizard/includes/template.inc.php');

}

?>