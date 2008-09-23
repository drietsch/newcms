<?php


class rpcSelectorGetSelectedIdView extends rpcView {
	
	
	function getResponse($response) {

		header('Content-type: text/plain');
		$suggests = $response->getData("data");		
		$html = "";
		if (is_array($suggests) && isset($suggests[0]['ID'])) {
			$status = "response";
			$html .= ' "id": "'.$_REQUEST['we_cmd'][4].'", "value": "'.$suggests[0]['ID'].'"';
			$html .= isset($suggests[0]['ContentType']) ? ', "contentType": "'.$suggests[0]['ContentType'].'"' : "";
		} else {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/weSelectorSuggest.inc.php");
			$status = "error";
			if(strpos($_REQUEST["we_cmd"][3],',')) {
				switch ($_REQUEST["we_cmd"][2]) {
					case FILE_TABLE:
						$msg = $l_weSelectorSuggest["no_document"];
						break;
					case TEMPLATES_TABLE:
						$msg = $l_weSelectorSuggest["no_template"];
						break;
					case OBJECT_TABLE:
						$msg = $l_weSelectorSuggest["no_class"];
						break;
					case OBJECT_FILES_TABLE:
						$msg = $l_weSelectorSuggest["no_class"];
						break;				
					default:
						$msg = $l_weSelectorSuggest["no_result"];
						break;
				}
			} else  {
				$msg = $l_weSelectorSuggest["no_folder"];
			}
			$html .= '"msg":"'.$msg.'","nr":"'.$_REQUEST["we_cmd"][2].'"';
		}
		return 
			'var weResponse = {
			"type": "' . $status . '",
			"data": {' . $html . ' }
		};';
	}
}



?>