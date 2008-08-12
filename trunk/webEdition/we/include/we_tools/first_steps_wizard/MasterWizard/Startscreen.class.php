<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

class Startscreen extends leWizardStepBase {
	
	var $EnabledButtons = array('next');

	function execute(&$Template) {
		
		return LE_WIZARDSTEP_NEXT;

	}
	
	function check(&$Template) {
		
		$Parameters = array(
			"update_cmd" => "checkConnection"
		);

		$Response = liveUpdateHttpWizard::getHttpResponse(LIVEUPDATE_SERVER, LIVEUPDATE_SERVER_SCRIPT, $Parameters);
		$LiveUpdateResponse = new liveUpdateResponse();

		if ($LiveUpdateResponse->initByHttpResponse($Response)) {
			if ($LiveUpdateResponse->isError()) {
				$Template->addError($this->Language['error'] . ":<br />" . $LiveUpdateResponse->getField('Message'));
				return false;

			} else {
				return true;

			}

		} else {
			$Template->addError($this->Language['no_connection']);
			return false;

		}
		
	}

}


?>