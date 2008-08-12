<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weDialog.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");


class weCellDialog extends weDialog{

##################################################################################################

	var $JsOnly = true;

	var $changeableArgs = array(	"width",
									"height",
									"bgcolor",
									"background",
									"align",
									"valign",
									"colspan",
									"class",
									"isheader",
									"id",
									"headers",
									"scope"
								);

##################################################################################################

	function weCellDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["edit_cell"];
		$this->defaultInit();
	}

##################################################################################################

	function defaultInit(){
		$this->args["width"] = "";
		$this->args["height"] = "";
		$this->args["bgcolor"] = "";
		$this->args["background"] = "";
		$this->args["align"] = "";
		$this->args["valign"] = "";
		$this->args["colspan"] = "";
		$this->args["class"] = "";
		$this->args["isheader"] = "";
		$this->args["id"] = "";
		$this->args["headers"] = "";
		$this->args["scope"] = "";
	}

##################################################################################################

	function getDialogContentHTML(){

		$foo = $this->formColor(10,"we_dialog_args[bgcolor]",(isset($this->args["bgcolor"]) ? $this->args["bgcolor"] : ""),50);
		$bgcolor = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["bgcolor"]);

		$foo = htmlTextInput("we_dialog_args[width]", 5, (isset($this->args["width"]) ? $this->args["width"] :""), "", ' onkeypress="return IsDigitPercent(event);"', "text" , 50 );
		$width = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["width"]);

		$foo = htmlTextInput("we_dialog_args[height]", 5, (isset($this->args["height"]) ? $this->args["height"] :""), "", ' onkeypress="return IsDigitPercent(event);"', "text" , 50 );
		$height = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["height"]);

		$foo = htmlTextInput("we_dialog_args[colspan]", 5, (isset($this->args["colspan"]) ? $this->args["colspan"] :""), "", ' onkeypress="return IsDigit(event);"', "text" , 50 );

		$colspan = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["colspan"]);

		$foo = '<select class="defaultfont" name="we_dialog_args[align]" size="1">
							<option value="">Default</option>
							<option value="left"'.((isset($this->args["align"]) && $this->args["align"] == "left") ? "selected" : "").'>Left</option>
							<option value="center"'.((isset($this->args["align"]) && $this->args["align"] == "center") ? "selected" : "").'>Center</option>
							<option value="right"'.((isset($this->args["align"]) && $this->args["align"] == "right") ? "selected" : "").'>Right</option>
						</select>';
		$align = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["halignment"]);

		$foo = '<select class="defaultfont" name="we_dialog_args[valign]" size="1">
							<option value="">Default</option>
							<option value="top"'.((isset($this->args["valign"]) && $this->args["valign"] == "top") ? "selected" : "").'>Top</option>
							<option value="middle"'.((isset($this->args["valign"]) && $this->args["valign"] == "middle") ? "selected" : "").'>Middle</option>
							<option value="bottom"'.((isset($this->args["valign"]) && $this->args["valign"] == "bottom") ? "selected" : "").'>Bottom</option>
						</select>';
		$valign = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["valignment"]);

		$foo = '<script language="JavaScript" type="text/javascript">showclasss("we_dialog_args[class]","'.(isset($this->args["class"]) ? $this->args["class"] : "").'","");</script>';
		$classSelect = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["css_style"]);

		$_isheader = we_forms::checkboxWithHidden($this->args["isheader"] == 1, "we_dialog_args[isheader]", $GLOBALS["l_wysiwyg"]["isheader"]);

		$foo = htmlTextInput("we_dialog_args[id]", 5, (isset($this->args["id"]) ? $this->args["id"] :""), "", '', "text" , 50 );
		$_id = htmlFormElementTable($foo,"id");

		$foo = htmlTextInput("we_dialog_args[headers]", 5, (isset($this->args["headers"]) ? $this->args["headers"] :""), "", '', "text" , 50 );
		$_headers = htmlFormElementTable($foo,"headers");

		$foo = '<select class="defaultfont" name="we_dialog_args[scope]" size="1">
							<option value="">Default</option>
							<option value="row"'.((isset($this->args["scope"]) && $this->args["scope"] == "row") ? "selected" : "").'>row</option>
							<option value="col"'.((isset($this->args["scope"]) && $this->args["scope"] == "col") ? "selected" : "").'>col</option>
							<option value="rowgroup"'.((isset($this->args["scope"]) && $this->args["scope"] == "rowgroup") ? "selected" : "").'>rowgroup</option>
							<option value="colgroup"'.((isset($this->args["scope"]) && $this->args["scope"] == "colgroup") ? "selected" : "").'>colgroup</option>
						</select>';
		$_scope = htmlFormElementTable($foo,"scope");


	$table = '<table border="0" cellpadding="0" cellspacing="0">
<tr><td>'.$width.'</td><td>'.$height.'</td><td>'.$colspan.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td>'.$align.'</td><td>'.$valign.'</td><td>'.$bgcolor.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td>'.$_isheader.'</td><td>'.$_id.'</td><td>'.$_headers.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td colspan="3">'.$_scope.'</td></tr>
<tr><td>'.getPixel(135,10).'</td><td>'.getPixel(135,4).'</td><td>'.getPixel(135,4).'</td></tr>
<tr><td colspan="3">'.$classSelect.'</td></tr>
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
	document.writeln(\'<select class="defaultfont"  name="\'+name+\'" id="\'+name+\'" size="1"\'+(onCh ? \' onChange="\'+onCh+\'"\' : \'\')+\' style="width:380px">\');
	document.writeln(\'<option value="">'.$GLOBALS["l_wysiwyg"]["none"].'\');
	for(var i=0;i<classNames.length;i++){
		var foo = classNames[i].substring(0,1) == "." ?
							classNames[i].substring(1,classNames[i].length) :
							classNames[i];
		document.writeln(\'<option value="\'+foo+\'"\'+((val==foo) ? \' selected\' : \'\')+\'>\'+classNames[i]);
	}
	document.writeln(\'</select>\');
}
	</script>
';
			return $js;
	}

##################################################################################################

}