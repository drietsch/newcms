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

class weRuleDialog extends weDialog{
	
##################################################################################################

	var $dialogWidth = 270;
	var $JsOnly = true;

	var $changeableArgs = array(	"width",
									"height",
									"color",
									"noshade",
									"align"
								);
	
##################################################################################################

	function weRuleDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["edit_hr"];
		$this->defaultInit();
	}
	
##################################################################################################

	function defaultInit(){
		$this->args["width"] = "";
		$this->args["height"] = "";
		$this->args["color"] = "";
		$this->args["align"] = "";
		$this->args["noshade"] = false;
	}
	

##################################################################################################

	function getDialogContentHTML(){
		$foo = $this->formColor(7,"we_dialog_args[color]",(isset($this->args["color"]) ? $this->args["color"] : ""),50);
		$color = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["color"]);
	
		$foo = htmlTextInput("we_dialog_args[width]", 5, (isset($this->args["width"]) ? $this->args["width"] :""), "", ' onkeypress="return IsDigitPercent(event);"', "text" , 50 );
		$width = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["width"]);

		$foo = htmlTextInput("we_dialog_args[height]", 5, (isset($this->args["height"]) ? $this->args["height"] :""), "", ' onkeypress="return IsDigitPercent(event);"', "text" , 50 );
		$height = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["height"]);

		$noshade = '<table cellpadding="0" cellspacing="0" border="0">
<tr><td><input type="checkbox" name="we_dialog_args[noshade]" value="1"'.((isset($this->args["noshade"]) && $this->args["noshade"]) ? " checked" : "").'></td><td>'.getPixel(8,2).'</td><td class="defaultfont">'.
				$GLOBALS["l_wysiwyg"]["noshade"].'</td></tr></table>';

		$foo = '<select class="defaultfont" name="we_dialog_args[align]" size="1">
							<option value="">Default</option>
							<option value="left"'.((isset($this->args["align"]) && $this->args["align"] == "left") ? "selected" : "").'>Left</option>
							<option value="center"'.((isset($this->args["align"]) && $this->args["align"] == "center") ? "selected" : "").'>Center</option>
							<option value="right"'.((isset($this->args["align"]) && $this->args["align"] == "right") ? "selected" : "").'>Right</option>
						</select>';
		$align = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["halignment"]);
	
	$table = '<table border="0" cellpadding="0" cellspacing="0">
<tr><td>'.$width.'</td><td>'.$height.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(90,4).'</td></tr>
<tr><td>'.$align.'</td><td>'.$color.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(90,4).'</td></tr>
<tr><td colspan="2">'.$noshade.'</td></tr>
</table>
';

		return $table;

	}
	
	
##################################################################################################

}