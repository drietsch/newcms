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

class rpcGetMouseOverDivsCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/class/searchtoolView.class.php');
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/weSearch/conf/define.conf.php');
		

		$whichsearch=$_REQUEST['whichsearch'];
		$setView = $_REQUEST['we_cmd']['setView'.$whichsearch.''];
		$anzahl = $_REQUEST['we_cmd']['anzahl'.$whichsearch.''];
		$searchstart = $_REQUEST['we_cmd']['searchstart'.$whichsearch.''];
	
		$_REQUEST['we_cmd']['obj'] = unserialize($_SESSION['weSearch_session']);
		
		$code = "";
		if($setView==1) {
			
			$content = searchtoolView::searchProperties($whichsearch);
			
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