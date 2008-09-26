<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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
			$_REQUEST["ImportType"] = "detail";
			return $this->executeOnline($Template, "snippet", "overview");
		
		}
	
	}

	function check(&$Template)
	{
		
		return $this->executeOnline($Template, "snippet", "registerImport");
	
	}

}

?>