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


function we_tag_charset($attribs,$content) {
	
	global $CHARSET;
	
	$defined = we_getTagAttribute("defined",$attribs);
	$xml     = we_getTagAttribute("xml",$attribs, true, true);

	if($GLOBALS["we_doc"]->EditPageNr == WE_EDITPAGE_PROPERTIES && $GLOBALS["we_doc"]->InWebEdition){	//	normally meta tags are edited on property page
		
		return '<?php	$GLOBALS["meta"]["Charset"]["default"] = "' . $content . '";
						$GLOBALS["meta"]["Charset"]["defined"] = "' . $defined . '";	?>';
	} else {
		
		if($CHARSET != ""){		//	take from template determined charset
				
			$content = $CHARSET;
		}
		if($content != ""){		//	set charset
			
			$attribs["http-equiv"] = "Content-Type";
			$attribs["content"]    = "text/html; charset=$content";
			
			$attribs = removeAttribs($attribs, array("defined"));

			return getHtmlTag("meta", $attribs);
			
		} else {
			
			return '';
		}
	}
}
?>