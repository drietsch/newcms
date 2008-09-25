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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/eplugin.inc.php");

	protect();

	$js=we_htmlElement::jsElement('
	var code;
	var to;
	
	var isLodaed = false;
	
	function setIsLoaded(flag) {
		self.isLoaded = flag;
	}
	
	function editSettings() {
		if (self.isLoaded) {
			document.WePlugin.editSettings();
		}
	}
	
	function editSource(filename,ct,charset){
	
		var _EditorFrame = top.weEditorFrameController.getActiveEditorFrame();
				
		var source = "###EDITORPLUGIN:EMPTYSTRING###";
		if(_EditorFrame.getContentEditor().getSource){
			source = _EditorFrame.getContentEditor().getSource();
			document.we_form.acceptCharset = _EditorFrame.getContentEditor().getCharset();
		}
	
		document.we_form.elements[\'we_cmd[0]\'].value="editSource";
		document.we_form.elements[\'we_cmd[1]\'].value=filename;
		document.we_form.elements[\'we_cmd[2]\'].value=_EditorFrame.getEditorTransaction();
		document.we_form.elements[\'we_cmd[3]\'].value=ct;
		document.we_form.elements[\'we_cmd[4]\'].value=source;

		document.we_form.submit();
		
	}
	
	function editFile(){
		var _EditorFrame = top.weEditorFrameController.getActiveEditorFrame();
		document.we_form.elements[\'we_cmd[0]\'].value="editFile";
		document.we_form.elements[\'we_cmd[1]\'].value=_EditorFrame.getEditorTransaction();
		
		document.we_form.submit();
		
		
	}
		
	function setSource(trans){
		
		var _EditorFrame = top.weEditorFrameController.getEditorFrameByTransaction(trans);
		if(_EditorFrame) {
		
			_EditorFrame.setEditorIsHot(true);
			
			var source =  (self.isLoaded) ? document.WePlugin.getSource(trans) : "";
				
			if(_EditorFrame && _EditorFrame.getContentEditor().setSource){
				_EditorFrame.getContentEditor().setSource(source);
			} else{
				document.we_form.elements[\'we_cmd[0]\'].value="setSource";
				document.we_form.elements[\'we_cmd[1]\'].value=trans;
				document.we_form.elements[\'we_cmd[2]\'].value=source;
	
				document.we_form.submit();
			}
		}
	}
	
	function setFile(source,trans){
		document.we_form.elements[\'we_cmd[0]\'].value="setFile";
		document.we_form.elements[\'we_cmd[1]\'].value=trans;
		document.we_form.elements[\'we_cmd[2]\'].value=source;
		document.we_form.submit();
	}
	
	
	
	function reloadContentFrame(trans){
		document.we_form.elements[\'we_cmd[0]\'].value="reloadContentFrame";
		document.we_form.elements[\'we_cmd[1]\'].value=trans;
		document.we_form.submit();
	}
	
	
	function remove(transaction) {
		if (self.isLoaded) {
			document.WePlugin.removeDocument(transaction);
		}
	}
	
	function isInEditor(transaction) {
		if (self.isLoaded) {
			return document.WePlugin.inEditor(transaction);
		}
		return false;
	}
	
	function getDocCount() {
		if (self.isLoaded) {
			return document.WePlugin.getDocCount();
		}
		return 1;
	}

	function pingPlugin() {
		if(document.WePlugin && self.isLoaded) {

			c++;
			//document.getElementById("debug").innerHTML += c + "<br>";
		
			if(document.WePlugin.hasMessages) {
				if(document.WePlugin.hasMessages()) {
					var messages = document.WePlugin.getMessages();
					eval(""+messages);
					//document.getElementById("debug").innerHTML += c + "<br>" + messages+"<br>";
				
				}
			}
		
		}
		
		to = window.setTimeout("pingPlugin()",1000);
	
	}
	
	
	var c = 0;

	');

	$applet=we_htmlElement::htmlApplet(array(
			"name"=>"WePlugin",
			"code"=>"EPlugin",
			"archive"=>"weplugin.jar",
			"codebase"=>"http://".$SERVER_NAME.(isset($SERVER_PORT) ? ":".$SERVER_PORT : "")."/webEdition/eplugin/",
			"width"=>"10",
			"height"=>"10",
			"scriptable"=>null,
			"mayscript"=>null
		),
		we_htmlElement::htmlParam(array("name"=>"param_list","value"=>"lan_main_dialog_title,lan_alert_noeditor_title,lan_alert_noeditor_text,lan_select_text,lan_select_button,lan_start_button,lan_close_button,lan_clear_button,lan_list_label,lan_showall_label,lan_edit_button,lan_default_for,lan_editor_name,lan_path,lan_args,lan_contenttypes,lan_defaultfor_label,lan_del_button,lan_save_button,lan_autostart_label,lan_settings_dialog_title,lan_alert_nodefeditor_text,lan_del_question,lan_clear_question,lan_encoding,lan_add_button"))."\n".
		we_htmlElement::htmlParam(array("name"=>"host","value"=>"http://".$SERVER_NAME.(isset($SERVER_PORT) ? ":".$SERVER_PORT : "")))."\n".
		we_htmlElement::htmlParam(array("name"=>"cmdentry","value"=>"http://".$SERVER_NAME.(isset($SERVER_PORT) ? ":".$SERVER_PORT : "") . "/webEdition/eplugin/weplugin_cmd.php"))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_main_dialog_title","value"=>$l_eplugin["lan_main_dialog_title"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_settings_dialog_title","value"=>$l_eplugin["lan_settings_dialog_title"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_alert_noeditor_title","value"=>$l_eplugin["lan_alert_noeditor_title"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_alert_noeditor_text","value"=>$l_eplugin["lan_alert_noeditor_text"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_select_text","value"=>$l_eplugin["lan_select_text"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_select_button","value"=>$l_eplugin["lan_select_button"]))."\n".
		
		we_htmlElement::htmlParam(array("name"=>"lan_start_button","value"=>$l_eplugin["lan_start_button"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_close_button","value"=>$l_eplugin["lan_close_button"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_clear_button","value"=>$l_eplugin["lan_clear_button"]))."\n".
		we_htmlElement::htmlParam(array("name"=>"lan_list_label","value"=>$l_eplugin["lan_list_label"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_showall_label","value"=>$l_eplugin["lan_showall_label"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_edit_button","value"=>$l_eplugin["lan_edit_button"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_default_for","value"=>$l_eplugin["lan_default_for"]))."\n" .
		
		we_htmlElement::htmlParam(array("name"=>"lan_editor_name","value"=>$l_eplugin["lan_editor_name"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_path","value"=>$l_eplugin["lan_path"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_args","value"=>$l_eplugin["lan_args"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_contenttypes","value"=>$l_eplugin["lan_contenttypes"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_defaultfor_label","value"=>$l_eplugin["lan_defaultfor_label"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_del_button","value"=>$l_eplugin["lan_del_button"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_save_button","value"=>$l_eplugin["lan_save_button"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_editor_prop","value"=>$l_eplugin["lan_editor_prop"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_autostart_label","value"=>$l_eplugin["lan_autostart_label"]))."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_alert_nodefeditor_text","value"=>$l_eplugin["lan_alert_nodefeditor_text"])) ."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_del_question","value"=>$l_eplugin["lan_del_question"])) ."\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_clear_question","value"=>$l_eplugin["lan_clear_question"])) . "\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_encoding","value"=>$l_eplugin["lan_encoding"])) . "\n" .
		we_htmlElement::htmlParam(array("name"=>"lan_add_button","value"=>$l_eplugin["lan_add_button"]))
		
	);

	$charset = '';

	print we_htmlElement::htmlHtml(
		we_htmlElement::htmlHead(
		$_meta_content_type = we_htmlElement::htmlMeta(array("http-equiv" => "content-type", "content" => "text/html; charset=" . ($charset ? $charset : $GLOBALS["_language"]["charset"]))).
		$js
		).
		we_htmlElement::htmlBody(array("bgcolor"=>"white","marginwidth"=>"0","marginheight"=>"0","leftmargin"=>"0","topmargin"=>"0","onload"=>"to=window.setTimeout('pingPlugin()',5000);"),
				
				we_htmlElement::htmlDiv(array("id"=>"debug"),"") .
		
				we_htmlElement::htmlHidden(array("name"=>"hm","value"=>"0")).
				$applet."\n".
				we_htmlElement::htmlForm(array("name"=>"we_form","target"=>"load","action"=>"/webEdition/eplugin/weplugin_cmd.php","method"=>"post","accept-charset"=>$charset),
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[0]","value"=>""))."\n".
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[1]","value"=>""))."\n".
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[2]","value"=>""))."\n".
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[3]","value"=>""))."\n".
					we_htmlElement::htmlHidden(array("name"=>"we_cmd[4]","value"=>""))."\n"
					//we_htmlElement::htmlInput(array("name"=>"wePluginUpload","type"=>"file","value"=>""))."\n"
				)
				//.we_htmlElement::htmlInput(array("type"=>"button","onclick"=>"setFile('file');"))
		)
	);

?>
