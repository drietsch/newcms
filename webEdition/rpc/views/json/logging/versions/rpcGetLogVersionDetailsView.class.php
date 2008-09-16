<?php


class rpcGetLogVersionDetailsView extends rpcView {
	
	
	function getResponse($response) {

		return $response->getData("data");
		
	}
	
}



?>