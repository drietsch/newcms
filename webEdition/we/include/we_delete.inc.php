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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_html_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_live_tools.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/" . "we_delete_fn.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/newfile.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_history.class.php");

protect();

$table = $_REQUEST["we_cmd"][2];
$wfchk = defined("WORKFLOW_TABLE") && ($table == FILE_TABLE || (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE)) ? (isset(
		$_REQUEST["we_cmd"][3]) ? $_REQUEST["we_cmd"][3] : 0) : 1;
$wfchk_html = "";
$script = "";

/*
if($table==TEMPLATES_TABLE){
	if(!we_hasPerm("DELETE_TEMPLATE")){
		include_once(WE_USERS_MODULE_DIR . "we_users_permmessage.inc.php");
		exit();

	}
}
*/
if (!$wfchk) {
	
	if (isset($_REQUEST["sel"])) {
		$found = false;
		include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/workflow/weWorkflowUtility.php");
		$selectedItems = explode(",", $_REQUEST["sel"]);
		for ($i = 0; $i < sizeof($selectedItems); $i++) {
			if (weWorkflowUtility::inWorkflow($selectedItems[$i], $table)) {
				$found = true;
				break;
			}
		}
		$wfchk_html .= '<script language="JavaScript" type="text/javascript">
                     function confirmDel(){' . "\n";
		if ($found)
			$wfchk_html .= 'if(confirm("' . $l_alert["found_in_workflow"] . '"))' . "\n";
		$wfchk_html .= 'we_cmd("' . $_REQUEST["we_cmd"][0] . '","","' . $table . '",1);' . "\n";
		if ($found)
			$wfchk_html .= 'else top.toggleBusy(0)';
		$wfchk_html .= '}</script>';
	
	} else {
		$script = "top.toggleBusy(0);\n" . we_message_reporting::getShowMessageCall(
				$l_alert["nothing_to_delete"], 
				WE_MESSAGE_WARNING);
	}
	$wfchk_html .= '</head><body onload="confirmDel()"><form name="we_form" method="post">' . "\n";
	$wfchk_html .= hidden("sel", isset($_REQUEST["sel"]) ? $_REQUEST["sel"] : "") . "</form>" . "\n";

} else 
	if ($_REQUEST["we_cmd"][0] == "do_delete" || $_REQUEST["we_cmd"][0] == "delete_single_document") {
		if (isset($_REQUEST["sel"]) && $_REQUEST["sel"]) {
			//	look which documents must be deleted.
			$selectedItems = explode(",", $_REQUEST["sel"]);
			$retVal = 1;
			$idInfos = array(
				'IsFolder' => 0, 'Path' => '', 'hasFiles' => 0
			);
			if (sizeof($selectedItems) > 0 && ($table == FILE_TABLE || $table == TEMPLATES_TABLE)) {
				$idInfos = getHash("SELECT IsFolder, Path FROM $table WHERE ID=" . $selectedItems[0], $DB_WE);
				if ($idInfos['IsFolder']) {
					$idInfos['hasFiles'] = f(
							"SELECT ID FROM $table WHERE ParentID=" . $selectedItems[0] . " AND  IsFolder = 0 AND Path LIKE '" . $idInfos['Path'] . "%'", 
							"ID", 
							$DB_WE) > 0 ? 1 : 0;
				}
			}
			
			$hasPerm = 0;
			if (we_hasPerm("ADMINISTRATOR")) {
				$hasPerm = 1;
			} else 
				if ($idInfos['IsFolder']) {
					if ($table == FILE_TABLE && we_hasPerm("DELETE_DOC_FOLDER") && (!$idInfos['hasFiles'] || we_hasPerm(
							"DELETE_DOCUMENT"))) {
						$hasPerm = 1;
					} else 
						if ($table == TEMPLATES_TABLE && we_hasPerm("DELETE_TEMP_FOLDER") && (!$idInfos['hasFiles'] || we_hasPerm(
								"DELETE_TEMPLATE"))) {
							$hasPerm = 1;
						} else 
							if ($table == OBJECT_FILES_TABLE && we_hasPerm("DELETE_OBJECTFILE")) {
								$hasPerm = 1;
							} else {
								$hasPerm = 0;
							}
				} else {
					if ($table == FILE_TABLE && we_hasPerm("DELETE_DOCUMENT")) {
						$hasPerm = 1;
					} else 
						if ($table == TEMPLATES_TABLE && we_hasPerm("DELETE_TEMPLATE")) {
							$hasPerm = 1;
						} else 
							if ($table == OBJECT_FILES_TABLE && we_hasPerm("DELETE_OBJECTFILE")) {
								$hasPerm = 1;
							} else 
								if ($table == OBJECT_TABLE && we_hasPerm("DELETE_OBJECT")) {
									$hasPerm = 1;
								} else {
									$hasPerm = 0;
								}
				}
			
			unset($idInfos);
			
			if (!$hasPerm) {
				$retVal = -6;
			} else 
				if ((!we_hasPerm("ADMINISTRATOR")) && ($table == FILE_TABLE . "_cache" || $table == OBJECT_FILES_TABLE . "_cache")) { //check if mey delete cache
					$retVal = -1;
				} else {
					
					for ($i = 0; $i < sizeof($selectedItems); $i++) {
						if (!checkIfRestrictUserIsAllowed($selectedItems[$i], $table)) {
							$retVal = -1;
							break;
						}
						
						if (!checkDeleteEntry($selectedItems[$i], $table)) {
							$retVal = 0;
							break;
						}
					}
				}
			
			if ($retVal == 1) { // only if no error occurs
				for ($i = 0; $i < sizeof($selectedItems); $i++) {
					
					if ($table == FILE_TABLE && defined('USER_TABLE')) {
						include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/users/we_users_util.php');
						$users = getUsersForDocWorkspace($selectedItems[$i]);
						if (count($users) > 0) {
							$retVal = -2;
							break;
						}
						
						// check if childrenfolders are workspaces
						$childs = array();
						
						pushChilds($childs, $selectedItems[$i], $table, true);
						$users = array();
						foreach ($childs as $ch) {
							$users = array_merge($users, getUsersForDocWorkspace($childs));
						}
						$users = array_unique($users);
						
						if (count($users)) {
							$retVal = -4;
							break;
						}
					}
					
					if ($table == TEMPLATES_TABLE && defined('USER_TABLE')) {
						include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/users/we_users_util.php');
						$users = getUsersForDocWorkspace($selectedItems[$i], "workSpaceTmp");
						if (count($users) > 0) {
							$retVal = -2;
							break;
						}
						
						// check if childrenfolders are workspaces
						$childs = array();
						
						pushChilds($childs, $selectedItems[$i], $table, true);
						$users = array();
						foreach ($childs as $ch) {
							$users = array_merge($users, getUsersForDocWorkspace($childs, "workSpaceTmp"));
						}
						$users = array_unique($users);
						
						if (count($users)) {
							$retVal = -4;
							break;
						}
					}
					
					if (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE && defined('USER_TABLE')) {
						include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/users/we_users_util.php');
						
						$users = getUsersForDocWorkspace($selectedItems[$i], "workSpaceObj");
						if (count($users) > 0) {
							$retVal = -2;
							break;
						}
						
						$childs = array();
						
						pushChilds($childs, $selectedItems[$i], $table, true);
						$users = getUsersForDocWorkspace($childs, "workSpaceObj");
						
						if (count($users)) {
							$retVal = -4;
							break;
						}
					}
					if (defined("OBJECT_FILES_TABLE") && $table == FILE_TABLE) {
						$objects = getObjectsForDocWorkspace($selectedItems[$i]);
						if (count($objects) > 0) {
							$retVal = -3;
							break;
						}
						
						$childs = array();
						
						pushChilds($childs, $selectedItems[$i], $table, true);
						$objects = getObjectsForDocWorkspace($childs);
						
						if (count($objects)) {
							$retVal = -5;
							break;
						}
					}
				
				}
			}
			
			if ($retVal == -6) {
				
				$script .= "top.toggleBusy(0);\n";
				$script .= we_message_reporting::getShowMessageCall($l_alert['no_perms_action'], WE_MESSAGE_ERROR);
			
			} else 
				if ($retVal == -5) { //	not allowed to delete workspace
					

					$script .= "top.toggleBusy(0);\n";
					$objList = "";
					foreach ($objects as $val) {
						$objList .= "- " . $val . "\\n";
					}
					$script .= we_message_reporting::getShowMessageCall(
							sprintf(
									$l_alert['delete_workspace_object_r'], 
									id_to_path($selectedItems[$i], $table), 
									$objList), 
							WE_MESSAGE_ERROR);
				
				} else 
					if ($retVal == -4) { //	not allowed to delete workspace
						$script .= "top.toggleBusy(0);\n";
						$usrList = "";
						foreach ($users as $val) {
							$usrList .= "- " . $val . "\\n";
						}
						$script .= we_message_reporting::getShowMessageCall(
								sprintf(
										$l_alert['delete_workspace_user_r'], 
										id_to_path($selectedItems[$i], $table), 
										$usrList), 
								WE_MESSAGE_ERROR);
					
					} else 
						if ($retVal == -3) { //	not allowed to delete workspace
							$script .= "top.toggleBusy(0);\n";
							$objList = "";
							foreach ($objects as $val) {
								$objList .= "- " . $val . "\\n";
							}
							$script .= we_message_reporting::getShowMessageCall(
									sprintf(
											$l_alert['delete_workspace_object'], 
											id_to_path($selectedItems[$i], $table), 
											$objList), 
									WE_MESSAGE_ERROR);
						
						} else 
							if ($retVal == -2) { //	not allowed to delete workspace
								$script .= "top.toggleBusy(0);\n";
								$usrList = "";
								foreach ($users as $val) {
									$usrList .= "- " . $val . "\\n";
								}
								$script .= we_message_reporting::getShowMessageCall(
										sprintf(
												$l_alert['delete_workspace_user'], 
												id_to_path($selectedItems[$i], $table), 
												$usrList), 
										WE_MESSAGE_ERROR);
							
							} else 
								if ($retVal == -1) { //	not allowed to delete document
									

									$script .= "top.toggleBusy(0);\n";
									$script .= we_message_reporting::getShowMessageCall(
											sprintf(
													$l_alert["noRightsToDelete"], 
													id_to_path($selectedItems[$i], $table)), 
											WE_MESSAGE_ERROR);
								
								} else 
									if ($retVal) { //	user may delete -> delete files !
										

										$GLOBALS["we_folder_not_del"] = array();
										
										if ($table == FILE_TABLE . "_cache" || (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE . "_cache")) {
											
											if ($table == FILE_TABLE . "_cache") {
												foreach ($selectedItems as $k => $v) {
													$cacheDir = weCacheHelper::getDocumentCacheDir($v);
													if (!weCacheHelper::clearCache($cacheDir)) {
													
													}
												}
											
											} elseif (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE . "_cache") {
												foreach ($selectedItems as $k => $v) {
													$cacheDir = weCacheHelper::getObjectCacheDir($v);
													if (!weCacheHelper::clearCache($cacheDir)) {
													
													}
												}
											
											}
										
										} else {
											
											$deletedItems = array();
											
											for ($i = 0; $i < sizeof($selectedItems); $i++) {
												deleteEntry($selectedItems[$i], $table);
											
											}
											
											if (defined("OBJECT_TABLE") && $table == OBJECT_TABLE) {
												$script .= "top.header.document.location.reload();\n";
											}
											
											if ($_SESSION["we_mode"] == "normal") { //	only update tree when in normal mode
												$script .= deleteTreeEntries(
														defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE);
											}
											
											if (sizeof($deletedItems)) {
												
												$class_condition = '';
												$deleted_objects = array();
												
												if (defined("OBJECT_TABLE") && $table == OBJECT_TABLE) { // close all open objects, if a class is deleted
													

													$_deletedItems = array();
													
													// if its deleted and not selected, it must be an object
													for ($i = 0; $i < sizeof(
															$deletedItems); $i++) {
														if (in_array($deletedItems[$i], $selectedItems)) {
															$_deletedItems[] = $deletedItems[$i];
														
														} else {
															$deleted_objects[] = $deletedItems[$i]; // deleted objects when classes are deleted
														}
													}
													$deletedItems = $_deletedItems;
													$class_condition = ' || (_usedEditors[frameId].getEditorEditorTable() == "' . OBJECT_FILES_TABLE . '" && (_delete_objects.indexOf( "," + _usedEditors[frameId].getEditorDocumentId() + "," ) != -1) ) ';
												
												}
												
												if (defined("CUSTOMER_TABLE")) { // delete the customerfilters
													require_once ($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_modules/customer/weDocumentCustomerFilter.class.php");
													weDocumentCustomerFilter::deleteModel(
															$deletedItems, 
															$table);
													if (defined("OBJECT_FILES_TABLE") && $table == OBJECT_TABLE) {
														if (sizeof($deleted_objects)) {
															weDocumentCustomerFilter::deleteModel(
																	$deleted_objects, 
																	OBJECT_FILES_TABLE);
														
														}
													}
												}
												
												// DELETE ENTRIES IN HISTORY. BE CAREFUL DURING MERGE 5.1 WITH CUSTOMERFILTERS!!!!!!!
												we_history::deleteFromHistory(
														$deletedItems, 
														$table);
												if (defined("OBJECT_FILES_TABLE") && $table == OBJECT_TABLE) {
													if (sizeof($deleted_objects)) {
														we_history::deleteFromHistory(
																$deleted_objects, 
																OBJECT_FILES_TABLE);
													
													}
												}
												
												$script .= '
						// close all Editors with deleted documents
						var _usedEditors =  top.weEditorFrameController.getEditorsInUse();

						// if a class is deleted, close all open objects of this class
						var _delete_table = "' . $table . '";
						var _delete_Ids = ",' . implode(",", $deletedItems) . ',";
						var _delete_objects = ",' . implode(",", $deleted_objects) . ',";

						for ( frameId in _usedEditors ) {

							if ( _delete_table == _usedEditors[frameId].getEditorEditorTable() && (_delete_Ids.indexOf( "," + _usedEditors[frameId].getEditorDocumentId() + "," ) != -1)
								' . $class_condition . '
								) {
								_usedEditors[frameId].setEditorIsHot(false);
								top.weEditorFrameController.closeDocument(frameId);
							}
						}
					';
											}
										
										}
										
										$script .= "\ntop.toggleBusy(0);\n";
										
										if ($_SESSION["we_mode"] == "normal") { //	different messages in normal or seeMode
											if (sizeof($GLOBALS["we_folder_not_del"])) {
												$_SESSION["delete_files_nok"] = array();
												$_SESSION["delete_files_info"] = str_replace(
														"\\n", 
														"", 
														sprintf(
																$GLOBALS["l_alert"]["folder_not_empty"], 
																""));
												foreach ($GLOBALS["we_folder_not_del"] as $datafile) {
													$_SESSION["delete_files_nok"][] = array(
														"icon" => "folder.gif", "path" => $datafile
													);
												}
												$script .= 'new jsWindow("' . WEBEDITION_DIR . 'delInfo.php","we_delinfo",-1,-1,550,550,true,true,true);' . "\n";
											} else {
												
												if (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE . "_cache" || defined(
														"FILE_TABLE") && $table == FILE_TABLE . "_cache") {
													$delete_ok = $l_alert["delete_cache_ok"];
												
												} else {
													$delete_ok = $l_alert["delete_ok"];
												
												}
												
												$script .= we_message_reporting::getShowMessageCall(
														$delete_ok, 
														WE_MESSAGE_NOTICE);
											}
										}
									
									} else {
										$script .= "top.toggleBusy(0);\n";
										if ($table == TEMPLATES_TABLE) {
											$script .= we_message_reporting::getShowMessageCall(
													$l_alert["deleteTempl_notok_used"], 
													WE_MESSAGE_ERROR);
										} else 
											if ($table == OBJECT_TABLE) {
												$script .= we_message_reporting::getShowMessageCall(
														$l_alert["deleteClass_notok_used"], 
														WE_MESSAGE_ERROR);
											} else {
												$script .= we_message_reporting::getShowMessageCall(
														$l_alert["delete_notok"], 
														WE_MESSAGE_ERROR);
											}
									}
		
		} else {
			$script .= "top.toggleBusy(0);\n" . we_message_reporting::getShowMessageCall(
					$l_alert["nothing_to_delete"], 
					WE_MESSAGE_WARNING) . "\n";
		}
		print '<script language="JavaScript" type="text/javascript" src="' . JS_DIR . 'windows.js"></script>' . "\n";
		print '<script language="JavaScript" type="text/javascript"><!--
' . $script . '
//-->
</script>
';
		//exit;
	}

//	in seeMode return to startDocument ...


if ($_SESSION["we_mode"] == "seem") {
	
	if ($retVal) { //	document deleted -> go to seeMode startPage
		$_js = we_message_reporting::getShowMessageCall(
				$l_alert['delete_single']['return_to_start'], 
				WE_MESSAGE_NOTICE) . "top.we_cmd('start_multi_editor');";
	} else {
		$_js = we_message_reporting::getShowMessageCall($l_alert['delete_single']['no_delete'], WE_MESSAGE_ERROR);
	}
	print 
			we_htmlElement::htmlHtml(we_htmlElement::htmlHead(we_htmlElement::jsElement($_js)));
	exit();
}

htmlTop();

print STYLESHEET;

?>
<script language="JavaScript" type="text/javascript"><!--
//top.deleteMode=1;
<?php

if ($_REQUEST["we_cmd"][0] != "delete_single_document") { // no select mode in delete_single_document
	

	if ($table == FILE_TABLE . "_cache") {
		if (we_hasPerm("ADMINISTRATOR")) {
			print '
				top.treeData.setstate(top.treeData.tree_states["selectitem"]);';
		
		}
	} elseif ($table == FILE_TABLE) {
		if (we_hasPerm("DELETE_DOC_FOLDER") && we_hasPerm("DELETE_DOCUMENT")) {
			print '
				top.treeData.setstate(top.treeData.tree_states["select"]);';
		
		} elseif (we_hasPerm("DELETE_DOCUMENT")) {
			print 'top.treeData.setstate(top.treeData.tree_states["selectitem"]);';
		
		}
	} elseif ($table == TEMPLATES_TABLE) {
		if (we_hasPerm("DELETE_TEMP_FOLDER") && we_hasPerm("DELETE_TEMPLATE")) {
			print 'top.treeData.setstate(top.treeData.tree_states["select"]);';
		
		} elseif (we_hasPerm("DELETE_TEMPLATE")) {
			print 'top.treeData.setstate(top.treeData.tree_states["selectitem"]);';
		
		}
	} elseif (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE) {
		if (we_hasPerm("DELETE_OBJECTFILE")) {
			print 'top.treeData.setstate(top.treeData.tree_states["select"]);';
		
		}
	} elseif (defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE . "_cache") {
		if (we_hasPerm("ADMINISTRATOR")) {
			print 'top.treeData.setstate(top.treeData.tree_states["selectitem"]);';
		}
	} else {
		print 'top.treeData.setstate(top.treeData.tree_states["selectitem"]);';
	}
}
?>
if(top.treeData.table != "<?php
print ereg_replace("_cache$", "", $table);
?>"){
	top.treeData.table = "<?php
	print ereg_replace("_cache$", "", $table);
	?>";
	we_cmd("load","<?php
	print ereg_replace("_cache$", "", $table);
	?>");
}else{
top.drawTree();
}

function we_submitForm(target,url){
	var f = self.document.we_form;
	var sel = "";
	for(var i=1;i<=top.treeData.len;i++){
		if(top.treeData[i].checked==1) sel += (top.treeData[i].id+",");
	}
	if(!sel){
		top.toggleBusy(0);
		<?php
		print we_message_reporting::getShowMessageCall($l_alert["nothing_to_delete"], WE_MESSAGE_ERROR);
		?>
		return;
	}

	sel = sel.substring(0,sel.length-1);

	f.sel.value = sel;
	f.target = target;
	f.action = url;
	f.method = "post";
	f.submit();
}
function we_cmd(){
	var args = "";
	for(var i = 0; i < arguments.length; i++){
		args += 'arguments['+i+']' + ((i < (arguments.length-1)) ? ',' : '');
	}
	eval('top.we_cmd('+args+')');
}
//-->
</script>
<?php
if (!$wfchk && $_REQUEST["we_cmd"][0] != "delete") {
	print $wfchk_html;
	exit();
}
if ($_REQUEST["we_cmd"][0] == "do_delete") {
	print "</head><body></body></html>";
	exit();
}
?>
<?php

$we_button = new we_button();
if ((defined("OBJECT_FILES_TABLE") && $table == OBJECT_FILES_TABLE . "_cache") || (defined("FILE_TABLE") && $table == FILE_TABLE . "_cache")) {
	$delete_text = $l_newFile["delete_text_cache"];
	$delete_confirm = $l_alert["delete_cache"];

} else {
	$delete_text = $l_newFile["delete_text"];
	$delete_confirm = $l_alert["delete"];

}
$content = '<span class="middlefont">' . $delete_text . '</span>';

$_buttons = $we_button->position_yes_no_cancel(
		$we_button->create_button(
				"ok", 
				"javascript:if(confirm('" . $delete_confirm . "')) we_cmd('do_delete','','$table')"), 
		"", 
		$we_button->create_button("quit_delete", "javascript:we_cmd('exit_delete','','$table')"), 
		10, 
		"left");

$form = '<form name="we_form" method="post">
' . hidden("sel", "") . '
</form>
';

print 
		'</head><body class="weTreeHeader">
<div style="width:380px;">
<h1 class="big" style="padding:0;margin:0;">' . htmlspecialchars(
				$l_newFile["title_delete"]) . '</h1>
<p class="small">' . $content . '</p>
<div>' . $_buttons . '</div></div>' . $form . '
</body>
</html>
';

?>