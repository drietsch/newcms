<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

class DownloadFiles extends leWizardStepBase {

	var $EnabledButtons = array('reload');

	var $ProgressBarVisible = true;


	function execute(&$Template) {
		
		$Template->addJavascript("top.document.getElementById('leWizardHeadline').innerHTML = '" . $this->Language['headline']. "';");
		$Template->addJavascript("top.document.getElementById('leWizardContent').innerHTML = '<p>" . $this->Language['content']. "</p>';");
		$Template->addJavascript("top.document.getElementById('leWizardDescription').innerHTML = '<p>" . $this->Language['description']. "</p>';");
		
		$this->liveUpdateHttpResponse = $this->getLiveUpdateHttpResponse();

		return LE_WIZARDSTEP_NEXT;

	}

}


?>