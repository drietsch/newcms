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