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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once(WE_MESSAGING_MODULE_DIR."messaging_defs.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");
protect();
/* send new email message */
function msg_new_email(&$rcpts, $subject, $body, &$errs) {
    include_once(WE_MESSAGING_MODULE_DIR . "we_msg_email.inc.php");

    $m = new we_msg_email();
    $m->set_login_data($_SESSION["user"]["ID"], isset($_SESSION["user"]["Name"]) ? $_SESSION["user"]["Name"] : "");
    $data = array('subject' => $subject, 'body' => $body);

    $res = $m->send($rcpts, $data);

    if (!empty($res['err'])) {
	$errs = $res['err'];
	return 0;
    }

    return 1;
}

/* generate new webedition message */
function msg_new_message(&$rcpts, $subject, $body, &$errs) {
    include_once(WE_MESSAGING_MODULE_DIR . "we_message.inc.php");

    $m = new we_message();
    $m->set_login_data($_SESSION["user"]["ID"], isset($_SESSION["user"]["Name"]) ? $_SESSION["user"]["Name"] : "");
    $data = array('subject' => $subject, 'body' => $body);

    $res = $m->send($rcpts, $data);

    if (!empty($res['err'])) {
		$errs = $res['err'];
		return $res;
    }

    return $res;
}

/* generate new ToDo */
/* return the ID of the created ToDo, 0 on error */
function msg_new_todo(&$rcpts, $subject, $body, &$errs, $ct = 'text', $deadline = 1, $priority = 5) {
    include_once(WE_MESSAGING_MODULE_DIR . "we_todo.inc.php");

    $m = new we_todo();
    $m->set_login_data($_SESSION["user"]["ID"], isset($_SESSION["user"]["Name"]) ? $_SESSION["user"]["Name"] : "");
    $data = array('subject' => $subject, 'body' => $body, 'deadline' => $deadline, 'Content_Type' => $ct, 'priority' => $priority);

    $res = $m->send($rcpts, $data);

    if (!empty($res['err'])) {
	$errs = $res['err'];
	return 0;
    }

    return $res['id'];
}


/* Mark ToDo as done */
/* $id - value of the 'ID' field in MSG_TODO_TABLE */
function msg_done_todo($id, &$errs) {
    include_once(WE_MESSAGING_MODULE_DIR . "we_todo.inc.php");

    $res = array();

    $m = new we_todo();

    $i_headers = array('_ID' => $id);

    $db = new DB_WE();
    $db->query('SELECT UserID FROM '.MSG_TODO_TABLE.' WHERE ID=' . addslashes($id));
    $db->next_record();
    $userid = $db->f('UserID');

    $m->set_login_data($userid, isset($_SESSION["user"]["Name"]) ? $_SESSION["user"]["Name"] : "");
    $m->init();

    $data = array('todo_status' => 100);

    $res = $m->update_status($data, $i_headers, $userid);

    if (isset($res['msg'])) {
	$errs = $res['msg'];
    }

    return ($res['err'] == 0 ? 1 : 0);
}

/* remove ToDo */
/* $id - value of the 'ID' field in MSG_TODO_TABLE */
function msg_rm_todo($id) {
    include_once(WE_MESSAGING_MODULE_DIR . "we_todo.inc.php");

    $m = new we_todo();
    $m->set_login_data($_SESSION["user"]["ID"], isset($_SESSION["user"]["Name"]) ? $_SESSION["user"]["Name"] : "");

    $i_headers = array('_ID' => $id);

    return $m->delete_items($i_headers);
}

/* Create the default folders for the given $userid */
function msg_create_folders($userid) {
    global $l_messaging;

    $default_folders = array(1 => array(5 => "sent",
					3 => "messages"),
			     2 => array(13 => "done",
					11 => "rejected",
					3 => "todo"));

    $db = new DB_WE();

    $pfolders = array(1 => -1,
		      2 => -1);

    $db->query('SELECT ID, msg_type, obj_type FROM '.MSG_FOLDERS_TABLE.' WHERE (obj_type=3 OR obj_type=5 OR obj_type=9 OR obj_type=11 OR obj_type=13) AND UserID=' . addslashes($userid));
    while ($db->next_record()) {
    	if (isset($default_folders[$db->f('msg_type')][$db->f('obj_type')])) {
    	    if ($db->f('obj_type') == 3)
    		$pfolders[$db->f('msg_type')] = $db->f('ID');
    
    	    unset($default_folders[$db->f('msg_type')][$db->f('obj_type')]);
    	}
    }

    foreach ($default_folders as $mt => $farr) {
    	if ($pfolders[$mt] != -1)
    	    $pf_id = $pfolders[$mt];
    	else {
    	    $db->query("INSERT INTO ".MSG_FOLDERS_TABLE." (ID, ParentID, UserID, msg_type, obj_type, Properties, Name) VALUES (NULL, 0, " . addslashes($userid) . ", $mt, 3, 1, '" . $default_folders[$mt]['3'] . '\')');
    	    $db->query('SELECT LAST_INSERT_ID() as pf_id');
    	    $db->next_record();
    	    $pf_id = $db->f('pf_id');
    	    unset($farr['3']);
    	}
    
    	foreach ($farr as $df => $fname) {
    	    $db->query("INSERT INTO ".MSG_FOLDERS_TABLE." (ID, ParentID, UserID, msg_type, obj_type, Properties, Name) VALUES (NULL, $pf_id, " . addslashes($userid) . ", $mt, " . $df . ', 1, "' . $fname . '")');
    	}
    }

    return 1;
}

/* Mark ToDo as rejected */
/* $id - value of the 'ID' field in MSG_TODO_TABLE */
function msg_reject_todo($id) {
    include_once(WE_MESSAGING_MODULE_DIR . "we_todo.inc.php");

    $res = array();

    $m = new we_todo();

    $db = new DB_WE();
    
    $userid = f('SELECT UserID FROM '.MSG_TODO_TABLE.' WHERE ID=' . addslashes($id),'UserID',$db);
    
    $m->set_login_data($userid, isset($_SESSION["user"]["Name"]) ? $_SESSION["user"]["Name"] : "");
    $m->init();

    $msg = array('int_hdrs'=> array('_ID' => $id,'_from_userid'=>$userid));
    $data = array('body'=>'');
    
    $m->reject($msg,$data);

}


?>