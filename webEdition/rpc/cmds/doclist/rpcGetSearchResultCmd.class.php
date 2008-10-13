<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

class rpcGetSearchResultCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
		
		protect();
				
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