<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_htmlElement.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php');

/*****************************************************************************
 * INITIALIZATION
 *****************************************************************************/

protect();

htmlTop();

/*****************************************************************************
 * CREATE JAVASCRIPT
 *****************************************************************************/

// Define needed JS
$_javascript = "
<!--
	self.focus();
//-->
";

/*****************************************************************************
 * RENDER FILE
 *****************************************************************************/

print
	we_htmlElement::jsElement($_javascript, array("type" => "text/javascript")) . 
	we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js")) . 
	we_htmlElement::jsElement(
		"
			function closeOnEscape() {
				return true;
				
			}
			
			function saveOnKeyBoard() {
				window.frames[1].we_save();
				return true;
				
			}"
	) .
"</head>";

$frameset = new we_htmlFrameset(array("rows" => "*,40", "framespacing" => "0", "border" => "1",  "frameborder" => "no"), 0);
$frameset->addFrame(array("src" => WEBEDITION_DIR . "we/include/we_editors/we_metadata_fields/editor.php", "name" => "we_metadatafields", "scrolling" => "auto", "noresize" => "noresize"));
$frameset->addFrame(array("src" => WEBEDITION_DIR . "we/include/we_editors/we_metadata_fields/footer.php?closecmd=".(isset($_REQUEST["we_cmd"][1]) ? rawurlencode($_REQUEST["we_cmd"][1]) : ""), "name" => "we_metadatafields_footer", "scrolling" => "no", "noresize" => "noresize"));

print $frameset->getHtmlCode() . we_htmlElement::htmlBody(array()) . "</html>";
?>