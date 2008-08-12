<?php

class rpcShowPreparedPreviewView extends rpcView {
	
	function getResponse($response) {
		
		$html = $response->getData("data");
		
		return $html;
	}
	
}

?>