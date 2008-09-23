<?php

class rpcSelectorSuggestCmd extends rpcCmd {
	function execute() {
		$resp = new rpcResponse();
				
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php");
		
		if (!isset($_REQUEST["we_cmd"][1]) || !isset($_REQUEST["we_cmd"][2])) exit();
		
		$selectorSuggest = new weSelectorQuery();
		$contentTypes = isset($_REQUEST["we_cmd"][3]) ? explode(",",$_REQUEST["we_cmd"][3]) : null;
		if(isset($_REQUEST["we_cmd"][4]) && !empty($_REQUEST["we_cmd"][4]) && isset($_REQUEST["we_cmd"][5]) && !empty($_REQUEST["we_cmd"][5])) {
			if ($_REQUEST["we_cmd"][2]=="tblTemplates" && $_REQUEST["we_cmd"][4]=="text/weTmpl") {
				$selectorSuggest->addCondition(array("AND", "<>","ID",$_REQUEST["we_cmd"][5]));
			}
		}
		$selectorSuggest->search($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],$contentTypes,"",(isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : ""));
		$resp->setData("data",$selectorSuggest->getResult()) ;
		
		return $resp;
	}
}

?>
