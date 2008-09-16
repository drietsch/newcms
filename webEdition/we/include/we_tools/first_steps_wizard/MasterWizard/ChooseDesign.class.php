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

class ChooseDesign extends leWizardStepBase
{

	var $EnabledButtons = array(
		'next', 'back'
	);

	function execute(&$Template)
	{
		
		// start the session on server
		if (!isset($_REQUEST["liveUpdateSession"]) || $_REQUEST["liveUpdateSession"] == "") {
			
			// use other template
			$Template->UseOnlineInstallerTemplate = false;
			
			$_REQUEST["update_cmd"] = $_REQUEST["leWizard"];
			$_REQUEST["detail"] = $_REQUEST["leStep"];
			
			$SessionForm = liveUpdateHttpWizard::getServerSessionForm();
			$Template->Output = $SessionForm;
		
		} else {
			$_REQUEST["ImportType"] = "master";
			return $this->executeOnline($Template, "snippet", "overview");
		
		}
	
	}

	function check(&$Template)
	{
		
		return $this->executeOnline($Template, "snippet", "registerImport");
	
	}

}

?>