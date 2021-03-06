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

class ImportFiles extends leWizardStepBase
{

	var $EnabledButtons = array(
		'back', 'next', 'reload'
	);

	var $ProgressBarVisible = true;

	function execute(&$Template)
	{
		
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/import.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_tagParser.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/xml_parser.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/xml_splitFile.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/xml_validate.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/xml_import.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/csv.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_baseCollection.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_baseElement.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/base/weFile.class.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_import/we_wizard.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_import/we_wiz_import.inc.php");
		
		$wizard = new we_wizard_import();
		
		$Template->UseOnlineInstallerTemplate = false;
		$Output = $wizard->getWizCmd('first_steps_wizard');
		
		$Template->addJavascript(
				"top.document.getElementById('leWizardHeadline').innerHTML = '" . $this->Language['headline'] . "';");
		$Template->addJavascript(
				"top.document.getElementById('leWizardContent').innerHTML = '<p>" . $this->Language['content'] . "</p>';");
		$Template->addJavascript(
				"top.document.getElementById('leWizardDescription').innerHTML = '<p>" . $this->Language['description'] . "</p>';");
		
		$Javascript = "script type=\"text/javascript\">" . "top.document.getElementById('leWizardHeadline').innerHTML = '" . $this->Language['headline'] . "';" . "top.document.getElementById('leWizardContent').innerHTML = '<p>" . $this->Language['content'] . "</p>';" . "top.document.getElementById('leWizardDescription').innerHTML = '<p>" . $this->Language['description'] . "</p>';" . "top.leWizardForm.setInputField('leWizard', '" . $GLOBALS['WizardCollection']->NextStep->getWizardName() . "');" . "top.leWizardForm.setInputField('leStep', '" . $GLOBALS['WizardCollection']->NextStep->getName() . "');" . "</script>";
		$Template->Output = preg_replace("</head>", $Javascript . "</head", $Output);
		
		return LE_WIZARDSTEP_NEXT;
	
	}

}

?>