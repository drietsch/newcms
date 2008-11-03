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


	if (!isset($_REQUEST["protocol"])) {
		$_REQUEST["protocol"] = "json";
	}

	require('rpcRoot.inc.php');
	require('base/rpcCmdShell.class.php');
	
	protect();
	
	if (!isset($_REQUEST['cmd'])) {
		
		switch ($_REQUEST["protocol"]) {
			
			case "json":
				$resp = new rpcResponse();
				$resp->setStatus(false);
				$resp->setData("data", "The Request is not well formed!");
				$errorView = new rpcJsonView();
				print $errorView->getResponse($resp);
				exit;
			break;
			case "text":
				$resp = new rpcResponse();
				$resp->setStatus(false);
				$resp->setData("data", "The Request is not well formed!");
				$errorView = new rpcView();
				print $errorView->getResponse($resp);
				exit;
			break;
			default:
				die('The Request is not well formed!');
			break;
				
		}
	}
	
	$_shell = new rpcCmdShell($_REQUEST,$_REQUEST["protocol"]);

	if($_shell->getStatus()==RPC_STATUS_OK) {
		$_shell->executeCommand();
		print $_shell->getResponse();
		
	} else { // there was an error in initializing the command
		
		switch ($_REQUEST["protocol"]) {
			
			case "json":
				$resp = new rpcResponse();
				$resp->setStatus(false);
				$resp->setData("data", $_shell->getErrorOut());
				$errorView = new rpcJsonView();
				die ( $errorView->getResponse($resp) );
				exit;
				
			break;
			case "text":
				$resp = new rpcResponse();
				$resp->setStatus(false);
				$resp->setData("data", "The Request is not well formed!");
				$errorView = new rpcView();
				print $errorView->getResponse($resp);
				exit;
			break;
			default:
				die($_shell->getErrorOut());
			break;
		}
	}
	
	unset($_shell);
	
	//include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/rpc/navi.php');

?>