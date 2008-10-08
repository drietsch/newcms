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
				
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersionsView.class.inc.php");
		
		$pos = $_REQUEST['position'];

		$foundItems = (isset($_SESSION['Versions']['foundItems'])) ? $_SESSION['Versions']['foundItems'] : 0;
		$we_transaction = $_REQUEST['we_cmd']['we_transaction'];
		
		$mode = $_REQUEST['we_cmd']['mode'];
		$order = $_REQUEST['we_cmd']['order'];

		$anzahl = $_REQUEST['we_cmd']['anzahl'];
		$searchstart = $_REQUEST['we_cmd']['searchstart'];

		$_SESSION['Versions']['anzahl'] = $anzahl;
		$_SESSION['Versions']['searchstart'] = $searchstart;
		
		$_REQUEST['we_cmd']['obj'] = 1;
		
		if($pos=="top") {
			$code = weVersionsView::getParameterTop($foundItems);
		}
		
		if($pos=="bottom") {
			$_REQUEST['we_cmd']['setInputSearchstart'] = 1;
			$code = weVersionsView::getParameterBottom($foundItems);
		}
		
		$resp->setData("data",$code) ;
		
		return $resp;
	}
	

}

?>