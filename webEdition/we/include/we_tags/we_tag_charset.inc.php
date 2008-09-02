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