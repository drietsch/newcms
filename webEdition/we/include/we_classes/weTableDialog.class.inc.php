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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");

class weTableDialog extends weDialog{

##################################################################################################
	var $ClassName = "weTableDialog";

	var $JsOnly = true;

	var $changeableArgs = array(	"border",
									"rows",
									"cols",
									"width",
									"height",
									"bgcolor",
									"background",
									"cellspacing",
									"cellpadding",
									"align",
									"class",
									"summary"
								);

##################################################################################################

	function weTableDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["edit_table"];
		$this->defaultInit();
	}

##################################################################################################

	function defaultInit(){
		$this->args["border"] = "";
		$this->args["rows"] = "";
		$this->args["cols"] = "";
		$this->args["width"] = "";
		$this->args["height"] = "";
		$this->args["bgcolor"] = "";
		$this->args["background"] = "";
		$this->args["cellpadding"] = "";
		$this->args["cellpadding"] = "";
		$this->args["align"] = "";
		$this->args["class"] = "";
		$this->args["summary"] = "";
	}

##################################################################################################

	function getDialogContentHTML(){

		$foo = $this->formColor(10,"we_dialog_args[bgcolor]",(isset($this->args["bgcolor"]) ? $this->args["bgcolor"] :""),50);
		$bgcolor = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["bgcolor"]);

		$foo = htmlTextInput("we_dialog_args[cellspacing]", 5, (isset($this->args["cellspacing"]) ? $this->args["cellspacing"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );
		$cellspacing = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["cellspacing"]);

		$foo = htmlTextInput("we_dialog_args[cellpadding]", 5, (isset($this->args["cellpadding"]) ? $this->args["cellpadding"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );

		$cellpadding = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["cellpadding"]);

		$foo = htmlTextInput("we_dialog_args[border]", 5, (isset($this->args["border"]) ? $this->args["border"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );

		$border = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["border"]);

		$foo = htmlTextInput("we_dialog_args[cols]", 5, (isset($this->args["cols"]) ? $this->args["cols"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );

		$cols = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["cols"]);

		$foo = htmlTextInput("we_dialog_args[rows]", 5, (isset($this->args["rows"]) ? $this->args["rows"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );

		$rows = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["rows"]);

		$foo = htmlTextInput("we_dialog_args[width]", 5, (isset($this->args["width"]) ? $this->args["width"] :""), "", ' onkeypress="return IsDigitPercent(event);"', "text" , 50 );
		$width = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["width"]);

		$foo = htmlTextInput("we_dialog_args[height]", 5, (isset($this->args["height"]) ? $this->args["height"] :""), "", ' onkeypress="return IsDigitPercent(event);"', "text" , 50 );
		$height = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["height"]);


		$foo = htmlTextInput("we_dialog_args[summary]", 50, (isset($this->args["summary"]) ? $this->args["summary"] :""), "", '', "text" , 380 );
		$_summary = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["summary"]);

		$foo = '<select class="defaultfont" name="we_dialog_args[align]" size="1" style="width:110px">
							<option value="">Default</option>
							<option value="top"'.((isset($this->args["align"]) && $this->args["align"] == "top") ? "selected" : "").'>Top</option>
							<option value="center"'.((isset($this->args["align"]) && $this->args["align"] == "center") ? "selected" : "").'>Center</option>
							<option value="bottom"'.((isset($this->args["align"]) && $this->args["align"] == "bottom") ? "selected" : "").'>Bottom</option>
							<option value="left"'.((isset($this->args["align"]) && $this->args["align"] == "left") ? "selected" : "").'>Left</option>
							<option value="right"'.((isset($this->args["align"]) && $this->args["align"] == "right") ? "selected" : "").'>Right</option>
							<option value="texttop"'.((isset($this->args["align"]) && $this->args["align"] == "texttop") ? "selected" : "").'>Text Top</option>
							<option value="baseline"'.((isset($this->args["align"]) && $this->args["align"] == "baseline") ? "selected" : "").'>Baseline</option>
							<option value="absbottom"'.((isset($this->args["align"]) && $this->args["align"] == "absbottom") ? "selected" : "").'>Abs Bottom</option>
						</select>';
		$align = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["alignment"]);

		$foo = '<script language="JavaScript" type="text/javascript">showclasss("we_dialog_args[class]","'.(isset($this->args["class"]) ? $this->args["class"] : "") .'","");</script>';
		$classSelect = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["css_style"]);

	$table = '<table border="0" cellpadding="0" cellspacing="0">
<tr><td>'.$rows.'</td><td>'.$cols.'</td><td>'.$border.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td>'.$cellpadding.'</td><td>'.$cellspacing.'</td><td>'.$bgcolor.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td>'.$width.'</td><td>'.$height.'</td><td>'.$align.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td colspan="3">'.$_summary.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td colspan="3">'.$classSelect.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
</table>
';

		return $table;

	}


##################################################################################################

	function getJs(){
		$js = weDialog::getJs().'	<script language=javascript>
				function showclasss(name, val, onCh) {
';
			if(isset($this->args["cssClasses"]) && $this->args["cssClasses"]){
				$js .= '					var classCSV = "'.$this->args["cssClasses"].'";
					classNames = classCSV.split(/,/);';
			}else{
				$js .= '					classNames = top.opener.we_classNames;';
			}
				$js .= '
					document.writeln(\'<select class="defaultfont" style="width:380px" name="\'+name+\'" id="\'+name+\'" size="1"\'+(onCh ? \' onChange="\'+onCh+\'"\' : \'\')+\'>\');
					document.writeln(\'<option value="">'.$GLOBALS["l_wysiwyg"]["none"].'\');

					for (var i = 0; i < classNames.length; i++) {
						var foo = classNames[i].substring(0,1) == "." ?
							classNames[i].substring(1,classNames[i].length) :
							classNames[i];
						document.writeln(\'<option value="\'+foo+\'"\'+((val==foo) ? \' selected\' : \'\')+\'>.\'+foo);
					}
					document.writeln(\'</select>\');
				}
	</script>
';
		return $js;
	}

##################################################################################################

}