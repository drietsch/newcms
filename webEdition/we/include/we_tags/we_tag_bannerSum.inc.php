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

function we_tag_bannerSum($attribs,$content){
	if(!isset($GLOBALS["lv"])){
			return false;
	}
	$foo = attributFehltError($attribs,"type","bannerSum");if($foo) return $foo;
	$type = we_getTagAttribute("type",$attribs);
	switch ($type){
		case "clicks":
			return $GLOBALS["lv"]->getAllclicks();
			break;
		case "views":
			return $GLOBALS["lv"]->getAllviews();
			break;
		case "rate":
			return $GLOBALS["lv"]->getAllrate();
			break;
	}
			
}

?>