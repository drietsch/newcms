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

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");
	
	
	$_messageTbl = new we_htmlTable(	array(	"border"      => 0,
												"cellpadding" => 0,
												"cellspacing" => 0),
									2,
									4);
	$we_button = new we_button();
	//	spaceholder
	$_messageTbl->setColContent(0,0, getPixel(20,7));
	$_messageTbl->setColContent(1,1, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "alert.gif")));
	$_messageTbl->setColContent(1,2, getPixel(5,2));
	$_messageTbl->setCol(1,3, array("class" => "defaultfont"), $l_alert["file_no_save_footer"]);
	
	
	$_head = we_htmlElement::htmlHead(we_htmlElement::jsElement("\n<!--\ntop.toggleBusy(0);\n-->\n") . STYLESHEET);
	$_body = we_htmlElement::htmlBody(	array(	"background" => "/webEdition/images/edit/editfooterback.gif",
												"bgcolor"    => "white"),
										$_messageTbl->getHtmlCode());
	
	
	print we_htmlElement::htmlHtml($_head . "\n" . $_body);
?>