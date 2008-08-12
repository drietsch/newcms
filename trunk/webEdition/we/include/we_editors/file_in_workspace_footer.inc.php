<?php

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");


	$_messageTbl = new we_htmlTable(	array(	"border"      => 0,
											"cellpadding" => 0,
											"cellspacing" => 0),
									2,
									4);
	//	spaceholder
	$_messageTbl->setColContent(0,0, getPixel(20,7));
	$_messageTbl->setColContent(1,1, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "alert.gif")));
	$_messageTbl->setColContent(1,2, getPixel(5,2));
	$_messageTbl->setCol(1,3, array("class" => "defaultfont"), $l_alert[FILE_TABLE]["not_im_ws"]);


	$_head = we_htmlElement::htmlHead(we_htmlElement::jsElement("\n<!--\ntop.toggleBusy(0);\n-->\n"));
	$_body = we_htmlElement::htmlBody(	array(	"background" => "/webEdition/images/edit/editfooterback.gif",
												"bgcolor"    => "white"),
										$_messageTbl->getHtmlCode());


	print we_htmlElement::htmlHtml($_head . STYLESHEET . "\n" . $_body);
?>