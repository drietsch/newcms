<?php


class rpcCopyNavigationFolderView extends rpcView {
	
	
	function getResponse($response) {
		header('Content-type: text/plain');
		return $response->getData("folders");
	}	
}



?>