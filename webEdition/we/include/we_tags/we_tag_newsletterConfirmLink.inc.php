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