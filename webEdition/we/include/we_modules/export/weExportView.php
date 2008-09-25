<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/* the parent class of storagable webEdition classes */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/export.inc.php");
include_once(WE_EXPORT_MODULE_DIR."weExport.php");

class weExportView {

	var $db;
	var $frameset;
	
	var $topFrame;
	var $export;
	
	var $editorBodyFrame;
	var $editorBodyDoc;
	var $editorBodyForm;

	function weExportView($frameset="",$topframe="top.content") {
		$this->db = new DB_WE();
		$this->setFramesetName($frameset);
		$this->setTopFrame($topframe);
		$this->export=new weExport();
	}
	
	//----------- Utility functions ------------------
	
	function htmlHidden($name, $value = "") {
		return we_htmlElement::htmlHidden(array("name"=>trim($name),"value"=>htmlspecialchars($value)));
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
	}	
	
	//------------------------------------------------	
	
	
	function getCommonHiddens($cmds=array()){
		$out=$this->htmlHidden("cmd",(isset($cmds["cmd"]) ? $cmds["cmd"] : ""));
		$out.=$this->htmlHidden("cmdid",(isset($cmds["cmdid"]) ? $cmds["cmdid"] : ""));
		$out.=$this->htmlHidden("pnt", (isset($cmds["pnt"]) ? $cmds["pnt"] : ""));
		$out.=$this->htmlHidden("tabnr",(isset($cmds["tabnr"]) ? $cmds["tabnr"] : ""));
		$out.=$this->htmlHidden("table",(isset($_REQUEST["table"]) ? $_REQUEST["table"] : FILE_TABLE));
		$out.=$this->htmlHidden("ID",(isset($this->export->ID) ? $this->export->ID : '0'));
		$out.=$this->htmlHidden("IsFolder",(isset($this->export->IsFolder) ? $this->export->IsFolder : '0'));
		$out.=$this->htmlHidden("selDocs",(isset($this->export->selDocs) ? $this->export->selDocs : ''));
		$out.=$this->htmlHidden("selTempl",(isset($this->export->selTempl) ? $this->export->selTempl : ''));
		$out.=$this->htmlHidden("selObjs",(isset($this->export->selObjs) ? $this->export->selObjs : ''));
		$out.=$this->htmlHidden("selClasses",(isset($this->export->selClasses) ? $this->export->selClasses : ''));
		
		$out.=$this->htmlHidden("selDocs_open",(isset($_REQUEST["selDocs_open"]) ? $_REQUEST["selDocs_open"] : ''));
		$out.=$this->htmlHidden("selTempl_open",(isset($_REQUEST["selTempl_open"]) ? $_REQUEST["selTempl_open"] : ''));
		$out.=$this->htmlHidden("selObjs_open",(isset($_REQUEST["selObjs_open"]) ? $_REQUEST["selObjs_open"] : ''));
		$out.=$this->htmlHidden("selClasses_open",(isset($_REQUEST["selClasses_open"]) ? $_REQUEST["selClasses_open"] : ''));
		
		return $out;
	}
	
	function getJSTop(){
		global $l_export;
		
		$mod = isset($_REQUEST['mod']) ? $_REQUEST['mod'] : '';
		$title = '';
		foreach($GLOBALS["_we_available_modules"] as $modData){
			if($modData["name"] == $mod){
				$title	= "webEdition " . $GLOBALS["l_global"]["modules"] . ' - ' .$modData["text"];
				break;
			}
		}
		
		$js='
			var get_focus = 1;
			var activ_tab = 1;
			var hot= 0;
			var scrollToVal=0;
			var table = "'.FILE_TABLE.'";
			
			function setHot() {
				hot = "1";
			}
			
			function usetHot() {
				hot = "0";
			}
			
			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			parent.document.title = "'.$title.'";
			
			function we_cmd() {
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
				if(hot == "1" && arguments[0] != "save_export") {
					if(confirm("'.$l_export["save_changed_export"].'")) {
						arguments[0] = "save_export";
					} else {
						top.content.usetHot();
					}
				}
				switch (arguments[0]) {
					case "exit_export":
						if(hot != "1") {
							eval(\'top.opener.top.we_cmd("exit_modules")\');
						}
				        break;
					case "new_export_group":
						'.(!we_hasPerm("NEW_EXPORT")
							? we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR) . 'return;'
							: '').'
						if('.$this->editorBodyFrame.'.loaded) {
							'.$this->editorBodyForm.'.IsFolder.value = 1;
						}
					case "new_export":
						'.(!we_hasPerm("NEW_EXPORT")
							? we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR) . 'return;'
							: '').'
						if('.$this->editorBodyFrame.'.loaded) {
							'.$this->editorBodyForm.'.cmd.value = arguments[0];
							'.$this->editorBodyForm.'.cmdid.value = arguments[1];
							'.$this->editorBodyForm.'.pnt.value = "edbody";
							'.$this->editorBodyForm.'.tabnr.value = 1;
							'.$this->editorBodyFrame.'.submitForm();
						} else {
							setTimeout("we_cmd("+arguments[0]+");", 10);
						}
					break;
					case "delete_export":
						if('.$this->editorBodyForm.'.cmd.value=="home") return;
						'.(!we_hasPerm("DELETE_EXPORT") ?
						(
								print we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR)
						)
						:
						('
								if ('.$this->editorBodyFrame.'.loaded) {
									var message="'.$l_export['delete_question'].'";
									if('.$this->editorBodyForm.'.IsFolder.value=="1") message = "'.$l_export['delete_group_question'].'";

									if (confirm(message)) {
										'.$this->editorBodyForm.'.cmd.value=arguments[0];
										'.$this->editorBodyForm.'.pnt.value = "cmd" ;
										'.$this->editorBodyForm.'.tabnr.value='.$this->topFrame.'.activ_tab;
										'.$this->editorBodyFrame.'.submitForm("cmd");
									}
								} else {
									' . we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["nothing_to_delete"], WE_MESSAGE_ERROR) . '
								}

						')).'
					break;
					case "start_export":
								if('.$this->topFrame.'.hot!=0){
									' . we_message_reporting::getShowMessageCall( $l_export["must_save"], WE_MESSAGE_ERROR ) . '
									break;
								}
								'.(!we_hasPerm("NEW_EXPORT")
									? we_message_reporting::getShowMessageCall( $GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR) . 'return;'
									: ''
								).'
								if ('.$this->topFrame.'.resize.right.editor.edheader.setTab) '.$this->topFrame.'.resize.right.editor.edheader.setActiveTab("tab_3");
								if ('.$this->topFrame.'.resize.right.editor.edheader.setTab) '.$this->topFrame.'.resize.right.editor.edheader.setTab(3);
								if ('.$this->topFrame.'.resize.right.editor.edfooter.doProgress) '.$this->topFrame.'.resize.right.editor.edfooter.doProgress(0);
								if ('.$this->editorBodyFrame.'.clearLog) '.$this->editorBodyFrame.'.clearLog();
								if ('.$this->editorBodyFrame.'.addLog) '.$this->editorBodyFrame.'.addLog("' . addslashes(getPixel(10,10)) . '<br>");
					case "save_export":
						'.(!we_hasPerm("NEW_EXPORT")
							? we_message_reporting::getShowMessageCall( $GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR) . 'return;'
							: ''
						).'
						if('.$this->editorBodyForm.'.cmd.value=="home") return;
						
						if ('.$this->editorBodyFrame.'.loaded) {
										if('.$this->editorBodyForm.'.Text.value==""){
											' . we_message_reporting::getShowMessageCall( $l_export['name_empty'], WE_MESSAGE_ERROR) . '
											return;
										}
										'.$this->editorBodyForm.'.cmd.value=arguments[0];
										'.$this->editorBodyForm.'.pnt.value=arguments[0]=="start_export" ? "load" : "edbody";
										'.$this->editorBodyForm.'.tabnr.value='.$this->topFrame.'.activ_tab;
										if('.$this->editorBodyForm.'.IsFolder.value!=1){
											'.$this->editorBodyForm.'.selDocs.value='.$this->editorBodyFrame.'.SelectedItems["'.FILE_TABLE.'"].join(",");
											'.$this->editorBodyForm.'.selTempl.value='.$this->editorBodyFrame.'.SelectedItems["'.TEMPLATES_TABLE.'"].join(",");
											'.(defined("OBJECT_FILES_TABLE") ? $this->editorBodyForm.'.selObjs.value='.$this->editorBodyFrame.'.SelectedItems["'.OBJECT_FILES_TABLE.'"].join(",");' : '').'
											'.(defined("OBJECT_TABLE") ? $this->editorBodyForm.'.selClasses.value='.$this->editorBodyFrame.'.SelectedItems["'.OBJECT_TABLE.'"].join(",");' : '') . '
						
											'.$this->editorBodyForm.'.selDocs_open.value='.$this->editorBodyFrame.'.openFolders["'.FILE_TABLE.'"];
											'.$this->editorBodyForm.'.selTempl_open.value='.$this->editorBodyFrame.'.openFolders["'.TEMPLATES_TABLE.'"];
											'.(defined("OBJECT_FILES_TABLE") ? $this->editorBodyForm.'.selObjs_open.value='.$this->editorBodyFrame.'.openFolders["'.OBJECT_FILES_TABLE.'"];' : '').'
											'.(defined("OBJECT_TABLE") ? $this->editorBodyForm.'.selClasses_open.value='.$this->editorBodyFrame.'.openFolders["'.OBJECT_TABLE.'"];' : '') . '
										}
										
										'.$this->editorBodyFrame.'.submitForm(arguments[0]=="start_export" ? "cmd" : "edbody");
						} else {
							' . we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["nothing_to_save"], WE_MESSAGE_ERROR) . '
						}
						top.content.usetHot();
					break;

					case "edit_export":
						'.(!we_hasPerm("EDIT_EXPORT")
							? we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR) . 'return;'
							: ''
						).'
						'.$this->topFrame.'.hot=0;
						'.$this->editorBodyForm.'.cmd.value=arguments[0];
						'.$this->editorBodyForm.'.pnt.value="edbody";
						'.$this->editorBodyForm.'.cmdid.value=arguments[1];
						'.$this->editorBodyForm.'.tabnr.value='.$this->topFrame.'.activ_tab;

						'.$this->editorBodyFrame.'.submitForm();
					break;
					case "load":
						'.$this->topFrame.'.cmd.location="'.$this->frameset.'?pnt=cmd&pid="+arguments[1]+"&offset="+arguments[2]+"&sort="+arguments[3];
					break;
					case "home":
						'.$this->editorBodyFrame.'.parent.location="'.$this->frameset.'?pnt=editor";
					break;						
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
						}
						eval("top.opener.top.we_cmd(" + args + ")");
				}
			}
			';
			
			return we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js")).we_htmlElement::jsElement($js); 
	}
	
	function getJSProperty(){
		
		$table = isset($_REQUEST["table"]) ? $_REQUEST["table"] : FILE_TABLE;
		
		$out="";
		$out.=we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js"));
		
		$js = '';
		
		$js='
			var loaded=0;
			var table = "'.$table.'";

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
			function we_cmd() {
				var args = "";
				var url = "'.WEBEDITION_DIR.'we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

				switch (arguments[0]) {
					case "switchPage":					
						document.we_form.cmd.value=arguments[0];
						document.we_form.tabnr.value=arguments[1];
						submitForm();
						break;
					case "openExportDirselector":
						url="/webEdition/we/include/we_modules/export/we_exportDirSelectorFrameset.php?";
						for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}
						new jsWindow(url,"we_exportselector",-1,-1,600,350,true,true,true);
						break;
					case "openCatselector":
						new jsWindow(url,"we_catselector",-1,-1,'.WINDOW_CATSELECTOR_WIDTH.','.WINDOW_CATSELECTOR_HEIGHT.',true,true,true,true);
					break;
					case "openDirselector":
						new jsWindow(url,"we_selector",-1,-1,'.WINDOW_SELECTOR_WIDTH.','.WINDOW_SELECTOR_HEIGHT.',true,true,true,true);
					break;
					case "add_cat":
					case "del_cat":
					case "del_all_cats":
						document.we_form.cmd.value=arguments[0];
						'.$this->editorBodyForm.'.pnt.value="edbody";
						document.we_form.tabnr.value='.$this->topFrame.'.activ_tab;
						document.we_form.cat.value=arguments[1];
						submitForm();
					break;
					default:
						for (var i = 0; i < arguments.length; i++) {
							args += "arguments["+i+"]" + ((i < (arguments.length-1)) ? "," : "");
						}
						eval("'.$this->topFrame.'.we_cmd("+args+")");
				}
			}

			'.$this->getJSSubmitFunction().'
		
		';
		$selected = '';
		$opened = '';
		$arr = array(FILE_TABLE=>"selDocs",TEMPLATES_TABLE=>"selTempl");
		if(defined("OBJECT_TABLE")){
			$arr[OBJECT_FILES_TABLE]="selObjs";
			$arr[OBJECT_TABLE]="selClasses";
		}

		foreach ($arr as $table=>$elem){
			$items = makeArrayFromCSV($this->export->$elem);
			foreach($items as $item){
				$selected .= 'SelectedItems["'.$table.'"].push("'.$item.'");'."\n";
			}
			
			if(isset($_REQUEST[$elem . '_open']) && !empty($_REQUEST[$elem . '_open'])) {
					$opened .= 'openFolders["'.$table.'"]="'.$_REQUEST[$elem . '_open'].'";'."\n"; 
			}		
			
		}		
		
		$js .= '
			function start() {
				' . $selected . $opened . ( $this->export->IsFolder==0 ? '
				setHead(' . $this->editorBodyFrame . '.table);' : '').'
			}
		';
		$out.=we_htmlElement::jsElement($js);
		return $out;
	}



function getJSTreeHeader(){
	return '

			function doUnload() {
				if (!!jsWindow_count) {
					for (i = 0; i < jsWindow_count; i++) {
						eval("jsWindow" + i + "Object.close()");
					}
				}
			}
			
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
			function submitForm() {
				var f = self.document.we_form;
				
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
		global $l_export;
		if (isset($_REQUEST["cmd"])) {
			switch ($_REQUEST["cmd"]) {
				case "new_export":
					if(!we_hasPerm("NEW_EXPORT")) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}else{
						$this->export = new weExport();
						print we_htmlElement::jsElement('
								'.$this->topFrame.'.resize.right.editor.edheader.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->export->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
						');
					}
						
				break;
				case "new_export_group":
					if(!we_hasPerm("NEW_EXPORT")) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}else{					
						$this->export = new weExport();
						$this->export->Text = $l_export['newFolder'];
						$this->export->IsFolder = 1;
						print we_htmlElement::jsElement('
								'.$this->topFrame.'.resize.right.editor.edheader.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->export->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
						');
					}
				break;
				case "edit_export":
					if(!we_hasPerm("EDIT_EXPORT")) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}else{
						$this->export = new weExport($_REQUEST["cmdid"]);
						print we_htmlElement::jsElement('
								'.$this->topFrame.'.hot=0;
								'.$this->topFrame.'.resize.right.editor.edheader.location="'.$this->frameset.'?pnt=edheader&text='.urlencode($this->export->Text).'";
								'.$this->topFrame.'.resize.right.editor.edfooter.location="'.$this->frameset.'?pnt=edfooter";
						');
					}
				break;
				case "save_export":
					if(!we_hasPerm("NEW_EXPORT")) {
						print we_htmlElement::jsElement(
							we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["no_perms"], WE_MESSAGE_ERROR)
						);
						break;
					}else{
						$js="";
						if($this->export->filenameNotValid($this->export->Text)){
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["wrongtext"], WE_MESSAGE_ERROR)
							);
							break;
						}
						// check if filename is valid.
						if( $this->export->exportToFilenameValid($this->export->Filename) ){
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["wrongfilename"], WE_MESSAGE_ERROR)
							);
							break;
						}
						
						if(trim($this->export->Text) == ''){
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["name_empty"], WE_MESSAGE_ERROR)
							);
							break;
						}
						$oldpath = $this->export->Path;
						// set the path and check it
						$this->export->setPath();
						if($this->export->pathExists($this->export->Path)){
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["name_exists"], WE_MESSAGE_ERROR)
							);
							break;
						}
						if($this->export->isSelf()){
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($GLOBALS["l_export"]["path_nok"], WE_MESSAGE_ERROR)
							);
							break;
						}						

					    if($this->export->ParentID>0) {
					    	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php');
					    	$weAcQuery = new weSelectorQuery();
					    	$weAcResult = $weAcQuery->getItemById($this->export->ParentID,EXPORT_TABLE,array("IsFolder"));
					    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
								print we_htmlElement::jsElement(
									we_message_reporting::getShowMessageCall($l_export['path_nok'], WE_MESSAGE_ERROR)
								);
								break;
					    	}
					    }
					    if(isset($this->export->Folder) && !empty($this->export->Folder) && $this->export->ParentID>0) {
					    	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php');
					    	$weAcQuery = new weSelectorQuery();
					    	$weAcResult = $weAcQuery->getItemById($this->export->Folder,FILE_TABLE,array("IsFolder"));
					    	if (!is_array($weAcResult) || $weAcResult[0]['IsFolder']==0) {
								print we_htmlElement::jsElement(
									we_message_reporting::getShowMessageCall($l_export['path_nok'], WE_MESSAGE_ERROR)
								);
								break;
					    	}
					    }
						
						$newone=true;
						if($this->export->ID) $newone=false;

						$this->export->save();

						if($this->export->IsFolder && $oldpath!='' && $oldpath!='/' && $oldpath!=$this->export->Path) {
							$db_tmp = new DB_WE();
							$this->db->query('SELECT ID FROM ' . EXPORT_TABLE . ' WHERE Path LIKE \'' . $oldpath . '%\' AND ID<>\''.$this->export->ID.'\';'); 
							while($this->db->next_record()) {
								$db_tmp->query('UPDATE ' . EXPORT_TABLE . ' SET Path=\'' . $this->export->evalPath($this->db->f("ID")) . '\' WHERE ID=\'' . $this->db->f("ID") . '\';');
							}
						}			

						if ($newone) {
							$js='
									'.$this->topFrame.'.makeNewEntry(\''.$this->export->Icon.'\',\''.$this->export->ID.'\',\''.$this->export->ParentID.'\',\''.$this->export->Text.'\',0,\''.($this->export->IsFolder ? 'folder' : 'item').'\',\''. EXPORT_TABLE .'\');
							'. $this->topFrame.'.drawTree();';
						} else {	
							$js=''.$this->topFrame.'.updateEntry('.$this->export->ID.',"'.$this->export->Text.'","'.$this->export->ParentID.'");'."\n";
						}						
						print we_htmlElement::jsElement($js.'
							'.$this->editorHeaderFrame.'.location.reload();
							' . we_message_reporting::getShowMessageCall(  ($this->export->IsFolder==1 ? $l_export["save_group_ok"] : $l_export["save_ok"]), WE_MESSAGE_NOTICE )
							.$this->topFrame.'.hot=0;
						');
					}
				break;
				case "delete_export":
					if (!we_hasPerm("DELETE_EXPORT")) {
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall($l_export["no_perms"], WE_MESSAGE_ERROR)
						);
						return;
					} else {

						if ($this->export->delete()) {
							print we_htmlElement::jsElement('
									'.$this->topFrame.'.deleteEntry('.$this->export->ID.');
									' . we_message_reporting::getShowMessageCall( ($this->export->IsFolder==1 ? $l_export["delete_group_ok"] : $l_export["delete_ok"]), WE_MESSAGE_NOTICE ) . '
									'.$this->topFrame.'.we_cmd("home");
							');
							$this->export = new weExport();
						} else {
							print we_htmlElement::jsElement(
								we_message_reporting::getShowMessageCall( ($this->export->IsFolder==1 ? $l_export["delete_group_nok"] : $l_export["delete_nok"]), WE_MESSAGE_ERROR )
							);
						}
					}

				break;
				case "start_export":
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLExIm.class.php");					
					weXMLExIm::unsetPerserves();
					$_REQUEST["cmd"] = "do_export";
					$this->export->ExportFilename=($this->export->ExportTo == 'local' ? TMP_DIR . "/" . $this->export->Filename : $_SERVER["DOCUMENT_ROOT"] . $this->export->ServerPath . "/" . $this->export->Filename);
				break;
				default:
			}
		}
		
		$_SESSION["ExportSession"]=serialize($this->export);
	}
	

	function processVariables() {
		
		if(isset($_SESSION["ExportSession"])){
			$this->export=unserialize($_SESSION["ExportSession"]);
		}
		
		if(isset($_SESSION["exportVars"])) unset($_SESSION["exportVars"]);		
				
		if (is_array($this->export->persistent_slots)) {
			foreach ($this->export->persistent_slots as $key=>$val) {
				$varname=$val;				
				if (isset($_REQUEST[$varname])) {
					eval('$this->export->'.$val.'="'.addslashes($_REQUEST[$varname]).'";');
				}
			}
		}
				
		if(isset($_REQUEST["page"]))
		if (isset($_REQUEST["page"])) {
			$this->page=$_REQUEST["page"];
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
	

}

?>