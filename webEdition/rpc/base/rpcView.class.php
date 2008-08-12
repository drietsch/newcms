<?php

/**
 * Base class for views.
 * 
 * @package leFramework_core
 * @author Slavko Tomcic
 * @copyright living-e AG
 */

class rpcView {

	var $CmdShell;
	
	function getResponse($response){
		
	}
	
	function setCmdShell($cmdshell) {
		$this->CmdShell = $cmdshell;
	}
}
?>