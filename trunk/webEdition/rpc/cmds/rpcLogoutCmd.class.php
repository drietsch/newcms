<?php


	class rpcLogoutCmd extends rpcCmd {
		
		function execute() {
			
			$resp = new rpcResponse();

			// reset session
			$_SESSION['user'] = array();
			$_SESSION['prefs'] = array();
			$_SESSION['perms'] = array();
			$_SESSION['we_data'] = array();
			
			return $resp;
				
		}
	
		
	}


?>