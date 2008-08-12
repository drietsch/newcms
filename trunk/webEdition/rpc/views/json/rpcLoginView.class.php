<?php

class rpcLoginView extends rpcView {
	
	
	function getResponse($response) {
	
		if($response->getStatus()==RPC_STATUS_OK) {
		
			$html = 'LOGIN OK<br>';
			
				
		} else {
			
			$html = 'LOGIN FAILED:' . $response->getReason();
			
		}
		
		return $html;
		
	}
}
?>