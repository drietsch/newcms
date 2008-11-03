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

class rpcGetNaviItemsCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
		
		$_nid = addslashes(isset($_REQUEST['nid']) ? $_REQUEST['nid'] : '');

		
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');
		
		
		$_navi = new weNavigation($_nid);
		
		$_items = $_navi->getChilds();	
		
		$_data = array();
		foreach ($_items as $_item) {

			$_data[] = $_item['id'] . ':' . $_item['text'];
			
		}

		$resp->setData('data',implode(',',$_data));
		
		return $resp;
	}
}

?>