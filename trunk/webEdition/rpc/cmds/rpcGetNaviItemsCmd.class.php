<?php

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