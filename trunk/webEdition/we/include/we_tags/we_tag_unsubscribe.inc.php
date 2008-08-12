<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_unsubscribe($attribs, $content)
{

	$attribs['type'] = 'text';
	$attribs['name'] = 'we_unsubscribe_email__';
	
	if(isset($_REQUEST["we_unsubscribe_email__"])){
	    $attribs['value'] = htmlspecialchars($_REQUEST["we_unsubscribe_email__"]);
	} else {
	    $attribs['value'] = "";
	}	
	
	return getHtmlTag('input', $attribs);
}
?>