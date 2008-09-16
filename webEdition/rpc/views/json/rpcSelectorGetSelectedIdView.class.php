<?php


class rpcSelectorGetSelectedIdView extends rpcView {
	
	
	function getResponse($response) {

		header('Content-type: text/plain');
		$suggests = $response->getData("data");		
		$html = "";
		if (is_array($suggests)) {
			$html .= $suggests[0]['ID'];
		}
		return $html;
	}
}



?>