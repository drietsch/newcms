<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


	class rpcGetDocElementCmd extends rpcCmd {
		
		var $Parameters = array('docid','element');
		
		function execute() {
			
			$resp = new rpcResponse();
			
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_webEditionDocument.inc.php');
			
			$_doc = new we_webEditionDocument();
			
			$_doc->initByID($_REQUEST['docid']);
			
			$resp->setData($_REQUEST['element'],$_doc->getElement($_REQUEST['element']));
			
			return $resp;
				
		}
				
		
	}


?>