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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");

class weAbbrDialog extends weDialog{
	
##################################################################################################

	var $dialogWidth = 370;
	var $JsOnly = true;

	var $changeableArgs = array(	"title",
									"lang",
									"class",
									"style"
								);
	
##################################################################################################

	function weAbbrDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["abbr_title"];
		$this->defaultInit();
	}
	
##################################################################################################

	function defaultInit(){
		$this->args["title"] = "";
		$this->args["lang"] = "";
		$this->args["class"] = "";
		$this->args["style"] = "";
	}

##################################################################################################
	
	function getJs() {
		
		$js = weDialog::getJs();
		
		if(defined("GLOSSARY_TABLE")) {
			$js .= '
			<script language="JavaScript" type="text/javascript">
			<!--
					function weSaveToGlossaryFn() {
						eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
						document.we_form.elements[\'weSaveToGlossary\'].value = 1;
						if(editorObj.getSelectedText().length > 0) {
							document.we_form.elements[\'text\'].value = editorObj.getSelectedText();
						} else {
							document.we_form.elements[\'text\'].value = editorObj.getNodeUnderInsertionPoint("ABBR",true,false).innerHTML;
						}
						document.we_form.submit();
					}
			-->
			</script>';
		}
		
		return $js;
		
	}
	

##################################################################################################

	function getDialogContentHTML(){
	
		$foo = htmlTextInput("we_dialog_args[title]", 30, (isset($this->args["title"]) ? $this->args["title"] :""), "", '', "text" , 350 );
		$title = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["title"]);

		$lang = $this->getLangField("lang",$GLOBALS["l_wysiwyg"]["language"],350);
		
	$table = '<table border="0" cellpadding="0" cellspacing="0">
<tr><td>'.$title.'</td></tr>
<tr><td>'.getPixel(225,10).'</td></tr>
<tr><td>'.$lang.'</td></tr>
</table>
';
		if(defined("GLOSSARY_TABLE") && we_hasPerm("NEW_GLOSSARY")) {
			$table .=  hidden("weSaveToGlossary", 0);
			$table .=  hidden("language", isset($_REQUEST['language']) && $_REQUEST['language'] != "" ? $_REQUEST['language'] : $GLOBALS['weDefaultFrontendLanguage']);
			$table .=  hidden("text", "");
		}

		return $table;

	}
	
	function getDialogButtons(){
		$we_button = new we_button();
		$trashbut =  $we_button->create_button("image:btn_function_trash", "javascript:document.we_form.elements['we_dialog_args[title]'].value='';weDoOk();");
		
		$buttons = array();
		array_push($buttons, $trashbut);
		
		if(defined("GLOSSARY_TABLE") && we_hasPerm("NEW_GLOSSARY")) {
			$glossarybut =  $we_button->create_button("to_glossary", "javascript:weSaveToGlossaryFn();", true, 100);
			array_push($buttons, $glossarybut);
		}
		
		array_push($buttons, parent::getDialogButtons());
		
		return $we_button->create_button_table($buttons);
		
	}
	
##################################################################################################

}