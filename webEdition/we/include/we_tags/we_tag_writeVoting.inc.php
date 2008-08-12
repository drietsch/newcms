<?php 

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//

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