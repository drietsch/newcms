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
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
    include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".  $GLOBALS["WE_LANGUAGE"] . "/SEEM.inc.php");
    
    //	Header for a none webEdition document opened with webEdition
    
    $_prot = getServerProtocol(true);
	$_webEditionSiteUrl = $_prot . SERVER_NAME . (defined("HTTP_PORT") ? ":" . HTTP_PORT : "" ) . "/webEdition/site";
	
	if( strpos($_REQUEST["url"], $_webEditionSiteUrl) === 0 ){
		$_errormsg = $GLOBALS["l_we_SEEM"]["ext_doc_tmp"];
	} else {
		$_errormsg = sprintf($GLOBALS["l_we_SEEM"]["ext_doc"], $_REQUEST["url"]);
	}
    
	$_table = new we_htmlTable(	array(	"cellpadding" => 0,
										"cellspacing" => 0,
										"border"      => 0),
								2,
								4);
	
	$_table->setColContent(0, 0, getPixel(20,6));
	$_table->setColContent(1, 0, getPixel(1,1));
	$_table->setColContent(1, 1, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "alert.gif", "width" => 25, "height" => 27)));
	$_table->setColContent(1, 2, getPixel(9,1));
	$_table->setCol(1, 3, array("class" => "middlefontred"), $_errormsg );
	

    $_body = $_table->getHtmlCode();
	$_head = STYLESHEET;
    
    
    $_body = we_htmlElement::htmlBody(	array(	"bgcolor"      => "white",
    											"background"   => IMAGE_DIR . "backgrounds/header_with_black_lines.gif",
    											"marginwidth"  => 0,
    											"marginheight" => 0,
    											"leftmargin"   => 0,
    											"topmargin"    => 0),
										$_body);
										
	print we_htmlElement::htmlHtml("\n" . $_head . "\n" . $_body );
    
?>