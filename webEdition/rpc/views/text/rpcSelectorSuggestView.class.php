<?php


class rpcSelectorSuggestView extends rpcView {
	
	
	function getResponse($response) {

		header('Content-type: text/plain');
		$suggests = $response->getData("data");	
		$html = "";
		if (is_array($suggests)) {
			foreach ($suggests as $sug) {
				$html .= $sug['Path'] . "	" . $sug['ID'];
				$html .= "	".(isset($sug['ContentType']) ? $sug['ContentType'] : (isset($sug['IsFolder']) && $sug['IsFolder'] ? "folder" : "")) . "\n";
			}
		}
		return $html;
	}
}



?>