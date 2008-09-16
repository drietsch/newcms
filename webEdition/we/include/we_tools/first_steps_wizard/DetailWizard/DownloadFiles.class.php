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

class DownloadFiles extends leWizardStepBase
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
				"top.document.getElementById('leWizardDescription').innerHTML = '" . $this->Language['description'] . "';");
		
		$this->liveUpdateHttpResponse = $this->getLiveUpdateHttpResponse();
		
		return LE_WIZARDSTEP_NEXT;
	
	}

}

?>