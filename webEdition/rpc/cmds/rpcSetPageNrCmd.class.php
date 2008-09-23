<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_session.inc.php");

class rpcSetPageNrCmd  extends rpcCmd {

	function execute() {
		$we_transaction = isset($_REQUEST['transaction']) ? $_REQUEST['transaction'] : '';
		if (isset($_SESSION["we_data"][$we_transaction])) {
			$_SESSION["we_data"][$we_transaction][0]['EditPageNr'] = $_REQUEST['editPageNr'];
		}
		$resp = new rpcResponse();
    	return $resp;
	}
	
}

?>
