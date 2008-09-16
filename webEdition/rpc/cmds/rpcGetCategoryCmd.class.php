<?php

class rpcGetCategoryCmd extends rpcCmd {
	
	function execute() {
		$resp = new rpcResponse();
		$_error = array();
		// check for necessory params
		if(!isset($_REQUEST['obj']) || $_REQUEST['obj']=="") {
			$_error[] = "Missing field obj";
		} 
		if(!isset($_REQUEST['cats']) || $_REQUEST['cats']=="") {
			$_error[] = "Missing field cats";
		} 
		if(isset($_REQUEST['part']) && $_REQUEST['part']=="table" && (!isset($_REQUEST['target']) || $_REQUEST['target']=="")) {
			$_error[] = "Missing target for table";
		} 
		
		if (count($_error) > 0) {
			$resp->setData("error",$_error);
		} else {
			$part = (isset($_REQUEST['part']) && $_REQUEST['part']!="") ? $_REQUEST['part'] : "rows";
			$target = (isset($_REQUEST['target']) && $_REQUEST['target']!="") ? $_REQUEST['target'] : $_REQUEST['obj']."CatTable";
			$catField = (isset($_REQUEST['catfield']) && $_REQUEST['catfield']!="") ? $_REQUEST['catfield'] : "";
			$categories = $this->getCategory($_REQUEST['obj'],$_REQUEST['cats'],$catField,$part);
			$categories = strtr($categories, array("\r" => "","\n"=>""));
			$resp->setData("elementsById",
				array($target => array("innerHTML" => addslashes($categories)))
			);
			
		}
		return $resp;
	}

	function getCategory($obj, $categories, $catField="", $as="table") {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser2.inc.php");
		$cats = new MultiDirChooser2(410,$categories,"delete_".$obj."Cat","","","Icon,Path",CATEGORY_TABLE);
		$cats->setRowPrefix($obj);
		$cats->setCatField($catField);
		return $cats->getTableRows();
	}
}
?>