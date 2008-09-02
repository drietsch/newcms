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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/delete.inc.php");

class deleteProgressDialog{

	function main(){

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");

		$WE_PB = new we_progressBar(0,0,true);
		$WE_PB->setStudLen(490);
		$WE_PB->addText("",0,"pb1");
		$js = $WE_PB->getJSCode();
		$pb = $WE_PB->getHTML();

		$WE_BTN = new we_button();
		$cancelButton = $WE_BTN->create_button("cancel","javascript:top.close();");
		$pb = htmlDialogLayout($pb,$GLOBALS["l_delete"]["delete"],$cancelButton);

		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				STYLESHEET .
				$js).
			we_htmlElement::htmlBody(array(
				"class"=>"weDialogBody"
				), $pb
			)
		);
	}

	function frameset(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlFrameset.inc.php");

		$fst = new we_htmlFrameset(array(
			"rows" => "*,0",
			"framespacing" => 0,
			"border" => 0,
			"frameborder" => "no")
		);

		$fst->addFrame(array("src" => WEBEDITION_DIR."delFrag.php?frame=main", "name" => "delmain"));
		$fst->setFrameAttributes(0, array("scrolling" => "no","onload"=>"delcmd.location='".WEBEDITION_DIR."delFrag.php?frame=cmd".(isset($_REQUEST["table"]) ? ("&amp;table=".rawurlencode($_REQUEST["table"])) : "")."&currentID=".rawurlencode($_REQUEST["currentID"])."';"));

		$fst->addFrame(array("src" => HTML_DIR."white.html", "name" => "delcmd"));
		$fst->setFrameAttributes(1, array("scrolling" => "no"));
		return we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead(
				we_htmlElement::jsElement("", array("src" => JS_DIR . "we_showMessage.js")) . 
				we_htmlElement::htmlTitle($GLOBALS["l_delete"]["delete"])).$fst->getHtmlCode());
	}

	function cmd(){
		if(isset($_SESSION["backup_delete"]) && $_SESSION["backup_delete"]){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/delete/delBackup.inc.php");
			$taskname = md5(session_id()."_backupdel");
			$fr = new delBackup($taskname,1,0);
		}
		else{
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/delete/delFragment.inc.php");
			$taskname = md5(session_id()."_del");
			$table = (isset($_REQUEST["table"]) && $_REQUEST["table"]) ? $_REQUEST["table"] : FILE_TABLE;
			$fr = new delFragment($taskname,1,0,$table);
		}
	}

}

?>