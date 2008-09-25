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


/*****************************************************************************
 * INCLUDES
 *****************************************************************************/

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_htmlElement.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/base/we_image_edit.class.php');

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

//  check if gd_lib is installed ...
if( we_image_edit::gd_version() > 0 ){

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
    $frameset->addFrame(array("src" => WEBEDITION_DIR . "we/include/we_editors/we_thumbnails.php", "name" => "we_thumbnails", "scrolling" => "auto", "noresize" => "noresize"));
    $frameset->addFrame(array("src" => WEBEDITION_DIR . "we/include/we_editors/we_thumbnails_footer.php?closecmd=".(isset($_REQUEST["we_cmd"][1]) ? rawurlencode($_REQUEST["we_cmd"][1]) : ""), "name" => "we_thumbnails_footer", "scrolling" => "no", "noresize" => "noresize"));

    print $frameset->getHtmlCode() . we_htmlElement::htmlBody(array()) . "</html>";

} else {    //  gd_lib is not installed - show error

    include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/html/we_multibox.inc.php');
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/import_files.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/thumbnails.inc.php");

    print STYLESHEET . '</head><body class="weDialogBody">';


    $parts = array();
    array_push($parts, array(	"headline"=>"",
								"html"=>htmlAlertAttentionBox($GLOBALS["l_import_files"]["add_description_nogdlib"],2,440),
								"space"=>0
						)
				);
	$content = we_multiIconBox::getHTML("weimportfiles","100%",$parts,30,"",-1,'','',false,$GLOBALS['l_thumbnails']['thumbnails']);

    print $content;
}

?>