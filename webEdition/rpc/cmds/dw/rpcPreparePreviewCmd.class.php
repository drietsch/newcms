<?php

class rpcPreparePreviewCmd extends rpcCmd {
	
	function execute() {
		
		$_SESSION["rpc_previewCode"] = $_REQUEST["source"];
		
		// an empty rpcResponse is enough
		$resp = new rpcResponse();
		return $resp;
	}
}

?>