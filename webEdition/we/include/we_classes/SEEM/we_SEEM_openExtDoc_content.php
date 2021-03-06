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


    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_global.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_defines.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."define_styles.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".  $GLOBALS["WE_LANGUAGE"] . "/SEEM.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

	
	//	this file gets the output from a none webEdition-Document on the same web-server
	//	and parses all found links to webEdition cmds
	
	protect();
	
	$fh = @fopen($_REQUEST["filepath"] . $seperator . urldecode($_REQUEST["paras"]),"rb");
	
	if($fh) {
		
		$content = "";
		
		while(!feof($fh)) {
			$content .= fgets($fh, 1024);
		}
		fclose($fh);
	}
	
    if(isset($content)){

        include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/"."we_SEEM.class.php");
        print we_SEEM::parseDocument($content, $_REQUEST["filepath"]);

    } else {
        
		if(!session_id()){
			session_start();
		}

        
        $_head = we_htmlElement::htmlHead(STYLESHEET);
        
       	$we_button = new we_button();
	
		$_table = new we_htmlTable(	array(	"cellpadding" => 0,
											"cellspacing" => 0,
											"border"      => 0),
													4,
													2);
		$_table->setColContent(0, 0, getPixel(20,20));
		$_table->setCol(1, 1, array("class" => "defaultfont"),  sprintf($GLOBALS["l_we_SEEM"]["ext_doc_not_found"], $_REQUEST["filepath"]) . "<br>");
		$_table->setColContent(2, 0, getPixel(20,6));
		
		//	there must be a navigation-history - so use it
		$_table->setColContent(3, 1, $we_button->create_button("back", "javascript:top.weNavigationHistory.navigateBack();"));
		
		$_body = $_table->getHtmlCode();
		$_body = we_htmlElement::htmlBody(	array("background" => IMAGE_DIR . "tree/bg_tree.gif"), $_body);
		
		print we_htmlElement::htmlHtml($_head . "\n" . $_body);
    }
?>
<script type="text/javascript">
<!--
  parent.openedWithWE = 1;
//-->
</script>