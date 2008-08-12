<?php


class rpcGetMouseOverDivsView extends rpcView {
	
	
	function getResponse($response) {

		return $response->getData("data");
		
	}
	
}



?>