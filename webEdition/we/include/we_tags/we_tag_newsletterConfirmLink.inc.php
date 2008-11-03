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