<?php

class rpcSelectorGetSelectedIdCmd extends rpcCmd {
	
	function execute() {
		$resp = new rpcResponse();
				
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php");
		
		if (!isset($_REQUEST["we_cmd"][1]) || !isset($_REQUEST["we_cmd"][2])) exit();
		
		$selectorSuggest = new weSelectorQuery();
		$contentTypes = isset($_REQUEST["we_cmd"][3]) ? explode(",",$_REQUEST["we_cmd"][3]) : null;
		$selectorSuggest->queryTable($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],$contentTypes);
		$resp->setData("data",$selectorSuggest->getResult()) ;
		
		return $resp;
	}
}

?>
