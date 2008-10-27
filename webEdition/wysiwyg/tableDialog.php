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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weTableDialog.class.inc.php");
protect();
$dialog = new weTableDialog();
// MS-Fix
if(isset($_REQUEST["we_dialog_args"]["cellPadding"])){
	$_REQUEST["we_dialog_args"]["cellpadding"] = $_REQUEST["we_dialog_args"]["cellPadding"];
	unset($_REQUEST["we_dialog_args"]["cellPadding"]);
}
if(isset($_REQUEST["we_dialog_args"]["cellSpacing"])){
	$_REQUEST["we_dialog_args"]["cellspacing"] = $_REQUEST["we_dialog_args"]["cellSpacing"];
	unset($_REQUEST["we_dialog_args"]["cellSpacing"]);
}
if(isset($_REQUEST["we_dialog_args"]["bgColor"])){
	$_REQUEST["we_dialog_args"]["bgcolor"] = $_REQUEST["we_dialog_args"]["bgColor"];
	unset($_REQUEST["we_dialog_args"]["bgColor"]);
}
$dialog->initByHttp();
$dialog->registerOkJsFN("weDoTblJS");

if(!$_REQUEST["we_dialog_args"]["edit"]){
	$dialog->dialogTitle = $GLOBALS["l_wysiwyg"]["insert_table"];
}
print $dialog->getHTML();

function weDoTblJS(){
	return '
eval("var editorObj = top.opener.weWysiwygObject_"+document.we_form.elements["we_dialog_args[editname]"].value);
var edit_table = (document.we_form.elements["we_dialog_args[edit]"].value==1) ? true : false;
var rows = document.we_form.elements["we_dialog_args[rows]"].value;rows = rows ? rows : 3;
var cols = document.we_form.elements["we_dialog_args[cols]"].value;cols = cols ? cols : 3;
var border = document.we_form.elements["we_dialog_args[border]"].value;
var classname = document.we_form.elements["we_dialog_args[class]"].value;
var cellpadding = document.we_form.elements["we_dialog_args[cellpadding]"].value;
var cellspacing = document.we_form.elements["we_dialog_args[cellspacing]"].value;
var bgcolor = document.we_form.elements["we_dialog_args[bgcolor]"].value;
var background = "";
var summary = document.we_form.elements["we_dialog_args[summary]"].value;
var width = document.we_form.elements["we_dialog_args[width]"].value;
var height = document.we_form.elements["we_dialog_args[height]"].value;
var align_sel = document.we_form.elements["we_dialog_args[align]"];
var align = align_sel.options[align_sel.selectedIndex].value;
editorObj.edittable(edit_table,rows,cols,border,cellpadding,cellspacing,bgcolor,background,width,height,align,classname,summary);
top.close();
';
}
?>