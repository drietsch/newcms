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


class rpcGetMouseOverDivsCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_folder.inc.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_doclist/doclistView.class.inc.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolView.class.php');
		
		$whichsearch=$_REQUEST['whichsearch'];	
		$setView = $_REQUEST['we_cmd']['setView'];
		$anzahl = $_REQUEST['we_cmd']['anzahl'];
		$searchstart = $_REQUEST['we_cmd']['searchstart'];
	
		if (isset($_REQUEST["we_transaction"])) {
			$we_dt = isset($_SESSION["we_data"][$_REQUEST["we_transaction"]]) ? $_SESSION["we_data"][$_REQUEST["we_transaction"]] : "";
		}
		
		$_document = new $_REQUEST["classname"];
		$_document->we_initSessDat($we_dt);	
		
		$_REQUEST['we_cmd']['obj'] = $_document;
		
		$code = "";
		if($setView==1) {
			$content = doclistView::searchProperties($whichsearch);
			
			$x = $searchstart+$anzahl;
					if ($x>sizeof($content)) {
						$x = $x-($x-sizeof($content));
					}
	
			$code = searchtoolView::makeMouseOverDivs($x,$content,$whichsearch);
		}		
			
		$resp->setData("data",$code) ;
			
		return $resp;
		
	}
	
}

?>