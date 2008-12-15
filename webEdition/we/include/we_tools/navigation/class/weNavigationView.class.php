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


/* the parent class of storagable webEdition classes */
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
//include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/navigation.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_language/'.$GLOBALS['WE_LANGUAGE'].'/copy_folder.inc.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');

class weNavigationView {

	var $db;
	var $frameset;

	var $topFrame;
	var $navigation;
	var $editorBodyFrame;
	var $editorBodyForm;
	var $editorHeaderFrame;
	var $editorFooterFrame;

	var $icon_pattern = '';
	var $item_pattern = '';
	var $group_pattern = '';
	var $page=1;

	function weNavigationView($frameset='',$topframe='top') {
		$this->db = new DB_WE();
		$this->setFramesetName($frameset);
		$this->setTopFrame($topframe);
		$this->Model=new weNavigation();
		$this->item_pattern = '<img style=\"vertical-align: bottom\" src=\"'.IMAGE_DIR.'tree/icons/navigation.gif\">&nbsp;';
		$this->group_pattern = '<img style=\"vertical-align: bottom\" src=\"'.IMAGE_DIR.'tree/icons/folder.gif\">&nbsp;';


	}

	//----------- Utility functions ------------------

	function htmlHidden($name, $value = '') {
		return we_htmlElement::htmlHidden(array('name'=>trim($name),'value'=>htmlspecialchars($value)));
	}


	//-----------------Init -------------------------------

	function setFramesetName($frameset){
		$this->frameset=$frameset;
	}

	function setTopFrame($frame){
		$this->topFrame=$frame;
		$this->editorBodyFrame = $frame . '.resize.right.editor.edbody';
		$this->editorBodyForm = $this->editorBodyFrame . '.document.we_form';
		$this->editorHeaderFrame = $frame . '.resize.right.editor.edheader';
		$this->editorFooterFrame = $frame . '.resize.right.editor.edfooter';
	}

	//------------------------------------------------


	function getCommonHiddens($cmds=array()){
		$out=$this->htmlHidden('cmd',(isset($cmds['cmd']) ? $cmds['cmd'] : ''));
		$out.=$this->htmlHidden('cmdid',(isset($cmds['cmdid']) ? $cmds['cmdid'] : ''));
		$out.=$this->htmlHidden('pnt', (isset($cmds['pnt']) ? $cmds['pnt'] : ''));
		$out.=$this->htmlHidden('tabnr',(isset($cmds['tabnr']) ? $cmds['tabnr'] : ''));
		$out.=$this->htmlHidden('vernr',(isset($cmds['vernr']) ? $cmds['vernr'] : 0));
		$out.=$this->htmlHidden('delayCmd',(isset($cmds['delayCmd']) ? $cmds['delayCmd'] : ''));
		$out.=$this->htmlHidden('delayParam',(isset($cmds['delayParam']) ? $cmds['delayParam'] : ''));

		return $out;
	}

	function getJSTop(){
		
		global $l_navigation;
		$js='
			var activ_tab = "1";
			var hot = 0;
			var makeNewDoc = false;

			function we_cmd() {
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				if('.$this->topFrame.'.hot && (arguments[0]=="tool_navigation_edit" || arguments[0]=="tool_navigation_new" || arguments[0]=="tool_navigation_new_group" || arguments[0]=="tool_navigation_exit")){
					'.$this->editorBodyFrame.'.document.we_form.delayCmd.value = arguments[0];
					'.$this->editorBodyFrame.'.document.we_form.delayParam.value = arguments[1];
					arguments[0] = "exit_doc_question";
				}
				switch (arguments[0]) {
					case "tool_navigation_edit":
						if('.$this->editorBodyFrame.'.loaded) {
							'.$this->editorBodyFrame.'.document.we_form.cmd.value = arguments[0];
							'.$this->editorBodyFrame.'.document.we_form.cmdid.value=arguments[1];
							'.$this->editorBodyFrame.'.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
							'.$this->editorBodyFrame.'.document.we_form.pnt.value="edbody";
							'.$this->editorBodyFrame.'.submitForm();
						} else {
							setTimeout(\'we_cmd("tool_navigation_edit",\'+arguments[1]+\');\', 10);
						}
					break;
					case "tool_navigation_new":
					case "tool_navigation_new_group":
						if('.$this->editorBodyFrame.'.loaded) {
							'.$this->topFrame.'.hot = 0;
							if('.$this->editorBodyFrame.'.document.we_form.presetFolder !== undefined) '.$this->editorBodyFrame.'.document.we_form.presetFolder.value = false;
							'.$this->editorBodyFrame.'.document.we_form.cmd.value = arguments[0];
							'.$this->editorBodyFrame.'.document.we_form.pnt.value="edbody";
							'.$this->editorBodyFrame.'.document.we_form.tabnr.value = 1;
							'.$this->editorBodyFrame.'.submitForm();
						} else {
							setTimeout(\'we_cmd("\' + arguments[0] + \'");\', 10);
						}
						if(treeData){
							treeData.unselectnode();
						}
					break;
					case "tool_navigation_save":
						if('.$this->editorBodyFrame.'.document.we_form.cmd.value=="home") return;
						if ('.$this->editorBodyFrame.'.loaded) {
								if('.$this->editorBodyFrame.'.document.we_form.presetFolder) '.$this->editorBodyFrame.'.document.we_form.presetFolder.value = makeNewDoc;
								var cont = true;
								if(typeof('.$this->editorBodyFrame.'.document.we_form.Selection)!="undefined") {
									if('.$this->editorBodyFrame.'.document.we_form.Selection.options['.$this->editorBodyFrame.'.document.we_form.Selection.selectedIndex].value=="dynamic" && '.$this->editorBodyFrame.'.document.we_form.IsFolder.value=="1"){
										cont = confirm("'.$l_navigation['save_populate_question'].'");
									}
								}
								if(cont){
									'.$this->editorBodyFrame.'.document.we_form.cmd.value=arguments[0];
									'.$this->editorBodyFrame.'.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
									'.$this->editorBodyFrame.'.document.we_form.pnt.value="edbody";
									'.$this->editorBodyFrame.'.submitForm();
								}
						} else {
							' . we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["nothing_to_save"], WE_MESSAGE_ERROR) . '
						}
						break;
					case "populate":
					case "depopulate":
						if('.$this->editorBodyFrame.'.document.we_form.cmd.value=="home") return;
						if ('.$this->editorBodyFrame.'.loaded) {
								if(arguments[0]=="populate") {
									q="'.$l_navigation['populate_question'].'";
								} else {
									q="'.$l_navigation['depopulate_question'].'";
								}
								if(confirm(q)){
									'.$this->editorBodyFrame.'.document.we_form.pnt.value="edbody";
									'.$this->editorBodyFrame.'.document.we_form.cmd.value=arguments[0];
									'.$this->editorBodyFrame.'.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
									if('.$this->editorBodyFrame.'.document.we_form.pnt.value=="previewIframe") {
									'.$this->editorBodyFrame.'.document.we_form.pnt.value="preview";
									}
									'.$this->editorBodyFrame.'.submitForm();
								}
						}
					break;
					case "tool_navigation_delete":
						if('.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmd.value=="home"){
							' . we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["nothing_selected"], WE_MESSAGE_ERROR) . '
							return;
						}
						if('.$this->topFrame.'.resize.right.editor.edbody.document.we_form.newone.value==1){
							' . we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["nothing_to_delete"], WE_MESSAGE_ERROR) . '
							return;
						}
						'.(!we_hasPerm("DELETE_NAVIGATION") ?
						(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["no_perms"], WE_MESSAGE_ERROR)
						)
						:
						('
								if ('.$this->topFrame.'.resize.right.editor.edbody.loaded) {
									if (confirm("'.$GLOBALS["l_navigation"]["delete_alert"].'")) {
										'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.cmd.value=arguments[0];
										'.$this->topFrame.'.resize.right.editor.edbody.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
										'.$this->editorHeaderFrame.'.location="'.$this->frameset.'?home=1&pnt=edheader";
										'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?home=1&pnt=edfooter";
										'.$this->topFrame.'.resize.right.editor.edbody.submitForm();
									}
								} else {
									' . we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["nothing_to_delete"], WE_MESSAGE_ERROR) . '
								}

						')).'
					break;
					case "move_up":
					case "move_down":
						'.$this->topFrame.'.cmd.location="'.$this->frameset.'?pnt=cmd&cmd="+arguments[0];
					break;
					case "dyn_preview":
					case "create_template":
					case "populateWorkspaces":
					case "populateFolderWs":
					case "populateText":
						'.$this->editorBodyFrame.'.document.we_form.cmd.value=arguments[0];
						'.$this->editorBodyFrame.'.document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
						'.$this->editorBodyFrame.'.document.we_form.pnt.value="cmd";
						'.$this->editorBodyFrame.'.submitForm("cmd");
					break;
					case "del_mode":
						'.$this->topFrame.'.treeData.setstate(treeData.tree_states["select"]);
						'.$this->topFrame.'.treeData.unselectnode();
						'.$this->topFrame.'.drawTree();
					case "move_mode":
						'.$this->topFrame.'.treeData.setstate(treeData.tree_states["selectitem"]);
						'.$this->topFrame.'.treeData.unselectnode();
						'.$this->topFrame.'.drawTree();
					break;
					case "tool_navigation_exit":
						top.close();
					break;
					case "exit_doc_question":
						url = "'.$this->frameset.'?pnt=exit_doc_question&delayCmd="+'.$this->editorBodyFrame.'.document.we_form.delayCmd.value+"&delayParam="+'.$this->editorBodyFrame.'.document.we_form.delayParam.value;
						new jsWindow(url,"we_exit_doc_question",-1,-1,380,130,true,false,true);
					break;
					
					case "tool_navigation_reset_customer_filter":
						if(confirm("'.$GLOBALS["l_navigation"]["reset_customerfilter_question"].'")) {
							we_cmd("tool_navigation_do_reset_customer_filter");
						}
					break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
						}
						eval("top.opener.top.we_cmd(" + args + ")");
				}
			}

			function mark() {
				hot=1;
				'.$this->editorHeaderFrame.'.mark();
			}

			';

			return we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).we_htmlElement::jsElement($js);
	}

	function getJSProperty(){
		global $l_navigation;
		$out="";
		$out.=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js"));
		$_objFields = "\n";
		if ($this->Model->SelectionType == 'classname') {
			if(defined('OBJECT_TABLE')) {

				include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_object.inc.php');

				$_class = new we_object();
				$_class->initByID($this->Model->ClassID,OBJECT_TABLE);
				$_fields = $_class->getAllVariantFields();
				
				foreach ($_fields as $_key=>$val){
					$_objFields .= "\t\t\t".'weNavTitleField["' . substr($_key,strpos($_key,"_")+1).'"] = "' . $_key . '";'."\n";
				}
			}
		}
		$_we_button = new we_button();
		$js='
			var loaded=0;
			function we_cmd() {
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]) {
					case "openDocselector":
						new jsWindow(url,"we_docselector",-1,-1,'.WINDOW_DOCSELECTOR_WIDTH.','.WINDOW_DOCSELECTOR_HEIGHT.',true,true,true,true);
						break;
					case "openSelector":
						new jsWindow(url,"we_selector",-1,-1,'.WINDOW_SELECTOR_WIDTH.','.WINDOW_SELECTOR_HEIGHT.',true,true,true,true);
						break;
					case "openDirselector":
						new jsWindow(url,"we_selector",-1,-1,'.WINDOW_DIRSELECTOR_WIDTH.','.WINDOW_DIRSELECTOR_HEIGHT.',true,true,true,true);
						break;
					case "openCatselector":
						new jsWindow(url,"we_catselector",-1,-1,'.WINDOW_CATSELECTOR_WIDTH.','.WINDOW_CATSELECTOR_HEIGHT.',true,true,true,true);
						break;
					case "openNavigationDirselector":
						url = "'.WEBEDITION_DIR.'/we/include/we_tools/navigation/we_navigationDirSelect.php?";
						for(var i = 0; i < arguments.length; i++){
							url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }
						}
						new jsWindow(url,"we_navigation_dirselector",-1,-1,600,400,true,true,true);
						break;
					case "openFieldSelector":
						url = "'.WEBEDITION_DIR.'/we/include/we_tools/navigation/edit_navigation_frameset.php?pnt=fields&cmd="+arguments[1]+"&type="+arguments[2]+"&selection="+arguments[3]+"&multi="+arguments[4];
						new jsWindow(url,"we_navigation_field_selector",-1,-1,380,350,true,true,true);
						break;
					case "copyNaviFolder":
						folderPath = document.we_form.CopyFolderPath.value;
						folderID   = document.we_form.CopyFolderID.value;
						setTimeout("copyNaviFolder(folderPath, folderID)",100);
						break;
					case "rebuildNavi":
						//new jsWindow(\''.WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=rebuild&step=2&type=rebuild_navigation&responseText=\',\'resave\',-1,-1,600,130,0,true);
						break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
						}
						eval("' . $this->topFrame . '.we_cmd("+args+")");
				}
			}
			' . $_we_button->create_state_changer(false) . '
			var copyNaviFolderUrl = "'.WEBEDITION_DIR.'/rpc/rpc.php";
			function copyNaviFolder(folderPath,folderID) {
				var parentPos = selfNaviPath.indexOf(folderPath);
				if(parentPos==(-1) || selfNaviPath.indexOf(folderPath)>0) {
					cnfUrl = copyNaviFolderUrl+"?protocol=text&cmd=CopyNavigationFolder&cns=tools/navigation&we_cmd[0]="+selfNaviPath+"&we_cmd[1]="+selfNaviId+"&we_cmd[2]="+folderPath+"&we_cmd[3]="+folderID;
					top.YAHOO.util.Connect.asyncRequest("GET", cnfUrl, copyNaviFolderAjaxCallback);
				} else {
					' . we_message_reporting::getShowMessageCall($GLOBALS["l_alert"]["copy_folder_not_valid"], WE_MESSAGE_ERROR) . '
				}
			}

			var copyNaviFolderAjaxCallback = {
				success: function(o) {
					if(o.responseText != "") {
						' . we_message_reporting::getShowMessageCall($GLOBALS["l_copyFolder"]["copy_success"], WE_MESSAGE_NOTICE) . '
						top.content.cmd.location.reload();
					} else {
						' . we_message_reporting::getShowMessageCall($GLOBALS["l_alert"]["copy_folder_not_valid"], WE_MESSAGE_ERROR) . '
					}
				},
				failure: function(o) {
					' . we_message_reporting::getShowMessageCall($GLOBALS["l_alert"]["copy_folder_not_valid"], WE_MESSAGE_ERROR) . '
				}
			}


			'.$this->getJSSubmitFunction().'

			var table = "'.FILE_TABLE.'";
			var log_counter=0;

			function toggle(id){
				var elem = document.getElementById(id);
				if(elem){
					if(elem.style.display == "none") elem.style.display = "block";
					else elem.style.display = "none";
				}
			}
			function setVisible(id,visible){
				var elem = document.getElementById(id);
				if(elem){
					if(visible==true) elem.style.display = "block";
					else elem.style.display = "none";
				}
			}

			function clearFields(){
				'.$this->topFrame.'.mark();
				var st = document.we_form.SelectionType;
				if(st.selectedIndex>-1){
					removeAllCats();
					'.$this->editorBodyFrame.'.switch_button_state("select_TitleField", "select_enabled", "enabled");
					'.$this->editorBodyFrame.'.switch_button_state("select_SortField", "select_enabled", "enabled");
					if(st.options[st.selectedIndex].value=="classname" && document.we_form.ClassID.options.length<1){
						'.$this->editorBodyFrame.'.switch_button_state("select_TitleField", "select_enabled", "disabled");
						'.$this->editorBodyFrame.'.switch_button_state("select_XFolder", "select_enabled", "disabled");
						document.getElementById("yuiAcInputFolderPath").disabled=true;
					} else {
						'.$this->editorBodyFrame.'.switch_button_state("select_XFolder", "select_enabled", "enabled");
						document.getElementById("yuiAcInputFolderPath").disabled=false;
					}
					if(st.options[st.selectedIndex].value=="doctype"){
						setVisible("docFolder",true);
						setVisible("objFolder",false);
						setVisible("catFolder",false);
						if('.$this->editorBodyForm.'.DocTypeID.options['.$this->editorBodyForm.'.DocTypeID.selectedIndex].value==0){
							'.$this->editorBodyFrame.'.switch_button_state("select_TitleField", "select_enabled", "disabled");
							'.$this->editorBodyFrame.'.switch_button_state("select_SortField", "select_enabled", "disabled");
						}
					}
					if(st.options[st.selectedIndex].value=="classname"){
						setVisible("docFolder",false);
						setVisible("objFolder",true);
						setVisible("catFolder",false);
					}
					' .
					(!$this->Model->IsFolder ? '
					document.we_form.LinkID.value="";
					document.we_form.LinkPath.value="";
					' : '') . '

					document.we_form.FolderID.value=0;
					document.we_form.FolderPath.value="/";
					document.we_form.TitleField.value="";
					document.we_form.__TitleField.value="";
					document.we_form.SortField.value="";
					document.we_form.__SortField.value="";
					weInputRemoveClass(document.we_form.__TitleField, "weMarkInputError");
					weInputRemoveClass(document.we_form.__SortField, "weMarkInputError");
					document.we_form.dynamic_Parameter.value="";
					if(document.we_form.IsFolder.value==0) {
						document.we_form.Parameter.value="";
						document.we_form.Url.value="http://";
					}

					if(st.options[st.selectedIndex].value=="category"){
						setVisible("docFolder",false);
						setVisible("objFolder",false);
						setVisible("catFolder",true);
						setVisible("fieldChooser",false);
						setVisible("catSort",false);
					} else {
						setVisible("fieldChooser",true);
						setVisible("catSort",true);
					}

				}

			}

			function setCustomerFilter(sel) {
';
				if(!$this->Model->IsFolder) {
					$js .= '
					var st = document.we_form.SelectionType;
					if (sel.options[sel.selectedIndex].value == "dynamic") {
						document.we_form.elements["_wecf_useDocumentFilter"].checked = false;
						document.we_form.elements["wecf_useDocumentFilter"].value = 0;
						document.we_form.elements["_wecf_useDocumentFilter"].disabled = true;
						document.getElementById("label__wecf_useDocumentFilter").style.color = "gray";
						document.getElementById("MainFilterDiv").style.display = "block";
					} else {
						document.we_form.elements["_wecf_useDocumentFilter"].disabled = false;
						document.getElementById("label__wecf_useDocumentFilter").style.color = "";
					}
';
				}

$js .= '
			}

			function setPresentation(type) {
				'.$this->topFrame.'.mark();
				var st = document.we_form.SelectionType;
				st.options.length = 0;
				if(type=="dynamic"){
					st.options[st.options.length] = new Option("'.$l_navigation['documents'].'","doctype");
					'.(defined('OBJECT_TABLE') ? '
					st.options[st.options.length] = new Option("'.$l_navigation['objects'].'","classname");
					'  : '' ) . '
					st.options[st.options.length] = new Option("'.$l_navigation['categories'].'","category");
					setVisible("doctype",true);
					setVisible("classname",false);
					setVisible("docFolder",true);
					setVisible("objFolder",false);
					setVisible("catFolder",false);
					setStaticSelection("document");
				} else {
					st.options[st.options.length] = new Option("'.$l_navigation['docLink'].'","docLink");
					st.options[st.options.length] = new Option("'.$l_navigation['urlLink'].'","urlLink");
					'.(defined('OBJECT_TABLE') ? '
					st.options[st.options.length] = new Option("'.$l_navigation['objLink'].'","objLink");
					'  : '' ) . '
					st.options[st.options.length] = new Option("'.$l_navigation['catLink'].'","catLink");
					setVisible("classname",true);
					setVisible("doctype",false);
					setVisible("docFolder",false);
					setVisible("objFolder",true);
					setVisible("catFolder",true);
					setVisible("docLink",true);
					setStaticSelection("docLink");
				}
				clearFields();
			}

			function closeAllSelection(){
				setVisible("dynamic",false);
				setVisible("static",false);
			}

			function closeAllType(){
				setVisible("doctype",false);
				'.(defined("OBJECT_TABLE") ?'
				setVisible("classname",false);
				'
				: '').'
			}

			function closeAllStats(){
				setVisible("docLink",false);
				'.(defined("OBJECT_TABLE") ?'
				setVisible("objLink",false);
				setVisible("objLinkWorkspace",false);
				'
				: '').'
				setVisible("catLink",false);
				document.we_form.LinkID.value = "";
				document.we_form.LinkPath.value = "";
			}

			function setFieldValue(fieldNameTo, fieldFrom){
				if(weNavTitleField[fieldFrom.value] != undefined){
					eval("document.we_form."+fieldNameTo+".value=\'"+weNavTitleField[fieldFrom.value]+"\'");
					weInputRemoveClass(fieldFrom, "weMarkInputError");
				} else if(fieldFrom.value=="") {
					eval("document.we_form."+fieldNameTo+".value=\'\'");
					weInputRemoveClass(fieldFrom, "weMarkInputError");
				} else {
					weInputAppendClass(fieldFrom, "weMarkInputError");
				}
				
			}
			
			function putTitleField(field){
				'.$this->topFrame.'.mark();
				document.we_form.TitleField.value=field;
				document.we_form.__TitleField.value = field.substring(field.indexOf("_")+1,field.length);
				weInputRemoveClass(document.we_form.__TitleField, "weMarkInputError");
			}

			function putSortField(field){
				'.$this->topFrame.'.mark();
				document.we_form.SortField.value=field;
				var __field=field.substr(field.indexOf("_")+1,field.length);
				document.we_form.__SortField.value=__field;
				weInputRemoveClass(document.we_form.__SortField, "weMarkInputError");
			}

			function setFocus() {
				if(typeof(document.we_form.Text)!="undefined" && '.$this->topFrame.'.activ_tab==1){
					document.we_form.Text.focus();
				}
			}

			function switch_button_state(element, button, state, type) {
				if (state == "enabled") {
					weButton.enable(element);
					return true;
				} else if (state == "disabled") {
					weButton.disable(element);
					return false;
				}

				return false;
			}

			function setWorkspaces(value) {
				setVisible("objLinkWorkspaceClass",false);
				setVisible("objLinkWorkspace",false);
				if(value=="classname"){
					setVisible("objLinkWorkspaceClass",true);
				}
				if(value=="objLink"){
					setVisible("objLinkWorkspace",true);
				}
			}

			function setStaticSelection(value){
				if(value=="category"){
					setVisible("dynUrl",true);
					setVisible("dynamic_LinkSelectionDiv",true);
					dynamic_setLinkSelection("intern");
				} else {

					setVisible("dynUrl",false);

					if(value=="catLink"){
						setVisible("staticSelect",true);
						setVisible("staticUrl",true);
					} else if(value=="urlLink" || value=="catLink"){
						setVisible("staticSelect",false);
						setVisible("staticUrl",true);
					} else {
						setVisible("staticSelect",true);
						setVisible("staticUrl",false);
					}

					if(value=="docLink" || value=="objLink" || value=="catLink"){
						setVisible("docLink",false);
						setVisible("objLink",false);
						setVisible("catLink",false);
						setVisible(value,true);
					}

					if(value=="urlLink") {
						setVisible("LinkSelectionDiv",false);
						setLinkSelection("extern");
					} else if(value=="catLink") {
						setVisible("LinkSelectionDiv",true);
						setLinkSelection("intern");
					}

				}

			}

			function setFolderSelection(value){
					document.we_form.LinkID.value = "";
					document.we_form.LinkPath.value = "";
					document.we_form.FolderUrl.value = "http://";
					document.we_form.FolderWsID.value = -1;
					if(value=="urlLink"){
						setVisible("folderSelectionDiv",false);
						setVisible("docFolderLink",false);
						setVisible("objFolderLink",false);
						setVisible("objLinkFolderWorkspace",false);
						setVisible("folderUrlDiv",true);
					}else if(value=="docLink"){
						setVisible("folderSelectionDiv",true);
						setVisible("docFolderLink",true);
						setVisible("objFolderLink",false);
						setVisible("objLinkFolderWorkspace",false);
						setVisible("folderUrlDiv",false);

					} else {
						setVisible("folderSelectionDiv",true);
						setVisible("docFolderLink",false);
						setVisible("objFolderLink",true);
						setVisible("objLinkFolderWorkspace",true);
						setVisible("folderUrlDiv",false);
					}


			}
			var weNavTitleField = new Array();
			'.$_objFields.'

		';

		$out.=we_htmlElement::jsElement($js);
		return $out;
	}



function getJSTreeHeader(){
	return '

			function we_cmd(){
				var args = "";
				var url = "'.$this->frameset.'?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				switch (arguments[0]) {
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += \'arguments[\'+i+\']\' + ((i < (arguments.length-1)) ? \',\' : \'\');
						}
						eval(\''.$this->topFrame.'.we_cmd(\'+args+\')\');
				}
			}

	'.$this->getJSSubmitFunction("cmd");
}



function getJSSubmitFunction($def_target="edbody",$def_method="post"){
	return '

			function populateVars() {
				if(typeof(categories_edit)!="undefined" && typeof(document.we_form.CategoriesCount)!="undefined"){
					document.we_form.CategoriesCount.value = categories_edit.itemCount;
				}
				if(typeof(sort_edit)!="undefined" && typeof(document.we_form.SortCount)!="undefined"){
					document.we_form.SortCount.value = sort_edit.itemCount;
				}
				if(typeof(specificCustomersEdit)!="undefined" && typeof(document.we_form.specificCustomersEditCount)!="undefined"){
					document.we_form.specificCustomersEditCount.value = specificCustomersEdit.itemCount;
				}
				if(typeof(blackListEdit)!="undefined" && typeof(document.we_form.blackListEditCount)!="undefined"){
					document.we_form.blackListEditCount.value = blackListEdit.itemCount;
				}
				if(typeof(whiteListEdit)!="undefined" && typeof(document.we_form.whiteListEditCount)!="undefined"){
					document.we_form.whiteListEditCount.value = whiteListEdit.itemCount;
				}
			}

			function submitForm() {

				var f = self.document.we_form;

				populateVars();

				if (arguments[0]) {
					f.target = arguments[0];
				} else {
					f.target = "'.$def_target.'";
				}

				if (arguments[1]) {
					f.action = arguments[1];
				} else {
					f.action = "'.$this->frameset.'";
				}

				if (arguments[2]) {
					f.method = arguments[2];
				} else {
					f.method = "'.$def_method.'";
				}
				f.submit();
			}

	';

}

function processCommands() {
		global $l_navigation;
		$_header_sent = false;

		if (isset($_REQUEST["cmd"])) {

			if(!empty($this->Model->Charset) && $_REQUEST['cmd']!='new_navigation') {
				header('Content-Type: text/html; charset=' . $this->Model->Charset);
				$_header_sent = true;
			}

			switch ($_REQUEST['cmd']) {
				case 'tool_navigation_new':
				case 'tool_navigation_new_group':
					if(!we_hasPerm('EDIT_NAVIGATION')) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}
					$this->Model = new weNavigation();
					$this->Model->IsFolder = ($_REQUEST['cmd'] == 'tool_navigation_new_group') ? 1 : 0;
					$this->Model->ParentID = isset($_REQUEST['ParentID']) && $_REQUEST['ParentID'] ? $_REQUEST['ParentID'] : 0;
					print we_htmlElement::jsElement('
								'.$this->editorHeaderFrame.'.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->Model->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
					');
					break;
				case 'tool_navigation_edit':
					if(!we_hasPerm('EDIT_NAVIGATION')) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}

					$this->Model = new weNavigation($_REQUEST['cmdid']);

					if(!empty($this->Model->Charset) && !$_header_sent) {
						header('Content-Type: text/html; charset=' . $this->Model->Charset);
					}

					if(!$this->Model->isAllowedForUser()) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["no_perms"], WE_MESSAGE_ERROR)
						);
						$this->Model = new weNavigation();
						$_REQUEST['home'] = true;
						break;
					}
					print we_htmlElement::jsElement('
								'.$this->editorHeaderFrame.'.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->Model->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
								if('.$this->topFrame.'.treeData){
									'.$this->topFrame.'.treeData.unselectnode();
									'.$this->topFrame.'.treeData.selectnode('.$this->Model->ID.');
								}
					');
					break;
				case 'tool_navigation_save':
					if(!we_hasPerm('EDIT_NAVIGATION') && !we_hasPerm('EDIT_NAVIGATION')) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}

					$js='';
					if($this->Model->filenameNotValid($this->Model->Text)){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["wrongtext"], WE_MESSAGE_ERROR)
						);
						break;
					}

					if(trim($this->Model->Text) == ''){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["name_empty"], WE_MESSAGE_ERROR)
						);
						break;
					}
					
					$oldpath = $this->Model->Path;
					// set the path and check it
					$this->Model->setPath();
					if($this->Model->pathExists($this->Model->Path)){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["name_exists"], WE_MESSAGE_ERROR)
						);
						break;
					}
					
					if($this->Model->isSelf()){
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]["path_nok"], WE_MESSAGE_ERROR)
						);
						break;
					}

					if($this->Model->SelectionType == "classname" && $this->Model->TitleField!=""){
						$_classFields = unserialize(f("SELECT DefaultValues FROM ".OBJECT_TABLE." WHERE ID=".abs($this->Model->ClassID),"DefaultValues",$this->db));
						if (is_array($_classFields) && count($_classFields)>0) {
							$_fieldsByNamePart = array();
							foreach ($_classFields as $_key=>$_val) {
								if (($_pos = strpos($_key,"_")) && (substr($_key, 0, $_pos)!="object")) {
									$_fieldsByNamePart[substr($_key, $_pos+1)] = $_key;
								}
							}
							if (!key_exists($this->Model->TitleField,$_fieldsByNamePart) && !key_exists($this->Model->TitleField,$_classFields)) {
								print we_htmlElement::jsElement(
									we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]['wrongTitleField'], WE_MESSAGE_ERROR)
								);
								break;
							}
						} else {
								print we_htmlElement::jsElement(
									we_message_reporting::getShowMessageCall($GLOBALS["l_navigation"]['wrongTitleField'], WE_MESSAGE_ERROR)
								);
								break;
						}
					}

                	$js='';

                	$newone = $this->Model->ID=='0' ? true : false;

                	$_dynamic = '';
                	if($this->Model->ID && $this->Model->IsFolder){
                		$_dynamic = f('SELECT Selection FROM '.NAVIGATION_TABLE.' WHERE ID='.abs($this->Model->ID),'Selection',$this->Model->db);
					}

                	$this->Model->save();

					if($this->Model->IsFolder && $oldpath!='' && $oldpath!='/' && $oldpath!=$this->Model->Path) {
						$db_tmp = new DB_WE();
						$this->db->query('SELECT ID FROM ' . NAVIGATION_TABLE . ' WHERE Path LIKE \'' . mysql_real_escape_string($oldpath) . '%\' AND ID<>\''.abs($this->Model->ID).'\';');
						while($this->db->next_record()) {
							$db_tmp->query('UPDATE ' . NAVIGATION_TABLE . ' SET Path=\'' . mysql_real_escape_string($this->Model->evalPath($this->db->f("ID"))) . '\' WHERE ID=\'' . abs($this->db->f("ID")) . '\';');
						}
					}
					if ($newone) {
						$js='
							'.$this->topFrame.'.makeNewEntry(\''.$this->Model->Icon.'\',\''.$this->Model->ID.'\',\''.$this->Model->ParentID.'\',\''.addslashes($this->Model->Text).'\',0,\''.($this->Model->IsFolder ? 'folder' : 'item').'\',\''. NAVIGATION_TABLE .'\',0,' . $this->Model->Ordn . ');
							';
					} else {
						$js=$this->topFrame.'.updateEntry(\''.$this->Model->ID.'\',\''.addslashes($this->Model->Text).'\',\''.$this->Model->ParentID.'\',\''.$this->Model->Depended.'\',0,\''.($this->Model->IsFolder ? 'folder' : 'item').'\',\''. NAVIGATION_TABLE .'\',' . $this->Model->Depended . ',' . $this->Model->Ordn . ');';
					}

					if($this->Model->IsFolder && $this->Model->Selection=='dynamic') {
						$_old_items = array();
						if($this->Model->hasDynChilds()){
							$_old_items = $this->Model->depopulateGroup();
							foreach ($_old_items as $_id) {
								$js .= $this->topFrame.'.deleteEntry('.$_id['id'].');';
							}
						}
						$_items = $this->Model->populateGroup($_old_items);
						foreach ($_items as $_k=>$_item) {
							$js .= $this->topFrame.'.makeNewEntry(\'link.gif\',\''.$_item['id'].'\',\''.$this->Model->ID.'\',\''.addslashes($_item['text']).'\',0,\'item\',\''. NAVIGATION_TABLE .'\',1,' . $_k . ');';
						}
					}


					$js = we_htmlElement::jsElement($js . '
						'.$this->editorHeaderFrame.'.location.reload();
						' . we_message_reporting::getShowMessageCall( ($this->Model->IsFolder==1 ? $l_navigation["save_group_ok"] : $l_navigation["save_ok"]), WE_MESSAGE_NOTICE ) . '
						'.$this->topFrame.'.hot=0;
						if('.$this->topFrame.'.makeNewDoc) {
							setTimeout("'.$this->topFrame.'.we_cmd(\"tool_navigation_'.(($this->Model->IsFolder==1) ? 'new_group' : 'new') . '\",100)");
						}
					');

					if(isset($_REQUEST['delayCmd']) && !empty($_REQUEST['delayCmd'])) {
						$js .= we_htmlElement::jsElement(
							$this->topFrame.'.we_cmd("'.$_REQUEST['delayCmd'].'"' . ((isset($_REQUEST['delayParam']) && !empty($_REQUEST['delayParam'])) ? ',"' .$_REQUEST['delayParam'].'"' : '' ) . ');
							'
						);
						$_REQUEST['delayCmd'] = '';
						if(isset($_REQUEST['delayParam'])){
							$_REQUEST['delayParam'] = '';
						}
					}

					print $js;

					break;
				case 'tool_navigation_delete':

					print we_htmlElement::jsElement('',array('src'=>JS_DIR . 'we_showMessage.js'));

					if (!we_hasPerm("DELETE_NAVIGATION")) {
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($l_navigation["no_perms"], WE_MESSAGE_ERROR)
							);
						return;
					} else {
						if ($this->Model->delete()) {
							print we_htmlElement::jsElement('
									'.$this->topFrame.'.deleteEntry('.$this->Model->ID.');
									setTimeout(\'' . we_message_reporting::getShowMessageCall( ($this->Model->IsFolder==1 ? $l_navigation['group_deleted'] : $l_navigation['navigation_deleted']), WE_MESSAGE_NOTICE) . '\',500);

							');
							$this->Model = new weNavigation();
							$_REQUEST['home'] = '1';
							$_REQUEST['pnt'] = 'edbody';
						} else {
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($l_navigation['nothing_to_delete'], WE_MESSAGE_ERROR)
							);
						}
					}
				break;
				case 'switchPage':

				break;
				case 'move_up' :
					if($this->Model->reorderUp()) {
						print we_htmlElement::jsElement('
								'.
								$this->editorBodyForm.'.Ordn.value='.($this->Model->Ordn+1).';' .
								$this->topFrame.'.reloadGroup('.$this->Model->ParentID.');

								'.$this->editorBodyFrame.'.switch_button_state("direction_down", "direction_down_enabled", "enabled");
								'.$this->editorBodyFrame.'.switch_button_state("direction_up", "direction_up_enabled", "enabled");

								if('.$this->editorBodyForm.'.Ordn.value==1){
									'.$this->editorBodyFrame.'.switch_button_state("direction_up", "direction_up_enabled", "disabled");
								} else {
									'.$this->editorBodyFrame.'.switch_button_state("direction_up", "direction_up_enabled", "enabled");
								}
								'
						);
					}
				break;
				case 'move_down' :
					if($this->Model->reorderDown()){
						$_parentid = f('SELECT ParentID FROM '.NAVIGATION_TABLE.' WHERE ID='.abs($this->Model->ID).';','ParentID',$this->db);
						$_num = f('SELECT MAX(Ordn) as OrdCount FROM '.NAVIGATION_TABLE.' WHERE ParentID='.abs($_parentid).';','OrdCount',$this->db);
						print we_htmlElement::jsElement('
									'.
									$this->editorBodyForm.'.Ordn.value='.($this->Model->Ordn+1).';' .
									$this->topFrame.'.reloadGroup('.$this->Model->ParentID.');
									'.$this->editorBodyFrame.'.switch_button_state("direction_down", "direction_down_enabled", "enabled");
									'.$this->editorBodyFrame.'.switch_button_state("direction_up", "direction_up_enabled", "enabled");
									if('.$this->editorBodyForm.'.Ordn.value=='.($_num+1).'){
										'.$this->editorBodyFrame.'.switch_button_state("direction_down", "direction_down_enabled", "disabled");
									} else {
										'.$this->editorBodyFrame.'.switch_button_state("direction_down", "direction_down_enabled", "enabled");
									}
									'
						);
					}
				break;
				case 'populate':
					$_items = $this->Model->populateGroup();
					$_js = '';
					foreach ($_items as $_k=>$_item) {
						$_js .= $this->topFrame.'.deleteEntry('.$_item['id'].');';
						$_js .= $this->topFrame.'.makeNewEntry(\'link.gif\',\''.$_item['id'].'\',\''.$this->Model->ID.'\',\''.addslashes($_item['text']).'\',0,\'item\',\''. NAVIGATION_TABLE .'\',1,' . $_k . ');';
					}
					print we_htmlElement::jsElement(
						$_js .
						we_message_reporting::getShowMessageCall($l_navigation['populate_msg'], WE_MESSAGE_NOTICE)
					);
				break;
				case 'depopulate':
					$_items = $this->Model->depopulateGroup();
					$_js = '';
					foreach ($_items as $_id) {
						$_js .= $this->topFrame.'.deleteEntry('.$_id.');
						';
					}
					$_js .= we_message_reporting::getShowMessageCall($l_navigation['depopulate_msg'], WE_MESSAGE_NOTICE);
					print we_htmlElement::jsElement($_js);
					$this->Model->Selection = 'nodynmic';
					$this->Model->saveField('Selection');
				break;
				case 'dyn_preview':

					print 	we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")) .
							we_htmlElement::jsElement('
						url = "'.WEBEDITION_DIR.'/we/include/we_tools/navigation/edit_navigation_frameset.php?pnt=dyn_preview";
						new jsWindow(url,"we_navigation_dyn_preview",-1,-1,480,350,true,true,true);'
					);
				break;
				case 'create_template':
					print we_htmlElement::jsElement(
							$this->topFrame.'.opener.top.we_cmd("new","' . TEMPLATES_TABLE . '","","text/weTmpl","","'.base64_encode($this->Model->previewCode).'");
					');
				break;
				case 'populateFolderWs':
					require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weDynList.class.php');
					$_prefix = '';
					$_values = weDynList::getWorkspacesForObject($this->Model->LinkID);
					$_js = '';

					if(!empty($_values)) {

						foreach ($_values as $_id=>$_path) {
							$_js .= $this->editorBodyForm.'.FolderWsID.options['.$this->editorBodyForm.'.FolderWsID.options.length] = new Option("'.$_path.'",'.$_id.');
							';
						}
						print we_htmlElement::jsElement(
							$this->editorBodyFrame.'.setVisible("objLinkFolderWorkspace",true);
							'.$this->editorBodyForm.'.FolderWsID.options.length = 0;
							'.$_js.'
						');

					} else {

						if(weDynList::getWorkspaceFlag($this->Model->LinkID)) {
							print we_htmlElement::jsElement(
								$this->editorBodyForm.'.FolderWsID.options.length = 0;
								'. $this->editorBodyForm.'.FolderWsID.options['.$this->editorBodyForm.'.FolderWsID.options.length] = new Option("/",0);
								'. $this->editorBodyForm.'.FolderWsID.selectedIndex = 0;
								'.$this->editorBodyFrame.'.setVisible("objLinkFolderWorkspace",true);'
							);
						} else {
							print we_htmlElement::jsElement(
								$this->editorBodyFrame.'.setVisible("objLinkFolderWorkspace'.$_prefix.'",false);
								'.$this->editorBodyForm.'.FolderWsID.options.length = 0;
								'. $this->editorBodyForm.'.FolderWsID.options['.$this->editorBodyForm.'.FolderWsID.options.length] = new Option("-1",-1);
								'.$this->editorBodyForm.'.LinkID.value = "";
								'.$this->editorBodyForm.'.LinkPath.value = "";
								' . we_message_reporting::getShowMessageCall($l_navigation['no_workspace'], WE_MESSAGE_ERROR) . '
							');
						}
					}
				break;
				case 'populateWorkspaces':

					$_objFields = "\n";
					if ($this->Model->SelectionType == 'classname') {
						$__fields = array();			
						if(defined('OBJECT_TABLE')) {

							include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/object/we_object.inc.php');
							$_class = new we_object();
							$_class->initByID($this->Model->ClassID,OBJECT_TABLE);
							$_fields = $_class->getAllVariantFields();
							$_objFields = "\n";
							foreach ($_fields as $_key=>$val){
								$_objFields .= $this->editorBodyFrame.'.weNavTitleField["' . substr($_key,strpos($_key,"_")+1).'"] = "' . $_key . '";'."\n";
							}
						}
					}
					
					
					
					require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weDynList.class.php');
					$_prefix = '';
					
					if($this->Model->Selection=='dynamic'){ 
						$_values = weDynList::getWorkspacesForClass($this->Model->ClassID);
						$_prefix = 'Class';
					} else {
						$_values = weDynList::getWorkspacesForObject($this->Model->LinkID);
					}

					$_js = '';

					if(!empty($_values)) { // if the class has workspaces

						foreach ($_values as $_id=>$_path) {
							$_js .= $this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options['.$this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options.length] = new Option("'.$_path.'",'.$_id.');
							';
						}
						$out = we_htmlElement::jsElement(
							$_objFields.
							$this->editorBodyFrame.'.setVisible("objLinkWorkspace'.$_prefix.'",true);
							'.$this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options.length = 0;
							'.$_js.'
						');
							print $out;
					} else { // if the class has no workspaces

						if(weDynList::getWorkspaceFlag($this->Model->LinkID)) {
							$out = we_htmlElement::jsElement(
								$_objFields.
								$this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options.length = 0;
								'. $this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options['.$this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options.length] = new Option("/",0);
								'. $this->editorBodyForm.'.WorkspaceID'.$_prefix.'.selectedIndex = 0;
								//'.$this->editorBodyFrame.'.setVisible("objLinkWorkspace'.$_prefix.'",false);'
							);
							print $out;
						} else {
							print we_htmlElement::jsElement(
								$_objFields.
								$this->editorBodyFrame.'.setVisible("objLinkWorkspace'.$_prefix.'",false);
								'.$this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options.length = 0;
								'. $this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options['.$this->editorBodyForm.'.WorkspaceID'.$_prefix.'.options.length] = new Option("-1",-1);
								'.$this->editorBodyForm.'.LinkID.value = "";
								'.$this->editorBodyForm.'.LinkPath.value = "";
								' . we_message_reporting::getShowMessageCall($l_navigation['no_workspace'], WE_MESSAGE_ERROR) . '
							');
						}
					}
				break;
				case 'populateText':
					if(empty($this->Model->Text) && $this->Model->Selection=='static' && $this->Model->SelectionType=='catLink'){
						include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_category.inc.php');
						$_cat = new we_category();
						$_cat->load($this->Model->LinkID);
						$_cat->Catfields = unserialize($_cat->Catfields);

						if(isset($_cat->Catfields['default']['Title'])){
							print we_htmlElement::jsElement('
								'.
								$this->editorBodyForm.'.Text.value = "'.addslashes($_cat->Catfields['default']['Title']).'";
								'
							);
						}
					}
				break;
				default:
			}
		}

		$_SESSION["navigation_session"]=serialize($this->Model);
	}


	function processVariables() {
		if(isset($_SESSION["navigation_session"])){
			$this->Model=unserialize($_SESSION["navigation_session"]);
		}

		if (defined('CUSTOMER_TABLE')) {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weNavigationCustomerFilter.class.php");



			if (isset($_REQUEST['wecf_mode'])) {

				weNavigationCustomerFilter::translateModeToNavModel($_REQUEST['wecf_mode'], $this->Model);

			}
			$this->Model->Customers = weAbstractCustomerFilter::getSpecificCustomersFromRequest();
			$this->Model->BlackList = weAbstractCustomerFilter::getBlackListFromRequest();
			$this->Model->WhiteList = weAbstractCustomerFilter::getWhiteListFromRequest();
			$this->Model->CustomerFilter = weAbstractCustomerFilter::getFilterFromRequest();
			$this->Model->UseDocumentFilter = weNavigationCustomerFilter::getUseDocumentFilterFromRequest();
		}

		$_categories = array();

		if(isset($_REQUEST['CategoriesControl']) && isset($_REQUEST['CategoriesCount'])){
			for($i=0;$i<$_REQUEST['CategoriesCount'];$i++){
				if(isset($_REQUEST[$_REQUEST['CategoriesControl'] . '_variant0_' . $_REQUEST['CategoriesControl'] . '_item' . $i])){
					$_categories[] = $_REQUEST[$_REQUEST['CategoriesControl'] . '_variant0_' . $_REQUEST['CategoriesControl'] . '_item' . $i];
				}
			}
			$this->Model->Categories = $_categories;
		}

		if(isset($_REQUEST['SortField'])){
			if ($_REQUEST['SortField'] !== "") {
				$this->Model->Sort = array(
					array(
						'field' => $_REQUEST['SortField'],
						'order' => $_REQUEST['SortOrder']
					)
				);
			} else {
				$this->Model->Sort = array();
			}
		}

		if (is_array($this->Model->persistent_slots)) {
			foreach ($this->Model->persistent_slots as $key=>$val) {
				if (isset($_REQUEST[$val])) {
					$this->Model->$val = $_REQUEST[$val];
				}
			}
		}

		if ($this->Model->Selection=='dynamic') {

			if(isset($_REQUEST['WorkspaceIDClass'])) {
				$this->Model->WorkspaceID = $_REQUEST['WorkspaceIDClass'];
			}

			if(isset($_REQUEST['dynamic_Parameter'])) {
				$this->Model->Parameter = $_REQUEST['dynamic_Parameter'];
			}

			if ($this->Model->SelectionType=='category' && isset($_REQUEST['dynamic_Url'])) {
				$this->Model->Url = $_REQUEST['dynamic_Url'];
				$this->Model->UrlID = $_REQUEST['dynamic_UrlID'];
				$this->Model->LinkSelection = $_REQUEST['dynamic_LinkSelection'];
				$this->Model->CatParameter = $_REQUEST['dynamic_CatParameter'];
			}

		}

		if($this->Model->IsFolder==0) {
			$this->Model->Charset = $this->Model->findCharset($this->Model->ParentID | 0);
		}

		if (isset($_REQUEST['previewCode'])) {
			$this->Model->previewCode=$_REQUEST["previewCode"];
		}

		if (isset($_REQUEST["page"])) {

			if($this->Model->IsFolder && $_REQUEST["page"]!=1 && $_REQUEST["page"]!=3) {
				$this->page=1;
			} else {
				$this->page=$_REQUEST["page"];
			}

		}

	}


	function new_array_splice(&$a,$start,$len=1){
		$ks=array_keys($a);
		$k=array_search($start,$ks);
		if($k!==false){
			$ks=array_splice($ks,$k,$len);
			foreach($ks as $k) unset($a[$k]);
		}
	}

	function getItems($id) {

		$_items = array();
		$_db = new DB_WE();

		$_db->query('SELECT ID,Text FROM '.NAVIGATION_TABLE.' WHERE ParentID='.abs($id).' AND Depended=1 ORDER BY Ordn;');
		while($_db->next_record()){
			$_items[$_db->f('ID')] = $_db->f('Text');
		}
		return $_items;
	}


}

?>