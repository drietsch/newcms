<?php

class rpcGetLogVersionDetailsCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
				
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLogView.class.php");
		

		$id = $_REQUEST['id'];
				
		$code = versionsLogView::handleData($id);
		
		$resp->setData("data",$code) ;
		
		return $resp;
	}
	

}

?>