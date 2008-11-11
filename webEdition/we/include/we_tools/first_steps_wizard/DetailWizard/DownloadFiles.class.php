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