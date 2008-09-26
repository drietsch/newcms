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

function we_tag_writeVoting($attribs, $content) {

	$id = we_getTagAttributeTagParser('id',$attribs,0);

	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/voting/weVoting.php');
	
	if($id) $pattern = '/_we_voting_answer_(' . $id . ')_?([0-9]+)?/';
	else $pattern = '/_we_voting_answer_([0-9]+)_?([0-9]+)?/';

	$vars = implode(',',array_keys($_REQUEST));

	$_voting = array();
	
	if(preg_match_all($pattern, $vars, $matches)){
		foreach ($matches[0] as $key=>$value){
			$id = $matches[1][$key];
			if(!isset($_voting[$id]) || !is_array($_voting[$id])) $_voting[$id] = array();
			$_voting[$id][]= $_REQUEST[$value];
		}
	}

	foreach($_voting as $id=>$value){
		$voting = new weVoting($id);
		$GLOBALS['_we_voting_status'] = $voting->vote($value);
		if($GLOBALS['_we_voting_status'] != VOTING_SUCCESS) {
			break;
		}
	}

}
?>