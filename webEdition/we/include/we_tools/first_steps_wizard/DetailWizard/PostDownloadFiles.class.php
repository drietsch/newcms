<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

class PostDownloadFiles extends leWizardStepBase {

	var $EnabledButtons = array('next');

	function execute(&$Template) {
		
		return LE_WIZARDSTEP_NEXT;

	}
	
	function check(&$Template) {
		
		return true;
		
	}

}


?>