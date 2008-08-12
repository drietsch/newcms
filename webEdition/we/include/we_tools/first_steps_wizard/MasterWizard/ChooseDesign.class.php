<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

class ChooseDesign extends leWizardStepBase {

	var $EnabledButtons = array('next', 'back');
	
	
	function execute(&$Template) {

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
	
	
	function check(&$Template) {
		
		return $this->executeOnline($Template, "snippet", "registerImport");
		
	}


}


?>