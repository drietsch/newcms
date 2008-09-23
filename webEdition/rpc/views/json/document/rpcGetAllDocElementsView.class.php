<?php

class rpcGetAllDocElementsView extends rpcView {
	
	function getResponse($response) {

		
		ob_start();
		print_r($response->getData('elements'));
		$out = ob_get_contents();
		ob_end_clean();
		
		$html = 
		'<pre>element:'  .
		$out . '</pre>'
		;
		
		return $html;
	}
}
?>