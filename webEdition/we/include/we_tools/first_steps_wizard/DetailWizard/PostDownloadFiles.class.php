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

class PostDownloadFiles extends leWizardStepBase
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
		
		return true;
	
	}

}

?>