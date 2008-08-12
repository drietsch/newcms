<?php


class rpcGetSnippetCodeView extends rpcView {
	
	
	function getResponse($response) {
		header('Content-type: text/plain');
		return $response->getData("data");
		
	}
	
}



?>