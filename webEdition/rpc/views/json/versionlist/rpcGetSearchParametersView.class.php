<?php


class rpcGetSearchParametersView extends rpcView {
	
	
	function getResponse($response) {

		return $response->getData("data");
		
	}
	
}



?>