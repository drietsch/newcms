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