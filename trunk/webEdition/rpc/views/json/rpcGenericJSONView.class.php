<?php
class rpcGenericJSONView extends rpcView {
	
	function getResponse($response) {
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/JSON.php");
		$json = new Services_JSON();
		return $json->encode($response);
	}
}
?>