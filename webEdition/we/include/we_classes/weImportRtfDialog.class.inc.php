<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_wysiwyg
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weDialog.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/importrtf.inc.php");


class weImportRtfDialog extends weDialog{
	
##################################################################################################

	var $ClassName = "weImportRtfDialog";

	var $pageNr = 1;
	var $numPages = 2;
	var $JsOnly = true;
	var $arg=array();
	var $changeableArgs = array("htmltxt",
									"applyFontName",
									"applyFontSize",
									"applyFontColor"
									);
	
##################################################################################################

	function weImportRtfDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_importrtf"]["import_rtf"];
		$this->args["htmltxt"] = "";
		$this->args["applyFontName"]=false;
		$this->args["applyFontSize"]=false;
		$this->args["applyFontColor"]=false;
	}

##################################################################################################

	function getJs(){
		return weDialog::getJs().'
<script language="JavaScript" type="text/javascript">

function checkTheBox(box){
	b = document.we_form.elements[box];
	b.checked = (b.checked) ? false : true;
}

function importFile(){
	f = document.we_form;
	f.we_what.value = "dialog";
	f.submit();
}

</script>
';
	}

##################################################################################################

	function getNextBut(){
		$we_button = new we_button();
		return $we_button->create_button("next", "javascript:importFile();");
	}

##################################################################################################

	function getHTML(){
		if($this->pageNr == 2) $this->JsOnly = true;
		return parent::getHTML();
	}

##################################################################################################

	function getFormHTML(){
		if($this->pageNr == 1){
			return '<form enctype="multipart/form-data" name="we_form" action="'.$_SERVER["PHP_SELF"].'" method="post" target="_self">';
		}else{
			return '<form name="we_form" action="'.$_SERVER["PHP_SELF"].'" method="post" target="we_'.$this->ClassName.'_cmd_frame">';
		}
	}

##################################################################################################

	function getDialogContentHTML(){
	
		switch($this->pageNr){
########################################################################	
			case 1:
########################################################################	
				$content='<table border="0" cellpadding="0" cellspacing="0" width="550">			
	<tr>
		<td>'.getPixel(550,5).'</td>
	</tr>
	<tr>
		<td class="defaultfont"><b>'.$GLOBALS["l_importrtf"]["chose"].'</b></td>
	</tr>            
	<tr>
		<td><input type="file" name="fileName" size="50" onKeyDown="return false"></td>
	</tr>
	<tr>
		<td>'.getPixel(5,10).'</td>
	</tr>
	<tr>
		<td>'.we_forms::checkbox("1",(isset($this->args["applyFontName"]) && $this->args["applyFontName"] == 1),"we_dialog_args[applyFontName]",$GLOBALS["l_importrtf"]["use_fontname"]).'</td>                
	</tr>
	<tr>
		<td>'.we_forms::checkbox("1",(isset($this->args["applyFontSize"]) && $this->args["applyFontSize"] == 1),"we_dialog_args[applyFontSize]",$GLOBALS["l_importrtf"]["use_fontsize"]).'</td>                
	</tr>
	<tr>
		<td>'.we_forms::checkbox("1",(isset($this->args["applyFontColor"]) && $this->args["applyFontColor"] == 1),"we_dialog_args[applyFontColor]",$GLOBALS["l_importrtf"]["use_fontcolor"]).'</td>                
	</tr>
	<tr>
		<td>'.getPixel(5,22).'</td>
	</tr>
</table><input type="hidden" name="we_pageNr" value="2">
';
				break;
########################################################################	
			case 2:
########################################################################	
				if(isset($_FILES["fileName"]) && is_array($_FILES["fileName"])){
		
					$filename = isset($_FILES["fileName"]["tmp_name"]) ? $_FILES["fileName"]["tmp_name"] : "";
					if($filename && $filename!="none"){
						
						$this->args["applyFontName"]=isset($this->args["applyFontName"]) ? $this->args["applyFontName"] : false;
						$this->args["applyFontSize"]=isset($this->args["applyFontSize"]) ? $this->args["applyFontSize"] : false;
						$this->args["applyFontColor"]=isset($this->args["applyFontColor"]) ? $this->args["applyFontColor"] : false;
						
						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_rtf2html.inc.php"); 
						$rtf2html=new we_rtf2html($filename,$this->args["applyFontName"],$this->args["applyFontSize"],$this->args["applyFontColor"]);
					}
				}
				$content='<table border="0" cellpadding="0" cellspacing="0" width="550">
	<tr>
		<td colspan="2" class="defaultfont"><b>'.$GLOBALS["l_global"]["preview"].'</b></td>
	</tr>

	<tr>
		<td colspan="2"><textarea id="we_dialog_args[htmltxt]" name="we_dialog_args[htmltxt]" cols="59" rows="15" style="width:550px">'.
					(isset($rtf2html) ? htmlspecialchars($rtf2html->htmlOut) : "").'</textarea>
		</td>
	</tr>            
	<tr>
		<td colspan="2">'.getPixel(5,22).'</td>
	</tr>
</table>
';
				break;
########################################################################	
		}
		return $content;                       

	}
	
	
##################################################################################################

}
