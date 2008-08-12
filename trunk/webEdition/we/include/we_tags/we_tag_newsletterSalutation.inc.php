<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) living-e AG                   |
// +----------------------------------------------------------------------+
//


function we_tag_newsletterSalutation($attribs, $content){
	$type = we_getTagAttribute("type",$attribs);
	switch($type){
		case "title":
			return isset($GLOBALS["WE_TITLE"]) ? $GLOBALS["WE_TITLE"] : "";
		case "firstname":
			return isset($GLOBALS["WE_FIRSTNAME"]) ? $GLOBALS["WE_FIRSTNAME"] : "";
		case "lastname":
			return isset($GLOBALS["WE_LASTNAME"]) ? $GLOBALS["WE_LASTNAME"] : "";
		case "email":
			return isset($GLOBALS["WE_MAIL"]) ? $GLOBALS["WE_MAIL"] : (isset($GLOBALS["WE_NEWSLETTER_EMAIL"]) ? $GLOBALS["WE_NEWSLETTER_EMAIL"] : "");
		default:
			return isset($GLOBALS["WE_SALUTATION"]) ? $GLOBALS["WE_SALUTATION"] : "";
	}
}
?>