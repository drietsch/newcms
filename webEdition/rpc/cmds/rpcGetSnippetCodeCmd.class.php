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
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

class rpcGetSnippetCodeCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
				
		include_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/weCodeWizard/classes/weCodeWizardSnippet.inc.php");
		include_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/weCodeWizard/classes/weCodeWizard.inc.php");
		
		if (!isset($_REQUEST["we_cmd"][1])) exit();
		
		$CodeWizard = new weCodeWizard();
		if(!is_file($CodeWizard->SnippetPath . $_REQUEST["we_cmd"][1])) {
			exit();
			
		}
		
		$Snippet = weCodeWizardSnippet::initByXmlFile($CodeWizard->SnippetPath . $_REQUEST["we_cmd"][1]);
		$Code = $Snippet->getCode("UTF-8");
				
		$resp->setData("data",$Code) ;
		
		return $resp;
	}
}

?>