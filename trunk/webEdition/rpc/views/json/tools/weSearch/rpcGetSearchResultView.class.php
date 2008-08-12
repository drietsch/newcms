<?php


class rpcGetSearchResultView extends rpcView {
	
	
	function getResponse($response) {

		return $response->getData("data");
		
	}
	
}



?>