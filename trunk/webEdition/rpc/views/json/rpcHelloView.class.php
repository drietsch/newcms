<?php

class rpcHelloView extends rpcView {
	
	
	function getResponse($response) {
		
		$html = '
			Hallo World!	
		';
		
		return $html;
	}
}
?>