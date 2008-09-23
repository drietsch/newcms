<?php

class rpcGetRssView extends rpcJsonView  {
	
	/**
	 * @param rpcResponse $response
	 * @return string
	 */
	function getResponse( $response ) {
		
		if ( $response->Success ) {
			$status = "response";

		} else {
			$status = "error";
		}
		
		return 
		'weResponse = {
			"type":"' . $status . '",
			"data":"' . addslashes( str_replace("\n", " ", str_replace("\r", " ", $response->getData("data")) ) ) . '",
			"titel":"' . addslashes($response->getData("titel")) . '",
			"widgetType":"' . addslashes($response->getData("widgetType")) . '",
			"widgetId":"' . addslashes($response->getData("widgetId")) . '"
		};'
		;
	}
}
?>