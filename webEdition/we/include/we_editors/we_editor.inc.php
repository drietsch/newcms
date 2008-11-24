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

$we_EDITOR = true;
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/SEEM/"."we_SEEM.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");

protect();
// prevent persmissions overriding
$perms=$_SESSION["perms"];
// init document


$we_dt = isset($_SESSION["we_data"][$we_transaction]) ? $_SESSION["we_data"][$we_transaction] : "";

include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_editors/we_init_doc.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");
$_insertReloadFooter = "";

switch($_REQUEST["we_cmd"][0]) {
	case "load_editor":
		// set default tab for creating new imageDocuments to "metadata":
		if($we_doc->ContentType == "image/*" && $we_doc->ID == "0") {
			$_SESSION["EditPageNr"] = WE_EDITPAGE_CONTENT;
			$we_doc->EditPageNr = WE_EDITPAGE_CONTENT;
			$_REQUEST["we_cmd"][1] = WE_EDITPAGE_CONTENT;
		}
		break;
	case "resizeImage":
		$we_doc->resizeImage($_REQUEST["we_cmd"][1], $_REQUEST["we_cmd"][2], $_REQUEST["we_cmd"][3]);
		break;
	case "rotateImage":
		$we_doc->rotateImage($_REQUEST["we_cmd"][1], $_REQUEST["we_cmd"][2], $_REQUEST["we_cmd"][3], $_REQUEST["we_cmd"][4]);
		break;
	case "del_thumb":
		$we_doc->del_thumbnails($_REQUEST["we_cmd"][1]);
		break;
	case "do_add_thumbnails":
		$we_doc->add_thumbnails($_REQUEST["we_cmd"][1]);
		break;
	case "copyDocument":
		$we_doc->copyDoc($_REQUEST["we_cmd"][1]);
		$we_doc->InWebEdition=1;
		break;
	case "new_alias":
		$we_doc->newAlias();
		break;
	case "delete_alias":
		$we_doc->deleteAlias($_REQUEST["we_cmd"][1]);
		break;
	case "delete_list":
		$we_doc->removeEntryFromList($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],$_REQUEST["we_cmd"][3],$_REQUEST["we_cmd"][4]);
		break;
	case "insert_entry_at_list":
		$we_doc->insertEntryAtList($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],isset($_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : 1);
		break;
	case "up_entry_at_list":
		$we_doc->upEntryAtList($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "down_entry_at_list":
		$we_doc->downEntryAtList($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "up_link_at_list":
		$we_doc->upEntryAtLinklist($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "down_link_at_list":
		$we_doc->downEntryAtLinklist($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "add_entry_to_list":
		$we_doc->addEntryToList($_REQUEST["we_cmd"][1],isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : 1);
		break;
	case "add_link_to_linklist":
		$GLOBALS["we_list_inserted"]=$_REQUEST["we_cmd"][1];
		$we_doc->addLinkToLinklist($_REQUEST["we_cmd"][1]);
		break;
	case "delete_linklist":
		$we_doc->removeLinkFromLinklist($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],$_REQUEST["we_cmd"][3]);
		break;
	case "insert_link_at_linklist":
		$GLOBALS["we_list_insertedNr"]=$_REQUEST["we_cmd"][2];
		$GLOBALS["we_list_inserted"]=$_REQUEST["we_cmd"][1];
		$we_doc->insertLinkAtLinklist($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "change_linklist":
		$we_doc->changeLinklist($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "change_link":
		$we_doc->changeLink($_REQUEST["we_cmd"][1]);
		break;
	case "doctype_changed":
		$we_doc->changeDoctype("", true);
		$_insertReloadFooter = "<script language=\"JavaScript\">try{parent.editFooter.location.reload();parent.editHeader.location.reload();}catch(exception){};</script>";
		break;
    case "template_changed":
        $we_doc->changeTemplate();
        $_insertReloadFooter = "<script language=\"JavaScript\">try{parent.editFooter.location.reload();parent.editHeader.location.reload();}catch(exception){};</script>";
        break;
	case "remove_image":
		$we_doc->remove_image($_REQUEST["we_cmd"][1]);
		break;
	case "wrap_on_off":
		$_SESSION["we_wrapcheck"] = ($_REQUEST["we_cmd"][1] == "true") ? 1 : 0;
		$we_doc->EditPageNr = WE_EDITPAGE_CONTENT;
		$_SESSION["EditPageNr"] = WE_EDITPAGE_CONTENT;
		break;
	case "add_owner":
		$we_doc->add_owner($_REQUEST["we_cmd"][1]);
		break;
	case "del_owner":
		$we_doc->del_owner($_REQUEST["we_cmd"][1]);
		break;
	case "add_user":
		$we_doc->add_user($_REQUEST["we_cmd"][1]);
		break;
	case "del_user":
		$we_doc->del_user($_REQUEST["we_cmd"][1]);
		break;
	case "del_all_owners":
		$we_doc->del_all_owners();
		break;

	case "applyWeDocumentCustomerFilterFromFolder":
		$we_doc->applyWeDocumentCustomerFilterFromFolder();
		break;

	case "restore_defaults":
		$we_doc->restoreDefaults();
		break;

	case "add_workspace":
		$we_doc->add_workspace($_REQUEST["we_cmd"][1]);
		break;
	case "del_workspace":
		$we_doc->del_workspace($_REQUEST["we_cmd"][1]);
		break;
	case "add_extraworkspace":
		$we_doc->add_extraWorkspace($_REQUEST["we_cmd"][1]);
		break;
	case "del_extraworkspace":
		$we_doc->del_extraWorkspace($_REQUEST["we_cmd"][1]);
		break;
	case "ws_from_class":
		$we_doc->ws_from_class();
		break;
	case "switch_edit_page":
		$_SESSION["EditPageNr"] = $_REQUEST["we_cmd"][1];
		$we_doc->EditPageNr = $_REQUEST["we_cmd"][1];
		if($_SESSION["we_mode"] == "seem"){
			$_insertReloadFooter =	"<script language=\"javascript\">\n<!--\ntry{parent.editFooter.location.reload();}catch(exception){};\n//-->\n</script>" .  SCRIPT_BUTTONS_ONLY . STYLESHEET_BUTTONS_ONLY;
		}
		break;
	case "delete_link":
		if(isset($we_doc->elements[$_REQUEST["we_cmd"][1]])) unset($we_doc->elements[$_REQUEST["we_cmd"][1]]);
		break;
	case "add_cat":
		$we_doc->addCat($_REQUEST["we_cmd"][1]);
		break;
	case "delete_cat":
		$we_doc->delCat($_REQUEST["we_cmd"][1]);
		break;
	case "changeTempl_ob":
		$we_doc->changeTempl_ob($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "delete_all_cats":
		$we_doc->Category = "";
		break;
	case "add_schedule":
		$we_doc->add_schedule();
		break;
	case "del_schedule":
		$we_doc->del_schedule($_REQUEST["we_cmd"][1]);
		break;
	case "delete_schedcat":
		$we_doc->delete_schedcat($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "delete_all_schedcats":
		$we_doc->schedArr[$_REQUEST["we_cmd"][1]]["CategoryIDs"] = "";
		break;
	case "add_schedcat":
		$we_doc->add_schedcat($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2]);
		break;
	case "doImage_convertGIF":
		$we_doc->convert("gif");
		break;
	case "doImage_convertPNG":
		$we_doc->convert("png");
		break;
	case "doImage_convertJPEG":
		$we_doc->convert("jpg",$_REQUEST["we_cmd"][1]);
		break;
	case "doImage_crop":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/PEAR.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/Transform.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/Transform/Driver/GD.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");

		$filename = TMP_DIR . '/'. weFile::getUniqueId();

		copy($we_doc->getElement("data"), $filename);


		//$filename = weFile::saveTemp($we_doc->getElement("data"));

		$x = $_REQUEST["we_cmd"][1];
		$y = $_REQUEST["we_cmd"][2];
		$width = $_REQUEST["we_cmd"][3];
		$height = $_REQUEST["we_cmd"][4];

		$img = Image_Transform::factory('GD');
		if (PEAR::isError($stat = $img->load($filename))) {
			trigger_error($stat->getMessage().' Filename: '.$filename);
		}
		if (PEAR::isError($stat = $img->crop($width, $height, $x, $y))) {
			trigger_error($stat->getMessage().' Filename: '.$filename);
		}
		if (PEAR::isError($stat = $img->save($filename))) {
			trigger_error($stat->getMessage().' Filename: '.$filename);
		}

		$we_doc->setElement("data", $filename);
		$we_doc->setElement("width", $width, "attrib");
		$we_doc->setElement("origwidth", $width, "attrib");
		$we_doc->setElement("height", $height,"attrib");
		$we_doc->setElement("origheight", $height, "attrib");
		$we_doc->DocChanged = true;
		break;
	case "add_css":
		$we_doc->add_css($_REQUEST["we_cmd"][1]);
		break;
	case "del_css":
		$we_doc->del_css($_REQUEST["we_cmd"][1]);
		break;
	case "add_navi":
		$we_doc->addNavi($_REQUEST["we_cmd"][1],$_REQUEST["we_cmd"][2],$_REQUEST["we_cmd"][3],$_REQUEST["we_cmd"][4]);
		break;
	case "delete_navi":
		$we_doc->delNavi($_REQUEST["we_cmd"][1]);
		break;
	case "delete_all_navi":
		$we_doc->delAllNavi();
		break;
	case "revert_published":
		$we_doc->revert_published();
		break;

}

//	if document is locked - only Preview mode is possible. otherwise show warning.
$_userID = $we_doc->isLockedByUser();
if( $_userID != 0 && $_userID != $_SESSION["user"]["ID"] && $we_doc->ID){	// document is locked

	if(in_array(WE_EDITPAGE_PREVIEW,$we_doc->EditPageNrs) ){
		$we_doc->EditPageNr = WE_EDITPAGE_PREVIEW;
		$_SESSION["EditPageNr"] = WE_EDITPAGE_PREVIEW;
	} else {

		include_once(WE_USERS_MODULE_DIR . "we_users_lockmessage.inc.php");
		exit;
	}
} else {	// lock document, if in seeMode and EditMode !!, don't lock when already locked
	if($_userID != $_SESSION["user"]["ID"] && $_SESSION["we_mode"] == "seem" && $we_doc->EditPageNr != WE_EDITPAGE_PREVIEW){
		$we_doc->lockDocument();
	}
}


/*
 * if the document is a webEdition document, we save it with a temp-name (path of document+extension) and redirect
 * to the tmp-location. This is done for the content- and preview-editpage.
 * With html-documents this is only done for preview-editpage.
 * We need to do this, because, when the pages has for example jsp. content, it will be parsed right!
 * This is only done when the IsDynamic - PersistantSlot is false.
 */
if((($_REQUEST["we_cmd"][0] != "save_document" && $_REQUEST["we_cmd"][0] != "publish" && $_REQUEST["we_cmd"][0] != "unpublish") && (($we_doc->ContentType=="text/webedition") && ($we_doc->EditPageNr == WE_EDITPAGE_PREVIEW || $we_doc->EditPageNr == WE_EDITPAGE_CONTENT )) || ($we_doc->ContentType=="text/html" && $we_doc->EditPageNr == WE_EDITPAGE_PREVIEW && $_REQUEST["we_cmd"][0] != "save_document")) && (!$we_doc->IsDynamic)) {

	$we_include = $we_doc->editor();
	$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
    ob_start();
    if(substr(strtolower($we_include),0,strlen($_SERVER["DOCUMENT_ROOT"])) == strtolower($_SERVER["DOCUMENT_ROOT"])) {
    	include($we_include);
    }else{
     	include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/".$we_include);
    }
    $contents = ob_get_contents();
    ob_end_clean();
	//  SEEM the file
	//  but only, if we are not in the template-editor
	if ($we_doc->ContentType != "text/weTmpl") {
        $contents = we_SEEM::parseDocument($contents);

        if (strpos($contents, '</head>')) {
        	$contents = str_replace('</head>', $_insertReloadFooter . '</head>', $contents);
        } else {
        	$contents = $_insertReloadFooter . $contents;
        }
	}
/*
	$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
*/
	$we_ext = ($we_doc->Extension == ".js" || $we_doc->Extension == ".css" || $we_doc->Extension == ".wml" || $we_doc->Extension == ".xml") ? ".html" : $we_doc->Extension;
	$tempName = dirname($we_doc->getSitePath())."/".session_id().$we_ext;
	$tempName = str_replace("\\","/",$tempName);
	insertIntoCleanUp($tempName,time());
/*
	$str = session_encode(); //serialize($arr);
	$fp = fopen(TMP_DIR."/$we_transaction.tmp","wb");
	fwrite($fp,$str);
	fclose($fp);
*/
	$cf = array();

	$parent = dirname($tempName);
	$parent = str_replace("\\","/",$parent);

	while(!checkAndMakeFolder($parent)) {
		array_push($cf,$parent);
		$parent = dirname($parent);
		$parent = str_replace("\\","/",$parent);
	}

	// url of document !!
	srand ((double)microtime()*1000000);
	$r = rand();
	$_url = dirname($we_doc->getHttpSitePath());
	$_url = str_replace("\\","/",$_url);

	$contents = str_replace("<?xml",'<?php print "<?xml"; ?>',$contents);

	ob_start();
	eval("?>" . $contents);
    $contents = ob_get_contents();
    ob_end_clean();

		//
	// --> Glossary Replacement
	//
	
	if(defined("GLOSSARY_TABLE") && ((isset($GLOBALS["we_editmode"]) && !$GLOBALS["we_editmode"]) || !isset($GLOBALS["we_editmode"]))) {
		if(isset($we_doc->InGlossar) && $we_doc->InGlossar==0) {
			include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryCache.php");
			include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryReplace.php");
			$contents = weGlossaryReplace::replace($contents, $we_doc->Language);
		}
	}


	saveFile($tempName,$contents);

    //  we need to add the parameters at the urls
    //  we_cmds are deleted.
    //  in which case??
    //	parastr isn't greater than 255 letters.
    $parastr = we_SEEM::arrayToParameters($_REQUEST, "", array("we_cmd") );

    // When the url is too long, this will not work anymore - therefore we cut the string.
    // we don't need this anymore? check seeMode
//    $_url = $_url . "/" . session_id() . $we_ext . "?r=" . $r . $parastr;
//    $_url = strlen($_url) > 255 ? substr($_url,0,240) : $_url;

	header("Location: " . $_url . "/" . session_id() . $we_ext . "?r=" . $r);
}
else {
	$we_JavaScript="";
	switch($_REQUEST["we_cmd"][0]) {
		case "save_document":
			if($we_doc->ContentType) {
				$saveTemplate = true;
				if (strpos($we_doc->ParentPath,"..")!==false || $we_doc->ParentPath{0} != "/") {
					$we_responseText = sprintf($GLOBALS["l_we_class"]["notValidFolder"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_filenameEmpty()) {
					$we_responseText = $l_we_editor[$we_doc->ContentType]["filename_empty"];
					$we_responseTextType = WE_MESSAGE_ERROR;
					$saveTemplate = false;
				} else if(!$we_doc->i_canSaveDirinDir()) {
					$we_responseText = $l_we_editor["pfolder_notsave"];
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_sameAsParent()) {
					$we_responseText = $l_we_editor["folder_save_nok_parent_same"];
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_fileExtensionNotValid()) {
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["we_filename_notValid"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_filenameNotValid()) {
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["we_filename_notValid"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_descriptionMissing()) {
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["we_description_missing"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_filenameNotAllowed()) {
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["we_filename_notAllowed"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_filenameDouble()) {
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_path_exists"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if(!$we_doc->i_checkPathDiffAndCreate()) {
					$we_responseText = sprintf($GLOBALS["l_we_class"]["notValidFolder"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($n = $we_doc->i_check_requiredFields()) {
					$we_responseText = sprintf($l_we_editor["required_field_alert"],$n);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($we_doc->i_scheduleToBeforeNow()) {
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/modules/schedule.inc.php");
					$we_responseText = $l_schedule["toBeforeNow"];
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if($n = $we_doc->i_hasDoubbleFieldNames()) {
					$we_responseText = sprintf($l_we_editor["doubble_field_alert"],$n);
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else if(!$we_doc->i_areVariantNamesValid()) {
					$we_responseText = $l_we_editor["variantNameInvalid"];
					$we_responseTextType = WE_MESSAGE_ERROR;
				} else {
					$we_JavaScript = "_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n"; // save/ rename a document
					if($we_doc->ContentType=="text/weTmpl") {
						if(isset($_REQUEST["we_cmd"][8]) && $_REQUEST["we_cmd"][8]) {
							// if  we_cmd[8] is set, it means that "automatic rebuild" was clicked
							// so we need to check we_cmd[3] (means save immediately) and we_cmd[4] (means rebuild immediately)
							$_REQUEST["we_cmd"][3] = 1;
							$_REQUEST["we_cmd"][4] = 1;
						}
####TEMPLATE_SAVE_CODE2_START###
						$TEMPLATE_SAVE_CODE2 = true;
						$arr = getTemplAndDocIDsOfTemplate($we_doc->ID, true, true);
						$nrDocsUsedByThisTemplate = count($arr["documentIDs"]);
						$nrTemplatesUsedByThisTemplate = count($arr["templateIDs"]);
						$somethingNeedsToBeResaved = ($nrDocsUsedByThisTemplate+$nrTemplatesUsedByThisTemplate) > 0;

						if($_REQUEST["we_cmd"][2]) {
							//this is the second call to save_document (see next else command)
							include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_template_save_question.inc.php"); // this includes the gui for the save question dialog
							$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
							exit();
						} else if(!$_REQUEST["we_cmd"][3] && $somethingNeedsToBeResaved) {
							// this happens when the template is saved and there are documents which use the template and "automatic rebuild" is not checked!
							include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_TemplateSave.inc.php"); // this calls again we_cmd with save_document and sets we_cmd[2]
							$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
							exit();
						} else {
							//this happens when we_cmd[3] is set and not we_cmd[2]
							if($we_doc->we_save()) {
								$wasSaved = true;
								$wasNew = (abs($we_doc->ID) == 0) ? true : false;
								$we_JavaScript .= "_EditorFrame.getDocumentReference().frames[0].we_setPath('".$we_doc->Path."', '" . $we_doc->Text . "');\n";
								$we_JavaScript .= "_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n".$we_doc->getUpdateTreeScript().";\n";// save/ rename a document
								$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_save_ok"],$we_doc->Path);
								$we_responseTextType = WE_MESSAGE_NOTICE;
								if($_REQUEST["we_cmd"][4]) {
									// this happens when the documents which uses the templates has to be rebuilt. (if user clicks "yes" at template save question or if automatic rebuild was set)
									if($somethingNeedsToBeResaved) {
										$we_JavaScript .= '_EditorFrame.setEditorIsHot(false);top.toggleBusy(0);top.openWindow(\''.WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=rebuild&step=2&btype=rebuild_filter&templateID='.$we_doc->ID.'&responseText='.rawurlencode(sprintf($we_responseText,$we_doc->Path)).'\',\'resave\',-1,-1,600,130,0,true);';
										$we_responseText = '';
									}
								}
							} else {
								// we got an error while saving the template
								$we_JavaScript = "";
								$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_save_notok"],$we_doc->Path);
								$we_responseTextType = WE_MESSAGE_ERROR;
							}
						}
####TEMPLATE_SAVE_CODE2_END###
						if(!isset($TEMPLATE_SAVE_CODE2) || !$TEMPLATE_SAVE_CODE2) {
							$we_responseText = $l_we_editor["text/weTmpl"]["no_template_save"];
							$we_responseTextType = WE_MESSAGE_ERROR;
							include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_editor_save.inc.php");exit();
						}
						if(isset($_REQUEST["we_cmd"][6]) && $_REQUEST["we_cmd"][6]) {
							$we_JavaScript .= "\n".$_REQUEST["we_cmd"][6]."\n";
						}
					} else {
 						include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");
						if((!we_hasPerm('NEW_SONSTIGE')) && $we_doc->ContentType=="application/*" && in_array($we_doc->Extension, makeArrayFromCSV($GLOBALS["WE_CONTENT_TYPES"]["text/html"]["Extension"]))) {
								$we_JavaScript = "";
								$we_responseText = sprintf($l_we_editor["application/*"]["response_save_wrongExtension"],$we_doc->Path,$we_doc->Extension);
								$we_responseTextType = WE_MESSAGE_ERROR;
						} else {

							$wf_flag = false;
							$wasNew = (abs($we_doc->ID) == 0) ? true : false;
							$wasPubl = (isset($we_doc->Published) && $we_doc->Published) ? true : false;
							if (!$_SESSION["perms"]["ADMINISTRATOR"] && $we_doc->ContentType != "object" && $we_doc->ContentType != "objectFile"  && !in_workspace($we_doc->ParentID,get_ws($we_doc->Table),$we_doc->Table)) {
								$we_responseText = $l_alert[FILE_TABLE]["not_im_ws"];
								$we_responseTextType = WE_MESSAGE_ERROR;
								include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_editor_save.inc.php");
								exit();
							}
							if(!$we_doc->userCanSave()) {
								$we_responseText = $l_alert["access_denied"];
								$we_responseTextType = WE_MESSAGE_ERROR;
								include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_editor_save.inc.php");
								exit();
							}


							if($we_doc->we_save()) {
								$wasSaved = true;
								if($we_doc->ContentType == "object") {
									$we_JavaScript .= "top.header.document.location.reload();\nif(top.treeData.table=='".OBJECT_FILES_TABLE."'){top.we_cmd('load', 'tblObjectFiles', 0);}\n";
								}
								$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_save_ok"],$we_doc->Path);
								$we_responseTextType = WE_MESSAGE_NOTICE;

								if($_REQUEST["we_cmd"][5]) {
									$_REQUEST["we_cmd"][5] = "";
									if($we_doc->i_publInScheduleTable()) {
											$foo = $we_doc->getNextPublishDate();
										if($foo) {
											$we_responseText .= "\\n".sprintf($l_we_editor[$we_doc->ContentType]["autoschedule"],date($l_global["date_format"],$foo));
											$we_responseTextType = WE_MESSAGE_NOTICE;

										}
									}
									else {
										if($we_doc->we_publish()) {
											if(defined("WORKFLOW_TABLE")) {
												include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/"."weWorkflowUtility.php");
												if(weWorkflowUtility::inWorkflow($we_doc->ID,$we_doc->Table)){
													weWorkflowUtility::removeDocFromWorkflow($we_doc->ID,$we_doc->Table,$_SESSION["user"]["ID"],"");
												}
											}
											$we_responseText .= "\\n".sprintf($l_we_editor[$we_doc->ContentType]["response_publish_ok"],$we_doc->Path);
											$we_responseTextType = WE_MESSAGE_NOTICE;
											// SEEM, here a doc is published
											$GLOBALS["publish_doc"] = true;
											if( $_SESSION["we_mode"] != "seem" && ($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES || $we_doc->EditPageNr == WE_EDITPAGE_INFO || $we_doc->EditPageNr == WE_EDITPAGE_PREVIEW)  && (!$_REQUEST["we_cmd"][4])) {
												$_REQUEST["we_cmd"][5] = '
													top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");
													_EditorFrame.getDocumentReference().frames[3].location.reload();'; // reload the footer with the buttons
											}
										}
										else {
											$we_responseText .= "\\n".sprintf($l_we_editor[$we_doc->ContentType]["response_publish_notok"],$we_doc->Path);
											$we_responseTextType = WE_MESSAGE_ERROR;
										}
									}
								}
								else {
									if(($we_doc->EditPageNr == WE_EDITPAGE_INFO && (!$_REQUEST["we_cmd"][4])) || (isset($_REQUEST["we_cmd"][7]) && $_REQUEST["we_cmd"][7])) {
										$we_responseText = (isset($_REQUEST["we_cmd"][7]) && $_REQUEST["we_cmd"][7]) ? "" : $we_responseText;
										$we_responseTextType = (isset($_REQUEST["we_cmd"][7]) && $_REQUEST["we_cmd"][7]) ? WE_MESSAGE_ERROR : $we_responseTextType;
										$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");';
										if((isset($_REQUEST["we_cmd"][7]) && $_REQUEST["we_cmd"][7] == 1)) {
											$we_JavaScript .= 'top.we_cmd("in_workflow","'.$we_transaction.'","'.$_REQUEST["we_cmd"][4].'");'."\n";
											$wf_flag = true;
										}
										else if((isset($_REQUEST["we_cmd"][7]) && $_REQUEST["we_cmd"][7] == 2)) {
											$we_JavaScript .= 'top.we_cmd("pass","'.$we_transaction.'");'."\n";
											$wf_flag = true;
										}
										else if((isset($_REQUEST["we_cmd"][7]) && $_REQUEST["we_cmd"][7] == 3)) {
											$we_JavaScript .= 'top.we_cmd("decline","'.$we_transaction.'");'."\n";
											$wf_flag = true;
										}
									}
									// Bug Fix #2065 -> Reload Preview Page of other documents
									elseif($we_doc->EditPageNr == WE_EDITPAGE_PREVIEW && $we_doc->ContentType == "application/*") {
											$we_JavaScript .= 'top.we_cmd("switch_edit_page","' . $we_doc->EditPageNr . '","'.$we_transaction.'");';
									}
								}

								$we_JavaScript .= "\n".$we_doc->getUpdateTreeScript(!$_REQUEST["we_cmd"][4])."\n";

								if($wasNew || (!$wasPubl)) {
									if($we_doc->ContentType == "folder"){
										$we_JavaScript .= 'top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");'."\n;";
									}
									$we_JavaScript .= "_EditorFrame.getDocumentReference().frames[3].location.reload();\n";
								}
								$we_JavaScript .= "_EditorFrame.getDocumentReference().frames[0].we_setPath('".$we_doc->Path."','" . $we_doc->Text . "');\n";


								if(!defined("SCHEDULE_TABLE")){
									$we_JavaScript .= "_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n";
								}

								if (($we_doc->ContentType=="text/webedition" || $we_doc->ContentType == 'objectFile') && $we_doc->canHaveVariants(true)) {
									include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_modules/shop/weShopVariants.inc.php');
									weShopVariants::setVariantDataForModel($we_doc, true);
								}
							}
							else {
								$we_JavaScript = "";
								$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_save_notok"],$we_doc->Path);
								$we_responseTextType = WE_MESSAGE_ERROR;
							}
						}
						if($_REQUEST["we_cmd"][6]) {
							$we_JavaScript .= "\n".$_REQUEST["we_cmd"][6]."\n";
						}
						else if($_REQUEST["we_cmd"][4] && (!$wf_flag)) {

							$we_doc->makeSameNew();
							if (isset($we_doc->NavigationItems)) $we_doc->NavigationItems = "";
							$we_JavaScript .= "_EditorFrame.getDocumentReference().frames[0].we_setPath('".$we_doc->Path."','" . $we_doc->Text . "');\n";
							//	switch to propertiy page, when user is allowed to do so.
							if($_SESSION["we_mode"] == "seem"){

								$_showAlert = true;	//	don't show confirm box in editor_save.inc
								if (we_hasPerm('CAN_SEE_PROPERTIES')) {
									$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page","' . WE_EDITPAGE_PROPERTIES . '","'.$we_transaction.'");';
								} else {
									$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page","' . $we_doc->EditPageNr . '","'.$we_transaction.'");';
								}

							} else if ($_SESSION["we_mode"] == "normal"){

								$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page","' . $we_doc->EditPageNr . '","'.$we_transaction.'");';
							}
						}
					}

					if ( $wasNew ) { // add to history
						$we_JavaScript .= "top.weNavigationHistory.addDocToHistory('" . $we_doc->Table . "', " . $we_doc->ID . ", '" . $we_doc->ContentType . "');";

					}
				}
				$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session

				if(defined("SCHEDULE_TABLE")){
					trigger_schedule();
					$we_JavaScript .= "_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n";// save/ rename a document
				}
				include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_editor_save.inc.php");

			} else {
				exit(" ContentType Missing !!! ");
			}
			break;
		case "unpublish":
			if($we_doc->Published) {
				if($we_doc->we_unpublish()) {
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_unpublish_ok"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_NOTICE;
					if($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES || $we_doc->EditPageNr == WE_EDITPAGE_INFO) {
						$_REQUEST["we_cmd"][5] = 'top.we_cmd("switch_edit_page","'.$we_doc->EditPageNr.'","'.$we_transaction.'");'; // wird in Templ eingef?gt
					}
					if(!isset($_REQUEST["we_cmd"][5])){
					    $_REQUEST["we_cmd"][5] = "";
					}
					//	When unpublishing a document stay where u are.
					//	uncomment the following line to switch to preview page.
					$_REQUEST["we_cmd"][5] .= '_EditorFrame.getDocumentReference().frames[3].location.reload();';

					$we_JavaScript = "_EditorFrame.setEditorDocumentId(".$we_doc->ID.");\n".$we_doc->getUpdateTreeScript().";\n";// save/ rename a document
				}
				else {
					$we_JavaScript = "";
					$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_unpublish_notok"],$we_doc->Path);
					$we_responseTextType = WE_MESSAGE_ERROR;
				}
				$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
			}
			else {
				$we_JavaScript = "";
				$we_responseText = sprintf($l_we_editor[$we_doc->ContentType]["response_not_published"],$we_doc->Path);
				$we_responseTextType = WE_MESSAGE_ERROR;

			}
			include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_templates/we_editor_publish.inc.php");
			break;
		default:
			if($we_include = $we_doc->editor()) {  // object does not handle html-output, so we need to include a template( return value)
				$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
				if(isset($_SERVER["DOCUMENT_ROOT"]) && $_SERVER["DOCUMENT_ROOT"]!="" && substr(strtolower($we_include),0,strlen($_SERVER["DOCUMENT_ROOT"])) == strtolower($_SERVER["DOCUMENT_ROOT"])) {
					// check if the template uses the document cache
					// if is so, the output must be evaled
					if($we_doc->ContentType == "text/weTmpl") {
						$cacheType = $we_doc->CacheType;
						$cacheLifeTime = $we_doc->CacheLifeTime;
					} else {
						$cacheType = f("SELECT CacheType FROM ".TEMPLATES_TABLE." WHERE ID='".abs($we_doc->TemplateID)."'","CacheType",$GLOBALS["DB_WE"]);
						$cacheLifeTime = f("SELECT CacheLifeTime FROM ".TEMPLATES_TABLE." WHERE ID='".abs($we_doc->TemplateID)."'","CacheLifeTime",$GLOBALS["DB_WE"]);
					}
					define("CACHING_INSIDE_WEBEDITION", true);

                    ob_start();
					if((!defined("WE_CONTENT_TYPE_SET")) && isset($we_doc->elements["Charset"]["dat"]) && $we_doc->elements["Charset"]["dat"]){	//	send charset which might be determined in template
						define("WE_CONTENT_TYPE_SET",1);
						header("Content-Type: text/html; charset=" . $we_doc->elements["Charset"]["dat"]);
					}
                    include($we_include);
                    $contents = ob_get_contents();
                    ob_end_clean();

                    // if document cache we must eval the template code, because there is some
                    // PHP-Code inside which first is printed out and now have to be executed
                    if($cacheType == "document" && $cacheLifeTime > 0) {
                    	$GLOBALS['weCacheOutput'] = true;
                    	ob_start();
                    	$contents = str_replace("<?xml",'<?php print "<?xml"; ?>',$contents);
                    	eval("?>".$contents);
                   		$contents = ob_get_contents();
                    	ob_end_clean();
                    	$GLOBALS['weCacheOutput'] = false;
                    }
                    weCacheHelper::clearCache(weCacheHelper::getCacheDir());

				    //  SEEM the file
				    //  but only, if we are not in the template-editor
				    if($we_doc->ContentType != "text/weTmpl" || ($we_doc->ContentType == "text/weTmpl" && $we_doc->EditPageNr == WE_EDITPAGE_PREVIEW_TEMPLATE)){
				    	$tmpCntnt = we_SEEM::parseDocument($contents);

				    	// insert $_reloadFooter at right place
				    	if (strpos($tmpCntnt, '</head>')) {
				        	$tmpCntnt = str_replace('</head>', $_insertReloadFooter . '</head>', $tmpCntnt);
				        } else {
				        	$tmpCntnt = $_insertReloadFooter . $tmpCntnt;
				        }

    			    	//
						// --> Start Glossary Replacement
						//
						
						if(defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])  && !$GLOBALS["we_editmode"]) {
							if(isset($we_doc->InGlossar) && $we_doc->InGlossar==0) {
								include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryCache.php");
								include_once(WE_GLOSSARY_MODULE_DIR."weGlossaryReplace.php");
	
								weGlossaryReplace::start();
							}

						}

						//
						// --> Print Cntents
						//

						print $tmpCntnt;

						//
						// --> Finish Glossary Replacement
						//

						if(defined("GLOSSARY_TABLE") && (!isset($GLOBALS["WE_MAIN_DOC"]) || $GLOBALS["WE_MAIN_DOC"] == $GLOBALS["we_doc"])  && !$GLOBALS["we_editmode"]) {
							if(isset($we_doc->InGlossar) && $we_doc->InGlossar==0) {
								weGlossaryReplace::end($GLOBALS["we_doc"]->Language);
							}

						}

    			    } else {
    			        print $contents;

    			    }

				} else {
				    //  These files were edited only in source-code mode, so no seeMode is needed.
					include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/".$we_include);
					print $_insertReloadFooter;

				}
				$we_doc->saveInSession($_SESSION["we_data"][$we_transaction]); // save the changed object in session
				if(isset($we_file_to_delete_after_include)){
                    deleteLocalFile($we_file_to_delete_after_include);
				}
                if($we_doc->EditPageNr == WE_EDITPAGE_PROPERTIES || $we_doc->EditPageNr == WE_EDITPAGE_SCHEDULER || $we_doc->EditPageNr == WE_EDITPAGE_THUMBNAILS) {
                    print '<script language="JavaScript" type="text/javascript">setTimeout("doScrollTo();",100);</script>';
                }
			}
			else {
				exit("Nothing to include ...");
			}
	}
}

// prevent persmissions overriding
$_SESSION["perms"]=$perms;
?>
