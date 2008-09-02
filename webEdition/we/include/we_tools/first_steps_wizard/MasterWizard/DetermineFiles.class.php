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

class DetermineFiles extends leWizardStepBase
{

	var $EnabledButtons = array(
		'reload'
	);

	var $ProgressBarVisible = true;

	function execute(&$Template)
	{
		
		$Template->addJavascript(
				"top.document.getElementById('leWizardHeadline').innerHTML = '" . $this->Language['headline'] . "';");
		$Template->addJavascript(
				"top.document.getElementById('leWizardContent').innerHTML = '<p>" . $this->Language['content'] . "</p>';");
		$Template->addJavascript(
				"top.document.getElementById('leWizardDescription').innerHTML = '<p>" . $this->Language['description'] . "</p>';");
		
		$_REQUEST['update_cmd'] = "snippet";
		$_REQUEST['detail'] = "determineFiles";
		
		$this->liveUpdateHttpResponse = $this->getLiveUpdateHttpResponse();
		return LE_WIZARDSTEP_NEXT;
	
	}

}

?>