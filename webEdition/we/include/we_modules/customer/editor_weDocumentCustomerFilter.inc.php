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

include_once( $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php" );
include_once( $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php" );
include_once( $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/customer.inc.php" );
include_once( $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_modules/customer/weDocumentCustomerFilter.class.php" );
include_once( $_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weDocumentCustomerFilterView.class.php" );


$parts = array();
$_space_size = 120;


if ($we_doc->ClassName != "we_imageDocument" && we_hasPerm("CAN_EDIT_CUSTOMERFILTER")) {
	$_filter = $we_doc->documentCustomerFilter;
	if (!$_filter) {
		$_filter = weDocumentCustomerFilter::getEmptyDocumentCustomerFilter();
	}
	$_view = new weDocumentCustomerFilterView($_filter, "_EditorFrame.setEditorIsHot(true);", 520);

	array_push(
		$parts,
		array(
			'headline' => $GLOBALS['l_customerFilter']['customerFilter'],
			'html' =>	$_view->getFilterHTML(),
			'space' => $_space_size
		)
	);

}


$_docWebUserHTML = formWebuser(we_hasPerm("CAN_CHANGE_DOCS_CUSTOMER"),434);
$_docWebUser = array(
	'headline' => $l_customer["one_customer"],
	'html' =>	$_docWebUserHTML,
	'space' => $_space_size
);
array_push( $parts, $_docWebUser );



print htmlTop();
print STYLESHEET;
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_editors/we_editor_script.inc.php");
print we_htmlElement::cssElement("
.paddingLeft {
	padding-left: 25px;
}
.paddingVertical {
	padding-top: 10px;
	padding-bottom: 10px;
}

");
print we_htmlElement::jsElement("", array("src" => JS_DIR . "/windows.js"));
print we_htmlElement::jsElement("", array("src" => JS_DIR . "/utils/multi_edit.js"));
if (isset($yuiSuggest)) { // webuser filter is not displayed at images, so $yuiSuggest is not defined!
	print $yuiSuggest->getYuiCssFiles() . $yuiSuggest->getYuiJsFiles();
}

print "<head>\n";
print "<body class=\"weEditorBody\">\n";
print "<form name=\"we_form\" onsubmit=\"return false\">\n";
print $we_doc->hiddenTrans();
if ($we_doc->ClassName != "we_imageDocument") {
	print hidden("we_edit_weDocumentCustomerFilter", 1);
	print hidden("weDocumentCustomerFilter_id", $_filter->getId());
}
print we_multiIconBox::getHTML("weDocProp","100%",$parts,20,"",-1,$GLOBALS["l_we_class"]["moreProps"],$GLOBALS["l_we_class"]["lessProps"]);
print "</form>\n";
print "</body>";
print "</html>";

function formWebuser($canChange,$width=388){
	global $l_we_class, $l_customer;

	$we_button = new we_button();

	if(!$GLOBALS['we_doc']->WebUserID) $GLOBALS['we_doc']->WebUserID = 0;

	$webuser = "";//$l_we_class["nobody"];

	if ($GLOBALS['we_doc']->WebUserID != 0) {
		$webuser = id_to_path($GLOBALS['we_doc']->WebUserID,CUSTOMER_TABLE,$GLOBALS['we_doc']->DB_WE);
		if(!$webuser) {
			$webuser = "";//$l_we_class["nobody"];
		}
	}

	if($canChange){

		$textname = 'wetmp_'.$GLOBALS['we_doc']->Name.'_WebUserID';
		$idname = 'we_'.$GLOBALS['we_doc']->Name.'_WebUserID';

		//$attribs = ' readonly';

		//$inputFeld=$GLOBALS['we_doc']->htmlTextInput($textname,24,$webuser,"",$attribs,"",$width);
		//$idfield = $GLOBALS['we_doc']->htmlHidden($idname,$GLOBALS['we_doc']->WebUserID);

		$button =  $we_button->create_button("select","javascript:we_cmd('openSelector',document.we_form.elements['$idname'].value,'".CUSTOMER_TABLE."','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$textname\\'].value')");

		$_trashBut = $we_button->create_button("image:btn_function_trash", "javascript:document.we_form.elements['$idname'].value=0;document.we_form.elements['$textname'].value='';_EditorFrame.setEditorIsHot(true);");
/*
		$out = $GLOBALS['we_doc']->htmlFormElementTable($inputFeld,
		$l_customer["connected_with_customer"],
		"left",
		"defaultfont",
		$idfield,
		getPixel(20,4),
		$button,getPixel(5,4),$_trashBut);
		*/
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("Customer");
		$yuiSuggest->setContentType("");
		$yuiSuggest->setInput($textname,$webuser,'','',1);
		$yuiSuggest->setLabel($l_customer["connected_with_customer"]);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($idname,$GLOBALS['we_doc']->WebUserID);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setWidth(434);
		$yuiSuggest->setSelectButton($button);
		$yuiSuggest->setTrashButton($_trashBut);
		$yuiSuggest->setTable(CUSTOMER_TABLE);
		
		$out = $yuiSuggest->getYuiFiles() . $yuiSuggest->getHTML() . $yuiSuggest->getYuiCode() . "\n";
		
	}else{
		$out = $webuser;
	}
	return $out;

}

?>