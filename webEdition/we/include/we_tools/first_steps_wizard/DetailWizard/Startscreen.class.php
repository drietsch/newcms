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

class Startscreen extends leWizardStepBase
{

	var $EnabledButtons = array(
		'next'
	);

	function execute(&$Template)
	{
		
		return LE_WIZARDSTEP_NEXT;
	
	}

	function check(&$Template)
	{
		
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