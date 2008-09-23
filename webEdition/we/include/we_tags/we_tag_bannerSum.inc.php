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