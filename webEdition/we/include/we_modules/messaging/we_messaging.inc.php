<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */



include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_class.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_std.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");


/* messaging object class */
class we_messaging extends we_class {

    /*****************************************************************/
    /* Class Properties **********************************************/
    /*****************************************************************/

    /* Name of the class => important for reconstructing the class from outside the class */
    var $ClassName = 'we_messaging';
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

    var $we_transact;

    var $Folder_ID = -1;

    var $userid = -1;

    var $username = '';

    var $used_msgobjs = array();

    var $send_msgobjs = array();

    var $used_msgobjs_names = array();

    var $active_msgobj = NULL;

    var $selected_message = array();

    var $selected_set = array();

    var $last_id = -1;

    var $search_fields = array(array('hdrs', 'Subject'),
				array('hdrs', 'From'),
				array('body', 'MessageText'));

    var $search_folder_ids = array();

    var $sortfield = array('hdrs', 'Date');

    var $last_sortfield = '';

    var $sortorder = 'desc';

    var $cont_from_folder = 0;

    var $ids_selected = array();

    var $available_folders = array();

    var $clipboard = array();

    var $clipboard_action = '';

    var $cached = array();

    /* Search Field names */
    var $sf_names = array('subject' => '',
			  'sender' => '',
			  'mtext' => '');

    /* Header Fields */
    var $si2sf = array('subject' => array('hdrs', 'Subject'),
			'date' => array('hdrs', 'Date'),
			'sender' => array('hdrs', 'From'),
			'isread' => array('hdrs', 'seenStatus'),
			'mtext' => array('body', 'MessageText'),
			'deadline' => array('hdrs', 'Deadline'),
			'creator' => array('hdrs', 'Creator'),
			'priority' => array('hdrs', 'Priority'),
			'status' => array('hdrs', 'Status'));

    var $sf2sh = array('headerSubject' => array('hdrs', 'Subject'),
                       'headerDate' => array('hdrs', 'Date'),
                       'headerFrom' => array('hdrs', 'From'),
                       'seenStatus' => array('hdrs', 'seenStatus'),
                       'MessageText' => array('body', 'MessageText'),
		       'headerDeadline' => array('hdrs', 'Deadline'),
		       'headerCreator' => array('hdrs', 'Creator'),
		       'Priority'   => array('hdrs', 'Priority'),
		       'headerStatus' => array('hdrs', 'Status'));

    /*****************************************************************/
    /* Class Methods *************************************************/
    /*****************************************************************/

    /* Constructor */
    function we_messaging(&$transact) {
	global $l_messaging;

	$this->Name = 'messaging_' . md5(uniqid(rand()));
	array_push($this->persistent_slots, 'Name', 'ID', 'Folder_ID', 'selected_message', 'selected_set', 'last_id', 'sortorder', 'last_sortfield', 'available_folders', 'ids_selected', 'search_folder_ids', 'search_fields', 'used_msgobjs_names', 'clipboard_action', 'clipboard', 'cached');
	$this->we_transact = &$transact;
	$this->DB = new DB_WE();

	$this->sf_names['subject'] = $l_messaging['subject'];
	$this->sf_names['sender'] = $l_messaging['sender'];
	$this->sf_names['mtext'] = $l_messaging['content'];
    }

    function add_msgobj($objname, $recover = 0) {
    	
		$inc_files = array("we_message" => WE_MESSAGING_MODULE_DIR . "we_message.inc.php",
		   "we_todo" => WE_MESSAGING_MODULE_DIR . "we_todo.inc.php",
		   "we_msg_email" => WE_MESSAGING_MODULE_DIR . "we_msg_email.inc.php");
    	
		if (in_array($objname, array_keys($this->send_msgobjs))){
    	    return 0;
    	}
    	
    	if (!isset($inc_files[$objname])){
	        return -1;
	    }
	    
    	include_once($inc_files[$objname]);
        if (!class_exists($objname)){
	        return -2;
	    }
	    
	    $c = new $objname;
	    $c->set_login_data($this->userid, $this->username);

    	if ($recover == 1) {
    	    if(isset($this->we_transact[$objname])){
    	        $c->init($this->we_transact[$objname]);
    	    } else {
    	        $c->init("");
    	    }
	    } else {
    	    $this->used_msgobjs_names[] = $objname;

	        if (!isset($c->msgclass_type) || $c->msgclass_type == 0) {
		        $this->available_folders = array_merge($this->available_folders, $c->get_available_folders());
	        }
	    }

	    $this->send_msgobjs[$objname] = &$c;

	    if (!isset($c->msgclass_type) || $c->msgclass_type == 0) {
    	    $this->used_msgobjs[$objname] = &$c;
	        $this->active_msgobj = &$c;
	    }

    	return 1;
    }

    function set_active_msgobj($classname) {
	if (isset($this->used_msgobjs[$classname])) {
	    $this->active_msgobj = $this->used_msgobjs[$classname];
	    return 1;
	}

	return 0;
    }

    /* Getters And Setters */
    function get_sortitem() {
	return array_key_by_val($this->sortfield, $this->si2sf);
    }

    function get_sortorder() {
		return $this->sortorder;
    }

    function get_ids_selected() {
	if (empty($this->ids_selected))
	    return '';

	return '"' . implode('","', $this->ids_selected) . '"';
    }

    function set_ids_selected($entrsel) {
	$this->ids_selected = explode(',', $entrsel);
    }

    function reset_ids_selected() {
	$this->ids_selected = array();
    }

    function update_last_id() {
	$this->last_id = -1;

	foreach ($this->selected_set as $elem)
	    if ($elem['ID'] > $this->last_id)
		$this->last_id = $elem['ID'];
    }

    function poll_for_new() {
	$c = 0;

	foreach ($this->used_msgobjs as $mo)
	    $c += $mo->get_newmsg_count();

	return $c;
    }

    function &group_by_msgobjs(&$arr) {
	$ret = array();

	foreach ($arr as $elem) {
	    if (isset($ret[$elem['ClassName']]) && is_array($ret[$elem['ClassName']])){
		    array_push($ret[$elem['ClassName']], $elem['ID']);
		} else {
		    $ret[$elem['ClassName']] = array((string)$elem['ID']);
		}
	}

	return $ret;
    }

    function check_folders() {
	/* XXX: Use defines for folder constants, instead of class variables in we_msg_proto.inc.php */
	$this->DB->query('SELECT count(ID) as c FROM '.MSG_FOLDERS_TABLE.' WHERE UserID=' . $this->userid . ' AND (obj_type=3 OR obj_type=5 OR obj_type=9 OR obj_type=11 OR obj_type=13)');
	$this->DB->next_record();
	if ($this->DB->f('c') < 5) {
	    return false;
	}

	return true;
    }

    /* Clipboard methods */
    function set_clipboard($entrsel, $mode) {
	$ids = explode(',', $entrsel);
	$this->clipboard = array();
	foreach ($ids as $id) {
	    $offs = array_ksearch('ID', $id, $this->selected_set);
	    $this->clipboard[] = array('ID' => $this->selected_set[$offs]['int_hdrs']['_ID'],
				       'ClassName' => $this->selected_set[$offs]['hdrs']['ClassName']);
	}

	$this->clipboard_action = $mode;
    }

    function clipboard_paste(&$errs) {
	    global $l_messaging;

	    if ($this->Folder_ID == -1) {
    	    $errs = $l_messaging['cant_paste'];
	        return;
	    }

	    $s_hash = $this->group_by_msgobjs($this->clipboard);
	    $f = $this->get_folder_info($this->Folder_ID);
	    $cn = $f['ClassName'];

	    if (isset($s_hash[$cn])) {
    	    if ($this->clipboard_action == 'cut') {
		        $this->used_msgobjs[$cn]->clipboard_cut($s_hash[$cn], $this->Folder_ID);
	        } else if ($this->clipboard_action == 'copy') {
		        $this->used_msgobjs[$cn]->clipboard_copy($s_hash[$cn], $this->Folder_ID);
	        }

	        if ($this->clipboard_action == 'cut'){
	            $this->reset_clipboard();
	        }
	    }
    }

    function reset_clipboard() {
	    $this->clipboard = array();
    }

    function &reject(&$data) {
		global $l_messaging;
	
		$results = array();
		$results['err'] = array();
		$results['ok'] = array();
		$results['failed'] = array();
		$rcpt_elems = explode(',', urldecode($data['rcpts_string']));
		
		if (empty($this->selected_message)) {
		    $results['err'][] = $l_messaging['no_selection'];
		    $results['failed'] = $rcpt_elems;
		    return $results;
		}
	
		$ret = $this->used_msgobjs[$this->selected_message['hdrs']['ClassName']]->reject($this->selected_message, $data);
		$results['err'] = $ret['err'];
		$results['ok'] = $ret['ok'];
		$results['failed'] = $ret['failed'];
	
		array_splice($this->selected_set, array_ksearch('ID', $this->selected_message['ID'], $this->selected_set), 1);
		$this->selected_message = array();
	
		return $results;
    }

    function forward(&$data) {
		global $l_messaging;
	
		$results = array();
		$results['err'] = array();
		$results['ok'] = array();
		$results['failed'] = array();
		$rcpt_elems = explode(',', urldecode($data['rcpts_string']));
		$rcpts = array();
	
		if (empty($this->selected_message)) {
		    $results['err'][] = $l_messaging['no_selection'];
		    $results['failed'] = $rcpt_elems;
		    return $results;
		}
	
		foreach ($rcpt_elems as $elem) {
		    $rcpt_info = array();
		    $elem = urldecode($elem);
		    if (!$this->get_recipient_info($elem, $rcpt_info, "")) {
			    $results['err'][] = $l_messaging['rcpt_parse_error'];
			    $results['failed'][] = $elem;
			    continue;
		    }
	
		    $rcpts[$rcpt_info['msg_obj']][] = $rcpt_info['address'];
		}
	
		unset($data['rcpts_string']);
	
		foreach ($rcpts as $vals) {
		    $ret = $this->used_msgobjs[$this->selected_message['hdrs']['ClassName']]->forward($vals, $data, $this->selected_message);
		    $results['err'] = array_merge($results['err'], $ret['err']);
		    $results['ok'] = array_merge($results['ok'], $ret['ok']);
		    $results['failed'] = array_merge($results['failed'], $ret['failed']);
		}
	
		return $results;
    }

    function delete_items() {
		foreach ($this->ids_selected as $id) {
		    $offset = array_ksearch('ID', $id, $this->selected_set);
		    $cn = $this->selected_set[$offset]['hdrs']['ClassName'];
		    if (isset($s_hash[$cn]) && is_array($s_hash[$cn])){
		        array_push($s_hash[$cn], array('ID' => $id, 'hdrs' => $this->selected_set[$offset]['int_hdrs']));
		    } else {
		        $s_hash[$cn] = array(array('ID' => $id, 'hdrs' => $this->selected_set[$offset]['int_hdrs']));
		    }
		}
	
		foreach ($s_hash as $cn => $val) {
			$kvals = array_get_kvals('hdrs', $val);
			$di = $this->used_msgobjs[$cn]->delete_items($kvals);
		    if ($di == 1) {
			$ids = array_get_kvals('ID', $val);
			foreach ($ids as $id) {
			    array_splice($this->selected_set, array_ksearch('ID', $id, $this->selected_set), 1);
			    $this->update_last_id();
			}
		    } else {
			echo "Couldn't delete Message ID=" . $val['ID'] . '<br>';
		    }
		}
    }

    function set_login_data($userid, $username) {
	$this->userid = $userid;
	$this->username = $username;
    }

    function save_settings($settings) {

        if (isset($settings['check_step'])) {

            //  Check if there are already saved settings for this user in the DB
            if( $this->DB->num_rows($this->DB->query("SELECT * FROM ".MSG_SETTINGS_TABLE." WHERE strKey=\"check_step\" AND UserID=\"" . $this->userid . "\"" ) ) > 0  ){
                $this->DB->query('UPDATE '.MSG_SETTINGS_TABLE.' SET strVal="' . addslashes($settings['check_step']) . '" WHERE strKey="check_step" AND UserID=' . $this->userid . ' LIMIT 1');
            } else {
                $this->DB->query("INSERT INTO ".MSG_SETTINGS_TABLE." (UserID, strKey, strVal) VALUES('" . $this->userid . "', 'check_step', '" . $settings['check_step'] . "')");
            }
	    }

	return 1;
    }

    function get_settings() {
	$settings = array();

	$this->DB->query('SELECT strKey, strVal FROM '.MSG_SETTINGS_TABLE.' WHERE UserID=' . $this->userid);
	while ($this->DB->next_record()){
	    $settings[$this->DB->f('strKey')] = $this->DB->f('strVal');
	}

	return $settings;
    }

    function get_subfolder_count($id, $classname = '') {
	$classname = $this->available_folders[array_ksearch('ID', $id, $this->available_folders)]['ClassName'];
	if (isset($classname)) {
	    return $this->used_msgobjs[$classname]->get_subfolder_count($id);
	} else {
	    return -1;
	}
    }

    function set_search_settings($search_fields, $search_folder_ids) {
	$this->search_fields = array();
	$this->search_folder_ids = array();

	if (isset($search_fields))
	    foreach ($search_fields as $elem) {
		if (!empty($this->si2sf[$elem]))
		    $this->search_fields[] = $this->si2sf[$elem];
	    }

	$tmp = array_get_kvals('ID', $this->available_folders);
	if (isset($search_folder_ids))
	    foreach ($search_folder_ids as $elem) {
		if (in_array($elem, array_get_kvals('ID', $this->available_folders)))
		    $this->search_folder_ids[] = $elem;
	    }


	return 1;

    }

    /* Intialize the class */
    function init() {
	if($this->we_transact && isset($this->we_transact['we_messaging']))
	    $this->initSessionDat($this->we_transact['we_messaging']);

	/* initialize the used message objects */
	foreach ($this->used_msgobjs_names as $elem) {
	    $this->add_msgobj($elem, 1);
	}

	if (empty($this->available_folders))
	    $this->get_available_folders();

	if (count($this->search_folder_ids) < 1)
	    $this->search_folder_ids = array($this->Folder_ID);
    }

    function initSessionDat($sessDat){
	if ($sessDat) {
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
	$save = array('we_messaging' => array());
	$save['we_messaging'][0] = array();

	for($i=0;$i<sizeof($this->persistent_slots);$i++){
	    eval('$save["we_messaging"][0]["'.$this->persistent_slots[$i].'"]=$this->'.$this->persistent_slots[$i].';');
	}

	$save['we_messaging'][1] = isset($this->elements) ? $this->elements : array();

	/* save the used message objects */
	foreach ($this->used_msgobjs as $key => $val) {
	    $this->used_msgobjs[$key]->saveInSession($save[$key]);
	}
    }

    function save_addresses(&$addressbook) {
	global $l_messaging;

	$this->DB->query('DELETE FROM '.MSG_ADDRBOOK_TABLE.' WHERE UserID=' . $this->userid);
	foreach ($addressbook as $elem) {
	    if (!empty($elem))
		$this->DB->query('INSERT INTO '.MSG_ADDRBOOK_TABLE.' (ID, UserID, strMsgType, strID, strAlias, strFirstname, strSurname) VALUES (NULL, ' . $this->userid . ',"' . addslashes($elem[0]) . '","' . addslashes($elem[1]) .  '","' . addslashes($elem[2]) . '", "", "")');
	}

	return true;
    }

    function get_folder_info($fid) {
	$t = isset($this->available_folders[array_ksearch('ID', $fid, $this->available_folders)]) ? $this->available_folders[array_ksearch('ID', $fid, $this->available_folders)] : NULL;
	return isset($t) ? $t : NULL;
    }

    function get_folder($fid) {
    	$idx = array_ksearch('ID', $fid, $this->available_folders);
    	if ($idx > -1) {
			$t = $this->available_folders[$idx];
			return isset($t) ? $t : NULL;
    	}
		return NULL;
    }

    function &get_inbox_folder($classname) {
	$c = 0;

	if (!isset($this->used_msgobjs[$classname]))
	    return NULL;

	while (($c = array_ksearch('obj_type', MSG_FOLDER_INBOX, $this->available_folders, $c)) != -1 && $this->available_folders[$c]['ClassName'] != $classname)
	    $c++;
	$r = isset($this->available_folders[$c]) ? $this->available_folders[$c] : NULL;
	return $r;
    }

    function &get_addresses() {
	$ret = array();

	$this->DB->query('SELECT strMsgType, strID, strAlias FROM '.MSG_ADDRBOOK_TABLE.' WHERE UserID=' . $this->userid);
	while($this->DB->next_record()) {
	    $ret[] = array($this->DB->f('strMsgType'), $this->DB->f('strID'), $this->DB->f('strAlias'));
	}

	return $ret;
    }

    function get_available_folders() {
	$this->available_folders = array();

	foreach ($this->used_msgobjs as $key => $val) {
	    $this->available_folders = array_merge($this->available_folders, $this->used_msgobjs[$key]->get_available_folders());
	}
    }

    function get_message_count($folderid, $classname = '') {
	$classname = $this->available_folders[array_ksearch('ID', $folderid, $this->available_folders)]['ClassName'];
	if (isset($classname)) {
	    return $this->used_msgobjs[$classname]->get_count($folderid);
	} else {
	    return -1;
	}
    }

    function delete_folders($ids) {
	$ret = array();
	$ret['ids'] = array();
	$nids = array();
	for($i = 0, $len = count($ids); $i < $len; $i++) {
	    preg_match('/\d+$/', $ids[$i], $m);
	    $nids[] = $m[0];
	}

	foreach ($nids as $f_id) {
	    $cn = $this->available_folders[array_ksearch('ID', $f_id, $this->available_folders)]['ClassName'];
	    if (isset($s_hash[$cn]) && is_array($s_hash[$cn])){
		    array_push($s_hash[$cn], (string)$f_id);
		} else {
		    $s_hash[$cn] = array((string)$f_id);
		}
	}

	foreach ($s_hash as $key => $val) {
	    $mo_ret = $this->used_msgobjs[$key]->delete_folders($val);
	    if ($mo_ret['res'] == 1) {
		    $ret['ids'] = array_merge($ret['ids'], $mo_ret["ids"]);
		    foreach ($mo_ret['ids'] as $id)
    		    if (($ind = array_ksearch('ID', $id, $this->available_folders)) != -1)
			        array_splice($this->available_folders, $ind, 1);
	    }
	}

	$ret['ids'] = $ret['ids'];
	$ret['res'] = 1;

	return $ret;
    }

    function cmp_asc($a, $b) {
	if ($a[$this->sortfield[0]][$this->sortfield[1]] == $b[$this->sortfield[0]][$this->sortfield[1]])
	    return 0;

	return ($a[$this->sortfield[0]][$this->sortfield[1]] > $b[$this->sortfield[0]][$this->sortfield[1]] ? -1 : 1);
    }

    function cmp_desc($a, $b) {
	if ($a[$this->sortfield[0]][$this->sortfield[1]] == $b[$this->sortfield[0]][$this->sortfield[1]])
	    return 0;

	return ($a[$this->sortfield[0]][$this->sortfield[1]] > $b[$this->sortfield[0]][$this->sortfield[1]] ? 1 : -1);
    }

    function sort_set() {
	if (!empty($this->selected_set)) {
	    if (($this->last_sortfield != $this->sortfield) || $this->sortorder != 'desc') {
		usort($this->selected_set, array($this, 'cmp_desc'));
		$this->sortorder = 'desc';
	    } else {
		usort($this->selected_set, array($this, 'cmp_asc'));
		$this->sortorder = 'asc';
	    }

	    $this->last_sortfield = $this->sortfield;
	}
    }

    function save_sortstuff($id, $sortfield, $sortorder) {
	return $this->active_msgobj->save_sortstuff($id, $sortfield, $sortorder);
    }

    function init_sortstuff($id, $classname) {
	if (empty($classname)) {
	    $this->sortfield = $this->sf2sh[$this->active_msgobj->get_sortfield($id)];
	    $this->sortorder = $this->sf2sh[$this->active_msgobj->get_sortorder()];
	} else {
	    $this->sortfield = $this->sf2sf[$this->used_msgobjs[$classname]->get_sortfield($id)];
	    $this->sortorder = $this->sf2sf[$this->used_msgobjs[$classname]->get_sortorder()];
	}
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

    function get_header($id, $headername) {
	return $this->selected_message[$headername];
    }

    function get_userid($username) {
	$username = trim($username);
	$this->DB->query('SELECT ID FROM '.USER_TABLE.' WHERE username="' . addslashes($username) . '"');
	if ($this->DB->next_record())
	    return $this->DB->f('ID');

	return -1;
    }

    function get_recipient_info($r, &$rcpt_info, $msgobj_name = '') {
	$add_is_email = 0;
	$rcpt_info['address'] = trim($r);

	if (strpos($rcpt_info['address'], '@', 1) != 0)
	    $addr_is_email = 1;

	if (!empty($msgobj_name)) {
	    $rcpt_info['msg_obj'] = $msgobj_name;

	    if (isset($addr_is_email) && $addr_is_email && ($rcpt_info['msg_obj'] != 'we_msg_email'))
		return 0;
	} else if (isset($addr_is_email) && $addr_is_email)
	    $rcpt_info['msg_obj'] = 'we_msg_email';
	else
	    $rcpt_info['msg_obj'] = 'we_message';

	return 1;
    }

    function send(&$data, $msgobj_name = '') {
	global $l_messaging;

	$results = array();
	$results['err'] = array();
	$results['ok'] = array();
	$results['failed'] = array();
	$rcpt_elems = explode(',', urldecode($data['rcpts_string']));
	$rcpts = array();

	foreach ($rcpt_elems as $elem) {
	    $rcpt_info = array();
	    $elem = urldecode($elem);
	    if (!$this->get_recipient_info($elem, $rcpt_info, isset($msgobj_name) ? $msgobj_name : "")) {
		$results['err'][] = $l_messaging['rcpt_parse_error'];
		$results['failed'][] = $elem;
		continue;
	    }

	    $rcpts[$rcpt_info['msg_obj']][] = $rcpt_info['address'];
	}

	unset($data['rcpts_string']);

	foreach ($rcpts as $obj_name => $vals) {
	    $ret = $this->send_msgobjs[$obj_name]->send($vals, $data);
	    $results['err'] = array_merge($results['err'], $ret['err']);
	    $results['ok'] = array_merge($results['ok'], $ret['ok']);
	    $results['failed'] = array_merge($results['failed'], $ret['failed']);
	}

	return $results;
    }

    function get_fc_data($id, $sortitem, $searchterm, $usecache = 1) {
	$sortfield = isset($this->si2sf[$sortitem]) ? $this->si2sf[$sortitem] : "";
	if ($id == '' && empty($searchterm) && $usecache) {
	    $this->cont_from_folder = 0;
	    if (!empty($sortfield)) {
		$this->sortfield = $sortfield;
		$this->sort_set();
		$this->save_sortstuff($this->Folder_ID, array_key_by_val($sortfield, $this->sf2sh), $this->sortorder);
	    }
	} else {
	    $this->selected_set = array();
	    $this->last_id = -1;
	    $search_cond = array();

	    if ($id != '') {
		$this->cont_from_folder = 1;
		$this->Folder_ID = $id;
		if ($this->search_folder_ids[0] == -1) {
		    $this->search_folder_ids = array($id);
		}
	    }

	    if (!empty($searchterm) && !empty($this->search_fields)) {
		$this->Folder_ID = -1;
		$s_hash = array();

		foreach ($this->search_folder_ids as $sfolder) {
		    $cn = $this->available_folders[array_ksearch('ID', $sfolder, $this->available_folders)]['ClassName'];
		    if (isset($s_hash[$cn]) && is_array($s_hash[$cn]))
			array_push($s_hash[$cn], $sfolder);
		    else
			$s_hash[$cn] = array("$sfolder");
		}

		foreach ($s_hash as $m_key => $m_val) {
		    $arr = array('searchterm' => $searchterm,
				 'search_fields' => $this->search_fields,
				 'search_folder_ids' => $m_val,
				 'start_id' => $this->last_id);
		    $this->selected_set = array_merge($this->selected_set, $this->used_msgobjs[$m_key]->get_msg_set($arr));
		    $this->update_last_id();
		}
	    } else {
/*		if (empty($sortfield))
		    $this->init_sortstuff($id, '');
		else
		    $this->save_sortstuff($id, array_key_by_val($sortfield, $this->sf2sh), $this->sortorder);*/

//		$this->ids_selected = array();

//		echo "ID=$id<br>\n";
		if(array_ksearch('ID', $id, $this->available_folders) != "-1"){
		    $o   = $this->used_msgobjs[$this->available_folders[array_ksearch('ID', $id, $this->available_folders)]['ClassName']];
		} else {
		    $o = null;
		}
		$arr = array('folder_id' => $id, 'last_id' => $this->last_id);
		$this->selected_set = isset($o)? $o->get_msg_set($arr) : array();
		$this->update_last_id();

		$this->last_sortfield = (isset($o) && isset($this->sf2sh[$o->get_sortfield()])) ? $this->sf2sh[$o->get_sortfield()] : "";
		$this->sortfield = $this->last_sortfield;
		$this->sortorder = isset($o) ? $o->get_sortorder() : "";
	    }

	}
    }

    /* Message-Data for the messaging_message_view Frame */
    /* params: ID - id of the shown message */
    function get_mv_data($id, $classname = '') {
	$this->selected_message = array();
	    if (isset($id)) {
    	    if(array_ksearch('ID', $id, $this->selected_set) != "-1"){
                $m = $this->selected_set[array_ksearch('ID', $id, $this->selected_set)];
	        }
	        if (!empty($m)) {
    		    $arr =  array($m['int_hdrs']);
		        $this->selected_message = array_pop($this->used_msgobjs[$m['hdrs']['ClassName']]->retrieve_items($arr));
	        }
	    }
    }

    function get_short_description($type) {
	if (!empty($type) && isset($this->used_msgobjs[$type])) {
	    return $this->used_msgobjs[$type]->Short_Description;
	}

	return;
    }

    function print_select_search_fields() {
    	$out = "";
		foreach ($this->sf_names as $key => $val) {
	   	 	$out .= '<option value="' . $key . '"' . (arr_in_array($this->si2sf[$key], $this->search_fields) ? ' selected' : '') . '>' . $val . "</option>\n";
		}
		return $out;
    }

    function &create_folder($name, $parent_id, $type) {
	global $l_messaging;

	$ret = array();

	/* Sanity Checks */
	if (empty($type) || !isset($this->used_msgobjs[$type])) {
	    $ret[] = -1;
	    $ret[] = $l_messaging['msg_type_not_found'];
	    return $ret;
	}

	if ((($ind = array_ksearch('Name', $name, $this->available_folders)) >= 0) && ($this->available_folders[$ind]['ParentID'] == $parent_id)) {
	    $ret[] = -1;
	    $ret[] = $l_messaging['children_same_name'];
	    return $ret;
	}

	$parent_id = $parent_id == -1 ? 0 : $parent_id;

	//XXX: Parent-check must be done by $type object;
	if ($parent_id != 0 && !in_array($parent_id, array_get_kvals('ID', $this->available_folders))) {
	    $ret[] = -1;
	    $ret[] = $l_messaging['no_parent_folder'];
	    return $ret;
	}

	if (($id = $this->used_msgobjs[$type]->create_folder($name, $parent_id)) != -1) {
	    $this->available_folders[] = array('ID' => $id,
						'ParentID' => $parent_id,
						'ClassName' => $type,
						'Name' => $name);

	    $ret[] = $id;
	    $ret[] = $l_messaging['folder_created'];
	} else {
	    $ret = -1;
	    $ret[] = $l_messaging['folder_create_error'];
	}

	return $ret;
    }

    function modify_folder($fid, $folder_name, $parent_folder) {
	global $l_messaging;

	$ret = array();

	if (!is_numeric($fid) || !is_numeric($parent_folder)) {
	    $ret[] =  -1;
	    $ret[] = $l_messaging['param_wrong_type'];
	    return $ret;
	}

	if ($parent_folder != -1 && ($fid == $parent_folder || !$this->valid_parent_folder($fid, $parent_folder))) {
	    $ret[] =  -1;
	    $ret[] = $l_messaging['parentfolder_invalid'];
	    return $ret;
	}

	if (($f = $this->get_folder($fid)) == NULL) {
	    $ret[] =  -1;
	    $ret[] = $l_messaging['folderid_invalid'];
	    return $ret;
	}

	if ($this->used_msgobjs[$f['ClassName']]->modify_folder($fid, $folder_name, $parent_folder)) {
	    $ind = array_ksearch('ID', $fid, $this->available_folders);
	    $this->available_folders[$ind]['Name'] = $folder_name;
	    $this->available_folders[$ind]['ParentID'] = $parent_folder;
	    $ret[] = 1;
	    $ret[] = $l_messaging['folder_modified'];
	} else {
	    $ret[] =  -1;
	    $ret[] = $l_messaging['folder_change_failed'];
	}

	return $ret;
    }

    function valid_parent_folder($folder, $parent) {
	static $children = array();

	foreach ($this->available_folders as $f) {
	    if ($f['ParentID'] == $folder) {
		$children[] = $f['ID'];
		$this->valid_parent_folder($f['ID'], $parent);
	    }
	}

	if (in_array($parent, $children))
	    return 0;

	return 1;
    }

    function &get_wesel_available_folders() {
    	$fooArray = array(
    						"sent" => $GLOBALS["l_messaging"]["folder_sent"],
    						"messages" => $GLOBALS["l_messaging"]["folder_messages"],
    						"done" => $GLOBALS["l_messaging"]["folder_done"],
    						"task" => $GLOBALS["l_messaging"]["folder_todo"],
    						"rejected" => $GLOBALS["l_messaging"]["folder_rejected"],
   							"todo" => $GLOBALS["l_messaging"]["folder_todo"]
    					);

    	$matchArray = array("Name" => $fooArray);

    	$mergedArray = array_merge(
    		array(
    			array(
    				'ID' => '0',
    				'Name' => "-- ".$GLOBALS["l_messaging"]["nofolder"]." --"
    			)
    		),
			array_hash_construct(
				$this->available_folders,
				array('ID', 'Name'),
				$matchArray
			)
		);

		$_arr1 = array('ID', 'Name');

		$_ret = arr_hash_to_wesel_hash($mergedArray, $_arr1);
		return $_ret;
    }

    function &get_wesel_folder_types() {
	$ret_arr = array();

	foreach ($this->used_msgobjs as $mo)
	    $ret_arr[$mo->ClassName] = $mo->Short_Description;

	return $ret_arr;
    }

    function print_select_search_folders() {
    	$out = "";
		foreach ($this->available_folders as $key => $val) {
	    	$out .= '<option value="' . $val['ID'] . '"' . (in_array($val['ID'], $this->search_folder_ids) ? ' selected' : '') . '>' . $val['Name'] . "</option>\n";
		}
		return $out;
    }
}

?>
