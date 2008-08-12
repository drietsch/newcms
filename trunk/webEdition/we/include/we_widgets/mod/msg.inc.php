<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


if (defined("MESSAGING_SYSTEM")){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
	include_once(WE_MESSAGING_MODULE_DIR."we_message.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

	$_SESSION['we_data'][$_transact] = array();

	$_we_messaging = new we_messaging($_SESSION['we_data'][$_transact]);
	$_we_messaging->add_msgobj('we_message');
	$_we_messaging->saveInSession($_SESSION['we_data'][$_transact]);
	$messaging_text = $l_javaMenu["module_information"]["messaging"]["text"].":";
	$new_messages = $l_messaging["new_messages"];
	$new_tasks = $l_messaging["new_tasks"];

	$messaging = "";
	$messaging = new we_messaging($_SESSION["we_data"]["we_transaction"]);
	$messaging->set_login_data($_SESSION["user"]["ID"], $_SESSION["user"]["Username"]);
	$messaging->add_msgobj('we_message', 1);
	$messaging->add_msgobj('we_todo', 1);

	$newmsg_count = $messaging->used_msgobjs['we_message']->get_newmsg_count();
	$newtodo_count = $messaging->used_msgobjs['we_todo']->get_newmsg_count();
	$we_button = new we_button();

	$msg_cmd = "javascript:top.we_cmd('messaging_start','message');";
	$todo_cmd = "javascript:top.we_cmd('messaging_start','todo');";
	$msg_button = we_htmlElement::htmlA(array("href"=>$msg_cmd),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR.'pd/msg/message.gif',"width"=>34,"height"=>34,"border"=>0)));
	$todo_button = we_htmlElement::htmlA(array("href"=>$todo_cmd),we_htmlElement::htmlImg(array("src"=>IMAGE_DIR.'pd/msg/todo.gif',"width"=>34,"height"=>34,"border"=>0)));
}

?>