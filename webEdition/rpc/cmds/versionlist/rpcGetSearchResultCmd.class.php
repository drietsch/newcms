<?php

class rpcGetSearchResultCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
				
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersionsView.class.inc.php");
		

		$we_transaction = $_REQUEST['we_cmd']['we_transaction'];

		$mode = $_REQUEST['we_cmd']['mode'];
		$order = $_REQUEST['we_cmd']['order'];
		$anzahl = $_REQUEST['we_cmd']['anzahl'];
		$searchstart = $_REQUEST['we_cmd']['searchstart'];
	
		$_REQUEST['we_cmd']['obj'] = 1;
		
		$content = weVersionsView::getVersionsOfDoc();
				
		$code = weVersionsView::tabListContent($searchstart,$anzahl,$content);
		
		$resp->setData("data",$code) ;
		
		return $resp;
	}
	

}

?>