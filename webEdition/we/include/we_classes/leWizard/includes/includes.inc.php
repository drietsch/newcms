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

/**
 *
 * Load all necessary files for the wizard
 *
 */

// Some constants for LiveUpdate Functions
if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/liveUpdate/includes/proxysettings.inc.php");
	
}
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/includes/define.inc.php');

// Live Update Classes
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/classes/liveUpdateHttp.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/liveUpdate/classes/liveUpdateTemplates.class.php');


// Some constants for Wizard
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/includes/define.inc.php');

// Wizard Classes
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizard.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizardCollection.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizardContent.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizardProgress.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizardStatus.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizardStepBase.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/leWizardTemplateBase.class.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/liveUpdateFunctions.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/liveUpdateResponse.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/liveUpdateHttpWizard.class.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/leWizard/liveUpdateTemplatesWizard.class.php');

?>