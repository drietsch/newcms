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
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weDialog.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/linklist_edit.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");

class weHyperlinkDialog extends weDialog{

	##################################################################################################

	var $ClassName = "weHyperlinkDialog";
	var $changeableArgs = array(	"type",
	"extHref",
	"fileID",
	"href",
	"fileHref",
	"objID",
	"objHref",
	"mailHref",
	"target",
	"class",
	"param",
	"anchor",
	"lang",
	"hreflang",
	"title",
	"accesskey",
	"tabindex",
	"rel",
	"rev"
	);

	##################################################################################################

	function weHyperlinkDialog($href="",$target="",$fileID=0,$objID=0){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["edit_hyperlink"];
	}

	##################################################################################################

	function getDialogButtons(){
		$we_button = new we_button();

		if ($this->pageNr == $this->numPages && $this->JsOnly == false) {
			$okBut = ($this->getBackBut() != "") ? $we_button->create_button_table(array($this->getBackBut(), $we_button->create_button("ok", "javascript:weCheckAcFields()"))) : $we_button->create_button("ok", "javascript:weCheckAcFields()");
		} else if ($this->pageNr < $this->numPages) {
			$okBut = (($this->getBackBut() != "") && ($this->getNextBut()) != "") ? $we_button->create_button_table(array($this->getBackBut(), $this->getNextBut())) : (($this->getBackBut() == "") ? $this->getNextBut() : $this->getBackBut());
		} else {
			$okBut = (($this->getBackBut() != "") && ($this->getOkBut()) != "") ? $we_button->create_button_table(array($this->getBackBut(), $this->getOkBut())) : (($this->getBackBut() == "") ? $this->getOkBut() : $this->getBackBut());
		}

		return $we_button->position_yes_no_cancel(	$okBut,
														"",
														$we_button->create_button("cancel", "javascript:top.close();"));
	}

	function initByHref($href,$target="",$class="",$param="",$anchor="",$lang="",$hreflang="",$title="",$accesskey="",$tabindex="",$rel="",$rev=""){
		if($href){
			$this->args["href"] = $href;

			// Object Links and internal links are not possible when outside webEdition
			// for exmaple in the wysiwyg (Mantis Bug #138)
			if(		$this->args["outsideWE"]
				&&	(
							substr($this->args["href"],0,7) == "object:"
						||	substr($this->args["href"],0,9) == "document:"
					)
				) {
					$this->args["href"] = "";

			}

			if(substr($this->args["href"],0,7) == "object:"){
				$this->args["type"] = "obj";
				$this->args["extHref"] = "";
				$this->args["fileID"] = "";
				$this->args["fileHref"] = "";
				$this->args["mailHref"] = "";
				$this->args["objID"] = abs(substr($this->args["href"],7));
				$this->args["objHref"] = f("SELECT Path FROM " . OBJECT_FILES_TABLE . " WHERE ID='".abs($this->args["objID"])."'","Path",$this->db);
			}else if(substr($this->args["href"],0,9) == "document:"){
				$this->args["type"] = "int";
				$this->args["extHref"] = "";
				$this->args["fileID"] = abs(substr($this->args["href"],9));
				$this->args["fileHref"] = f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".abs($this->args["fileID"])."'","Path",$this->db);
				$this->args["mailHref"] = "";
				$this->args["objID"] = "";
				$this->args["objHref"] = "";
			}else if(substr($this->args["href"],0,7) == "mailto:"){
				$this->args["type"] = "mail";
				$this->args["mailHref"] = ereg_replace('^([^\?#]+).*$','\1',substr($this->args["href"],7));
				$this->args["extHref"] = "";
				$this->args["fileID"] = "";
				$this->args["fileHref"] = "";
				$this->args["objID"] = "";
				$this->args["objHref"] = "";
			}else{
				$this->args["type"] = "ext";
				$this->args["extHref"] = ereg_replace('^([^\?#]+).*$','\1',ereg_replace('^/webEdition/','',ereg_replace('^/webEdition/we_cmd.php[^"\'#]+(#.*)$','\1',$this->args["href"])));
				$this->args["fileID"] = "";
				$this->args["fileHref"] = "";
				$this->args["mailHref"] = "";
				$this->args["objID"] = "";
				$this->args["objHref"] = "";
			}
		}
		$this->args["target"] = $target;
		$this->args["class"] = $class;
		$this->args["param"] = str_replace("&amp;", "&", $param);
		$this->args["anchor"] = $anchor;
		$this->args["lang"] = $lang;
		$this->args["hreflang"] = $hreflang;
		$this->args["title"] = $title;
		$this->args["accesskey"] = $accesskey;
		$this->args["tabindex"] = $tabindex;
		$this->args["rel"] = $rel;
		$this->args["rev"] = $rev;
	}

	##################################################################################################

	function initByFileID($fileID,$target="",$class="",$param="",$anchor="",$lang="",$hreflang="",$title="",$accesskey="",$tabindex="",$rel="",$rev=""){
		if($fileID){
			$this->args["href"] = "document:".$fileID;
			$this->args["type"] = "int";
			$this->args["extHref"] = "";
			$this->args["fileID"] = $fileID;
			$this->args["fileHref"] = f("SELECT Path FROM " . FILE_TABLE . " WHERE ID='".abs($this->args["fileID"])."'","Path",$this->db);
			$this->args["objID"] = "";
			$this->args["mailHref"] = "";
			$this->args["objHref"] = "";
		}
		$this->args["target"] = $target;
		$this->args["class"] = $class;
		$this->args["param"] = $param;
		$this->args["anchor"] = $anchor;
		$this->args["lang"] = $lang;
		$this->args["hreflang"] = $hreflang;
		$this->args["title"] = $title;
		$this->args["accesskey"] = $accesskey;
		$this->args["tabindex"] = $tabindex;
		$this->args["rel"] = $rel;
		$this->args["rev"] = $rev;
	}

	##################################################################################################

	function initByObjectID($objID,$target="",$class="",$param="",$anchor="",$lang="",$hreflang="",$title="",$accesskey="",$tabindex="",$rel="",$rev=""){
		if($objID){
			$this->args["href"] = "object:".$objID;
			$this->args["type"] = "obj";
			$this->args["extHref"] = "";
			$this->args["fileID"] = "";
			$this->args["fileHref"] = "";
			$this->args["mailHref"] = "";
			$this->args["objID"] = $objID;
			$this->args["objHref"] = f("SELECT Path FROM " . OBJECT_FILES_TABLE . " WHERE ID='".abs($this->args["objID"])."'","Path",$this->db);
		}
		$this->args["target"] = $target;
		$this->args["class"] = $class;
		$this->args["param"] = $param;
		$this->args["anchor"] = $anchor;
		$this->args["lang"] = $lang;
		$this->args["hreflang"] = $hreflang;
		$this->args["title"] = $title;
		$this->args["accesskey"] = $accesskey;
		$this->args["tabindex"] = $tabindex;
		$this->args["rel"] = $rel;
		$this->args["rev"] = $rev;
	}

	##################################################################################################
	function initByMailHref($mailHref,$target="",$class="",$param="",$anchor="",$lang="",$hreflang="",$title="",$accesskey="",$tabindex="",$rel="",$rev=""){
		if($mailHref){
			$this->args["href"] = "mailto:".$mailHref;
			$this->args["type"] = "mail";
			$this->args["extHref"] = "";
			$this->args["fileID"] = "";
			$this->args["fileHref"] = "";
			$this->args["mailHref"] = $mailHref;
			$this->args["objID"] = "";
			$this->args["objHref"] = "";
		}
		$this->args["target"] = $target;
		$this->args["class"] = $class;
		$this->args["param"] = $param;
		$this->args["anchor"] = $anchor;
		$this->args["lang"] = $lang;
		$this->args["hreflang"] = $hreflang;
		$this->args["title"] = $title;
		$this->args["accesskey"] = $accesskey;
		$this->args["tabindex"] = $tabindex;
		$this->args["rel"] = $rel;
		$this->args["rev"] = $rev;
	}

	##################################################################################################

	function glue_url($parsed) {
	   if (! is_array($parsed)) return false;
	       $uri = $parsed['scheme'] ? $parsed['scheme'].':'.((strtolower($parsed['scheme']) == 'mailto') ? '':'//'): '';
	       $uri .= $parsed['user'] ? $parsed['user'].($parsed['pass']? ':'.$parsed['pass']:'').'@':'';
	       $uri .= $parsed['host'] ? $parsed['host'] : '';
	       $uri .= $parsed['port'] ? ':'.$parsed['port'] : '';
	       $uri .= $parsed['path'] ? $parsed['path'] : '';
	       $uri .= $parsed['query'] ? '?'.$parsed['query'] : '';
	       $uri .= $parsed['fragment'] ? '#'.$parsed['fragment'] : '';
	  return $uri;
	}

	function initByHttp(){
		weDialog::initByHttp();
		$href = $this->getHttpVar("href");
		$target = $this->getHttpVar("target");
		$param = $this->getHttpVar("param");
		$anchor = $this->getHttpVar("anchor");
		$lang = $this->getHttpVar("lang");
		$hreflang = $this->getHttpVar("hreflang");
		$title = $this->getHttpVar("title");
		$accesskey = $this->getHttpVar("accesskey");
		$tabindex = $this->getHttpVar("tabindex");
		$rel = $this->getHttpVar("rel");
		$rev = $this->getHttpVar("rev");

		if($href && (strpos($href,"?") !== false || strpos($href,"#") !== false)){
			$urlparts = parse_url($href);

			if( (!$param) && isset($urlparts["query"]) && $urlparts["query"]){
				$param = $urlparts["query"];
			}
			if( (!$anchor) && isset($urlparts["fragment"]) && $urlparts["fragment"]){
				$anchor = $urlparts["fragment"];
			}
		}

		$class = $this->getHttpVar("class");
		$type = $this->getHttpVar("type");
		if($href){
			$this->initByHref($href,$target,$class,$param,$anchor,$lang,$hreflang,$title,$accesskey,$tabindex,$rel,$rev);
		}else if($type){
			$fileID = $this->getHttpVar("fileID",0);
			$objID = $this->getHttpVar("objID",0);
			switch($type){
				case "ext":
				$extHref = $this->getHttpVar("extHref","#");
				$this->initByHref($extHref,$target,$class,$param,$anchor,$lang,$hreflang,$title,$accesskey,$tabindex,$rel,$rev);
				break;
				case "int":
				$this->initByFileID($fileID,$target,$class,$param,$anchor,$lang,$hreflang,$title,$accesskey,$tabindex,$rel,$rev);
				break;
				case "obj":
				$this->initByObjectID($objID,$target,$class,$param,$anchor,$lang,$hreflang,$title,$accesskey,$tabindex,$rel,$rev);
				break;
				case "mail":
				$mailhref = $this->getHttpVar("mailHref");
				$this->initByMailHref($mailhref,$target,$class,$param,$anchor,$lang,$hreflang,$title,$accesskey,$tabindex,$rel,$rev);
				break;
			}
		}else{
			$this->defaultInit();
		}
	}

	##################################################################################################

	function defaultInit(){
		$this->args["href"] = "document:";
		$this->args["type"] = "int";
		$this->args["extHref"] = "";
		$this->args["fileID"] = "";
		$this->args["fileHref"] = "";
		$this->args["objID"] = "";
		$this->args["objHref"] = "";
		$this->args["mailHref"] = "";
		$this->args["target"] = "";
		$this->args["class"] = "";
		$this->args["param"] = "";
		$this->args["anchor"] = "";
		$this->args["lang"] = "";
		$this->args["hreflang"] = "";
		$this->args["title"] = "";
		$this->args["accesskey"] = "";
		$this->args["tabindex"] = "";
		$this->args["rel"] = "";
		$this->args["rev"] = "";
	}

	##################################################################################################

	function getDialogContentHTML() {
		global $BROWSER,$l_we_class,$l_contentTypes,$l_linklist_edit;
		// Initialize we_button class
		$we_button = new we_button();

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weSuggest.class.inc.php");
		$yuiSuggest =& weSuggest::getInstance();

		$extHref = utf8_decode((substr($this->args["extHref"],0,1) == "#") ? "" : $this->args["extHref"]);
		if ($this->args["outsideWE"] == "1") {


			$_select_type = '<select name="we_dialog_args[type]" size="1" style="margin-bottom:5px;" onchange="changeTypeSelect(this);">
<option value="ext"'.(($this->args["type"]=="ext") ? ' selected="selected"' : '').'>'.$GLOBALS["l_linklist_edit"]["external_link"].'</option>
<option value="mail"'.(($this->args["type"]=="mail") ? ' selected="selected"' : '').'>'.$GLOBALS["l_wysiwyg"]["emaillink"].'</option>
</select>';


			$_external_link = htmlTextInput("we_dialog_args[extHref]",30,$extHref,"",'',"text",300);


			// INTERNAL LINK
			$_internal_link = "";

			// E-MAIL LINK

			$_email_link = htmlTextInput("we_dialog_args[mailHref]",30,$this->args["mailHref"],"",'',"text",300);

			// OBJECT LINK
			$_object_link = "";

		} else {
			$_select_type = '<select name="we_dialog_args[type]" id="weDialogType" size="1" style="margin-bottom:5px;width:300px;" onchange="changeTypeSelect(this);">
<option value="ext"'.(($this->args["type"]=="ext") ? ' selected="selected"' : '').'>'.$GLOBALS["l_linklist_edit"]["external_link"].'</option>
<option value="int"'.(($this->args["type"]=="int") ? ' selected="selected"' : '').'>'.$GLOBALS["l_linklist_edit"]["internal_link"].'</option>
<option value="mail"'.(($this->args["type"]=="mail") ? ' selected="selected"' : '').'>'.$GLOBALS["l_wysiwyg"]["emaillink"].'</option>
' . ((defined("OBJECT_TABLE") && ($_SESSION["we_mode"] == "normal" || we_hasPerm("CAN_SEE_OBJECTFILES"))) ? '
<option value="obj"'.(($this->args["type"]=="obj") ? ' selected="selected"' : '').'>'.$GLOBALS["l_linklist_edit"]["objectFile"].'</option>' : '') . '
</select>';

			// EXTERNAL LINK

			$_external_select_button = we_hasPerm("CAN_SELECT_EXTERNAL_FILES") ? $we_button->create_button("select", "javascript:we_cmd('browse_server', 'document.we_form.elements[\\'we_dialog_args[extHref]\\'].value', '', document.we_form.elements['we_dialog_args[extHref]'].value, '')") : "";

			$_external_link = "<div style='margin-top:1px'>".htmlFormElementTable(htmlTextInput("we_dialog_args[extHref]",30,$extHref ? $extHref : "http://","",'onchange="if(this.value==\'\'){this.value=\'http://\'}"',"text",300), "", "left", "defaultfont", getPixel(10, 1), $_external_select_button, "", "", "", 0)."</div>";


			// INTERNAL LINK

			$_internal_select_button = $we_button->create_button("select", "javascript:we_cmd('openDocselector', document.we_form.elements['we_dialog_args[fileID]'].value, '" . FILE_TABLE . "', 'document.we_form.elements[\\'we_dialog_args[fileID]\\'].value', 'document.we_form.elements[\\'we_dialog_args[fileHref]\\'].value', '', '', 0, '', " . (we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1) . ");");

			$yuiSuggest->setAcId("Path");
			$yuiSuggest->setContentType("folder,text/webedition,image/*,text/js,text/css,text/html,application/*,video/quicktime");
			$yuiSuggest->setInput("we_dialog_args[fileHref]",$this->args["fileHref"]);
			$yuiSuggest->setMaxResults(20);
			$yuiSuggest->setMayBeEmpty(0);
			$yuiSuggest->setResult("we_dialog_args[fileID]",($this->args["fileID"]==0?"":$this->args["fileID"]));
			$yuiSuggest->setSelector("Docselector");
			$yuiSuggest->setWidth(300);
			$yuiSuggest->setSelectButton($_internal_select_button,10);
		
			$_internal_link = $yuiSuggest->getHTML();
			// E-MAIL LINK

			$_email_link = htmlFormElementTable(htmlTextInput("we_dialog_args[mailHref]",30,$this->args["mailHref"],"",'',"text",300), "", "left", "defaultfont", "", "", "", "", "", 0);

			// OBJECT LINK
			if(defined("OBJECT_TABLE") && ($_SESSION["we_mode"] == "normal" || we_hasPerm("CAN_SEE_OBJECTFILES"))){

				$_object_select_button = $we_button->create_button("select", "javascript:we_cmd('openDocselector', document.we_form.elements['we_dialog_args[objID]'].value, '" . OBJECT_FILES_TABLE . "', 'document.we_form.elements[\\'we_dialog_args[objID]\\'].value', 'document.we_form.elements[\\'we_dialog_args[objHref]\\'].value', '', '', '', 'objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).");", false, 100, 22, "", "", !we_hasPerm("CAN_SEE_OBJECTFILES"));

				$yuiSuggest->setAcId("Obj");
				$yuiSuggest->setContentType("folder,objectFile");
				$yuiSuggest->setInput("we_dialog_args[objHref]",$this->args["objHref"]);
				$yuiSuggest->setMaxResults(20);
				$yuiSuggest->setMayBeEmpty(0);
				$yuiSuggest->setResult("we_dialog_args[objID]",($this->args["objID"]==0?"":$this->args["objID"]));
				$yuiSuggest->setSelector("Docselector");
				$yuiSuggest->setTable(OBJECT_FILES_TABLE);
				$yuiSuggest->setWidth(300);
				$yuiSuggest->setSelectButton($_object_select_button,10);
		
				$_object_link = $yuiSuggest->getHTML();
/*
				$_object_link = htmlFormElementTable(htmlTextInput("we_dialog_args[objHref]",30,$this->args["objHref"],"",' readonly="readonly"',"text",300, "0", "", !we_hasPerm("CAN_SEE_OBJECTFILES")) .
				'<input type="hidden" name="we_dialog_args[objID]" value="'.$this->args["objID"].'">', "", "left", "defaultfont", getPixel(10, 1), $_object_select_button, "", "", "", 0);
				*/
			}
		}

		$_anchorSel = '<script language="JavaScript" type="text/javascript">showanchors("anchors","","this.form.elements[\'we_dialog_args[anchor]\'].value=this.options[this.selectedIndex].value;this.selectedIndex=0;")</script>';
		$_anchorInput = htmlTextInput("we_dialog_args[anchor]",30,$this->args["anchor"],"","","text",300);

		$_anchor = htmlFormElementTable($_anchorInput, "", "left", "defaultfont", getPixel(10, 1), $_anchorSel, "", "", "", 0);

		$_param = htmlTextInput("we_dialog_args[param]",30,utf8_decode($this->args["param"]),"","","text",300);

		// CSS STYLE
		$classSelect = '
			<script language="JavaScript" type="text/javascript"><!--
				showclasss("we_dialog_args[class]", "' . $this->args["class"] . '", "");
			//-->
			</script>';


		// lang
		$_lang = $this->getLangField("lang",$GLOBALS["l_wysiwyg"]["link_lang"],145);
		$_hreflang = $this->getLangField("hreflang",$GLOBALS["l_wysiwyg"]["href_lang"],145);

		$_title = htmlTextInput("we_dialog_args[title]",30,$this->args["title"],"","","text",300);


		$_accesskey = htmlFormElementTable(htmlTextInput("we_dialog_args[accesskey]",30,$this->args["accesskey"],"","","text",145),"accesskey");
		$_tabindex = htmlFormElementTable(htmlTextInput("we_dialog_args[tabindex]",30,$this->args["tabindex"],"",' onkeypress="return IsDigit(event);"',"text",145),"tabindex");


		$_rev = htmlFormElementTable($this->getRevRelSelect("rev"),"rev");
		$_rel = htmlFormElementTable($this->getRevRelSelect("rel"),"rel");


		$parts = array();
		// Create table output
		$table = '
			<div style="position:relative; top:15px"><table cellpadding="0" cellspacing="0" border="0" height="65">
				<tr>
					<td class="defaultgray" valign="top" width="100" height="20">
						'  . $l_we_class["linkType"] . '</td>
					<td valign="top">
						' . $_select_type . '</td>
				</tr>
				<tr id="ext_tr" style="display:'.(($this->args["type"]=="ext") ? "" : "none").';">
					<td class="defaultgray" valign="top" width="100">'.$l_linklist_edit["external_link"].'</td><td valign="top" >
						' . $_external_link . '</td>
				</tr>
				';

		if (isset($_internal_link)) {
			$autoSuggest  = $_internal_link;
			$autoSuggest .= "<script type='text/javascript'>\n";
			$autoSuggest .= "document.we_form.onsubmit = weonsubmit;\n";
			$autoSuggest .= "function weonsubmit() {\n";
			$autoSuggest .= "	return false;\n";
			$autoSuggest .= "}\n";
			$autoSuggest .= "</script>\n";
			$table .= '
				<tr id="int_tr" style="display:'.(($this->args["type"]=="int") ? "" : "none").';">
					<td class="defaultgray" valign="top" width="100"> ' . $l_we_class["document"] . '</td>
					<td valign="top"> ' . $autoSuggest . '</td>
				</tr>';
		}

		$table .= '
				<tr id="mail_tr" style="display:'.(($this->args["type"]=="mail") ? "" : "none").';">
					<td class="defaultgray" valign="top" width="100">'.$GLOBALS["l_wysiwyg"]["emaillink"].'</td>
					<td valign="top">
						' . $_email_link . '</td>
				</tr>';

		if (defined("OBJECT_TABLE") && isset($_object_link)) {
			$table .= '
				<tr id="obj_tr" style="display:'.(($this->args["type"]=="obj") ? "" : "none").';">
					<td class="defaultgray" valign="top" width="100" height="0">'.$l_contentTypes["objectFile"].'</td>
					<td valign="top">
						' . $_object_link . '</td>
				</tr>';
		}

		$show_accessible_class = (we_hasPerm("CAN_SEE_ACCESSIBLE_PARAMETERS") ? '' : ' class="weHide"');
		$table .= '</table></div>';
		$table .= $yuiSuggest->getYuiCssFiles();
		$table .= $yuiSuggest->getYuiCss();
		$table .= $yuiSuggest->getYuiJsFiles();
		$table .= $yuiSuggest->getYuiJs();

		$parts[] = array("html"=>$table);

		$table = '<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="defaultgray" valign="top" width="100">
						' . $GLOBALS["l_wysiwyg"]["anchor"] . '</td>
					<td>
						' . $_anchor . '</td>
				</tr>
				<tr>
					<td colspan="2">
						' . getPixel(110, 10) . '</td>
				</tr>
				<tr>
					<td class="defaultgray" valign="top">
						' . $GLOBALS["l_linklist_edit"]["link_params"] . '</td>
					<td>
						' . $_param . '</td>
				</tr>
				<tr>
					<td colspan="2">
						' . getPixel(110, 10) . '</td>
				</tr>
				<tr>
					<td class="defaultgray" valign="top">
						' . $GLOBALS["l_wysiwyg"]["css_style"] . '</td>
					<td>
						' . $classSelect . '</td>
				</tr>
			 	<tr>
					<td colspan="2">
						' . getPixel(110, 10) . '</td>
				</tr>
				<tr>
					<td class="defaultgray" valign="top">
						' . $GLOBALS["l_linklist_edit"]["link_target"] . '</td>
					<td>
						' . targetBox("we_dialog_args[target]", 29, 300, "we_dialog_args[target]", $this->args["target"], "", 10, 100) . '</td>
				</tr>
			</table>';
			$parts[] = array("html"=>$table);


			$table = '<table cellpadding="0" cellspacing="0" border="0">
				<tr'.$show_accessible_class.'>
					<td class="defaultgray" valign="top" width="100">
						' . $GLOBALS["l_wysiwyg"]["language"] . '</td>
					<td>
						<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . $_lang . '</td><td>'.getPixel(10,2).'</td><td>'.$_hreflang.'</td></tr></table></td>
				</tr>
				<tr'.$show_accessible_class.'>
					<td colspan="2">
						' . getPixel(110, 10) . '</td>
				</tr>
				<tr'.$show_accessible_class.'>
					<td class="defaultgray" valign="top">
						' . $GLOBALS["l_wysiwyg"]["title"] . '</td>
					<td>
						' . $_title . '</td>
				</tr>
				<tr'.$show_accessible_class.'>
					<td colspan="2">
						' . getPixel(110, 5) . '</td>
				</tr>
				<tr'.$show_accessible_class.'>
					<td class="defaultgray" valign="top">
						' . $GLOBALS["l_wysiwyg"]["keyboard"] . '</td>
					<td>
						<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . $_accesskey . '</td><td>'.getPixel(10,2).'</td><td>'.$_tabindex.'</td></tr></table></td>
				</tr>
				<tr'.$show_accessible_class.'>
					<td colspan="2">
						' . getPixel(110, 5) . '</td>
				</tr>
				<tr'.$show_accessible_class.'>
					<td class="defaultgray" valign="top">
						'.$GLOBALS["l_wysiwyg"]["relation"].'</td>
					<td>
						<table border="0" cellpadding="0" cellspacing="0"><tr><td>' . $_rel . '</td><td>'.getPixel(10,2).'</td><td>'.$_rev.'</td></tr></table></td>
				</tr>
				<tr>
					<td colspan="2">
						' . getPixel(110, 10) . '</td>
				</tr>
			</table>';

			$parts[] = array("html"=>$table);


		// Return output
		return $parts;
	}

	function getRevRelSelect($type){
		return '<input type="text" name="we_dialog_args['.$type.']" value="'.htmlspecialchars($this->args["$type"]).'" style="width:70px;"><select name="'.$type.'_sel" size="1" style="width:75px;" onchange="this.form.elements[\'we_dialog_args['.$type.']\'].value=this.options[this.selectedIndex].text;this.selectedIndex=0;">
<option></option>
<option>contents</option>
<option>chapter</option>
<option>section</option>
<option>subsection</option>
<option>index</option>
<option>glossary</option>
<option>appendix</option>
<option>copyright</option>
<option>next</option>
<option>prev</option>
<option>start</option>
<option>help</option>
<option>bookmark</option>
<option>alternate</option>
<option>nofollow</option>
</select>
';
	}
	##################################################################################################

	function getJs(){
		$js = weDialog::getJs() . '
			<script language="JavaScript" type="text/javascript"><!--
				var weAcCheckLoop = 0;
				var weFocusedField;
				function setFocusedField(elem){
					weFocusedField = elem;
				}

				function weCheckAcFields(){
					if(!!weFocusedField) weFocusedField.blur();
					if(document.getElementById("weDialogType").value=="int"){
						setTimeout("weDoCheckAcFields()",100);
					} else {
						document.forms["we_form"].submit();
					}
				}

				function weDoCheckAcFields(){
					acStatus = YAHOO.autocoml.checkACFields();
					acStatusType = typeof acStatus;
					if (weAcCheckLoop > 10) {
						' . we_message_reporting::getShowMessageCall($GLOBALS['l_alert']['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) . '
						weAcCheckLoop = 0;
					} else if(acStatusType.toLowerCase() == "object") {
						if(acStatus.running) {
							weAcCheckLoop++;
							setTimeout("weDoCheckAcFields",100);
						} else if(!acStatus.valid) {
							' . we_message_reporting::getShowMessageCall($GLOBALS['l_alert']['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) . '
							weAcCheckLoop=0;
						} else {
							weAcCheckLoop=0;
							document.forms["we_form"].submit();
						}
					} else {
						' . we_message_reporting::getShowMessageCall($GLOBALS['l_alert']['save_error_fields_value_not_valid'],WE_MESSAGE_ERROR) . '
					}
				}

			 	function changeTypeSelect(s){
					for(var i=0; i< s.options.length; i++){
						var trObj = document.getElementById(s.options[i].value+"_tr");
						if(i != s.selectedIndex){
							trObj.style.display = "none";
						}else{
							trObj.style.display = "";
						}
					}
			 	}

				function we_cmd() {
					var args = "";
					var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

					switch (arguments[0]) {
    					case "openDocselector":
							new jsWindow(url,"we_docselector",-1,-1,'.WINDOW_DOCSELECTOR_WIDTH.','.WINDOW_DOCSELECTOR_HEIGHT.',true,false,true,true);
							break;

						case "browse_server":
							new jsWindow(url,"browse_server",-1,-1,800,400,true,false,true);
							break;
					}
				}

				function showclasss(name, val, onCh) {
';
			if(isset($this->args["cssClasses"]) && $this->args["cssClasses"]){
				$js .= '					var classCSV = "'.$this->args["cssClasses"].'";
					classNames = classCSV.split(/,/);';
			}else{
				$js .= '					classNames = top.opener.we_classNames;';
			}
				$js .= '
					document.writeln(\'<select class="defaultfont" style="width:300px" name="\'+name+\'" id="\'+name+\'" size="1"\'+(onCh ? \' onChange="\'+onCh+\'"\' : \'\')+\'>\');
					document.writeln(\'<option value="">'.$GLOBALS["l_wysiwyg"]["none"].'\');

					for (var i = 0; i < classNames.length; i++) {
						var foo = classNames[i].substring(0,1) == "." ?
							classNames[i].substring(1,classNames[i].length) :
							classNames[i];
						document.writeln(\'<option value="\'+foo+\'"\'+((val==foo) ? \' selected\' : \'\')+\'>.\'+foo);
					}
					document.writeln(\'</select>\');
				}

				function showanchors(name, val, onCh) {
					var pageAnchors = top.opener.document.getElementsByTagName("A");
					var objAnchors = top.opener.weWysiwygObject_'.$this->args["editname"].'.eDocument.getElementsByTagName("A");
					var allAnchors = new Array();

					for(var i = 0; i < pageAnchors.length; i++) {
						if (!pageAnchors[i].href && pageAnchors[i].name != "") {
							allAnchors.push(pageAnchors[i].name);
						}
					}

					for (var i = 0; i < objAnchors.length; i++) {
						if(!objAnchors[i].href && objAnchors[i].name != "") {
							allAnchors.push(objAnchors[i].name);
						}
					}
					if(allAnchors.length){
						document.writeln(\'<select class="defaultfont" style="width:100px" name="\'+name+\'" id="\'+name+\'" size="1"\'+(onCh ? \' onChange="\'+onCh+\'"\' : \'\')+\'>\');
						document.writeln(\'<option value="">\');

						for (var i = 0; i < allAnchors.length; i++) {
							document.writeln(\'<option value="\'+allAnchors[i]+\'"\'+((val==allAnchors[i]) ? \' selected\' : \'\')+\'>\'+allAnchors[i]);
						}

						document.writeln(\'</select>\');
					}
				}

			//-->
			</script>';
		return $js;
	}

	##################################################################################################

}