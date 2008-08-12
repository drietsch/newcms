<?php


	class rpcGetAllDocElementsCmd extends rpcCmd {
		
		var $Parameters = array('docid');
		
		function execute() {
			
			$resp = new rpcResponse();
			
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_webEditionDocument.inc.php');
			$_doc = new we_webEditionDocument();		
			$_doc->initByID($_REQUEST['docid']);
			
			$resp->setData('elements',$_doc->elements);
			
			return $resp;
				
		}
		
		
	}


?>