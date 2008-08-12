<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_newsletterConfirmLink($attribs, $content="") {
	
	$plain = we_getTagAttribute("plain",$attribs,false,true);
	
	$content = trim($content);
	$link = isset($GLOBALS["WE_CONFIRMLINK"]) ? $GLOBALS["WE_CONFIRMLINK"] : "";
	if (strlen($content) < 1) {
		$content = $link;
	}
	
	if (strlen($link) > 0) {
		if(!$plain) {
			$attribs["href"] = $link;
			return getHtmlTag("a", $attribs, $content);
		} else {
			return $link;
		}
	} else {
		return "";
	}
}
?>