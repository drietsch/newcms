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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_folder.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_temporaryDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once(WE_OBJECT_MODULE_DIR . "we_searchobject_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weSuggest.class.inc.php");

$yuiSuggest =& weSuggest::getInstance();

/* a class for handling templates */
class we_class_folder extends we_folder
{

	//######################################################################################################################################################
	//##################################################################### Variables ######################################################################
	//######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_class_folder";

	var $EditPageNrs = array(WE_EDITPAGE_CFWORKSPACE,WE_EDITPAGE_FIELDS);//,WE_EDITPAGE_CFSEARCH);
	var $Icon = "class_folder.gif";
	var $IsClassFolder = "1";
	var $InWebEdition = false;
	var $searchclass;
	var $searchclass_class;

	var $GreenOnly = 0;
	var $Order = "OF_Path";
	var $Search="";
	var $SearchField="";
	var $SearchStart = 0;
	/* Constructor */
	function we_class_folder(){
		$this->we_folder();
		array_push($this->persistent_slots,"searchclass","searchclass_class");


	}

	function we_initSessDat($sessDat){
		we_folder::we_initSessDat($sessDat);
		if(isset($this->searchclass_class) && !is_object($this->searchclass_class)){
		    $this->searchclass_class=unserialize($this->searchclass_class);

		} else if(isset($_SESSION['we_objectSearch'][$this->ID])) {
			$temp = unserialize($_SESSION['we_objectSearch'][$this->ID]);
		    $this->searchclass_class=unserialize($temp['Serialized']);
			$this->SearchStart = $temp['SearchStart'];
			$this->GreenOnly = $temp['GreenOnly'];
			$this->EditPageNr = $temp['EditPageNr'];
			$this->Order = $temp['Order'];
		}

		if(is_object($this->searchclass_class)){
			$this->searchclass=$this->searchclass_class;
		}else{
			$this->searchclass = new objectsearch();
			$this->searchclass_class=serialize($this->searchclass);
		}

		if(empty($this->EditPageNr)){
			$this->EditPageNr = WE_EDITPAGE_CFWORKSPACE;
		}

	}

	function we_save() {
		parent::we_save();
		return true;
	}

	function initByPath($path,$tblName=FILE_TABLE,$IsClassFolder=0,$IsNotEditable=0){
		$id = f("SELECT ID FROM ".$tblName." WHERE Path='$path' AND IsFolder=1","ID",$this->DB_WE);
		if($id != ""){
			$this->initByID($id);
		}else{
			## Folder does not exist, so we have to create it (if user has permissons to create folders)

			$spl = explode("/",$path);
			$folderName = array_pop($spl);
			$p = array();
			$anz = sizeof($spl);
			$last_pid = 0;
			for($i=0;$i<$anz;$i++){
				array_push($p,array_shift($spl));
				$pa = implode("/",$p);
				if($pa){
					$pid = f("SELECT ID FROM ".$tblName." WHERE Path='$pa'","ID",new DB_WE());
					if(!$pid){
						$folder = new we_folder();
						$folder->init();
						$folder->Table = $tblName;
						$folder->ParentID=$last_pid;
						$folder->Text = $p[$i];
						$folder->Filename = $p[$i];
						$folder->IsNotEditable = $IsClassFolder;
						$folder->ClassName=($IsClassFolder)?"we_class_folder":"we_folder";

						$this->IsClassFolder=$IsClassFolder;
						$folder->Path=$pa;
						$folder->save();
						$last_pid = $folder->ID;
					}else{
						$last_pid = $pid;
					}

				}
			}
			$this->init();
			$this->Table = $tblName;
			$this->ClassName=($IsClassFolder)?"we_class_folder":"we_folder";
			$this->IsClassFolder=$IsClassFolder;
			$this->Icon = $IsClassFolder ? "class_folder.gif" : "folder.gif";

			$this->ParentID=$last_pid;
			$this->Text = $folderName;
			$this->Filename = $folderName;
			$this->Path=$path;
			$this->IsNotEditable=$IsNotEditable;
			$this->save();
		}
		return true;

	}


	/* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
	function editor(){

		switch($this->EditPageNr){
			case WE_EDITPAGE_CFWORKSPACE:
			    return "we_modules/object/we_classFolder_properties.inc.php";
			    break;
			case WE_EDITPAGE_FIELDS:
			    return "we_modules/object/we_classFolder_fields.inc.php";
			    break;
			case WE_EDITPAGE_WEBUSER:
				return "we_modules/customer/editor_weDocumentCustomerFilter.inc.php";
				break;
			/*
			case WE_EDITPAGE_CFSEARCH:
			    return "we_modules/object/we_classFolder_search.inc.php";
			    break;
			*/
			default:
			    $this->EditPageNr = WE_EDITPAGE_CFWORKSPACE;
			    $_SESSION["EditPageNr"] = WE_EDITPAGE_CFWORKSPACE;
			    return "we_modules/object/we_classFolder_properties.inc.php";
		}
	}

	function getUserDefaultWsPath(){

		$userWSArray = makeArrayFromCSV(get_ws());

		$userDefaultWsID = sizeof($userWSArray) ? $userWSArray[0] : 0;
		if(abs($userDefaultWsID) != 0){
			$userDefaultWsPath = id_to_path($userDefaultWsID,FILE_TABLE,$GLOBALS["DB_WE"]);
		}else{
			$userDefaultWsPath = "/";
		}

		return $userDefaultWsPath;

	}


	function searchProperties() {

		$DB_WE = new DB_WE();

		if (!isset($_REQUEST['Order'])) {
			if(isset($this->Order)) {
				$_REQUEST['Order'] = $this->Order;
			} else {
				$_REQUEST['Order'] = 'ModDate DESC';
			}
		} else {
			$this->searchclass->Order = $_REQUEST["Order"];
		}
		$this->Order = $_REQUEST["Order"];

		if(isset($_POST["SearchStart"])){
			$this->searchclass->searchstart = $_POST["SearchStart"];
		}

		if(isset($_REQUEST["Anzahl"])){
			$this->searchclass->anzahl = $_REQUEST["Anzahl"];
		}

		//$this->searchclass->setlimit(1);
		$we_obectPathLength = 32;

		if(!isset($javascript)) {
			$javascript = "";
		}

		//$this->searchclass->setlimit(2);
		$we_wsLength = 26;
		$we_extraWsLength = 26;

		$userWSArray = makeArrayFromCSV(get_ws());

		$userDefaultWsID = sizeof($userWSArray) ? $userWSArray[0] : 0;
		if(abs($userDefaultWsID) != 0){
			$userDefaultWsPath = id_to_path($userDefaultWsID,FILE_TABLE,$DB_WE);
		}else{
			$userDefaultWsPath = "/";
		}

		// get Class
		$classArray = getHash("SELECT * FROM " . OBJECT_TABLE . " WHERE Path='".$this->Path."'",$DB_WE);

		$userDefaultWsPath = $this->getUserDefaultWsPath();
		$this->WorkspacePath = ($this->WorkspacePath != "") ? $this->WorkspacePath : $userDefaultWsPath;
		$this->WorkspaceID = ($this->WorkspaceID != "") ? $this->WorkspaceID : $userDefaultWsID;

		if(isset($this->searchclass->searchname) ){
			$where = "1 ".$this->searchclass->searchfor($this->searchclass->searchname,$this->searchclass->searchfield,$this->searchclass->searchlocation,OBJECT_X_TABLE.$classArray["ID"],$rows=-1,$start=0,$order="",$desc=0);
			$where .= $this->searchclass->greenOnly($this->GreenOnly,$this->WorkspaceID,$classArray["ID"]);
		} else {
			$where = "1".$this->searchclass->greenOnly($this->GreenOnly,$this->WorkspaceID,$classArray["ID"]);
		}

		$this->searchclass->settable(OBJECT_X_TABLE.$classArray["ID"].", ".OBJECT_FILES_TABLE);
		$this->searchclass->setwhere($where.' AND '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ID !=0 AND '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ID = '.OBJECT_FILES_TABLE.'.ID');
		$foundItems = $this->searchclass->countitems();

		//$this->searchclass->setorder($z);
		//$this->searchclass->setstart(1);

		$this->searchclass->searchquery($where.' AND '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ID !=0 AND '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ID = '.OBJECT_FILES_TABLE.'.ID' , OBJECT_X_TABLE.$classArray["ID"].'.ID, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_Text, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ID, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_Path, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ParentID, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_Workspaces, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ExtraWorkspaces, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_ExtraWorkspacesSelected, '.OBJECT_X_TABLE.$classArray["ID"].'.OF_Published, '.OBJECT_FILES_TABLE.'.ModDate');


		$content=array();
		$foo = unserialize(f("SELECT DefaultValues FROM "  . OBJECT_TABLE . " WHERE ID='".$classArray["ID"]."'","DefaultValues",$DB_WE));

		$ok = isset($foo["WorkspaceFlag"]) ? $foo["WorkspaceFlag"] : "";

		$javascriptAll = "";
		if($foundItems){

			$f=0;
			while($this->searchclass->next_record()){

				$content[$f][1]["align"]="center"; $content[$f][1]["height"]=35;
				$content[$f][0]["align"]="center";

				if((we_hasPerm("DELETE_OBJECTFILE") || we_hasPerm("NEW_OBJECTFILE")) && checkIfRestrictUserIsAllowed($this->searchclass->f("OF_ID"),OBJECT_FILES_TABLE)){
					$content[$f][0]["dat"] = '<input type="checkbox" name="weg'.$this->searchclass->f("ID").'">';
				} else {
					$content[$f][0]["dat"] = '<img src="'.TREE_IMAGE_DIR.'check0_disabled.gif">';
				}

				$javascriptAll .= "var flo=document.we_form.elements['weg".$this->searchclass->f("ID")."'].checked=true;";

				if($this->searchclass->f("OF_Published") && (((in_workspace($this->WorkspaceID,$this->searchclass->f("OF_Workspaces")) && $this->searchclass->f("OF_Workspaces")!="") || (in_workspace($this->WorkspaceID,$this->searchclass->f("OF_ExtraWorkspacesSelected")) && $this->searchclass->f("OF_ExtraWorkspacesSelected")!="" ) ) || ($this->searchclass->f("OF_Workspaces")=="" && $ok))){
					$content[$f][1]["dat"] = '<img src="'.IMAGE_DIR.'we_boebbel_blau.gif" width="16" height="18">';
				} else {
					$content[$f][1]["dat"] = '<img src="'.IMAGE_DIR.'we_boebbel_grau.gif" width="16" height="18">';
				}
				$content[$f][2]["dat"] = '<a href="javascript:top.weEditorFrameController.openDocument(\'' . OBJECT_FILES_TABLE . '\','.$this->searchclass->f("OF_ID").',\'objectFile\');" style="text-decoration:none" class="middlefont" title="'.$this->searchclass->f("OF_Path").'">'.shortenPath($this->searchclass->f("OF_Text"),$we_obectPathLength);
				$content[$f][3]["dat"] = $this->searchclass->getWorkspaces(makeArrayFromCSV($this->searchclass->f("OF_Workspaces")),$we_wsLength);
				$content[$f][4]["dat"] = $this->searchclass->getExtraWorkspace(makeArrayFromCSV($this->searchclass->f("OF_ExtraWorkspaces")),$we_extraWsLength,$classArray["ID"],$userWSArray);
				$content[$f][5]["dat"] = '<nobr>'.($this->searchclass->f("OF_Published") ? date($GLOBALS['l_global']["date_format"],$this->searchclass->f("OF_Published")) : "-").'</nobr>';
				$content[$f][6]["dat"] = '<nobr>'.($this->searchclass->f("ModDate") ? date($GLOBALS['l_global']["date_format"],$this->searchclass->f("ModDate")) : "-").'</nobr>';

				$f++;
			}

		} else {
			//echo "Leider nichts gefunden!";
		}

		$headline[0]["dat"] = "";
		$headline[1]["dat"] = $GLOBALS['l_object_classfoldersearch']["zeige"];
		$headline[2]["dat"] = '<a href="javascript:setOrder(\'OF_Path\');">'.$GLOBALS['l_object_classfoldersearch']["Objekt"] . '</a> ' . $this->getSortImage('OF_Path');
		$headline[3]["dat"] = $GLOBALS['l_object_classfoldersearch']["Arbeitsbereiche"];
		$headline[4]["dat"] = $GLOBALS['l_object_classfoldersearch']["xtraArbeitsbereiche"];
		$headline[5]["dat"] = '<a href="javascript:setOrder(\'OF_Published\');">'.$GLOBALS['l_object_classfoldersearch']["Veroeffentlicht"].'</a> ' . $this->getSortImage('OF_Published');
		$headline[6]["dat"] = '<a href="javascript:setOrder(\'ModDate\');">'.$GLOBALS['l_object_classfoldersearch']["geaendert"].'</a> ' . $this->getSortImage('ModDate');

		return $this->getSearchresult($content, $headline, $foundItems, $javascriptAll);

	}


	function searchFields() {

		$DB_WE = new DB_WE();

		if (!isset($_REQUEST['Order'])) {
			if(isset($this->Order)) {
				$_REQUEST['Order'] = $this->Order;
			} else {
				$_REQUEST['Order'] = 'OF_PATH';
			}
		} else {
			if(eregi("^ModDate", $_REQUEST['Order']) || eregi("^OF_Published", $_REQUEST['Order'])) {
				$_REQUEST['Order'] = 'OF_PATH';
			}
			$this->searchclass->Order = $_REQUEST["Order"];
		}
		$this->Order = $_REQUEST["Order"];


		if(isset($_POST["SearchStart"])){
			$this->searchclass->searchstart=$_POST["SearchStart"];
		}

		if(isset($_REQUEST["Anzahl"])){
			$this->searchclass->anzahl=$_REQUEST["Anzahl"];
		}

		//$this->searchclass->setlimit(1);
		$we_obectPathLength = 32;
		$values = array(10=>10,25=>25,50=>50,100=>100);
		$strlen = 20;

		// get Class
		$classArray = getHash("SELECT * FROM " . OBJECT_TABLE . " WHERE Path='".$this->Path."'",$DB_WE);

		if(isset($_REQUEST["do"]) && $_REQUEST["do"]=="delete"){
			foreach(array_keys($_REQUEST) as $f){
				if(substr($f,0,3)=="weg"){
					//$this->query("");
					$DB_WE->query("SELECT OF_ID FROM ". OBJECT_X_TABLE . $classArray["ID"]." where ID=".substr($f,3));
					$DB_WE->next_record();
					$ofid = $DB_WE->f("OF_ID");

					if(checkIfRestrictUserIsAllowed($ofid,OBJECT_FILES_TABLE)){
						$DB_WE->query("DELETE FROM " . OBJECT_X_TABLE . $classArray["ID"]." where ID=".substr($f,3));

						$DB_WE->query("DELETE FROM " . INDEX_TABLE . " where OID=".$ofid);
						$DB_WE->query("DELETE FROM ".OBJECT_FILES_TABLE." where ID=".$ofid);
						we_temporaryDocument::delete($ofid);
					}
				}
			}
		}

		$userWSArray = makeArrayFromCSV(get_ws());

		$userDefaultWsID = sizeof($userWSArray) ? $userWSArray[0] : 0;
		if(abs($userDefaultWsID) != 0){
			$userDefaultWsPath = id_to_path($userDefaultWsID,FILE_TABLE,$DB_WE);
		} else {
			$userDefaultWsPath = "/";
		}

		$fields = "*";

		$userDefaultWsPath = $this->getUserDefaultWsPath();
		$this->WorkspacePath = ($this->WorkspacePath != "") ? $this->WorkspacePath : $userDefaultWsPath;
		$this->WorkspaceID = ($this->WorkspaceID != "") ? $this->WorkspaceID : $userDefaultWsID;

		if(isset($this->searchclass->searchname) ){
			$where = "1".$this->searchclass->searchfor($this->searchclass->searchname,$this->searchclass->searchfield,$this->searchclass->searchlocation,OBJECT_X_TABLE.$classArray["ID"],$rows=-1,$start=0,$order="",$desc=0);
			$where .= $this->searchclass->greenOnly($this->GreenOnly,$this->WorkspaceID,$classArray["ID"]);
		} else {
			$where = "1".$this->searchclass->greenOnly($this->GreenOnly,$this->WorkspaceID,$classArray["ID"]);
		}

		$this->searchclass->settable(OBJECT_X_TABLE.$classArray["ID"]);
		$this->searchclass->setwhere($where." AND OF_ID !=0 ");

		$foundItems = $this->searchclass->countitems();

		//$this->searchclass->setorder($z);
		//$this->searchclass->setstart(1);

		$this->searchclass->searchquery($where." AND OF_ID !=0 ",$fields);

		$DB_WE->query("SELECT DefaultValues FROM " . OBJECT_TABLE . " a,".OBJECT_FILES_TABLE." c WHERE a.Text=c.Text AND c.ID=".$this->ID);
		$DB_WE->next_record();
		$DefaultValues = unserialize($DB_WE->f("DefaultValues"));

		$content=array();
		$foo = unserialize(f("SELECT DefaultValues FROM " . OBJECT_TABLE . " WHERE ID='".$classArray["ID"]."'","DefaultValues",$DB_WE));

		$ok = isset($foo["WorkspaceFlag"]) ? $foo["WorkspaceFlag"] : "";

		$javascriptAll = "";

		if($foundItems){

			$f=0;
			while($this->searchclass->next_record()) {
				/*
				$out .= "<pre>".sizeof($this->searchclass->Record);
				print_r($this->searchclass->Record);
				$out .= "</pre>";
				*/
				if($f==0){
					 $i=0;

					 while(list($key, $val) = each($this->searchclass->Record)){

							if(ereg('^(.+)_(.+)$',$key,$regs)){
								if($regs[1]!="OF"){
									if($regs[1]=="object"){
										$object[$i+3]=$regs[2];
										$headline[$i+3]["dat"] = '<table border="0" cellpadding="0" cellspacing="0" class="defaultfont"><tr><td>' . f("SELECT Text FROM " . OBJECT_TABLE . " WHERE ID='".$regs[2]."'","Text",$DB_WE) . '</td><td></td></tr></table>';
										$type[$i+3]=$regs[1];
										$i++;
									} elseif($regs[1]=="multiobject"){
										$headline[$i+3]["dat"] = '<table border="0" cellpadding="0" cellspacing="0" class="defaultfont"><tr><td>'.$regs[2].'</td><td></td></tr></table>';
										$head[$i+3]["dat"] = $regs[2];
										$type[$i+3]=$regs[1];
										$i++;
									}else{
										$headline[$i+3]["dat"] = '<table border="0" cellpadding="0" cellspacing="0" class="defaultfont"><tr><td><a href="javascript:setOrder(\''.$key.'\');">'.$regs[2].'</a></td><td> ' . $this->getSortImage($key) . '</td></tr></table>';
										$head[$i+3]["dat"] = $regs[2];
										$type[$i+3]=$regs[1];
										$i++;
									}
								}
							}

					}

					$count = $i;
				}

				$content[$f][1]["align"]="center";
				$content[$f][0]["height"]=35;
				$content[$f][0]["align"]="center";
				if(we_hasPerm("DELETE_OBJECTFILE")){
					$content[$f][0]["dat"] = '<input type="checkbox" name="weg'.$this->searchclass->f("ID").'">';
				}else{
					$content[$f][0]["dat"] = '<img src="'.TREE_IMAGE_DIR.'check0_disabled.gif">';
				}
				$javascriptAll .= "var flo=document.we_form.elements['weg".$this->searchclass->f("ID")."'].checked=true;";

				if($this->searchclass->f("OF_Published") && (((in_workspace($this->WorkspaceID,$this->searchclass->f("OF_Workspaces")) && $this->searchclass->f("OF_Workspaces")!="") || (in_workspace($this->WorkspaceID,$this->searchclass->f("OF_ExtraWorkspacesSelected")) && $this->searchclass->f("OF_ExtraWorkspacesSelected")!="" ) ) || ($this->searchclass->f("OF_Workspaces")=="" && $ok))){
					$content[$f][1]["dat"] = '<img src="'.IMAGE_DIR.'we_boebbel_blau.gif" width="16" height="18">';
				}else{
					$content[$f][1]["dat"] = '<img src="'.IMAGE_DIR.'we_boebbel_grau.gif" width="16" height="18">';
				}

				$content[$f][2]["dat"] = '<a href="javascript:top.weEditorFrameController.openDocument(\''.OBJECT_FILES_TABLE.'\','.$this->searchclass->f("OF_ID").',\'objectFile\');" style="text-decoration:none" class="defaultfont" title="'.$this->searchclass->f("OF_Path").'">'.shortenPath($this->searchclass->f("OF_Text"),$we_obectPathLength);

				for($i=0;$i<$count;$i++){
					if($type[$i+3]=="date"){
						$content[$f][$i+3]["dat"] = date($GLOBALS['l_global']["date_format"],$this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]));
					}else if($type[$i+3]=="object"){
						$tmp = f("SELECT OF_Path FROM " . OBJECT_X_TABLE.$object[$i+3]." WHERE OF_ID='".$this->searchclass->f($type[$i+3]."_".$object[$i+3])."'","OF_Path",$DB_WE);
						if($tmp != "") {
							$obj = '<a href="javascript:top.weEditorFrameController.openDocument(\''.OBJECT_FILES_TABLE.'\','.$this->searchclass->f($type[$i+3]."_".$object[$i+3]).',\'objectFile\');" style="text-decoration:none" class="defaultfont" title="'.$tmp.'">'.shortenPath(f("SELECT OF_Path FROM " . OBJECT_X_TABLE.$object[$i+3]." WHERE OF_ID='".$this->searchclass->f($type[$i+3]."_".$object[$i+3])."'","OF_Path",$DB_WE),$we_obectPathLength).'</a>';
						} else {
							$obj = "&nbsp;";
						}
						$content[$f][$i+3]["dat"] = $obj;
					}else if($type[$i+3]=="multiobject"){
						$temp = unserialize($this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]));
						if(is_array($temp['objects']) && sizeof($temp['objects'])>0) {
							$objects = $temp['objects'];
							$class = $temp['class'];
							$content[$f][$i+3]["dat"] = "";
							foreach($objects as $idx => $id) {
								$content[$f][$i+3]["dat"] .= '<a href="javascript:top.weEditorFrameController.openDocument(\''.OBJECT_FILES_TABLE.'\','.$id.',\'objectFile\');" style="text-decoration:none" class="defaultfont" title="'.f("SELECT OF_Path FROM " . OBJECT_X_TABLE.$class." WHERE OF_ID='".$id."'","OF_Path",$DB_WE).'">'.shortenPath(f("SELECT OF_Path FROM " . OBJECT_X_TABLE.$class." WHERE OF_ID='".$id."'","OF_Path",$DB_WE),$we_obectPathLength)."<br />";//
							}
						} else {
							$content[$f][$i+3]["dat"] = "-";
						}
					}else if($type[$i+3]=="checkbox"){
						$text = $this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]);
						$content[$f][$i+3]["dat"] = ($text == "1" ? $GLOBALS["l_global"]["yes"]  : $GLOBALS["l_global"]["no"] );
					}else if($type[$i+3]=="meta"){
						if(		$this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]) != ""
							&& 	isset($DefaultValues[$type[$i+3]."_".$head[$i+3]["dat"]]["meta"][$this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"])])) {
							$text = $DefaultValues[$type[$i+3]."_".$head[$i+3]["dat"]]["meta"][$this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"])];
							$content[$f][$i+3]["dat"] = (strlen($text)>$strlen)?substr($text,0,$strlen)." ...":$text;
						} else {
							$content[$f][$i+3]["dat"] = "&nbsp;";
						}
					}else if($type[$i+3]=="link"){
						$text = $this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]);
						$content[$f][$i+3]["dat"] = we_document::getFieldByVal($text,"link");
					}else if($type[$i+3]=="href"){
						$text = $this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]);
						$hrefArr = $text ? unserialize($text) : array();
						if(!is_array($hrefArr)) $hrefArr= array();

						$content[$f][$i+3]["dat"] = we_document::getHrefByArray($hrefArr);
						//$text = $DefaultValues[$type[$i+3]."_".$head[$i+3]["dat"]]["meta"][$this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"])];
						//$content[$f][$i+3]["dat"] = "TEST";
					}else{
						$text = strip_tags($this->searchclass->f($type[$i+3]."_".$head[$i+3]["dat"]));
						$content[$f][$i+3]["dat"] = (strlen($text)>$strlen)?substr($text,0,$strlen)." ...":$text;
					}
				}

				$f++;
			}


		}else{
			//$out .= "Leider nichts gefunden!";
		}
		$headline[0]["dat"] = "";
		$headline[1]["dat"] = '<table border="0" cellpadding="0" cellspacing="0" class="defaultfont"><tr><td>' . $GLOBALS['l_object_classfoldersearch']["zeige"] . '</td><td></td></tr></table>';
		$headline[2]["dat"] = '<table border="0" cellpadding="0" cellspacing="0" class="defaultfont"><tr><td><a href="javascript:setOrder(\'OF_Path\');">' . $GLOBALS['l_object_classfoldersearch']["Objekt"] . '</a></td><td> ' . $this->getSortImage('OF_Path') . '</td></tr></table>';

		return $this->getSearchresult($content, $headline, $foundItems, $javascriptAll);

	}


	function getSearchDialog() {

		$we_button = new we_button();

		$DB_WE = new DB_WE();

		$out =	'
				<table cellpadding="2" cellspacing="0" border="0" width="510">
				<form name="we_form_search"  onSubmit="sub();return false;" methode="GET">
				'.$this->HiddenTrans().'
				<input type="hidden" name="todo">
				<input type="hidden" name="position">';

		for($i=0;$i <= $this->searchclass->height ;$i++){
			
			if($i==0) {
				$button = getPixel(26,10);
			}
			else {
				$button = $we_button->create_button("image:btn_function_trash", "javascript:del(".$i.");", true, 26, 22, "", "", false);
			}

			if(isset($this->searchclass->objsearchField) && is_array($this->searchclass->objsearchField) && isset($this->searchclass->objsearchField[$i]) && (substr($this->searchclass->objsearchField[$i],0,4)=="meta" || substr($this->searchclass->objsearchField[$i],0,8)=="checkbox")) {
				$DB_WE->query("SELECT DefaultValues FROM " . OBJECT_TABLE . " a," . OBJECT_FILES_TABLE . " c WHERE a.Text=c.Text AND c.ID=".$this->ID);
				$DB_WE->next_record();
				$DefaultValues = unserialize($DB_WE->f("DefaultValues"));

				if(substr($this->searchclass->objsearchField[$i],0,4)=="meta") {
					$values = $DefaultValues[$this->searchclass->objsearchField[$i]]["meta"];
				} else {
					$values = array(
						0 => $GLOBALS['l_global']['no'],
						1 => $GLOBALS['l_global']['yes'],
					);
				}

				$out .= '
				<tr>
					<td class="defaultfont">'.$GLOBALS['l_global']["search"].'</td>
					<td width="50">'.getPixel(5,2).'</td>
					<td>'.$this->searchclass->getFields("objsearchField[".$i."]",1,$this->searchclass->objsearchField[$i],$this->Path).'</td>
					<td>'.getPixel(10,2).'</td>
					<td width="50">'.$this->searchclass->getLocationMeta("objlocation[".$i."]", (isset($this->searchclass->objlocation[$i]) ? $this->searchclass->objlocation[$i] : '') ).'</td>
					<td>'.getPixel(10,2).'</td>
					<td>'.htmlSelect('objsearch['.$i.']',$values,1,$this->searchclass->objsearch[$i],false,"","value").'</td>
					<td>'.getPixel(10,2).'</td>
					<td align="right">'.$button.'</td>
				</tr>';

			} elseif(isset($this->searchclass->objsearchField) && is_array($this->searchclass->objsearchField) && isset($this->searchclass->objsearchField[$i]) && substr($this->searchclass->objsearchField[$i],0,4)=="date") {
				$DB_WE->query("SELECT DefaultValues FROM " . OBJECT_TABLE . " a," . OBJECT_FILES_TABLE . " c WHERE a.Text=c.Text AND c.ID=".$this->ID);
				$DB_WE->next_record();
				$DefaultValues = unserialize($DB_WE->f("DefaultValues"));

				$month = array();
				$month[''] = "";
				for($j = 1; $j <= 12; $j++) {
					if($j < 10) {
						$month[$j] = "0".$j;
					} else {
						$month[$j] = $j;
					}
				}

				$day = array();
				$day[''] = "";
				for($j = 1; $j <= 31; $j++) {
					if($j < 10) {
						$day[$j] = "0".$j;
					} else {
						$day[$j] = $j;
					}
				}

				$hour = array();
				$hour[''] = "";
				for($j = 0; $j <= 23; $j++) {
					if($j < 10) {
						$hour[$j] = "0".$j;
					} else {
						$hour[$j] = $j;
					}
				}

				$minute = array();
				$minute[''] = "";
				for($j = 0; $j <= 59; $j++) {
					if($j < 10) {
						$minute[$j] = "0".$j;
					} else {
						$minute[$j] = $j;
					}
				}

				$out .= '
				<tr>
					<td class="defaultfont">'.$GLOBALS['l_global']["search"].'</td>
					<td>'.getPixel(5,2).'</td>
					<td>'.$this->searchclass->getFields("objsearchField[".$i."]",1,$this->searchclass->objsearchField[$i],$this->Path).'</td>
					<td>'.getPixel(10,2).'</td>
					<td>'.$this->searchclass->getLocationDate("objlocation[".$i."]", (isset($this->searchclass->objlocation[$i]) ? $this->searchclass->objlocation[$i] : '') ).'</td>
					<td>'.getPixel(10,2).'</td>
					<td>
						'.htmlTextInput('objsearch['.$i.'][year]', 4, (isset($this->searchclass->objsearch) && is_array($this->searchclass->objsearch) && isset($this->searchclass->objsearch[$i]['year']) ? $this->searchclass->objsearch[$i]['year'] : date("Y") ), 4).' -
						'.htmlSelect('objsearch['.$i.'][month]',$month,1,(isset($this->searchclass->objsearch) && is_array($this->searchclass->objsearch) && isset($this->searchclass->objsearch[$i]['month']) ? $this->searchclass->objsearch[$i]['month'] : date("m") )).' -
						'.htmlSelect('objsearch['.$i.'][day]',$day,1,(isset($this->searchclass->objsearch) && is_array($this->searchclass->objsearch) && isset($this->searchclass->objsearch[$i]['day']) ? $this->searchclass->objsearch[$i]['day'] : date("d") )).' &nbsp;
						'.htmlSelect('objsearch['.$i.'][hour]',$hour,1,(isset($this->searchclass->objsearch) && is_array($this->searchclass->objsearch) && isset($this->searchclass->objsearch[$i]['hour']) ? $this->searchclass->objsearch[$i]['hour'] : date("H") )).' :
						'.htmlSelect('objsearch['.$i.'][minute]',$minute,1,(isset($this->searchclass->objsearch) && is_array($this->searchclass->objsearch) && isset($this->searchclass->objsearch[$i]['minute']) ? $this->searchclass->objsearch[$i]['minute'] : date("i") )).'
					</td>
					<td>'.getPixel(10,2).'</td>
					<td align="right">'.$button.'</td>
				</tr>';

			} else {
				$out .= '
				<tr>
					<td class="defaultfont">'.$GLOBALS['l_global']["search"].'</td>
					<td>'.getPixel(1,2).'</td>
					<td>'.$this->searchclass->getFields("objsearchField[".$i."]",1, (isset($this->searchclass->objsearchField) && is_array($this->searchclass->objsearchField) && isset($this->searchclass->objsearchField[$i]) ? $this->searchclass->objsearchField[$i] : "" ),$this->Path).'</td>
					<td>'.getPixel(1,2).'</td>
					<td>'.$this->searchclass->getLocation("objlocation[".$i."]", (isset($this->searchclass->objlocation[$i]) ? $this->searchclass->objlocation[$i] : '') ).'</td>
					<td>'.getPixel(1,2).'</td>
					<td>'.htmlTextInput("objsearch[".$i."]",30,(isset($this->searchclass->objsearch) && is_array($this->searchclass->objsearch) && isset($this->searchclass->objsearch[$i]) ? $this->searchclass->objsearch[$i] : '' ),"","","text",200).'</td>
					<td>'.getPixel(1,2).'</td>
					<td align="right">'.$button.'</td>
				</tr>';
			}

		}

		$out .= '
				<tr>
					<td colspan="9"><br></td>
				</tr>
				<tr>
					<td colspan="2"></td>
					<td colspan="3">' . $we_button->create_button("add", "javascript:newinput();") . '</td>
					<td colspan="4" align="right">'.$we_button->create_button("search", "javascript:sub();").'</td>
				</tr>
				</form>
				</table>';

		return $out;

	}


	function getSearchresult($content, $headline, $foundItems, $javascriptAll) {
		$yuiSuggest =& weSuggest::getInstance();
		$we_button = new we_button();

		$out = "";

		$values = array(10=>10,25=>25,50=>50,100=>100);


		// JS einbinden
		$out .= $this->searchclass->getJSinWEsearchobj($this->Name);

		$out .= '
		<form name="we_form" method="post">
		'.$this->hiddenTrans().'
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="defaultgray">'.$GLOBALS['l_object_classfoldersearch']["Verzeichnis"].'</td>
			<td colspan="3">'.$this->formDirChooser(388,0,FILE_TABLE,"WorkspacePath","WorkspaceID","opener.we_cmd(\\'reload_editpage\\');",false).'</td>
		</tr>
		<tr>
			<td colspan="4">'.getPixel(18,12).'</td>
		</tr>
		<tr>
			<td class="defaultgray">'.$GLOBALS['l_object_classfoldersearch']["Ansicht"].'</td>
			<td>'.htmlSelect("Anzahl",$values,1,$this->searchclass->anzahl,"",'onChange=\'this.form.elements["SearchStart"].value=0;we_cmd("reload_editpage");\'');

		$out .= hidden("Order",$this->searchclass->Order);
		$out .= hidden("do","");

		$out .=  '</td>
			<td>&nbsp;</td>
			<td>'.we_forms::checkboxWithHidden($this->GreenOnly==1 ? true : false, "we_".$this->Name."_GreenOnly", $GLOBALS['l_object_classfoldersearch']["sicht"],false,"defaultfont","toggleShowVisible(document.getElementById('_we_".$this->Name."_GreenOnly'));").'</td>
		</tr>';

		$out .= '
		<tr>
			<td>'.getPixel(128,20).'</td>
			<td>'.getPixel(40,15).'</td>
			<td>'.getPixel(10,15).'</td>
			<td>'.getPixel(350,15).'</td>
		</tr>
		</table>
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="defaultgray">';

		if(isset($this->searchclass->searchname)){
			$out .= $GLOBALS['l_object_classfoldersearch']["teilsuche"];
		}

		$out .= '</td>
			<td align="right">'.$this->searchclass->getNextPrev($foundItems).'</td>
		</tr>
		<tr>
			<td>'.getPixel(175,12).'</td>
			<td>'.getPixel(460,12).'</td>
		</tr>
		</table>';

		$out .= htmlDialogBorder3(636,0, $content ,$headline);

		$out .= '
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>'.getPixel(175,12).'</td>
			<td>'.getPixel(460,12).'</td>
		</tr>
		<tr>
			<td>'.getPixel(5,1).(we_hasPerm("DELETE_OBJECTFILE") || we_hasPerm("NEW_OBJECTFILE") ? $we_button->create_button("selectAll", "javascript: ".$javascriptAll."") : "").'</td>
			<td align="right">'.$this->searchclass->getNextPrev($foundItems).'</td>
		</tr>
		<tr>
			<td>'.getPixel(175,12).'</td>
			<td>'.getPixel(460,12).'</td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>'.getPixel(5,1).'</td>
					<td class="small">'.(we_hasPerm("DELETE_OBJECTFILE") ? $we_button->create_button("image:btn_function_trash", "javascript: if(confirm('".$GLOBALS['l_object_classfoldersearch']["wirklichloeschen"]."'))document.we_form.elements['do'].value='delete';we_cmd('reload_editpage');") .'</td>
					<td>'.getPixel(5,1).'</td>
					<td class="small">&nbsp;'.$GLOBALS['l_object_classfoldersearch']["loesch"] : "").'</td>
				</tr>
				</table>
			</td>
		<tr>
		<tr>
			<td>'.getPixel(175,12).'</td>
			<td>'.getPixel(460,12).'</td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>'.getPixel(5,1).'</td>
					<td class="small">'.(we_hasPerm("NEW_OBJECTFILE") ? $we_button->create_button("image:btn_function_publish", "javascript: if(confirm('".$GLOBALS['l_object_classfoldersearch']["wirklichveroeffentlichen"]."'))document.we_form.elements['do'].value='publish';we_cmd('reload_editpage');") .'</td>
					<td>'.getPixel(5,1).'</td>
					<td class="small">&nbsp;'.$GLOBALS['l_object_classfoldersearch']["veroeffentlichen"] : "").'</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>'.getPixel(175,12).'</td>
			<td>'.getPixel(460,12).'</td>
		</tr>
		<tr>
			<td colspan="2">
				<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td>'.getPixel(5,1).'</td>
					<td class="small">'.(we_hasPerm("NEW_OBJECTFILE") ? $we_button->create_button("image:btn_function_unpublish", "javascript: if(confirm('".$GLOBALS['l_object_classfoldersearch']["wirklichparken"]."'))document.we_form.elements['do'].value='unpublish';we_cmd('reload_editpage');") .'</td>
					<td>'.getPixel(5,1).'</td>
					<td class="small">&nbsp;'.$GLOBALS['l_object_classfoldersearch']["parken"] : "").'</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		</form>
		';
		$out .= $yuiSuggest->getYuiCssFiles();
		$out .= $yuiSuggest->getYuiCss();

		$out .= $yuiSuggest->getYuiJsFiles();
		$out .= $yuiSuggest->getYuiJs();

		return $out;

	}


	function getSearchJS() {

		$DB_WE = new DB_WE();

		$modulepath = WE_OBJECT_MODULE_PATH;

		$ret = <<<EOF
		<script language="JavaScript" type="text/javascript">
		function sub(){

			// not needed anymore since version 5?! (Bug Fix #989)
			//parent.editHeader.we_tabs[0].setState(2,false,parent.editHeader.we_tabs);

			document.we_form_search.target="load";
			document.we_form_search.action="{$modulepath}search_submit.php";
			document.we_form_search.todo.value="search";
			document.we_form_search.submit();


		}

		function newinput(){
			document.we_form_search.target='load';
			document.we_form_search.action='{$modulepath}search_submit.php';
			document.we_form_search.todo.value="add";
			document.we_form_search.submit();
		}

		function del(pos){
			document.we_form_search.target='load';
			document.we_form_search.action='{$modulepath}search_submit.php';
			document.we_form_search.todo.value="delete";
			document.we_form_search.position.value=pos;
			document.we_form_search.submit();
		}


		function changeit(f){
EOF;

			$objID = f("SELECT ID FROM " . OBJECT_TABLE . " WHERE Path='".$this->Path."'","ID",$DB_WE);
			$tableInfo =  $DB_WE->metadata(OBJECT_X_TABLE.$objID);

			for($i=0;$i<sizeof($tableInfo);$i++){
				if(substr($tableInfo[$i]["name"],0,5) == "meta_"){

		$ret.= "
			if(f=='".$tableInfo[$i]["name"]."'){
				document.we_form_search.target='load';
				document.we_form_search.action='{$modulepath}search_submit.php';
				document.we_form_search.todo.value='changemeta';
				document.we_form_search.submit();
			}
		";
				} else if(substr($tableInfo[$i]["name"],0,5) == "date_"){

		$ret.= "
			if(f=='".$tableInfo[$i]["name"]."'){
				document.we_form_search.target='load';
				document.we_form_search.action='{$modulepath}search_submit.php';
				document.we_form_search.todo.value='changedate';
				document.we_form_search.submit();
			}
		";
				} else if(substr($tableInfo[$i]["name"],0,9) == "checkbox_"){

		$ret.= "
			if(f=='".$tableInfo[$i]["name"]."'){
				document.we_form_search.target='load';
				document.we_form_search.action='{$modulepath}search_submit.php';
				document.we_form_search.todo.value='changecheckbox';
				document.we_form_search.submit();
			}
		";
				}
			}

		$ret .= <<<EOF

		}

		function changeitanyway(f){
				document.we_form_search.target='load';
				document.we_form_search.action='{$modulepath}search_submit.php';
				document.we_form_search.todo.value="changemeta";
				document.we_form_search.submit();
		}


</script>
EOF;

		return $ret;

	}

	function getSortImage($for) {
		if (strpos($_REQUEST['Order'], $for) === 0) {
			if (strpos($_REQUEST['Order'], 'DESC')) {
				return '<img border="0" width="11" height="8" src="' . IMAGE_DIR . 'arrow_sort_desc.gif" />';
			}
			return '<img border="0" width="11" height="8" src="' . IMAGE_DIR . 'arrow_sort_asc.gif" />';
		}
		return getPixel(11,8);
	}


	function saveInSession(&$save) {

		parent::saveInSession($save);

		if(!isset($_SESSION['we_objectSearch'])) {
			$_SESSION['we_objectSearch'] = array();
		}
		if(!isset($_SESSION['we_objectSearch'][$this->ID])) {
			$_SESSION['we_objectSearch'][$this->ID] = array();
		}
		$_SESSION['we_objectSearch'][$this->ID] = serialize(array(
			'Serialized' => serialize($this->searchclass),
			'SearchStart' => $this->SearchStart,
			'GreenOnly' => $this->GreenOnly,
			'Order' => $this->Order,
			'EditPageNr' => $this->EditPageNr,
		));
	}


	function deleteObjects() {

		$DB_WE = new DB_WE();

		$javascript = "";

		$deletedItems = array();

		// get Class
		$classArray = getHash("SELECT * FROM " . OBJECT_TABLE . " WHERE Path='".$this->Path."'",$DB_WE);
		foreach(array_keys($_REQUEST) as $f){
			if(substr($f,0,3)=="weg"){
				//$this->query("");
				$DB_WE->query("SELECT OF_ID FROM " . OBJECT_X_TABLE.$classArray["ID"]." WHERE ID=".substr($f,3));
				$DB_WE->next_record();
				$ofid = $DB_WE->f("OF_ID");
				if(checkIfRestrictUserIsAllowed($ofid,OBJECT_FILES_TABLE)){

					$DB_WE->query("DELETE FROM " . OBJECT_X_TABLE.$classArray["ID"]." WHERE ID=".substr($f,3));
					$DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE OID=".$ofid);
					$DB_WE->query("DELETE FROM " . OBJECT_FILES_TABLE . " WHERE ID=".$ofid);

					$obj = new we_objectFile();
					$obj->initByID($ofid, OBJECT_FILES_TABLE);

					we_temporaryDocument::delete($ofid,OBJECT_FILES_TABLE,$DB_WE);
					$javascript .= 'top.deleteEntry('.$obj->ID.');'."\n";

					$deletedItems[] = $obj->ID;

				}
			}
		}

		$javascript .= "
			top.drawTree();

			// close all Editors with deleted documents
			var _usedEditors =  top.weEditorFrameController.getEditorsInUse();

			var _delete_table = '"  . OBJECT_FILES_TABLE. "';
			var _delete_Ids = '," . implode(",",$deletedItems) . ",';

			for ( frameId in _usedEditors ) {

				if ( _delete_table == _usedEditors[frameId].getEditorEditorTable() && (_delete_Ids.indexOf( ',' + _usedEditors[frameId].getEditorDocumentId() + ',' ) != -1) ) {
					_usedEditors[frameId].setEditorIsHot(false);
					top.weEditorFrameController.closeDocument(frameId);
				}
			}
		";

		return $javascript;

	}


	function publishObjects($publish = true) {

		$DB_WE = new DB_WE();
		

		$javascript = "";

		// get Class
		$classArray = getHash("SELECT * FROM " . OBJECT_TABLE . " WHERE Path='".$this->Path."'",$DB_WE);
		foreach(array_keys($_REQUEST) as $f){
			if(substr($f,0,3)=="weg"){

				$DB_WE->query("SELECT OF_ID FROM " . OBJECT_X_TABLE.$classArray["ID"]." WHERE ID=".substr($f,3));
				$DB_WE->next_record();
				$ofid = $DB_WE->f("OF_ID");

				if(checkIfRestrictUserIsAllowed($ofid,OBJECT_FILES_TABLE)){
					if($publish!=true) {

						$obj = new we_objectFile();
						$obj->initByID($ofid, OBJECT_FILES_TABLE);

						if($obj->we_unpublish()) {
							$javascript .=	"_EditorFrame = top.weEditorFrameController.getActiveEditorFrame();\n"
										//.	"_EditorFrame.setEditorDocumentId(".$obj->ID.");\n"
										.	$obj->getUpdateTreeScript(false)."\n"
										.	"if(top.treeData.table!='".OBJECT_FILES_TABLE."') {\n"
										.   "top.rframe.bframe.bm_vtabs.we_cmd('load', '".OBJECT_FILES_TABLE."', 0);\n"
										.	"}\n"
										.   "weWindow.treeData.selectnode(".$GLOBALS['we_doc']->ID.");";
										
						}

					} else {

						$obj = new we_objectFile();
						$obj->initByID($ofid, OBJECT_FILES_TABLE);
						
						$obj->getContentDataFromTemporaryDocs($ofid);

						if($obj->we_publish()) {
							$javascript .=	"_EditorFrame = top.weEditorFrameController.getActiveEditorFrame();\n"
										//.	"_EditorFrame.setEditorDocumentId(".$obj->ID.");\n"
										.	$obj->getUpdateTreeScript(false)."\n"
										.	"if(top.treeData.table!='".OBJECT_FILES_TABLE."') {\n"
										.   "top.rframe.bframe.bm_vtabs.we_cmd('load', '".OBJECT_FILES_TABLE."', 0);\n"
										.	"}\n"
										.   "weWindow.treeData.selectnode(".$GLOBALS['we_doc']->ID.");";
						}

					}
				}
			}
		}

		return $javascript;

	}

}

?>