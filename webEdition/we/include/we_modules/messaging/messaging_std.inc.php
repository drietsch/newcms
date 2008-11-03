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
include_once(WE_MESSAGING_MODULE_DIR . "we_messaging.inc.php");

// exit if script called directly
if (str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME'])=="/messaging_std.inc.php") {
	exit();
}


/* Get all values for $key in an array of hashes (e.g. get all ID values) */
/* params: key, hash */
/* returns: array of the values for the key */
function array_get_kvals($key, &$arr) {
    $ret_arr = array();

    foreach ($arr as $elem) {
	$ret_arr[] = $elem[$key];
    }

    return $ret_arr;
}

function array_hash_construct($arr_hash, $keys, $map="") {
    $ret_arr = array();
    $len_arr = count($arr_hash);

    for ($i = 0; $i < $len_arr; $i++) {
	$tmp_hash = array();

	foreach ($keys as $key){
		if(is_array($map) && sizeof($map)){
			if(isset($map[$key])){
				foreach($map[$key] as $k=>$v){
					if(strtolower($k)==strtolower($arr_hash[$i][$key])){
						$arr_hash[$i][$key] = $v;
						break;
					}
				}
			}
		}
	    $tmp_hash[$key] = $arr_hash[$i][$key];
	}

	array_push($ret_arr, $tmp_hash);
    }

    return $ret_arr;
}

/*
 * Convert array of hashes to a single hash, using the first and second field
 * of each hash as key => val of the returned hash.
 */
function arr_hash_to_wesel_hash($arr_hash, $keys) {
    $ret_hash = array();
    $len_arr = count($arr_hash);

    for ($i = 0; $i < $len_arr; $i++) {
	$ret_hash[$arr_hash[$i][$keys[0]]] = $arr_hash[$i][$keys[1]];
    }

    return $ret_hash;
}

/* php 4.0.0 does not support array comparison using the == operator */
function array_cmp(&$arr1, &$arr2) {
    if (count($arr1) != count($arr2))
	return 0;

    for ($i = 0; $i < count($arr1); $i++)
	if ($arr1[$i] != $arr2[$i])
	    return 0;

    return 1;
}

/* Return key for given value */
function array_key_by_val($value, &$arr) {
    foreach ($arr as $key => $val) {
	if (array_cmp($val, $value))
	    return $key;
    }
}

/* in_array in PHP versions prior to 4.2.0 can not take an */
/* array as needle */
function arr_in_array(&$needle, &$haystack) {
    foreach ($haystack as $elem) {
	if (array_cmp($needle, $elem)) {
	    return 1;
	}
    }

    return 0;
}

function arr_offset_arraysearch(&$needle, &$haystack) {
    $pos = 0;

    foreach ($haystack as $elem) {
	if (array_cmp($elem, $needle) == 1) {
	    return $pos;
	}
	$pos++;
    }

    return -1;
}

function array_ksearch($key, $val, &$arr, $pos = 0) {
    $len = count($arr);

    for (; $pos < $len; $pos++) {
	if ($arr[$pos][$key] == $val)
	    return $pos;
    }

    return -1;
}

function get_nameline($id, $addr = 'username') {
	$db2 = new DB_WE();
	if ($addr == 'username') {
	    $db2->query("SELECT First, Second, Username FROM ".USER_TABLE." WHERE ID=".abs($id));
	    if ($db2->next_record())
		return $db2->f('Username') . ((($db2->f('First') == '') && ($db2->f('Second') == '')) ? '' : ' (' . $db2->f('First') . ' ' . $db2->f('Second') . ')');

	} else {
	    $db2->query("SELECT First, Second, Username, Email FROM ".USER_TABLE." WHERE ID=".abs($id));
	    if ($db2->next_record())
		return $db2->f('Email') . ' (' . ((($db2->f('First') == '') && ($db2->f('Second') == '')) ? $db2->f('Username') : $db2->f('First') . ' ' . $db2->f('Second')) . ')';
	}

	return $l_messaging['userid_not_found'];
}
?>
