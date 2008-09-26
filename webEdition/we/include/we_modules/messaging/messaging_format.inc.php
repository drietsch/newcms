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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_class.inc.php");
include_once(WE_MESSAGING_MODULE_DIR . "messaging_std.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/messaging.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");

/* message object class */
class we_format extends we_class {

	/*****************************************************************/
	/* Class Properties **********************************************/
	/*****************************************************************/

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName = 'we_format';
	/* In this array are all storagable class variables */
	var $persistent_slots = array();
	/* Name of the Object that was createt from this class */
	var $Name='';

	/* ID from the database record */
	var $ID=0;

	/* database table in which the object is stored */
	var $Table = MESSAGES_TABLE;

	/* Database Object */
	var $DB_WE;

	/* Flag which is set when the file is not new */
	var $wasUpdate=0;

	var $InWebEdition = 0;

	var $Folder_ID = -1;

	var $userid = -1;

	var $username = '';

	var $mode = '';

	var $fromheader = '';

	var $subject = '';

	var $messagetext = '';

	var $selected_recipient = -1;

	var $sel_msg = NULL;

	var $highlight_quoting = 1;

	var $quote_levels = 3;

	var $attribution_line;

	var $quoting_prefix = '> ';

	var $selected_cc = array();

	/*****************************************************************/
	/* Class Methods *************************************************/
	/*****************************************************************/

	/* Constructor */
	function we_format($mode, $sel_msg = NULL) {
		global $l_messaging;

		$this->Name = 'messageformat_' . md5(uniqid(rand()));
		array_push($this->persistent_slots, 'ClassName','Name','ID','Table', 'mode', 'userid', 'username');
		$this->DB = new DB_WE();
		$this->mode = $mode;
		$this->sel_msg = $sel_msg;
		$this->msg_obj = isset($sel_msg['hdrs']['ClassName']) ? $sel_msg['hdrs']['ClassName'] : "";
		$this->attribution_line = $l_messaging['attrib_line'] . ':';
	}

	/* Getters And Setters */
	function set_login_data($userid, $username) {
		$this->userid = $userid;
		$this->username = $username;
	}

	/* Get all values for $key in an array of hashes */
	/* params: key, hash */
	/* returns: array of the values for the key */
	function array_get_kvals($key, $hash) {
		$ret_arr = array();

		foreach ($hash as $elem)
			$ret_arr[] = $elem[$key];

		return $ret_arr;
	}

	/* Intialize the class. If $sessDat (array) is set, the class will be initialized from this array */
	function init($sessDat){
		switch ($this->mode) {
		    case 're':
			$this->selected_recipient = $this->sel_msg['int_hdrs']['_reply_to'];
			break;
		    default:
			break;
		}

		if($sessDat)
			$this->initSessionDat($sessDat);
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
		$save = array();
		$save[0] = array();
		for($i=0;$i<sizeof($this->persistent_slots);$i++){
			eval('$save[0]["'.$this->persistent_slots[$i].'"]=$this->'.$this->persistent_slots[$i].';');
		}
		$save[1] = $this->elements;

	}

	function userid_to_username($id) {
		global $l_messaging;
		$db2 = new DB_WE();
		$db2->query('SELECT username FROM '.USER_TABLE.' WHERE ID=' . addslashes($id));
		if ($db2->next_record())
			return $db2->f('username');

		return $l_messaging['userid_not_found'];
	}

	function get_date() {
	    $ret = '';
	    switch ($this->mode) {
		case 'update':
		case 'view':
		    $ret = date($GLOBALS['l_global']['date_format'], isset($this->sel_msg['hdrs']['Date']) ? $this->sel_msg['hdrs']['Date'] : "");
		    break;
		default:
		    break;
	    }

	    return $ret;
	}

	function get_from() {
		$ret = '';

		switch ($this->mode) {
		    case 'new':
		    case 'forward':
		    case 're':
			$ret = get_nameline($this->userid);
			break;
		    default:
			$ret = isset($this->sel_msg['hdrs']['From']) ? $this->sel_msg['hdrs']['From'] : "";
			break;
		}

		return $ret;
	}

	function get_assigner() {
		$ret = '';

		if ($this->msg_obj == 'we_todo') {
		    if (!empty($this->sel_msg['hdrs']['Assigner'])) {
			$ret = $this->sel_msg['hdrs']['Assigner'];
		    } else {
			$ret = $this->sel_msg['hdrs']['From'];
		    }
		}

		return $ret;
	}

	function get_priority() {
	    $ret = '';

	    if ($this->msg_obj == 'we_todo') {
		$ret = $this->sel_msg['hdrs']['Priority'];
	    }

	    return $ret;
	}

	function get_subject() {
		$ret = isset($this->sel_msg['hdrs']['Subject']) ? $this->sel_msg['hdrs']['Subject'] : "";

		switch ($this->mode) {
		    case 're':
			if (substr($ret, 0, 4) != 'Re: ') {
			    $ret = "Re: $ret";
			}
			break;
		    case 'new':
			$ret = '';
			break;
		    default:
			break;
		}

		return $ret;
	}

	function get_deadline() {
	    $ret = 0;

	    switch ($this->mode) {
		case 'update':
		case 'forward':
		    $ret = $this->sel_msg['hdrs']['Deadline'];
		    break;
		case 'view':
		    $ret = date($GLOBALS['l_global']['date_format'], $this->sel_msg['hdrs']['Deadline']);
		    break;
		case 'new':
		    $ret = time();
		    break;
		default:
		    break;
	    }

	    return $ret;
	}

	function get_status() {
	    if ($this->msg_obj != 'we_todo')
		return -1;

	    $ret = '';

	    switch ($this->mode) {
		case 'update':
		case 'view':
		    $ret = $this->sel_msg['hdrs']['status'] . '%';
		    break;
		default:
		    break;
	    }

	    return $ret;
	}

	function get_recipient_line() {
	    $ret = '';

	    switch ($this->mode) {
		case 're':
		    $ret = $this->sel_msg['int_hdrs']['_reply_to'];
		    break;
		case 'reject':
		    $ret = $this->sel_msg['hdrs']['Assigner'];
		case 'forward':
		default:
		    break;
	    }

	    return $ret;
	}

	function get_recipient_id() {
		return $this->selected_recipient;
	}

	function &get_msg_text() {
		$ret = '';

		switch ($this->mode) {
		    case 're':
			$ret .= $this->attribution_line . "\n";

			$lines = split("\n", htmlspecialchars($this->sel_msg['body']['MessageText']));

			$ret .= (!empty($lines) ? htmlspecialchars($this->quoting_prefix) : '') . join("\n" . htmlspecialchars($this->quoting_prefix), $lines) . "\n\n";
			break;
		    case 'view':
		    case 'update':
			if (isset($this->sel_msg['hdrs']['Content_Type']) && $this->sel_msg['hdrs']['Content_Type'] == 'html') {
			    $ret .= $this->sel_msg['body']['MessageText'];
			} else {
			    if ($this->highlight_quoting) {
				$lines = split("\n", isset($this->sel_msg['body']['MessageText']) ? $this->sel_msg['body']['MessageText'] : "");
				foreach ($lines as $line) {
				    $l = -1;
				    $len = strlen($this->quoting_prefix);

				    do {
					$pos = strpos($line, $this->quoting_prefix, $len * ++$l);
				    } while (is_integer($pos) && $pos == $len*$l && $l < $this->quote_levels);
				    $ret .= '<span class="quote_lvl_' . $l . '">' .  nl2br(htmlspecialchars($line)) . '</span>';
				}
			    } else {
				$ret .= nl2br(htmlspecialchars($this->sel_msg['body']['MessageText']));
			    }
			}
			break;
		    case 'forward':
			$ret .= nl2br(htmlspecialchars($this->sel_msg['body']['MessageText']));
			break;
		    case 'new':
		    default:
			$ret = '';
			break;
		}

		return $ret;
	}

	function &get_todo_history() {
	    global $l_messaging;

	    if ($this->msg_obj != 'we_todo') {
		return NULL;
	    }

	    $ret = '';

	    foreach ($this->sel_msg['body']['History'] as $c) {
		$hist_str = '';
		switch ($c['action']) {
		    case 1:
			$hist_str = $l_messaging['comment_created'];
			break;
		    case 2:
			$hist_str =  $l_messaging['forwarded_to'] . ' ' . $c['username'];
			break;
		    case 3:
			$hist_str =  $l_messaging['rejected_to']. ' ' . $c['username'];
		    default:
			break;
		}
		$ret .= '<span class="todo_hist_hdr">--- ' . $this->userid_to_username($c['from_userid']) . ' -- ' . date($GLOBALS['l_global']['date_format'], $c['date']) . ' -- ' . $hist_str . "</span><br>\n";
		if (!empty($c['comment'])) {
		    $ret .= nl2br(htmlspecialchars($c['comment'])) . "<br><br>\n";
		}
	    }

	    if (!empty($ret)) {
		$ret = substr($ret, 0, -5);
	    }

	    return $ret;
	}

	function print_select_users() {
		foreach ($this->sf_names as $key => $val) {
			echo '<option value="' . $key . '"' . (in_array($this->si2sf[$key], $this->search_fields) ? ' selected' : '') . '>' . $val . "</option>\n";
		}
	}

}

?>
