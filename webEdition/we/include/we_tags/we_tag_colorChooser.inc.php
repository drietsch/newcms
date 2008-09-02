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


function we_tag_colorChooser($attribs, $content){
 	global $we_editmode,$we_doc;
 	$foo = attributFehltError($attribs,"name","colorChooser");if($foo) return $foo;
 	
 	if(!$we_doc->getElement($attribs["name"])){
 		if(isset($attribs["value"]) && $attribs["value"]) $we_doc->setElement($attribs["name"],$attribs["value"]);
 	}
 	
 	if($we_editmode){
 		$width = (isset($attribs["width"]) && $attribs["width"]) ? $attribs["width"] : 100;
 		$height = (isset($attribs["height"]) && $attribs["height"]) ? $attribs["height"] : 18;
 		return $we_doc->formColor($width,$attribs["name"],25,"txt",$height);
 	}else{
 		return $we_doc->getElement($attribs["name"]);
 	}
}

?>