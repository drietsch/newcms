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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/wysiwyg.inc.php");


class weColorDialog extends weDialog{
	
##################################################################################################

	var $changeableArgs = array("color");
	var $JsOnly = true;
	
##################################################################################################

	function weColorDialog(){
		$this->weDialog();
		$this->dialogTitle = $GLOBALS["l_wysiwyg"]["choosecolor"];
		$this->args["color"] = "";
	}
		
##################################################################################################

	function getDialogContentHTML(){
	
$colortable = '<table border="1" bordercolor="SILVER" bordercolorlight="WHITE" bordercolordark="BLACK" cellspacing="0" cellpadding="0">
<script language="JavaScript" type="text/javascript">
var z=0;
for ( col in we_color2 ){
	if(z == 0){
		document.writeln(\'<tr>\');
	}

document.writeln(\'<td bgcolor="\'+col+\'"><a href="#" onClick="selectColor(\\\'\'+col+\'\\\');"><img src="'.IMAGE_DIR.'pixel.gif" width="15" height="15" border="0" alt="\'+we_color2[col]+\'"></a></td>\');

if(z==17){
		document.writeln(\'</tr>\');
		z = 0;
	}else{
		z++;
	}
}
if(z != 0){
	for(var i=z;i<18;i++){
		document.writeln(\'<td></td>\');
	}
	document.writeln(\'</tr>\');
}
</script>
		</table>
	';
	$we_button = new we_button();
	$trash = $we_button->create_button("image:btn_function_trash", "javascript:selectColor('')");
	
	$foo = '<table border="0" cellpadding="0" cellspacing="0"><tr><td><input type="text" size="20" name="we_dialog_args[color]" class="defaultfont" style="width:150px;'.($this->args["color"] ? ('background-color:'.$this->args["color"].';') : '').'" value="'.$this->args["color"].'"></td><td>'.getPixel(10,2).'</td><td>'.$trash.'</td></tr></table>';
	$color = htmlFormElementTable($foo,$GLOBALS["l_wysiwyg"]["color"]);
	

	$table = '<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>'.$colortable.'</td>
	</tr>
	<tr>
		<td>'.getPixel(2,10).'</td>
	</tr>
	<tr>
		<td>'.$color.'</td>
	</tr>
</table>
';
	return $table;

	}
	
##################################################################################################

	function getJs(){
		return weDialog::getJs(). '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'we_colors2.js"></script>
<script language="JavaScript" type="text/javascript">

function selectColor(c){
	document.we_form.elements["we_dialog_args[color]"].value = c;
	if(document.we_form.elements["we_dialog_args[color]"].style){
		document.we_form.elements["we_dialog_args[color]"].style.backgroundColor = c;
	}
}
</script>
';
	}
	
##################################################################################################

}