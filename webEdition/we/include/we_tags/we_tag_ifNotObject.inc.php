<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_ifNotObject($attribs,$content) {
	
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tags/we_tag_ifObject.inc.php');
	return !we_tag_ifObject($attribs, $content);
}

?>