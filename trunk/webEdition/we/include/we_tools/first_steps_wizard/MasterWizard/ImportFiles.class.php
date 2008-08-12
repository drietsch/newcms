<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

class ImportFiles extends leWizardStepBase {

	var $EnabledButtons = array('back', 'next', 'reload');

	var $ProgressBarVisible = true;
	
	function execute(&$Template) {
		
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/import.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_tagParser.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_parser.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_splitFile.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_validate.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/xml_import.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/csv.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_baseCollection.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_baseElement.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/we_wizard.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/we_wiz_import.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_import/we_wizard_seem.inc.php");
		
		$wizard = new we_wizard_import();
				
		$Template->UseOnlineInstallerTemplate = false;
		$Output = $wizard->getWizCmd('first_steps_wizard');
		
		$Template->addJavascript("top.document.getElementById('leWizardHeadline').innerHTML = '" . $this->Language['headline']. "';");
		$Template->addJavascript("top.document.getElementById('leWizardContent').innerHTML = '<p>" . $this->Language['content']. "</p>';");
		$Template->addJavascript("top.document.getElementById('leWizardDescription').innerHTML = '<p>" . $this->Language['description']. "</p>';");
		
		
		$Javascript	=	"script type=\"text/javascript\">"
					.	"top.document.getElementById('leWizardHeadline').innerHTML = '" . $this->Language['headline']. "';"
					.	"top.document.getElementById('leWizardContent').innerHTML = '<p>" . $this->Language['content']. "</p>';"
					.	"top.document.getElementById('leWizardDescription').innerHTML = '<p>" . $this->Language['description']. "</p>';"
					.	"top.leWizardForm.setInputField('leWizard', '". $GLOBALS['WizardCollection']->NextStep->getWizardName(). "');"
					.	"top.leWizardForm.setInputField('leStep', '". $GLOBALS['WizardCollection']->NextStep->getName() . "');"
					.	"</script>";
		$Template->Output = preg_replace("</head>", $Javascript . "</head", $Output);
		
		return LE_WIZARDSTEP_NEXT;
		
	}
	
}


?>