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


include_once(WE_MESSAGING_MODULE_DIR . "we_msg_proto.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_std.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_defs.inc.php");

// Activate the webEdition error handler
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_error_handler.inc.php");
we_error_handler();

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");

/* message object class */
class we_message extends we_msg_proto {

    /*****************************************************************/
    /* Class Properties **********************************************/
    /*****************************************************************/

    /* Name of the class => important for reconstructing the class from outside the class */
    var $ClassName = 'we_message';
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

    var $search_fields = array('m.headerSubject', 'm.headerFrom', 'm.MessageText');

    var $search_folder_ids = array();

    var $sortfield = 'm.headerDate';

    var $last_sortfield = '';

    var $sortorder = 'desc';

    var $ids_selected = array();

    var $available_folders = array();

    var $sql_class_nr = 1;

    var $Short_Description = 'webEdition Message';

    var $view_class = 'message';

    var $sf2sqlfields = array('m.headerSubject' => array('hdrs', 'Subject'),
			    'm.headerDate' => array('hdrs', 'Date'),
			    'm.headerFrom' => array('hdrs', 'From'),
			    'm.seenStatus' => array('hdrs', 'seenStatus'),
			    'm.MessageText' => array('body', 'MessageText'));

    var $so2sqlso = array('desc' => 'asc',
			  'asc' => 'desc');

    /*****************************************************************/
    /* Class Methods *************************************************/
    /*****************************************************************/
    
    /* Constructor */
    function we_message() {
	$this->Name = 'message_' . md5(uniqid(rand()));
	array_push($this->persistent_slots, 'ClassName','Name','ID','Table', 'Folder_ID', 'selected_message', 'sortorder', 'last_sortfield', 'available_folders', 'search_folder_ids', 'search_fields');
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
		$this->DB->query('SELECT ID, obj_type FROM '.MSG_FOLDERS_TABLE.' WHERE UserID=' . abs($this->userid) . ' AND msg_type=' . $this->sql_class_nr . ' AND (obj_type=' . addslashes(join(' OR obj_type=', $init_folders)) . ')');
		while ($this->DB->next_record()) {
		    $this->default_folders[$this->DB->f('obj_type')] = $this->DB->f('ID');
		}
	    }
    }

    // XXX: put following 2 methods out of the class (same goes for we_todo.inc.php)
    /* Methods dealing with USER_TABLE and other userstuff */
    function userid_to_username($id) {
	global $l_messaging;

	$db2 = new DB_WE();
	$db2->query('SELECT username FROM '.USER_TABLE.' WHERE ID=' . abs($id));
	if ($db2->next_record())
	    return $db2->f('username');

		return $l_messaging['userid_not_found'];
    }

    function username_to_userid($username) {
		$db2 = new DB_WE();
		$db2->query('SELECT ID FROM '.USER_TABLE.' WHERE username="' . mysql_real_escape_string($username) . '"');
		if ($db2->next_record())
		    return $db2->f('ID');
	
		return -1;
    }

    /* Getters And Setters */
    function get_newmsg_count() {
		$this->DB->query('SELECT COUNT(ID) AS c FROM ' . $this->table . ' WHERE NOT (seenStatus & ' . MSG_STATUS_SEEN . ') AND obj_type=' . MSG_MESSAGE_NR . ' AND msg_type=' . abs($this->sql_class_nr) . ' AND ParentID=' . $this->default_folders[MSG_FOLDER_INBOX] . ' AND UserID=' . abs($this->userid));
		if ($this->DB->next_record()) {
		    return $this->DB->f('c');
		}
	
		return 0;
    }

    function get_count($folder_id) {
		$this->DB->query('SELECT COUNT(ID) AS c FROM ' . $this->table . ' WHERE ParentID=' . abs($folder_id) . ' AND obj_type=' . MSG_MESSAGE_NR . ' AND msg_type=' . abs($this->sql_class_nr) . ' AND UserID=' . abs($this->userid));	
		if ($this->DB->next_record())
		    return $this->DB->f('c');
	
		return -1;
    }

    function get_userids_by_nick($nick) {
		$ret_ids = array();

		$DB2 = new DB_WE();
		$DB2->query('SELECT ID FROM '.USER_TABLE.' WHERE username LIKE "%' . mysql_real_escape_string($nick) . '%" OR First LIKE "%' . mysql_real_escape_string($nick) . '%" OR Second LIKE "%' . mysql_real_escape_string($nick) . '%"');
		while ($DB2->next_record())
	    	$ret_ids[] = $DB2->f('ID');

		return $ret_ids;
    }

    function create_folder($name, $parent) {
		return parent::create_folder($name, $parent);
    }

    function delete_items(&$i_headers) {
		if (empty($i_headers))
	    	return -1; 
	    
	    	
		$cond = '';
		foreach ($i_headers as $ih) {
	    	$cond .= 'ID=' . abs($ih['_ID']) . ' OR ';
		}

		$cond = substr($cond, 0, -4);
	
		$this->DB->query('DELETE FROM ' . $this->table . " WHERE ($cond) AND obj_type=" . MSG_MESSAGE_NR . " AND UserID=" . abs($this->userid));

		return 1;
    }

    function clipboard_cut($items, $target_fid) {
    	if (empty($items)){
    	    return;
    	}
		foreach ($items as $key=>$val){
			$_items[$key] = abs($val);
		}
	    $id_str = 'ID=' . join(', ID=', $_items);
	    $this->DB->query('UPDATE ' . $this->table . " SET ParentID=$target_fid WHERE ($id_str) AND UserID=" . abs($this->userid));

	    return 1;
    }

    function clipboard_copy($items, $target_fid) {
		$tmp_msgs = array();
	
		if (empty($items))
		    return;
	
		$target_fid = addslashes($target_fid);
		foreach ($items as $item) {
		    $tmp = array();
		    $query = 'SELECT ParentID, msg_type, obj_type, headerDate, headerSubject, headerUserID, headerFrom, Priority, MessageText, seenStatus, tag FROM ' . $this->table . " WHERE ID=".abs($item)." AND UserID=" . abs($this->userid);
		    $this->DB->query($query);
		    while($this->DB->next_record()) {
				$tmp['ParentID'] = isset($this->DB->Record['ParentID']) ? $this->DB->Record['ParentID'] : 'NULL';
				$tmp['msg_type'] = $this->DB->f('msg_type');
				$tmp['obj_type'] = $this->DB->f('obj_type');
				$tmp['headerDate'] = isset($this->DB->Record['headerDate']) ? $this->DB->Record['headerDate'] : 'NULL';
				$tmp['headerSubject'] = isset($this->DB->Record['headerSubject']) ? $this->DB->Record['headerSubject'] : 'NULL';
				$tmp['headerUserID'] = isset($this->DB->Record['headerUserID']) ? $this->DB->Record['headerUserID'] : 'NULL';
				$tmp['headerFrom'] = isset($this->DB->Record['headerFrom']) ? $this->DB->Record['headerFrom'] : 'NULL';
				$tmp['Priority'] = $this->DB->f('Priority');
				$tmp['MessageText'] = $this->DB->f('MessageText');
				$tmp['seenStatus'] = $this->DB->f('seenStatus');
				$tmp['tag'] = $this->DB->f('tag');
		    }
	
		    $query = 'INSERT INTO ' . mysql_real_escape_string($this->table) . ' (ParentID, UserID, msg_type, obj_type, headerDate, headerSubject, headerUserID, headerFrom, Priority, MessageText, seenStatus, tag) VALUES (' .
			$target_fid . ',' .
			$this->userid . ',' .
			$tmp['msg_type'] . ',' .
			$tmp['obj_type'] . ',' .
			$tmp['headerDate'] . ',' .
			'"' . addslashes($tmp['headerSubject']) . '",' .
			$tmp['headerUserID'] . ',' .
			'"' . addslashes($tmp['headerFrom']) . '",' .
			$tmp['Priority'] . ',' .
			'"' . addslashes($tmp['MessageText']) . '",' .
			$tmp['seenStatus'] . ',' .
			$tmp['tag'] . ')';
		    $this->DB->query($query);
	
		    $this->DB->query('SELECT LAST_INSERT_ID() as l');
		    if ($this->DB->next_record()) {
			$pending_ids[] = $this->DB->f('l');
		    }
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
		    //XXX: Put this out of the loop
		    if (($userid = $this->username_to_userid($rcpt)) == -1) {
				$results['err'][] = $l_messaging['no_inbox_folder'];
				$results['failed'][] = $rcpt;
				continue;
		    }

		    /* XXX: replace this by default_folders[inbox] or something */
		    $this->DB->query('SELECT ID FROM ' . mysql_real_escape_string($this->folder_tbl) . ' WHERE obj_type=' . MSG_FOLDER_INBOX . ' AND msg_type=' . abs($this->sql_class_nr) . ' AND UserID=' . abs($userid));
		    $this->DB->next_record();
		    $in_folder = $this->DB->f('ID');
		    if (!isset($in_folder) || $in_folder == '') {
				/* Create default Folders for target user */
				include_once(WE_MESSAGING_MODULE_DIR."messaging_interfaces.inc.php");
				if (msg_create_folders($userid) == 1) {
				    $this->DB->query('SELECT ID FROM ' . mysql_real_escape_string($this->folder_tbl) . ' WHERE obj_type=' . MSG_FOLDER_INBOX . ' AND msg_type=' . abs($this->sql_class_nr) . ' AND UserID=' . abs($userid));
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
	
		    $this->DB->query('INSERT INTO ' . mysql_real_escape_string($this->table) . " (ParentID, UserID, msg_type, obj_type, headerDate, headerSubject, headerUserID, Priority, MessageText,seenStatus) VALUES (".abs($in_folder).", " . abs($userid) . ',' . $this->sql_class_nr . ',' . MSG_MESSAGE_NR .  ', UNIX_TIMESTAMP(NOW()), "' . mysql_real_escape_string(($data['subject'])) . '", ' . abs($this->userid) . ', 0, "' . mysql_real_escape_string($data['body']) . '",0)');
		    $results['ok'][] = $rcpt;
		}
		/* Copy sent message into 'Sent' Folder of the sender */
		if (!isset($this->default_folders[MSG_FOLDER_SENT]) || $this->default_folders[MSG_FOLDER_SENT] < 0) {
		    $this->DB->query('SELECT ID FROM ' . mysql_real_escape_string($this->folder_tbl) . ' WHERE obj_type=' . MSG_FOLDER_SENT . ' AND msg_type=' . $this->sql_class_nr . ' AND UserID=' . abs($_SESSION["user"]["ID"]));
		    $this->DB->next_record();
		    $this->default_folders[MSG_FOLDER_SENT] = $this->DB->f('ID');
		}
		$to_str = join(',', $rcpts);
		$this->DB->query('INSERT INTO ' . mysql_real_escape_string($this->table) . ' (ParentID, UserID, msg_type, obj_type, headerDate, headerSubject, headerUserID, headerTo, Priority, MessageText,seenStatus) VALUES (' . $this->default_folders[MSG_FOLDER_SENT] . ', ' . abs($this->userid) . ',' . $this->sql_class_nr . ',' . MSG_MESSAGE_NR .  ', UNIX_TIMESTAMP(NOW()), "' . mysql_real_escape_string($data['subject']) . '", ' . abs($this->userid) . ', "' . mysql_real_escape_string(strlen($to_str) > 60 ? substr($to_str, 0, 60) . '...' : $to_str) . '", 0, "' . mysql_real_escape_string($data['body']) . '",0)');
	
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

	    $sfield_cond = substr($sfield_cond, 0, -3);

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
	$query = 'SELECT m.ID, m.ParentID, m.headerDate, m.headerSubject, m.headerUserID, m.Priority, m.seenStatus, u.username 
		FROM ' . mysql_real_escape_string($this->table) . ' as m, '.USER_TABLE.' as u 
		WHERE ((m.msg_type=' . $this->sql_class_nr . ' AND m.obj_type=' . MSG_MESSAGE_NR . ') ' . ($sfield_cond == '' ?  '' : " AND ($sfield_cond)") . ($folders_cond == '' ? '' : " AND (m.ParentID=$folders_cond)") . ( (!isset($message_ids_cond) || $message_ids_cond == '') ? '' : " AND (m.ID=$message_ids_cond)") .  ") AND m.UserID=" . $this->userid . " AND m.headerUserID=u.ID
		ORDER BY " . $this->sortfield . ' ' . $this->so2sqlso[$this->sortorder];

	$this->DB->query($query);

	$i = isset($criteria['start_id']) ? $criteria['start_id'] + 1 : 0;

	$seen_ids = array();

	while ($this->DB->next_record()) {
	    if (!($this->DB->f('seenStatus') & MSG_STATUS_SEEN))
		$seen_ids[] = $this->DB->f('ID');
	
	    $this->selected_set[] = 
		array('ID' => $i++,
		    'hdrs' => array('Date' => $this->DB->f('headerDate'),
					'Subject' => $this->DB->f('headerSubject'),
					'From' => $this->DB->f('username'),
					'Priority' => $this->DB->f('Priority'),
					'seenStatus' => $this->DB->f('seenStatus'),
					'ClassName' => $this->ClassName),

		    'int_hdrs' => array('_from_userid' => $this->DB->f('headerUserID'),
						'_ParentID' => $this->DB->f('ParentID'),
						'_ClassName' => $this->ClassName,
						'_ID' => $this->DB->f('ID')));
	}

	/* mark selected_set messages as seen */
	if (!empty($seen_ids)) {
	    $query = 'UPDATE ' . mysql_real_escape_string($this->table) . ' SET seenStatus=(seenStatus | ' . MSG_STATUS_SEEN . ') WHERE (ID=' . join(' OR ID=', $seen_ids) . ') AND UserID=' . $this->userid;
	    $this->DB->query($query);
	}

	return $this->selected_set;
    }

    function &retrieve_items(&$int_hdrs) {
	$ret = array();
	$i = 0;

	if (empty($int_hdrs))
	    return $ret;

	$id_str = '';
	foreach ($int_hdrs as $ih) {
	    $id_str .= 'm.ID=' . addslashes($ih['_ID']);
	}

	$this->DB->query('SELECT m.ID, m.headerDate, m.headerSubject, m.headerUserID, m.headerTo, m.MessageText, m.seenStatus, u.username, u.First, u.Second FROM ' . mysql_real_escape_string($this->table) . " as m, ".USER_TABLE." as u WHERE ($id_str) AND u.ID=m.headerUserID AND m.UserID=" . abs($this->userid));

	$read_ids = array();

	while ($this->DB->next_record()) {
	    if (!($this->DB->f('seenStatus') & MSG_STATUS_READ))
		$read_ids[] = $this->DB->f('ID');

	    $ret[] = array('ID' => $i++,
		    'hdrs' => array('Date' => $this->DB->f('headerDate'),
					'Subject' => $this->DB->f('headerSubject'),
					'From' => $this->DB->f('First') . ' ' . $this->DB->f('Second') . ' (' . $this->DB->f('username') . ')',
					'To' => $this->DB->f('headerTo'),
					'Priority' => $this->DB->f('Priority'),
					'seenStatus' => $this->DB->f('seenStatus'),
					'ClassName' => $this->ClassName),

		    'int_hdrs' => array('_from_userid' => $this->DB->f('headerUserID'),
						'_ID' => $this->DB->f('ID'),
						'_reply_to' => $this->DB->f('username')),
		    'body' => array('MessageText' => $this->DB->f('MessageText')));
	}

	if (!empty($read_ids)) {
	    $query = 'UPDATE ' . abs($this->table) . ' SET seenStatus=(seenStatus | ' . MSG_STATUS_READ . ') WHERE (ID=' . join(' OR ID=', $read_ids) . ') AND UserID=' . abs($this->userid);
	    $this->DB->query($query);
	}

	return $ret;
    }
}

    
?>