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

class rpcGetSearchResultCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
				
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_folder.inc.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_doclist/doclistView.class.inc.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolView.class.php');
		

		$setView = $_REQUEST['we_cmd']['setView'];
		
		if (isset($_REQUEST["we_transaction"])) {
			$we_dt = isset($_SESSION["we_data"][$_REQUEST["we_transaction"]]) ? $_SESSION["we_data"][$_REQUEST["we_transaction"]] : "";
		}
		
		$_document = new $_REQUEST["classname"];
		$_document->we_initSessDat($we_dt);	
		
		$_REQUEST['we_cmd']['obj'] = $_document;
		
		$content = doclistView::searchProperties();
				
		$code = searchtoolView::tabListContent($setView,$content,$class="middlefont","doclist");
		
		$resp->setData("data",$code) ;
		
		return $resp;
	}
	

}

?>