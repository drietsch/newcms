<?php

class rpcGetSearchParametersCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
				
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolView.class.php');
		
		$pos = $_REQUEST['position'];
		$whichsearch=$_REQUEST['whichsearch'];
		$foundItems = $_SESSION['weSearch']['foundItems'.$whichsearch.''];
		$anzahl = $_REQUEST['we_cmd']['anzahl'.$whichsearch.''];
		$searchstart = $_REQUEST['we_cmd']['searchstart'.$whichsearch.''];

		$_SESSION['weSearch']['anzahl'.$whichsearch.''] = $anzahl;
		$_SESSION['weSearch']['searchstart'.$whichsearch.''] = $searchstart;
		
		$_REQUEST['we_cmd']['obj'] = true;
		
		if($pos=="top") {
			$code = searchtoolView::getSearchParameterTop($foundItems,$whichsearch);
		}
		if($pos=="bottom") {
			$_REQUEST['we_cmd']['setInputSearchstart'] = 1;
			$code = searchtoolView::getSearchParameterBottom($foundItems,$whichsearch);
		}
		
		$resp->setData("data",$code) ;
		
		return $resp;
	}
	

}

?>