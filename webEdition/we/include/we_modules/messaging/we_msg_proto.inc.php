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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_class.inc.php");
include_once(WE_MESSAGING_MODULE_DIR."messaging_defs.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");

/* message protocol root class */
class we_msg_proto extends we_class {

    /*****************************************************************/
    /* Class Properties **********************************************/
    /*****************************************************************/

    /* Name of the class => important for reconstructing the class from outside the class */
    var $ClassName = 'we_msg_proto';
    /* In this array are all storagable class variables */
    var $persistent_slots = array();
    /* Name of the Object that was createt from this class */
    var $Name='';

    /* ID from the database record */
    var $ID=0;
    
    /* Database Object */
    var $DB_WE;
    
    /* Flag which is set when the file is not new */
    var $wasUpdate = 0;
    
    var $InWebEdition = 0;

    var $Folder_ID = -1;

    var $userid = -1;

    var $username = '';

    var $selected_message = array();

    var $selected_set = array();

    var $search_ids = array();

    var $search_fields = array('headerSubject', 'headerFrom', 'MessageText');

    var $search_folder_ids = array();

    var $sortfield = 'headerDate';

    var $last_sortfield = '';

    var $sortorder = 'desc';

    var $ids_selected = array();

    var $available_folders = array();

    var $cached = array('sortorder' => 0,
			'sortfield' => 0);

//    var $got_sortstuff_from_db = 0;
    var $update_interval = 10;

    var $default_folders = array(13	=> -1, /* done - Folder */
				 11	=> -1, /* rejected - Folder */
				 9	=> -1, /* trash - Folder */
				 5	=> -1, /* sent - Folder */
				 3	=> -1); /* inbox - Folder */

    var $table = MESSAGES_TABLE;

    var $folder_tbl = MSG_FOLDERS_TABLE;

    /*****************************************************************/
    /* Class Methods *************************************************/
    /*****************************************************************/
    
    /* Constructor */
    function we_msg_proto() {
	$this->Name = 'msg_proto_' . md5(uniqid(rand()));
	array_push($this->persistent_slots, 'ClassName','Name','ID','Table', 'Folder_ID', 'selected_message', 'sortorder', 'last_sortfield', 'search_ids', 'available_folders', 'search_folder_ids', 'search_fields', 'cached');
	$this->DB = new DB_WE();
    }

    /* Getters And Setters */
    function get_sortitem() {
	if (empty($this->sortfield))
	    $this->init_sortstuff($this->Folder_ID);

	return $this->sf2si[$this->sortfield];
    }

    function get_entries_selected() {
	if (empty($this->ids_selected))
	    return '';

	return '"' . implode('","', $this->ids_selected) . '"';
    }

    function set_entries_selected($entrsel) {
	$this->ids_selected = explode(',', $entrsel);
    }

    function reset_entries_selected() {
	$this->ids_selected = array();
    }

    function set_login_data($userid, $username) {
	$this->userid = $userid;
	$this->username = $username;
    }

    function get_sortfield() {
	if ($this->cached['sortfield'] != 1) {
	    $this->init_sortstuff($this->Folder_ID);
	}

	return $this->sortfield;
    }

    function get_sortorder() {
		if ($this->cached['sortorder'] != 1) {
		    $this->init_sortstuff($this->Folder_ID);
		}
	
		return $this->sortorder;
	    }

    /* Get all values for $key in an array of hashes */
    /* params: key, hash */
    /* returns: array of the values for the key */
    function array_get_kvals($key, $hash) {
	$ret_arr = array();

	foreach ($hash as $elem) {
	    $ret_arr[] = $elem[$key];
	}

	return $ret_arr;
    }

    function get_subfolder_count($id) {
	$this->DB->query('SELECT count(ID) as c FROM ' . $this->folder_tbl . ' WHERE ParentID=' . addslashes($id) . ' AND UserID=' . $this->userid);

	if ($this->DB->next_record() && $this->DB->f('c') > 0)
	    return $this->DB->f('c');

	return -1;
    }

    function set_search_settings($search_fields, $search_folder_ids) {
	$this->search_fields = array();
	$this->search_folder_ids = array();

	if (isset($search_fields)) 
		foreach ($search_fields as $elem) {
		    if (!empty($this->si2sf[$elem])) 
			$this->search_fields[] = $this->si2sf[$elem];
		}

	if (isset($search_folder_ids)) 
	    foreach ($search_folder_ids as $elem) {
		if (in_array($elem, $this->array_get_kvals('ID', $this->available_folders))) 
		    $this->search_folder_ids[] = $elem;
		}
    }

    /* Intialize the class. If $sessDat (array) is set, the class will be initialized from this array */
    function init($sessDat){
	if($sessDat) 
	    $this->initSessionDat($sessDat);

/*	if (empty($this->available_folders))
	    $this->get_available_folders();*/
    }

    function initSessionDat($sessDat){ 
	if ($sessDat) {
	    for ($i = 0; $i < sizeof($this->persistent_slots); $i++) {
		if (isset($sessDat[0][$this->persistent_slots[$i]])) {
		    eval('$this->' . $this->persistent_slots[$i] . '=$sessDat[0][$this->persistent_slots[$i]];');
		}
	    }
    
	    if (isset($sessDat[1])) 
		$this->elements = $sessDat[1];
	}
    }

    function saveInSession(&$save){
//	$save = array();
	$save[0] = array();

	for($i=0;$i<sizeof($this->persistent_slots);$i++){
	    eval('$save[0]["'.$this->persistent_slots[$i].'"]=$this->'.$this->persistent_slots[$i].';');
	}

	$save[1] = isset($this->elements) ? $this->elements : array();
    }

    function get_available_folders() {
	$this->available_folders = array();

	$this->DB->query('SELECT ID, ParentID, account_id, Name, obj_type FROM  ' . $this->folder_tbl . ' WHERE msg_type=' . $this->sql_class_nr  . ' AND UserID=' . $this->userid);
	//$this->DB->query('SELECT ID, ParentID, account_id, Name, obj_type FROM  ' . $this->folder_tbl . ' WHERE msg_type=' . $this->sql_class_nr  . ' AND UserID=' . $this->userid);
	while ($this->DB->next_record()) {
	    $this->available_folders[] = array('ID' => $this->DB->f('ID'),
						'ParentID' => $this->DB->f('ParentID'),
						'ClassName' => $this->ClassName,
						'account_id' => $this->DB->f('account_id'),
						'obj_type' => $this->DB->f('obj_type'),
						'view_class' => $this->view_class,
						'Name' => $this->DB->f('Name'));
	}

	return $this->available_folders;
    }

    function create_folder($name, $parent) {
	$this->DB->query('INSERT INTO ' . $this->folder_tbl . ' (ID, ParentID, UserID, account_id, msg_type, obj_type, Name) VALUES (NULL, ' . addslashes($parent) . ', ' . $this->userid . ', -1, ' . $this->sql_class_nr . ', ' . MSG_FOLDER_NR . ', "' . addslashes($name) . '")');
	$this->DB->query('SELECT LAST_INSERT_ID() as l');
	$this->DB->next_record();

	return $this->DB->f('l');
    }

    function modify_folder($fid, $folder_name, $parent_folder) {
	if (!is_numeric($fid) || !is_numeric($parent_folder)) {
	    return -1;
	}

	$query = 'UPDATE ' . $this->folder_tbl . ' SET Name="' . addslashes($folder_name) . '", ParentID=' . addslashes($parent_folder) . ' WHERE ID=' . addslashes($fid) . ' AND UserID=' . $this->userid;
	$this->DB->query($query);
	return 1;
    }

    /* get subtree starting with node $id (only the folders) */
    function &get_f_children($id) {
	$fids = array();

	$this->DB->query('SELECT ID FROM ' . $this->folder_tbl . ' WHERE ParentID=' . addslashes($id) . ' AND UserID=' . $this->userid);
	while ($this->DB->next_record())
	    $fids[] = $this->DB->f('ID');    

	foreach ($fids as $fid)
	    $fids = array_merge($fids, $this->get_f_children($fid));

	return $fids;
    }

    function delete_folders($f_arr) {

    $ret = array();
    $ret["res"] = 0;
    $ret["ids"] = array();
        
	if (empty($f_arr)){
	    return $ret;
	    
	}
	    
	$rm_folders = array();
	$rm_fids = $f_arr;
	$norm_folderds = array();

	foreach ($f_arr as $id) {
	    $rm_fids = array_merge($rm_fids, $this->get_f_children($id));
	}

	$cond = '';
	foreach ($rm_fids as $rf) {
	    $cond .= 'ID=' . addslashes($rf) . ' OR ';
	}
	$cond = substr($cond, 0, -4);

	$query = 'SELECT ID, Name, (Properties & ' . MSG_FOLDER_NR . ') as norm FROM ' . $this->folder_tbl . " WHERE ($cond) AND UserID=" . $this->userid;
	$this->DB->query($query);
	while($this->DB->next_record()) {
	    if ($this->DB->f('norm') == 1) {
		$norm_folders[] = $this->DB->f('Name') . ' (ID=' . $this->DB->f('ID') . ')';
	    } else {
		$rm_folders[] = $this->DB->f('ID');
	    }
	}
    
	if (empty($rm_folders)) {
	    return $ret;
	} else {
	    $query = 'DELETE FROM ' . $this->folder_tbl . ' WHERE (ID=' . join(' OR ID=', $rm_folders) . ') AND UserID=' . $this->userid;
	    $this->DB->query($query);
	}
    
    $ret["res"] = 1;
    $ret["ids"] = $rm_folders;
    
	return $ret;
    }

    function cmp_asc($a, $b) {
	if ($a[$this->sortfield] == $b[$this->sortfield])
	    return 0;

	return ($a[$this->sortfield] > $b[$this->sortfield] ? 1 : -1);
    }

    function cmp_desc($a, $b) {
	if ($a[$this->sortfield] == $b[$this->sortfield])
	    return 0;

	return ($a[$this->sortfield] > $b[$this->sortfield] ? -1 : 1);
    }

    function sort_set() {
	if (!empty($this->selected_set)) {
	    if (($this->last_sortfield != $this->sortfield) || $this->sortorder != 'asc') {
		usort($this->selected_set, array($this, 'cmp_asc'));
		$this->sortorder = 'asc';
	    } else {
		usort($this->selected_set, array($this, 'cmp_desc'));
		$this->sortorder = 'desc';
	    }

	    $this->last_sortfield = $this->sortfield;
	}
    }

    function save_sortstuff($id, $sortfield, $sortorder) {
	if ($sortorder == 'asc')
	    $sortorder = 'desc';
	else
	    $sortorder = 'asc';
		    
	$this->DB->query('UPDATE ' . $this->folder_tbl . ' SET sortItem="' . addslashes($sortfield) . '", sortOrder="' . addslashes($sortorder) . '" WHERE ID=' . addslashes($id) . ' AND UserID=' . $this->userid);
    }

    function init_sortstuff($id) {
	$this->DB->query('SELECT sortItem, sortOrder FROM ' . $this->folder_tbl . ' WHERE ID=' . addslashes($id) . ' AND UserID=' . $this->userid);
	$this->DB->next_record();

	if (($this->DB->f('sortItem'))) {
	    $this->sortfield = $this->DB->f('sortItem');
	}

	if (($this->DB->f('sortOrder'))) {
	    if ($this->DB->f('sortOrder') == 'asc')
		$this->sortorder = 'desc';
	    else if ($this->DB->f('sortOrder') == 'desc')
		$this->sortorder = 'asc';
	}

	$this->cached[] = 'sortfield';
	$this->cached[] = 'sortorder';
//	$this->got_sortstuff_from_db = 1;
    }
}
    
?>
