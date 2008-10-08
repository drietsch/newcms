<?php

/**
 * This is rpc adapter for webEdition. The parameters are defined
 * in REQUEST variable.
 * 
 * @package RPC
 * @author Slavko Tomcic
 * @copyright living-e AG
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