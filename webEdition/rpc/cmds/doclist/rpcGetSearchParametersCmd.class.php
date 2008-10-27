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