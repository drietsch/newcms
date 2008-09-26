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

include_once(WE_MESSAGING_MODULE_DIR . "we_msg_proto.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_std.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_defs.inc.php");


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");

/* todo object class */
class we_todo extends we_msg_proto {

    /*****************************************************************/
    /* Class Properties **********************************************/
    /*****************************************************************/

    /* Name of the class => important for reconstructing the class from outside the class */
    var $ClassName = 'we_todo';
    /* In this array are all storagable class variables */
    var $persistent_slots = array();
    /* Name of the Object that was createt from this class */
    var $Name='';

    /* ID from the database record */
    var $ID=0;
    
    /* Database Object */
    var $DB_WE;
    
    /* Flag which is set when the file is not new */
    var $wasUpdate=0;
    
    var $InWebEdition = 0;

    var $selected_message = array();

    var $selected_set = array();

    var $search_fields = array('m.headerSubject', 'm.headerCreator', 'm.MessageText');

    var $search_folder_ids = array();

    var $sortfield = 'm.headerDeadline';

    var $last_sortfield = '';

    var $sortorder = 'desc';

    var $ids_selected = array();

    var $available_folders = array();

    var $sql_class_nr = 2;

    var $Short_Description = 'webEdition TODO';

    var $table = MSG_TODO_TABLE;

    var $view_class = 'todo';

    var $sf2sqlfields = array('m.headerSubject' => array('hdrs', 'Subject'),
			    'm.headerDate' => array('hdrs', 'Date'),
			    'm.headerDeadline' => array('hdrs', 'Deadline'),
			    'm.headerCreator' => array('hdrs', 'Creator'),
			    'm.seenStatus' => array('hdrs', 'seenStatus'),
			    'm.MessageText' => array('body', 'MessageText'));

    var $so2sqlso = array('desc' => 'asc',
			  'asc' => 'desc');

    /*****************************************************************/
    /* Class Methods *************************************************/
    /*****************************************************************/
    
    /* Constructor */
    function we_todo() {
    	$this->Short_Description =   $GLOBALS["l_messaging"]["we_todo"];
		$this->Name = 'todo_' . md5(uniqid(rand()));
		array_push($this->persistent_slots, 'ClassName','Name','ID', 'Folder_ID', 'selected_message', 'sortorder', 'last_sortfield', 'available_folders', 'search_folder_ids', 'search_fields', 'default_folders');
		$this->DB = new DB_WE();
    }

    function init($sessDat = '') {
	    $init_folders = array();

	    if($sessDat) 
		    $this->initSessionDat($sessDat);

	    foreach ($this->default_folders as $id => $fid)
		if ($fid == -1)
		    $init_folders[] = $id;

	    if (!empty($init_folders)) {
		$this->DB->query('SELECT ID, obj_type FROM '.MSG_FOLDERS_TABLE.' WHERE UserID=' . $this->userid . ' AND msg_type=' . $this->sql_class_nr . ' AND (obj_type=' . addslashes(join(' OR obj_type=', $init_folders)) . ')');
		while ($this->DB->next_record()) {
		    $this->default_folders[$this->DB->f('obj_type')] = $this->DB->f('ID');
		}
	    }
    }

    function initSessionDat($sessDat) {
	    if ($sessDat) {
		    /* move sizeof out of loop */
		    for ($i = 0; $i < sizeof($this->persistent_slots); $i++) {
			    if (isset($sessDat[0][$this->persistent_slots[$i]])) {
				    eval('$this->' . $this->persistent_slots[$i] . '=$sessDat[0][$this->persistent_slots[$i]];');
			    }
		    }
    
		    if (isset($sessDat[1])) {
			    $this->elements = $sessDat[1];
		    }
	    }
    }

    function saveInSession(&$save){
	    $save = array();
	    $save[0] = array();
	    for($i=0;$i<sizeof($this->persistent_slots);$i++){
		    eval('$save[0]["'.$this->persistent_slots[$i].'"]=$this->'.$this->persistent_slots[$i].';');
	    }
	    $save[1] = isset($this->elements) ? $this->elements : "";

    }

    /* Methods dealing with USER_TABLE and other userstuff */
    function userid_to_username($id) {
	global $l_messaging;

	$db2 = new DB_WE();
	$db2->query('SELECT username FROM '.USER_TABLE.' WHERE ID=' . addslashes($id));
	if ($db2->next_record())
	    return $db2->f('username');

	return $l_messaging['userid_not_found'];
    }

    function username_to_userid($username) {
	$db2 = new DB_WE();
	$db2->query('SELECT ID FROM '.USER_TABLE.' WHERE username="' . addslashes($username) . '"');
	if ($db2->next_record())
	    return $db2->f('ID');

	return -1;
    }

    /* Getters And Setters */

    function get_newmsg_count() {
	$this->DB->query('SELECT COUNT(ID) AS c FROM ' . $this->table . ' WHERE NOT (seenStatus & ' . MSG_STATUS_SEEN . ') AND obj_type=' . MSG_TODO_NR . ' AND msg_type=' . $this->sql_class_nr . ' AND ParentID=' . $this->default_folders[MSG_FOLDER_INBOX] . ' AND UserID=' . $this->userid);
	if ($this->DB->next_record()) {
	    return $this->DB->f('c');
	}

	return 0;
    }

    function get_count($folder_id) {
	$this->DB->query('SELECT COUNT(ID) AS c FROM ' . $this->table . ' WHERE ParentID=' . addslashes($folder_id) . ' AND obj_type=' . MSG_TODO_NR . ' AND msg_type=' . $this->sql_class_nr . ' AND UserID=' . $this->userid);
	if ($this->DB->next_record())
	    return $this->DB->f('c');

	return -1;
    }

    function get_userids_by_nick($nick) {
	$ret_ids = array();

	$db2 = new DB_WE();
	$db2->query('SELECT ID FROM '.USER_TABLE.' WHERE username LIKE "%' . addslashes($nick) . '%" OR First LIKE "%' . addslashes($nick) . '%" OR Second LIKE "%' . addslashes($nick) . '%"');
	while ($db2->next_record())
	    $ret_ids[] = $db2->f('ID');

	return $ret_ids;
    }

    function format_from_line($userid) {
	$ret = '';

	$db2 = new DB_WE();
	$db2->query('SELECT First, Second, username FROM '.USER_TABLE.' WHERE ID=' . addslashes($userid));

	$db2->next_record();
	    $ret = $db2->f('First') . ' ' . $db2->f('Second') . ' (' . $db2->f('username') . ')';

	return $ret;
    }

    function create_folder($name, $parent, $aid = -1) {
	return parent::create_folder($name, $parent, $aid);
    }

    /* get subtree starting with node $id */
    function &get_f_children($id) {
	$fids = array();

	$this->DB->query('SELECT ID FROM ' . $this->folder_tbl . ' WHERE ParentID=' . addslashes($id) . ' AND UserID=' . $this->userid);
	while ($this->DB->next_record())
		$fids[] = $this->DB->f('ID');    

	foreach ($fids as $fid)
		$fids = array_merge($fids, $this->get_f_children($fid));

	return $fids;
    }

    function delete_items(&$i_headers) {
	if (empty($i_headers))
	    return -1; 
	    
	$cond = '';
	foreach ($i_headers as $ih) {
	    $cond .= 'ID=' . addslashes($ih['_ID']) . ' OR ';
	}

	$cond = substr($cond, 0, -4);

	$this->DB->query('DELETE FROM ' . $this->table . ' WHERE (' . addslashes($cond) . ') AND obj_type=' . MSG_TODO_NR . " AND UserID=" . $this->userid);

	return 1;
    }

    function history_update($id, $userid, $fromuserid, $comment, $action, $status = 'NULL') {
	$this->DB->query('INSERT INTO '.MSG_TODOHISTORY_TABLE.' (ParentID, UserID, fromUserID, Comment, Created, action, status) VALUES (' . addslashes($id) . ', ' . addslashes($userid) . ', ' . addslashes($fromuserid) . ', ' . '"' . addslashes($comment) . '", UNIX_TIMESTAMP(NOW()), ' . addslashes($action) . ', ' . addslashes($status) . ')');

	return 1;
    }

    function add_comment() {
	if ($this->history_update($id, $this->userid, $this->userid, $comment, MSG_ACTION_COMMENT) == 1) {
	    return 1;
	}

	return 0;
    }

    function &update_status(&$data, &$msg, $userid = '') {
	global $l_messaging;

	$ret = array();
	$ret['changed'] = 0;
	$set_query = array();

	if ($userid == '') {
	    $userid = $this->userid;
	}

	if (empty($data)) {
	    $ret['msg'] = $l_messaging['todo_no_changes'];
	    return $ret;
	}

	if (empty($msg)) {
	    $ret['msg'] = $l_messaging['todo_none_selected'];
	    return $ret;
	}

	if (isset($data['todo_comment'])) {
	    /* XXX: use current assignee instead of userid */
	    if ($this->history_update($msg['_ID'], $userid, $userid, $data['todo_comment'], MSG_ACTION_COMMENT)) {
		/* XXX: ? */
		$ret['msg'] = $l_messaging['update_successful'];
		$ret['changed'] = 1;
	    } else {
		$ret['msg'] = $l_messaging['error_occured'];
		$ret['err'] = 1;
	    }
	}

	if (isset($data['todo_status'])) {
	    if (!is_numeric($data['todo_status']) || ($data['todo_status'] < 0)) {
		$ret['msg'] = $l_messaging['todo_status_inv_input'];
		$ret['err'] = 1;
		return $ret;
	    }

	    $set_query[] = 'headerStatus=' . addslashes($data['todo_status']);
	    if ($data['todo_status'] >= 100) {
		if ($this->default_folders[MSG_FOLDER_DONE] < 0) {
		    $ret['msg'] = $l_messaging['todo_move_error'] . ': ' . $l_messaging['no_done_folder'];
		    return $ret;
		} else {
		    $set_query[] = 'ParentID=' . $this->default_folders[MSG_FOLDER_DONE];
		}
	    }
	}

	if (isset($data['deadline'])) {
	    $set_query[] = 'headerDeadline=' . addslashes($data['deadline']);
	}

	if (isset($data['todo_priority'])) {
	    $set_query[] = 'Priority=' . addslashes($data['todo_priority']);
	}

	$this->DB->query('UPDATE ' . $this->table . ' SET ' . join(', ', $set_query) . ' WHERE ID=' . addslashes($msg['_ID']));
	$ret['msg'] = $l_messaging['update_successful'];
	$ret['changed'] = 1;
	$ret['err'] = 0;

	return $ret;
    }

    /* Forward is actually "reassign", so no copy is made */
    function forward(&$rcpts, &$data, &$msg) {
	global $l_messaging;

	$results = array();
	$results['err'] = array();
	$results['ok'] = array();
	$results['failed'] = array();
	$in_folder = '';

	$rcpt = $rcpts[0];

	if (($userid = $this->username_to_userid($rcpt)) == -1) {
	    $results['err'][] = $l_messaging['username_not_found'];
	    $results['failed'][] = $rcpt;
	    return $results;
	}

	$this->DB->query('SELECT ID FROM ' . $this->table . ' WHERE Properties=' . MSG_TODO_PROP_IMMOVABLE . ' AND ID=' . addslashes($msg['int_hdrs']['_ID']));
	$this->DB->next_record();
	if ($this->DB->f('ID') == $msg['int_hdrs']['_ID']) {
	    $results['err'][] = $l_messaging['todo_no_forward'];
	    $results['failed'][] = $this->userid;
	    return $results;
	}

	$this->DB->query('SELECT ID FROM ' . $this->folder_tbl . ' WHERE obj_type=' . MSG_FOLDER_INBOX . ' AND msg_type=' . $this->sql_class_nr . ' AND UserID=' . addslashes($userid));
	$this->DB->next_record();
	$in_folder = $this->DB->f('ID');
	if (!isset($in_folder) || $in_folder == '') {
	    $results['err'][] = $l_messaging['no_inbox_folder'];
	    $results['failed'][] = $rcpt;
	    return $results;
	}

	if ($this->history_update($msg['int_hdrs']['_ID'], $userid, $this->userid, $data['body'], MSG_ACTION_FORWARD) == 1) {
	    $this->DB->query('UPDATE ' . $this->table . " SET ParentID=$in_folder, UserID=" . addslashes($userid) . ', seenStatus=0, headerAssigner=' . addslashes($this->userid) . " WHERE ID=" . addslashes($msg['int_hdrs']['_ID']) . ' AND UserID=' . $this->userid);
	    $results['ok'][] = $rcpt;
	} else {
	    $results['err'][] = $l_messaging['todo_err_history_update'];
	    $results['failed'][] = $rcpt;
	}

	return $results;
    }

    function reject(&$msg, &$data) {
		global $l_messaging;
	
		$results = array();
		$results['err'] = array();
		$results['ok'] = array();
		$results['failed'] = array();
	
	
		$this->DB->query('SELECT ID FROM '.MSG_FOLDERS_TABLE.' WHERE obj_type=' . MSG_FOLDER_REJECT . ' AND UserID=' . addslashes($msg['int_hdrs']['_from_userid']));
		$this->DB->next_record();
		$rej_folder = $this->DB->f('ID');
		if (empty($rej_folder)) {
		    $results['err'][] = $l_messaging['no_reject_folder'];
		    $results['failed'][] = $this->userid_to_username($msg['int_hdrs']['_from_userid']);
		    return $results;
		}
		
		$this->DB->query('SELECT ID FROM ' . $this->table . ' WHERE Properties=' . MSG_TODO_PROP_IMMOVABLE . ' AND ID=' . addslashes($msg['int_hdrs']['_ID']));
		$this->DB->next_record();
		if ($this->DB->f('ID') == $msg['int_hdrs']['_ID']) {
		    $results['err'][] = $l_messaging['todo_no_reject'];
		    $results['failed'][] = $this->userid_to_username($msg['int_hdrs']['_from_userid']);
		    return $results;
		}
	
		$this->DB->query('UPDATE ' . $this->table . ' SET UserID=' . addslashes($msg['int_hdrs']['_from_userid']) . ', ParentID=' . addslashes($rej_folder) . ' WHERE ID=' . addslashes($msg['int_hdrs']['_ID']));
		$this->history_update($msg['int_hdrs']['_ID'], $msg['int_hdrs']['_from_userid'], $this->userid, $data['body'], MSG_ACTION_REJECT);
	
		$results['err'][] = '';
		$results['ok'][] = $this->userid_to_username($msg['int_hdrs']['_from_userid']);
	
		return $results;
    }

    function clipboard_cut($items, $target_fid) {
	if (empty($items)){
	    return;
	}

	$id_str = 'ID=' . join(', ID=', $items);
	$this->DB->query('UPDATE ' . $this->table . ' SET ParentID=' . addslashes($target_fid) . ' WHERE (' . addslashes($id_str) . ') AND UserID=' . $this->userid);

	return 1;
    }

    function clipboard_copy($items, $target_fid) {
	$tmp_msgs = array();

	if (empty($items))
	    return;

	$target_fid = addslashes($target_fid);
	foreach ($items as $item) {
	    $tmp = array();
	    $query = 'SELECT ParentID, msg_type, obj_type, headerDate, headerSubject, headerCreator, headerAssigner, headerStatus, headerDeadline, Priority, Content_Type, MessageText, seenStatus, tag FROM ' . $this->table . " WHERE ID=$item AND UserID=" . $this->userid;
	    $this->DB->query($query);
	    while($this->DB->next_record()) {
		$tmp['ParentID'] = isset($this->DB->Record['ParentID']) ? $this->DB->Record['ParentID'] : 'NULL';
		$tmp['msg_type'] = $this->DB->f('msg_type');
		$tmp['obj_type'] = $this->DB->f('obj_type');
		$tmp['headerDate'] = isset($this->DB->Record['headerDate']) ? $this->DB->Record['headerDate'] : 'NULL';
		$tmp['headerSubject'] = isset($this->DB->Record['headerSubject']) ? $this->DB->Record['headerSubject'] : 'NULL';
		$tmp['headerCreator'] = isset($this->DB->Record['headerCreator']) ? $this->DB->Record['headerCreator'] : 'NULL';
		$tmp['headerAssigner'] = isset($this->DB->Record['headerAssigner']) ? $this->DB->Record['headerAssigner'] : 'NULL';
		$tmp['headerStatus'] = isset($this->DB->Record['headerStatus']) ? $this->DB->Record['headerStatus'] : 'NULL';
		$tmp['headerDeadline'] = $this->DB->f('headerDeadline');
		$tmp['Priority'] = $this->DB->f('Priority');
		$tmp['MessageText'] = $this->DB->f('MessageText');
		$tmp['Content_Type'] = $this->DB->f('Content_Type');
		$tmp['seenStatus'] = $this->DB->f('seenStatus');
		$tmp['tag'] = $this->DB->f('tag');
	    }

	    $query = 'INSERT INTO ' . $this->table . ' (ParentID, UserID, msg_type, obj_type, headerDate, headerSubject, headerCreator, headerAssigner, headerStatus, headerDeadline, Priority, MessageText, Content_Type, seenStatus, tag) VALUES (' .
		$target_fid . ',' .
		$this->userid . ',' .
		$tmp['msg_type'] . ',' .
		$tmp['obj_type'] . ',' .
		($tmp['headerDate']==""?'NULL':$tmp['headerDate']) . ',' .
		'"' . addslashes($tmp['headerSubject']) . '",' .
		($tmp['headerCreator']==""?'NULL':$tmp['headerCreator']) . ',' .
		($tmp['headerAssigner']==""?'NULL':$tmp['headerAssigner']) . ',' .
		($tmp['headerStatus']==""?'NULL':$tmp['headerStatus']) . ',' .
		($tmp['headerDeadline']==""?'NULL':$tmp['headerDeadline']) . ',' .
		($tmp['Priority']==""?'NULL':$tmp['Priority']) . ',' .
		'"' . addslashes($tmp['MessageText']) . '",' .
		'"' . addslashes($tmp['Content_Type']) . '",' .
		($tmp['seenStatus']==""?'NULL':$tmp['seenStatus']) . ',' .
		($tmp['tag']==""?'NULL':$tmp['tag']) . ')';
	    $this->DB->query($query);
	}

	return 1;
    }

    function &send(&$rcpts, &$data) {
	global $l_messaging;

	$results = array();
	$results['err'] = array();
	$results['ok'] = array();
	$results['failed'] = array();

	foreach ($rcpts as $rcpt)  {
	    $in_folder = '';
	    //XXX: Put this out of the loop (the select statement)
	    if (($userid = $this->username_to_userid($rcpt)) == -1) {
			$results['err'][] = "Username '$rcpt' existiert nicht'";
			$results['failed'][] = $rcpt;
			continue;
	    }

	    $this->DB->query('SELECT ID FROM ' . $this->folder_tbl . ' WHERE obj_type=' . MSG_FOLDER_INBOX . ' AND msg_type=' . $this->sql_class_nr . ' AND UserID=' . addslashes($userid));
	    $this->DB->next_record();
	    $in_folder = $this->DB->f('ID');
	    if (!isset($in_folder) || $in_folder == '') {
		/* Create default Folders for target user */
		include_once(WE_MESSAGING_MODULE_DIR."messaging_interfaces.inc.php");
		if (msg_create_folders($userid) == 1) {
		    $this->DB->query('SELECT ID FROM ' . $this->folder_tbl . ' WHERE obj_type=' . MSG_FOLDER_INBOX . ' AND msg_type=' . $this->sql_class_nr . ' AND UserID=' . addslashes($userid));
		    $this->DB->next_record();
		    $in_folder = $this->DB->f('ID');
		    if (!isset($in_folder) || $in_folder == '') {
			$results['err'][] = $l_messaging['no_inbox_folder'];
			$results['failed'][] = $rcpt;
			continue;
		    }
		} else {
		    $results['err'][] = $l_messaging['no_inbox_folder'];
		    $results['failed'][] = $rcpt;
		    continue;
		}
	    }

	    $this->DB->query('INSERT INTO ' . $this->table . ' (ParentID, UserID, msg_type, obj_type, headerDate, headerSubject, headerCreator, headerStatus, headerDeadline' . (!empty($data['priority']) ? ', Priority' : '') . ', ' . (empty($data['Content_Type']) ? '' : 'Content_Type, ') . " Properties, MessageText,seenStatus) VALUES ($in_folder, " . $userid . ', ' . $this->sql_class_nr . ',' . MSG_TODO_NR .  ', UNIX_TIMESTAMP(NOW()), "' . addslashes($data['subject']) . '", ' . $this->userid . ', 0, ' . addslashes($data['deadline']) . (!empty($data['priority']) ? ', ' . addslashes($data['priority']) : '') . ', ' . (empty($data['Content_Type']) ? '' : '"' . addslashes($data['Content_Type']) . '", ') . MSG_TODO_PROP_NONE . ',"' . addslashes($data['body']) . '",0)');
	    $this->DB->query('SELECT LAST_INSERT_ID() as lid');
	    $this->DB->next_record();
	    $results['id'] = $this->DB->f('lid');
	    $results['ok'][] = $rcpt;
	}

	return $results;
    }

    function get_msg_set(&$criteria) {
	$sfield_cond = '';

	if (isset($criteria['search_fields'])) {

	    $arr = array('hdrs', 'From');
	    $sf_uoff = arr_offset_arraysearch($arr, $criteria['search_fields']);

	    if ($sf_uoff > -1) {
		$sfield_cond .= 'u.username LIKE "%' . addslashes($criteria['searchterm']) . '%" OR 
				u.First LIKE "%' . addslashes($criteria['searchterm']) . '%" OR 
				u.Second LIKE "%' . addslashes($criteria['searchterm']) . '%" OR ';

		array_splice($criteria['search_fields'], $sf_uoff, 1);
	    }

	    foreach ($criteria['search_fields'] as $sf) {
		$sfield_cond .= array_key_by_val($sf, $this->sf2sqlfields) . ' LIKE "%' . addslashes($criteria['searchterm']) . '%" OR ';
	    }

	    $sfield_cond = substr($sfield_cond, 0, -4);

	    $folders_cond = join(' OR m.ParentID=', $criteria['search_folder_ids']);
	} else if (isset($criteria['folder_id'])) {
	    $folders_cond = $criteria['folder_id'];

	    if ($this->cached['sortfield'] != 1 || $this->cached['sortorder'] != 1) {
		$this->init_sortstuff($criteria['folder_id']); 
	    }

	    $this->Folder_ID = $criteria['folder_id'];
	}

	if (isset($criteria['message_ids'])) {
	    $message_ids_cond = join(' OR m.ID=', $criteria['message_ids']); 
	}

	$this->selected_set = array();
	$query = 'SELECT m.ID, m.ParentID, m.headerDeadline, m.headerSubject, m.headerCreator, m.Priority, m.seenStatus, m.headerStatus, u.username 
		FROM ' . $this->table . ' as m, '.USER_TABLE.' as u 
		WHERE ((m.msg_type=' . $this->sql_class_nr . ' AND m.obj_type=' . MSG_TODO_NR . ') ' . ($sfield_cond == '' ?  '' : " AND ($sfield_cond)") . ($folders_cond == '' ? '' : " AND (m.ParentID=$folders_cond)") . ( (!isset($message_ids_cond) || $message_ids_cond == '') ? '' : " AND (m.ID=$message_ids_cond)") .  ") AND m.UserID=" . $this->userid . " AND m.headerCreator=u.ID
		ORDER BY " . $this->sortfield . ' ' . $this->so2sqlso[$this->sortorder];
	$this->DB->query($query);

	$i = isset($criteria['start_id']) ? $criteria['start_id'] + 1 : 0;

	$seen_ids = array();

	while ($this->DB->next_record()) {
	    if (!($this->DB->f('seenStatus') & MSG_STATUS_SEEN))
		$seen_ids[] = $this->DB->f('ID');
	
	    $this->selected_set[] = 
		array('ID' => $i++,
		      'hdrs' => array('Deadline' => $this->DB->f('headerDeadline'),
					'Subject' => $this->DB->f('headerSubject'),
					'Creator' => $this->DB->f('username'),
					'Priority' => $this->DB->f('Priority'),
					'seenStatus' => $this->DB->f('seenStatus'),
					'status' => $this->DB->f('headerStatus'),
					'ClassName' => $this->ClassName),
		      'int_hdrs' => array('_from_userid' => $this->DB->f('headerCreator'),
					'_ParentID' => $this->DB->f('ParentID'),
					'_ID' => $this->DB->f('ID')));

	}

	/* mark selected_set messages as seen */
	if (!empty($seen_ids)) {
	    $query = 'UPDATE ' . $this->table . ' SET seenStatus=(seenStatus | ' . MSG_STATUS_SEEN . ') WHERE (ID=' . join(' OR ID=', $seen_ids) . ') AND UserID=' . $this->userid;
	    $this->DB->query($query);
	}

	return $this->selected_set;
    }

    function &retrieve_items(&$int_hdrs) {
	$ret = array();
	$i = 0;

	if (empty($int_hdrs))
	    return $ret;

	foreach ($int_hdrs as $ih) {
	    if(!isset($id_str)){
	        $id_str = "";
	    }
	    $id_str .= 'm.ID=' . addslashes($ih['_ID']);
	}

	$this->DB->query('SELECT m.ID, m.headerDate, m.headerSubject, m.headerCreator, m.headerAssigner, m.headerStatus, m.headerDeadline, m.MessageText, m.Content_Type, u.username, u.First, u.Second FROM ' . $this->table . " as m, ".USER_TABLE." as u WHERE ($id_str) AND u.ID=m.headerCreator AND m.UserID=" . $this->userid);

	$db2 = new DB_WE();

	$read_ids = array();

	while ($this->DB->next_record()) {
	    if (!($this->DB->f('seenStatus') & MSG_STATUS_READ))
		$read_ids[] = $this->DB->f('ID');

	    $history = array();
	    /* XXX: get the ids; use one query outside of the loop; */
	    $db2->query('SELECT u.username, t.Comment, t.Created, t.action, t.fromUserID FROM '.MSG_TODOHISTORY_TABLE.' as t, '.USER_TABLE.' as u WHERE t.ParentID=' . $this->DB->f('ID') . ' AND t.UserID=u.ID ORDER BY Created');
	    while ($db2->next_record()) {
		$history[] = array('username' => $db2->f('username'),
				   'from_userid' => $db2->f('fromUserID'),
				   'date' => $db2->f('Created'),
				   'action' => $db2->f('action'),
				   'comment' => $db2->f('Comment'));
	    }

	    $from = $this->DB->f('First') . ' ' . $this->DB->f('Second') . ' (' . $this->DB->f('username') . ')';
	    $ret[] = array('ID' => $i++,
		    'hdrs' => array('Date' => $this->DB->f('headerDate'),
				    'Deadline' => $this->DB->f('headerDeadline'),
				    'Subject' => $this->DB->f('headerSubject'),
				    'From' => $from,
				    'Assigner' => empty($this->DB->Record['headerAssigner']) ? $from
							: $this->format_from_line($this->DB->Record['headerAssigner']),
				    'status' => $this->DB->f('headerStatus'),
				    'Priority' => $this->DB->f('Priority'),
				    'seenStatus' => $this->DB->f('seenStatus'),
				    'Content_Type' => $this->DB->f('Content_Type'),
				    'ClassName' => $this->ClassName),
		    'int_hdrs' => array('_from_userid' => $this->DB->f('headerCreator'),
				    '_ID' => $this->DB->f('ID'),
				    '_reply_to' => $this->DB->f('username')),
		    'body' => array('MessageText' => $this->DB->f('MessageText'),
				    'History' => $history));
	}

	if (!empty($read_ids)) {
	    $query = 'UPDATE ' . $this->table . ' SET seenStatus=(seenStatus | ' . MSG_STATUS_READ . ') WHERE (ID=' . join(' OR ID=', $read_ids) . ') AND UserID=' . $this->userid;
	    $this->DB->query($query);
	}

	return $ret;
    }
}

?>