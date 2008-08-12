<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

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