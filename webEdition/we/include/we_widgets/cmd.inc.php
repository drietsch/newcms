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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");

switch ($_REQUEST["we_cmd"][0]) {
	case "save" :
		setUserPref("cockpit_dat", $_REQUEST["we_cmd"][1]);
		break;
	case "add" :
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_html_tools.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/cockpit.inc.php");
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_widgets/cfg.inc.php");
		
		$aProps = array();
		$aProps[0] = $_REQUEST["we_cmd"][1];
		$aProps[1] = $aPrefs[$aProps[0]]["cls"];
		$aProps[2] = $aPrefs[$aProps[0]]["res"];
		$aProps[3] = $aPrefs[$aProps[0]]["csv"];
		foreach ($aCfgProps as $a) {
			foreach ($a as $arr) {
				if ($arr[0] == $aProps[0]) {
					$aProps[3] = $arr[3];
					break 2;
				}
			}
		}
		$iCurrId = str_replace('m_', '', $_REQUEST["we_cmd"][2]);
		$iWidth = $aPrefs[$aProps[0]]['width'];
		if ($aProps[0] != 'rss' && $aProps[0] != 'pad') {
			if ($aProps[0] == "msg")
				$_transact = md5(uniqid(rand()));
			include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_widgets/mod/' . $aProps[0] . '.inc.php');
		}
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_widgets/inc/' . $aProps[0] . '.inc.php');
		
		$js = "
function gel(id_){
	return document.getElementById?document.getElementById(id_):null;
}
function transmit(){
	if(top.weEditorFrameController.getActiveDocumentReference() && top.weEditorFrameController.getActiveDocumentReference().quickstart){
		top.weEditorFrameController.getActiveDocumentReference().pushContent('" . $aProps[0] . "','m_" . $iCurrId . "',gel('content').innerHTML,gel('prefix').innerHTML,gel('postfix').innerHTML,gel('csv').innerHTML);
	}
}
";
		print 
				we_htmlElement::htmlHtml(
						we_htmlElement::htmlHead(
								we_htmlElement::cssElement("div,span{display:none;}") . we_htmlElement::jsElement(
										$js)) . we_htmlElement::htmlBody(
								array(
									"onload" => "transmit();"
								), 
								we_htmlElement::htmlDiv(array(
									"id" => "content"
								), $oTblCont->getHtmlCode()) . we_htmlElement::htmlSpan(array(
									"id" => "prefix"
								), $aLang[0]) . we_htmlElement::htmlSpan(array(
									"id" => "postfix"
								), $aLang[1]) . we_htmlElement::htmlSpan(array(
									"id" => "csv"
								), (isset($aProps[3]) ? $aProps[3] : ""))));
}
?>
