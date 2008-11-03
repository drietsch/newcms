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
		
		protect();
				
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