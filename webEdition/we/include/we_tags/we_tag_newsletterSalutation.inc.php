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