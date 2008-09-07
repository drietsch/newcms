<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpcGetSearchParametersCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
		
		$lang = $_REQUEST['language'];
		
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