<?php

// +---------------------------------------------------------+
// | webEdition
// +---------------------------------------------------------+
// | PHP version 4.1 or greater
// +---------------------------------------------------------+
// | Copyright (c) 2000 - 2008 living-e AG  
// +---------------------------------------------------------+

/**
 * @abstract generate paging fields for doclist 
 * @author Thomas Kneip
 * @copyright Copyright (c) 2000 - 2007, living-e AG
 * @since 5.1.0.0 - 14.10.2007
 */

class rpcGetSearchParametersCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
				
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_doclist/doclistView.class.inc.php');		
		
		$pos = $_REQUEST['position'];

		$foundItems = (isset($_SESSION['weSearch']['foundItems'])) ? $_SESSION['weSearch']['foundItems'] : 0;
		$anzahl = $_REQUEST['we_cmd']['anzahl'];
		$searchstart = $_REQUEST['we_cmd']['searchstart'];
		
		$_SESSION['weSearch']['anzahl'] = $anzahl;
		$_SESSION['weSearch']['searchstart'] = $searchstart;
		
		$_REQUEST['we_cmd']['obj'] = true;
		
		if($pos=="top") {
			$code = doclistView::getSearchParameterTop($foundItems);
		}
		if($pos=="bottom") {
			$_REQUEST['we_cmd']['setInputSearchstart'] = 1;
			$code = doclistView::getSearchParameterBottom($foundItems);
			
		}
		
		$resp->setData("data",$code) ;
		
		return $resp;
	}
	

}

?>