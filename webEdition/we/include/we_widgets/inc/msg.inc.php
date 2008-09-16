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

$oTblCont = new we_htmlTable(
		array(
			
				"id" => "m_" . $iCurrId . "_inline", 
				"style" => "width:" . $iWidth . "px;", 
				"cellpadding" => "0", 
				"cellspacing" => "0", 
				"border" => "0"
		), 
		3, 
		3);
$oTblCont->setCol(0, 0, array(
	"width" => "34", "valign" => "middle", "class" => "middlefont"
), $msg_button);
$oTblCont->setCol(0, 1, array(
	"width" => "5"
), getpixel(5, 1));
$oTblCont->setCol(
		0, 
		2, 
		array(
			"valign" => "middle"
		), 
		we_htmlElement::htmlA(
				array(
					
						"href" => $msg_cmd, 
						"class" => "middlefont", 
						"style" => "font-weight:bold;text-decoration:none;"
				), 
				$new_messages . " (" . we_htmlElement::htmlSpan(array(
					"id" => "msg_count"
				), $newmsg_count) . ")"));
$oTblCont->setCol(1, 0, array(
	"height" => "3"
), getPixel(1, 3));
$oTblCont->setCol(2, 0, array(
	"width" => "34", "valign" => "middle", "class" => "middlefont"
), $todo_button);
$oTblCont->setCol(2, 1, array(
	"width" => "5"
), getpixel(5, 1));
$oTblCont->setCol(
		2, 
		2, 
		array(
			"valign" => "middle"
		), 
		we_htmlElement::htmlA(
				array(
					
						"href" => $msg_cmd, 
						"class" => "middlefont", 
						"style" => "font-weight:bold;text-decoration:none;"
				), 
				$new_tasks . " (" . we_htmlElement::htmlSpan(array(
					"id" => "task_count"
				), $newtodo_count) . ")"));
$aLang = array(
	$l_cockpit["messaging"], ""
);

?>
