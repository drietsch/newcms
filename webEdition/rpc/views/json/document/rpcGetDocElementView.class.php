<?php

class rpcGetDocElementView extends rpcView {
	
	function getResponse($response) {

		$html = $_REQUEST['element'] . ':'  .
		$response->getData($_REQUEST['element']);
		;

		return $html;
	}
}
?>