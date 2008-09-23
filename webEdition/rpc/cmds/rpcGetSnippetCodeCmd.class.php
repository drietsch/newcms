<?php

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