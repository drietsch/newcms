<?php

class rpcJsonView {
	
	var $CmdShell;
	
	function setCmdShell($cmdshell) {
		$this->CmdShell = $cmdshell;
	}
	
	
	/**
	 * @param rpcResponse $response
	 * @return string
	 */
	function getResponse( $response ) {
		
		if ( $response->Success ) {
			$status = "response";

		} else {
			$status = "error";
		}
		
		// DONT TOUCH THIS -  this is also  used forDreamweaver extension !!!!
		return 
		'var weResponse = {
			"type":"' . $status . '",
			"data":"' . addslashes($response->getData("data")) . '"
		};'
		;
	}
}

?>