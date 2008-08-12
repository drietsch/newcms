<?php


	class rpcLoginCmd extends rpcCmd {
		
		var $Parameters = array('username','password');
		
		function execute() {
			
			$resp = new rpcResponse();
			
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_db.inc.php');
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_db_tools.inc.php');
			
			
			$_db = new DB_WE();

			$_res = getHash('SELECT id,passwd FROM ' . USER_TABLE . ' WHERE username="' . addslashes($_REQUEST['username']) . '";',$_db);
		
			if($_res['passwd'] == $_REQUEST['password']) {
				
				$resp->setStatus(RPC_STATUS_OK);
				
				$_REQUEST['md5password'] = $_REQUEST['password'];

				$_POST = $_REQUEST;
				$DB_WE = new DB_WE();
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_session.inc.php");
				
				
			} else {
				
				$resp->setStatus(RPC_STATUS_LOGIN_FAILED);
	
			}
			
			return $resp;
				
		}
		
		function checkSession() {
	
		}
		
		function startSession() {
	
		}
		
		
	}


?>