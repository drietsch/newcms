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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/workflow.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

function showWorkflowFooterForNormalMode(){
	
	global $we_doc, $showPubl, $l_global;
	
	$_gap = 16;
	$_col = 0;
	$we_button = new we_button();
	
	$_footerTable = new we_htmlTable(	array(	"cellpadding" => 0,
												"cellspacing" => 0,
												"border"      => 0),
												1,
												0);
	
	$_publishbutton = '';
	//	decline
	$_footerTable->addCol(2);
	$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
	$_footerTable->setColContent(0, $_col++, $we_button->create_button("decline", "javascript:decline_workflow();"));
	
	if(weWorkflowUtility::isWorkflowFinished($we_doc->ID,$we_doc->Table) || ((1+weWorkflowUtility::findLastActiveStep($we_doc->ID,$we_doc->Table)) == sizeof(weWorkflowUtility::getNumberOfSteps($we_doc->ID,$we_doc->Table)) && we_hasPerm("PUBLISH"))){
		$_publishbutton = $we_button->create_button("publish", "javascript:finish_workflow();");
		
	} else {
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("forward", "javascript:pass_workflow();") );
		
	}
	
	if(weWorkflowUtility::canUserEditDoc($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]) && $we_doc->userCanSave()){
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("save", "javascript:_EditorFrame.setEditorPublishWhenSave(false);we_save_document();") );
	}
	
	if ($_publishbutton) {
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $_publishbutton );
		
	} else {
		if(weWorkflowUtility::canUserEditDoc($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]) && $we_doc->userCanSave()){
			
			if(!isset($we_doc->IsClassFolder) || !$we_doc->IsClassFolder){
				if( $showPubl ){
					$_footerTable->addCol(2);
					$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
					$_footerTable->setColContent(0, $_col++, $we_button->create_button("publish", "javascript:_EditorFrame.setEditorPublishWhenSave(true);we_save_document();") );
				}
			}
		}
	}
	
	
	return $_footerTable->getHtmlCode();
}

function showWorkflowFooterForSEEMMode(){
	
	global $we_doc, $showPubl, $l_global;
	
	$we_button = new we_button();
	
	$_col = 0;
	$_gap = 16;
	$_footerTable = new we_htmlTable(	array(	"cellpadding" => 0,
												"cellspacing" => 0,
												"border"      => 0),
										1,0);
	
	if($we_doc->EditPageNr == WE_EDITPAGE_PREVIEW){
		
		//	Edit-Button
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("edit", "javascript:parent.editHeader.we_cmd('switch_edit_page'," . WE_EDITPAGE_CONTENT . ",'" . $GLOBALS["we_transaction"] . "');"));
		
		//	Decline Workflow
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("decline", "javascript:decline_workflow();") );
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		if(weWorkflowUtility::isWorkflowFinished($we_doc->ID,$we_doc->Table) || ((1+weWorkflowUtility::findLastActiveStep($we_doc->ID,$we_doc->Table)) == sizeof(weWorkflowUtility::getNumberOfSteps($we_doc->ID,$we_doc->Table)) && we_hasPerm("PUBLISH"))){
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("publish", "javascript:finish_workflow();") );
		} else {
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("forward", "javascript:pass_workflow();") );
		}
		
	} else if ($we_doc->EditPageNr == WE_EDITPAGE_CONTENT){
	
		//	Preview Button
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("preview", "javascript:parent.editHeader.we_cmd('switch_edit_page'," . WE_EDITPAGE_PREVIEW . ",'" . $GLOBALS["we_transaction"] . "');") );
		
		//	Propertie-button
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/permissionhandler/permissionhandler.class.php");
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("properties", "javascript:parent.editHeader.we_cmd('switch_edit_page'," . WE_EDITPAGE_PROPERTIES . ",'" . $GLOBALS["we_transaction"] . "');") );
		
		//	Decline Workflow
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("decline", "javascript:decline_workflow();") );
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		if(weWorkflowUtility::isWorkflowFinished($we_doc->ID,$we_doc->Table) || ((1+weWorkflowUtility::findLastActiveStep($we_doc->ID,$we_doc->Table)) == sizeof(weWorkflowUtility::getNumberOfSteps($we_doc->ID,$we_doc->Table)) && we_hasPerm("PUBLISH"))){
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("publish", "javascript:finish_workflow();") );
		} else {
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("forward", "javascript:pass_workflow();") );
		}
		if(weWorkflowUtility::canUserEditDoc($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]) && $we_doc->userCanSave()){
			$_footerTable->addCol(2);
			$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("save", "javascript:_EditorFrame.setEditorPublishWhenSave(false);we_save_document();") );
			if(!isset($we_doc->IsClassFolder) || !$we_doc->IsClassFolder){
				if($showPubl){
					$_footerTable->addCol(2);
					$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
					$_footerTable->setColContent(0, $_col++, $we_button->create_button("publish", "javascript:_EditorFrame.setEditorPublishWhenSave(true);we_save_document();") );
				}
			}
		}
	} else if($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES){
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("preview", "javascript:parent.editHeader.we_cmd('switch_edit_page'," . WE_EDITPAGE_PREVIEW . ",'" . $GLOBALS["we_transaction"] . "');") );
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("preview", "javascript:parent.editHeader.we_cmd('switch_edit_page'," . WE_EDITPAGE_PREVIEW . ",'" . $GLOBALS["we_transaction"] . "');") );
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		$_footerTable->setColContent(0, $_col++, $we_button->create_button("decline", "javascript:decline_workflow();") );
		
		$_footerTable->addCol(2);
		$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
		if(weWorkflowUtility::isWorkflowFinished($we_doc->ID,$we_doc->Table) || ((1+weWorkflowUtility::findLastActiveStep($we_doc->ID,$we_doc->Table)) == sizeof(weWorkflowUtility::getNumberOfSteps($we_doc->ID,$we_doc->Table)) && we_hasPerm("PUBLISH"))){
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("publish", "javascript:finish_workflow();") );
		} else {
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("forward", "javascript:pass_workflow();") );
		}
		
		if(weWorkflowUtility::canUserEditDoc($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]) && $we_doc->userCanSave()){
			$_footerTable->addCol(2);
			$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
			$_footerTable->setColContent(0, $_col++, $we_button->create_button("save", "javascript:_EditorFrame.setEditorPublishWhenSave(false);we_save_document();") );
			
			if(!isset($we_doc->IsClassFolder) || !$we_doc->IsClassFolder){
				if($showPubl){
					$_footerTable->addCol(2);
					$_footerTable->setColContent(0, $_col++, getPixel($_gap, 2));
					$_footerTable->setColContent(0, $_col++, $we_button->create_button("publish", "javascript:_EditorFrame.setEditorPublishWhenSave(true);we_save_document();") );
				}
			}
		}
	}
	return $_footerTable->getHtmlCode();
}

if(weWorkflowUtility::isUserInWorkflow($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"]) || we_hasPerm("PUBLISH")){
	
	if($_SESSION["we_mode"] == "normal"){
		$_table = showWorkflowFooterForNormalMode();
	} else if ($_SESSION["we_mode"] == "seem"){
		$_table = showWorkflowFooterForSEEMMode();
	}
	
	
	$_we_form = we_htmlElement::htmlForm(	array(	"name"   => "we_form",
													"method" => "post"),
											$_table
											);
	
	$_body = we_htmlElement::htmlBody(	array(	"bgcolor"      => "white",
												"background"   => EDIT_IMAGE_DIR . "editfooterback.gif",
												"marginwidth"  => 0,
												"marginheight" => 8,
												"leftmargin"   => 0,
												"topmargin"    => 8),
										$_we_form)
										;
	
	print $_body;
} else {
	
	$_table = new we_htmlTable(	array(	"cellpadding" => 0,
										"cellspacing" => 0,
										"border"      => 0),
								1,
								4);
	$_table->setColContent(0, 0, getPixel( 16, 2));
	$_table->setColContent(0, 1, we_htmlElement::htmlImg(array("src" => IMAGE_DIR . "alert.gif")));
	$_table->setColContent(0, 2, getPixel( 16, 2));
	$_table->setCol(0, 3, array("class" => "defaultfont"), $l_workflow["doc_in_wf_warning"]);
	
	$_body = we_htmlElement::htmlBody(	array(	"bgcolor"      => "white",
												"background"   => EDIT_IMAGE_DIR . "editfooterback.gif",
												"marginwidth"  => 0,
												"marginheight" => 8,
												"leftmargin"   => 0,
												"topmargin"    => 8),
										$_table->getHtmlCode());

	print $_body;
	
	}
	
	$_jscode = "";
	
	print we_htmlElement::jsElement($_jscode);
?>
</html>