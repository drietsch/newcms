<?php

if (defined("MESSAGING_SYSTEM")) {
	include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
}

class rpcPingCmd extends rpcCmd {

	function execute() {
		$resp = new rpcResponse();
		
		if ($_SESSION["user"]["ID"]) {
			$GLOBALS['DB_WE']->query("UPDATE ".USER_TABLE." SET Ping=".time()." WHERE ID=".$_SESSION["user"]["ID"]);
		}
		
    	if (defined("MESSAGING_SYSTEM")) {
	        include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_session.inc.php");
	        $messaging = new we_messaging($we_transaction);
	        $messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
	        $messaging->add_msgobj('we_message', 1);
	        $messaging->add_msgobj('we_todo', 1);
	        
			$resp->setData("newmsg_count", $messaging->used_msgobjs['we_message']->get_newmsg_count());
 			$resp->setData("newtodo_count", $messaging->used_msgobjs['we_todo']->get_newmsg_count());
    	}
		
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_usersOnline.class.php");
		$users_online = new usersOnline();
		
		$resp->setData("users", $users_online->getUsers());
 		$resp->setData("num_users", $users_online->getNumUsers());
    	return $resp;
	}
	
}

?>