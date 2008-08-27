<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_class.inc.php");
if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_button.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");
}

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_ContentTypes.inc.php");
/* the parent class for tree-objects */
class we_root extends we_class
{
	######################################################################################################################################################
	##################################################################### Variables ######################################################################
	######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_root";

	/* ParentID of the object (ID of the Parent-Folder of the Object) */
	var $ParentID=0;

	/* Parent Path of the object (Path of the Parent-Folder of the Object) */
	var $ParentPath="/";

	/* The Text that will be shown in the tree-menue */
	var $Text="";

	/* Filename of the file */
	var $Filename="";

	/* Path of the File  */
	var $Path="";

	/* OldPath of the File => used internal  */
	var $OldPath="";

	/* Creation Date as UnixTimestamp  */
	var $CreationDate=0;

	/* Modification Date as UnixTimestamp  */
	var $ModDate=0;

	/* Flag which is set, when the file is a folder  */
	var $IsFolder=0;

	/* ContentType of the Object  */
	var $ContentType="";

	/* Icon which is shown at the tree-menue  */
	var $Icon="";

	var $IsBinary = false;


	/* array which holds the content of the Object */
	var $elements = array();

	/* Number of the EditPage when editor() is called */
	var $EditPageNr = 1;

	var $CopyID;

	var $EditPageNrs = array();


    var $Owners="";
    var $OwnersReadOnly = "";

    var $WebUserID="";

        /* ID of the Autor who created the document */
	var $CreatorID=0;

        /* ID of the user who last modify the document */
    var $ModifierID=0;

    var $RestrictOwners = 0;

    var $DefaultInit = false;  // this flag is set when the document was first initialized with default values e.g. from Doc-Types
	var $DocStream = "";

	######################################################################################################################################################
	##################################################################### FUNCTIONS ######################################################################
	######################################################################################################################################################

	/* Constructor */
	function we_root(){
		$this->CreationDate = time();
		$this->ModDate = time();
		$this->we_class();

 		array_push($this->persistent_slots,"OwnersReadOnly","ParentID","ParentPath","Text","Filename","Path","OldPath","CreationDate","ModDate","IsFolder","ContentType","Icon","elements","EditPageNr","CopyID","Owners","CreatorID","ModifierID","DefaultInit","RestrictOwners","WebUserID");

	}

	function makeSameNew(){
		$ParentID = $this->ParentID;
		$ParentPath = $this->ParentPath;
		$EditPageNr = $this->EditPageNr;

 		eval('$tempDoc = new '.$this->ClassName.'();');
		$tempDoc->we_new();
		for($i=0;$i<sizeof($tempDoc->persistent_slots);$i++){
			eval('$this->'.$tempDoc->persistent_slots[$i].'= isset($tempDoc->'.$tempDoc->persistent_slots[$i].') ? $tempDoc->'.$tempDoc->persistent_slots[$i].' : "" ;');
		}
		$this->InWebEdition = true;
		$this->ParentID = $ParentID;
		$this->ParentPath = $ParentPath;
		$this->EditPageNr = $EditPageNr;
	}

	function equals($obj){
		for($i=0;$i<sizeof($this->persistent_slots);$i++){
			if($this->persistent_slots[$i] != "Name" && $this->persistent_slots[$i] != "elements" && $this->persistent_slots[$i] != "EditPageNr" && $this->persistent_slots[$i] != "wasUpdate"){
				eval('$foo1 = $this->'.$this->persistent_slots[$i].";");
				eval('$foo2 = $obj->'.$this->persistent_slots[$i].";");
				if($foo1 != $foo2) {
                	return false;
				}
			}
		}
		foreach($this->elements as $key=>$val){
			if($this->elements[$key]["dat"] != $obj->elements[$key]["dat"] || $this->elements[$key]["bdid"] != $obj->elements[$key]["bdid"]){
            	return false;
			}

		}
		return true;
	}

	function setParentID($newID){
		$this->ParentID=$newID;
		$this->ParentPath = $this->getParentPath();
	}


	function ModifyPathInformation($parentID){
		$this->setParentID($parentID);
		$this->Path = $this->getPath();
		$this->wasUpdate = 1;
		$this->we_save(); //i_savePersistentSlotsToDB("Filename,Extension,Text,Path,ParentID");
		$this->modifyChildrenPath(); // only on folders, because on other classes this function is empty
	}

	function modifyChildrenPath(){
		// do nothing, only in Folder-Classes this Function schould have code!!

	}

	function checkIfPathOk(){
		### check if Path has changed
		$Path = $this->getPath();
		if($Path != $this->Path){

			### check if Path exists in db
			if(f("SELECT Path FROM ".$this->Table." WHERE Path='$Path'","Path",$this->DB_WE)){
				$GLOBALS["we_responseText"] = sprintf($GLOBALS["l_we_class"]["response_path_exists"],$Path);
				return false;
			}
			$this->Path = $Path;
		}
		return true;
	}

	function saveInSession(&$save){
		$save = array();
		$save[0] = array();
		for($i=0;$i<sizeof($this->persistent_slots);$i++){
			eval('$bb= isset($this->'.$this->persistent_slots[$i].') ? $this->'.$this->persistent_slots[$i].' : "";');
			if(!is_object($bb)){
				eval('$save[0]["'.$this->persistent_slots[$i].'"]=$bb;');
				//eval('$save[0]["'.$this->persistent_slots[$i].'"]=$this->'.$this->persistent_slots[$i].';');
			}else{
				eval('$save[0]["'.$this->persistent_slots[$i].'_class"]=serialize($bb);');
				//print_r($bb);
				//echo serialize($bb);print_r(unserialize(serialize($bb)));
			}
		}
		$save[1] = $this->elements;
		// save weDocumentCustomerFilter in Session
		if (isset($this->documentCustomerFilter) && defined("CUSTOMER_TABLE") ) {
			$save[3] = serialize($this->documentCustomerFilter);
		}
	}

	function applyWeDocumentCustomerFilterFromFolder() {

		if (isset($this->documentCustomerFilter) && defined("CUSTOMER_TABLE") ) {
			$_tmpFolder = new we_folder();
			$_tmpFolder->initByID($this->ParentID, $this->Table);
			$this->documentCustomerFilter = $_tmpFolder->documentCustomerFilter;

			if ($this->IsFolder) {
				$this->ApplyWeDocumentCustomerFiltersToChilds = true;

			}
			unset($_tmpFolder);
		}
	}

	/* saves the data of the object in $filename */
	/* load  data in the object from $filename */
	function loadFromFile($filename){
		$fp = fopen($filename,"rb");
		$str = fread($fp,filesize($filename));
		fclose($fp);
		if($str){
			$arr = unserialize($str);
			for($i=0;$i<sizeof($this->persistent_slots);$i++){
				if(isset($arr[0][$this->persistent_slots[$i]])){
					eval('$this->'.$this->persistent_slots[$i].'=$arr[0][$this->persistent_slots[$i]];');
				}
			}
			if(isset($arr[1])){
				$this->elements = $arr[1];
			}
			return true;
		}else{
			return false;
		}
	}

	/* init the object with data from the database */


	function copyDoc($id){
		// overwrite

	}


######### Form functions for generating the html of the input fields ##########

	/* creates a text-input field for entering Data that will be stored at the $elements Array */

	/* creates the filename input-field */
	function formFilename($text=""){
		global $l_we_class;
		return $this->formTextInput("","Filename",$text ? $text : $l_we_class["filename"],24,255);
	}

	/* creates the DirectoryChoooser field with the "browse"-Button. Clicking on the Button opens the fileselector */
	function formDirChooser($width="",$rootDirID=0,$table="",$Pathname="ParentPath",$IDName="ParentID",$cmd="",$showTitle=true){
		global $l_we_class, $BROWSER;
		$yuiSuggest =& weSuggest::getInstance();
		$we_button = new we_button();

		if(!$table) $table = $this->Table;
		$textname = 'we_'.$this->Name.'_'.$Pathname;
		$idname = 'we_'.$this->Name.'_'.$IDName;
		eval('$path = $this->'.$Pathname.';');
		eval('$myid = $this->'.$IDName.';');

		$_parentPathChanged = '';
		$_parentPathChangedBlur = '';
		if ($Pathname == "ParentPath") {
			$_parentPathChanged = "if (opener.pathOfDocumentChanged) { opener.pathOfDocumentChanged(); }";
			$_parentPathChangedBlur = "if (pathOfDocumentChanged) { pathOfDocumentChanged(); }";
		}

		if ($width) {
			$_attribs['style'] = "width: " . $width . "px";
		} else {
			$width=0;
		}

		$button = $we_button->create_button("select", "javascript:we_cmd('openDirselector',document.we_form.elements['$idname'].value,'$table','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$textname\\'].value','opener._EditorFrame.setEditorIsHot(true);" . $_parentPathChanged .$cmd."','".session_id()."','$rootDirID')");

		$yuiSuggest->setAcId("Path",id_to_path(array($rootDirID),$table));
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($textname,$path,array("onBlur"=>$_parentPathChangedBlur));
		$yuiSuggest->setLabel($l_we_class["dir"]);
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(0);
		$yuiSuggest->setResult($idname,$myid);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable($table);
		$yuiSuggest->setWidth($width);
		$yuiSuggest->setSelectButton($button);

		return $yuiSuggest->getHTML();
	}

	function htmlTextInput_formDirChooser($attribs=array(), $addAttribs=array()) {
		$_attribs = array(
			'onfocus'	=> "this.className='wetextinputselected';",
			'onblur'	=> "this.className='wetextinput';",
			'class'		=> "wetextinput",
			'size'		=> 30,
			'value'		=> "",
		);

		foreach ( $addAttribs as $key => $value ) {
			if (isset($_attribs[$key])) {
				$_attribs[$key] .= $value;
			} else {
				$_attribs[$key] = $value;
			}
		}

		foreach ( $attribs as $key => $value ) {
			$_attribs[$key] = $value;

		}

		$_attribs['type'] = 'text';

		return getHtmlTag('input', $_attribs);

	}

	function formCreator($canChange,$width=388){
		global $l_we_class;

		$we_button = new we_button();

		if(!$this->CreatorID) $this->CreatorID = 0;

		$creator = $this->CreatorID ? id_to_path($this->CreatorID,USER_TABLE,$this->DB_WE) : $l_we_class["nobody"];


		if($canChange){

			$textname = 'wetmp_'.$this->Name.'_CreatorID';
			$idname = 'we_'.$this->Name.'_CreatorID';

			$attribs = ' readonly';

			$inputFeld=$this->htmlTextInput($textname,24,$creator,"",$attribs,"",$width);
			$idfield = $this->htmlHidden($idname,$this->CreatorID);

			$button = $we_button->create_button("edit", "javascript:we_cmd('browse_users','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','user',document.forms[0].elements['$idname'].value,'opener._EditorFrame.setEditorIsHot(true);')");

			$out = $this->htmlFormElementTable($inputFeld,
			$l_we_class["maincreator"],
			"left",
			"defaultfont",
			$idfield,
			getPixel(20,4),
			$button);
		}else{
			$out = $creator;
		}
		return $out;

	}

	function formRestrictOwners($canChange){
		global $l_we_class;
		if($canChange){
			$n = 'we_'.$this->Name.'_RestrictOwners';
			$v = $this->RestrictOwners ? true : false;
			return we_forms::checkboxWithHidden($v ? true : false, $n, $l_we_class["limitedAccess"],false,"defaultfont","setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('reload_editpage');");
		}else{
			return '<table cellpadding="0" cellspacing="0" border="0"><tr><td><img src="'.TREE_IMAGE_DIR.($this->RestrictOwners ? 'check1_disabled.gif' : 'check0_disabled.gif').'"></td><td class="defaultfont">&nbsp;'.$l_we_class["limitedAccess"].'</td></tr></table>';
		}
	}

	function formOwners($canChange=true){

		global $l_we_class;

		$we_button = new we_button();

		$owners = makeArrayFromCSV($this->Owners);
		$ownersReadOnly = $this->OwnersReadOnly ? unserialize($this->OwnersReadOnly) : array();

		$content = '<table border="0" callpadding="0" cellspacing="0" width="370">';
		$content .= '<tr><td>'.getPixel(20,2).'</td><td>'.getPixel(351,2).'</td><td>'.getPixel(100,2).'</td><td>'.getPixel(26,2).'</td></tr>'."\n";
		if(sizeof($owners)){
			for($i=0;$i<sizeof($owners);$i++){
				$foo = getHash("SELECT ID,Path,Icon from " . USER_TABLE . " WHERE ID='".$owners[$i]."'",$this->DB_WE);
				$content .= '<tr><td><img src="'.ICON_DIR.$foo["Icon"].'" width="16" height="18"></td><td class="defaultfont">'.$foo["Path"].'</td><td>'.

				we_forms::checkboxWithHidden(isset($ownersReadOnly[$owners[$i]]) ? $ownersReadOnly[$owners[$i]] : "", 'we_owners_read_only['.$owners[$i].']', $l_we_class["readOnly"],false,"defaultfont","_EditorFrame.setEditorIsHot(true);",!$canChange).

				'</td><td>'.($canChange ? $we_button->create_button("image:btn_function_trash", "javascript:setScrollTo();_EditorFrame.setEditorIsHot(true);we_cmd('del_owner','".$owners[$i]."');") : "").'</td></tr>'."\n";
			}
		}else{
			$content .= '<tr><td><img src="'.ICON_DIR."user.gif".'" width="16" height="18"></td><td class="defaultfont">'.$l_we_class["onlyOwner"].'</td><td></td><td></td></tr>'."\n";
		}
		$content .= '<tr><td>'.getPixel(20,2).'</td><td>'.getPixel(351,2).'</td><td>'.getPixel(100,2).'</td><td>'.getPixel(26,2).'</td></tr></table>'."\n";

		$textname = 'OwnerNameTmp';
		$idname = 'OwnerIDTmp';
		$delallbut = $we_button->create_button("delete_all","javascript:we_cmd('del_all_owners','')",true,-1,-1,"","",$this->Owners ? false : true);
		$addbut = $canChange ?
				$this->htmlHidden($idname,"").$this->htmlHidden($textname,"").$we_button->create_button("add", "javascript:we_cmd('browse_users','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','',document.forms[0].elements['$idname'].value,'opener._EditorFrame.setEditorIsHot(true);opener.setScrollTo();fillIDs();opener.we_cmd(\\'add_owner\\',top.allIDs)','','',1);")
				: "";

		$content = '<table border="0" cellpadding="0" cellspacing="0" width="500">
<tr><td><div class="multichooser">'.$content.'</div></td></tr>
'.($canChange ? '<tr><td align="right">'.getPixel(2,8).'<br>'.$we_button->create_button_table(array($delallbut, $addbut)).'</td></tr>' : "").'</table'."\n";

		return $this->htmlFormElementTable($content,
			$l_we_class["otherowners"],
			"left",
			"defaultfont");
	}

	function formCreatorOwners(){
		global $l_we_class;
		$width = 388;
		if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){
			include_once(WE_USERS_MODULE_DIR . "we_users_util.php");
			$canChange = (!$this->ID) || isUserInUsers($_SESSION["user"]["ID"],$GLOBALS["we_doc"]->CreatorID);

			$out = '<table border="0" cellpadding="0" cellspacing="0">
<tr><td class="defaultfont">'.$this->formCreator($canChange,$width).'</td></tr>
<tr><td>'.getPixel(2,20).'</td></tr>
<tr><td>'.$this->formRestrictOwners($canChange).'</td></tr>
';
			if($this->RestrictOwners){
				$out .= '<tr><td>'.getPixel(2,10).'</td></tr>
<tr><td>'.$this->formOwners($canChange).'</td></tr>
';
			}
			$out .= '</table>
';
		}else{
			$out = $this->formCreator((($this->CreatorID==$_SESSION["user"]["ID"]) || $_SESSION["perms"]["ADMINISTRATOR"]),$width);
		}

		return $out;
	}

	function del_all_owners(){
		$this->Owners = "";
	}

	function add_owner($id){

		$owners = makeArrayFromCSV($this->Owners);
		$ids = makeArrayFromCSV($id);
		foreach($ids as $id){
			if($id && (!in_array($id,$owners))) {
				array_push($owners,$id);
			}
		}
		$this->Owners=makeCSVFromArray($owners,true);
	}

	function del_owner($id){
		$owners = makeArrayFromCSV($this->Owners);
		if(in_array($id,$owners)){
			$pos = getArrayKey($id,$owners);
			if($pos != "" || $pos=="0"){
				array_splice($owners,$pos,1);
			}
		}
		$this->Owners=makeCSVFromArray($owners,true);
	}

   /**
	* @return bool
	* @desc	checks if a document is restricted to several users and if
			the user is one of the restricted users
 	*/
	function userHasPerms(){
		if(!defined("BIG_USER_MODULE") || !in_array("busers",$GLOBALS["_pro_modules"]))
			return true;
		if($_SESSION["perms"]["ADMINISTRATOR"])
			return true;
		if(!$this->RestrictOwners)
			return true;
		if(we_isOwner($this->Owners) || we_isOwner($this->CreatorID))
			return true;
		return false;
	}

	function userIsCreator(){
		if(!defined("BIG_USER_MODULE") || !in_array("busers",$GLOBALS["_pro_modules"])) return true;
		if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
		return we_isOwner($this->CreatorID);
	}

   function userCanSave(){
		if(!defined("BIG_USER_MODULE") || !in_array("busers",$GLOBALS["_pro_modules"])) return true;
		if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
		include_once(WE_USERS_MODULE_DIR . "we_users_util.php");
		if(defined("OBJECT_TABLE") && ($this->Table == OBJECT_FILES_TABLE)){
			if(!(we_hasPerm("NEW_OBJECTFILE_FOLDER") || we_hasPerm("NEW_OBJECTFILE"))) return false;
		}else{
			if(!we_hasPerm("SAVE_DOCUMENT_TEMPLATE")) return false;
		}
		if(!$this->RestrictOwners) return true;
		if(!$this->userHasPerms()) return false;
		$ownersReadOnly = $this->OwnersReadOnly ? unserialize($this->OwnersReadOnly) : array();
		$readers=array();
		foreach(array_keys($ownersReadOnly) as $key){
			if(isset($ownersReadOnly[$key]) && $ownersReadOnly[$key] == 1) $readers[]=$key;
		}
      return !isUserInUsers($_SESSION["user"]["ID"],$readers);

   }

	function formCopyDocument(){
		$idname = 'we_'.$this->Name.'_CopyID';
		$we_button = new we_button();
		$but = $we_button->create_button("select", "javascript:we_cmd('openDocselector', document.forms[0].elements['" . $idname . "'].value, '" . $this->Table . "', 'document.forms[\\'we_form\\'].elements[\\'" . $idname . "\\'].value', '', 'opener._EditorFrame.setEditorIsHot(true); opener.top.we_cmd(\\'copyDocument\\', currentID);', '" . session_id() . "', '0', '" . $this->ContentType . "',1);");

		$content = $this->htmlHidden($idname,$this->CopyID).$but;
		return $content;

	}

	# return html code for button and field to select user
	# ATTENTION !!: You have to have we_cmd function in your file and browse_user section
	#
	function formUserChooser($old_userID=-1,$width="",$in_textname="",$in_idname="")
	{
		global $l_we_class;

		$we_button = new we_button();

		$textname = $in_textname=="" ?  'we_'.$this->Name.'_UserName' : $in_textname;
		$idname = $in_idname=="" ?  'we_'.$this->Name.'_UserID' : $in_idname;

		$username = "";
		$userid = $old_userID;

		if ((int)$userid >0)
		{
			$username = f("SELECT username FROM " . USER_TABLE . " WHERE ID='$userid'","username",$this->DB_WE);
		}


		return we_root::htmlFormElementTable
		(
			we_root::htmlTextInput($textname,30,$username,"",' readonly',"text",$width,0),
			"User",
			"left",
			"defaultfont",
			we_root::htmlHidden($idname,$userid),
			getPixel(20,4),
			$we_button->create_button("select", "javascript:we_cmd('browse_users','document.forms[\\'we_form\\'].elements[\\'$idname\\'].value','document.forms[\\'we_form\\'].elements[\\'$textname\\'].value','user')")
		);


	}

	#################### Function for getting and setting the $elements Array #########################################################################

	/* returns true if the element with the name $name is set */
	function issetElement($name){
		return isset($this->elements[$name]);
	}

	/* set the Data for an element */
	function setElement($name,$data,$type="txt",$id=0,$autobr=0){
		$this->elements[$name]["dat"]=$data;
		$this->elements[$name]["type"]=$type;
		if($id) $this->elements[$name]["id"]=$id;
		if($autobr) $this->elements[$name]["autobr"]=$autobr;
	}

	/* get the data from an element */
	function getElement($name,$key="dat"){
	    if(isset($this->elements[$name][$key]))
	        return $this->elements[$name][$key];
	    else
	        return "";
	}

	/* reset the array-pointer (for use with nextElement()) */
	function resetElements(){
		if(is_array($this->elements)) reset($this->elements);
	}

	/* returns the next element or false if the array-pointer is at the end of the array*/
	function nextElement($type="txt"){
		if(is_array($this->elements)){
			while($arr = each($this->elements)){
				if( (isset($arr["value"]["type"]) && $arr["value"]["type"] == $type) || $type==""){
					return $arr;
				}
			}
		}
		return false;
	}

	##### Functions for generating JavaScrit to update the document tree

	/* returns the JavaScript-Code which modifies the tree-menue */
	function getUpdateTreeScript($select=true){

		return $this->getMoveTreeEntryScript($select);
	}

	function getMoveTreeEntryScript($select=true){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weMainTree.inc.php");
		$Tree=new weMainTree("webEdition.php","top","self.Tree","top.load");
		return $Tree->getJSUpdateTreeScript($this,$select);
	}


##################### Path info functions

	/* returns the Path dynamically (use it, when the class-variable Path is not set)  */
	function getPath() {
		$ParentPath = $this->getParentPath();
		$ParentPath .= ($ParentPath != "/") ? "/" : "";
		$text=( isset($this->Filename) ? $this->Filename : "" ).( isset($this->Extension) ? $this->Extension : "" );
		return $ParentPath.$text;
	}

	/* get the Path of the Parent-Object */
	function getParentPath(){
		return (!$this->ParentID) ? "/" : f("SELECT Path FROM ".$this->Table." WHERE ID=".$this->ParentID,"Path",$this->DB_WE);
	}

	function constructPath(){
		if($this->ID){
			$pid = $this->ParentID;
			$p = "/".$this->Text;
			$z=0;
			while($pid && $z < 50){
				$h = getHash("SELECT ParentID,Text FROM ".$this->Table." WHERE ID='$pid'",$this->DB_WE);
				$p = "/".$h["Text"].$p;
				$pid = $h["ParentID"];
				$z++;
			}
			if($z >= 50) return false;
			return $p;
		}
		return false;
	}

	/* get the Real-Path of the Object (Server-Path) */
	function getRealPath($old=false){
		return (($this->Table==FILE_TABLE) ? $_SERVER["DOCUMENT_ROOT"] : TEMPLATE_DIR).($old ? $this->OldPath : $this->getPath());
	}
	/* get the Site-Path of the Object */
	function getSitePath($old=false){
		$path = $_SERVER["DOCUMENT_ROOT"].SITE_DIR;
		return $path.substr(($old ? $this->OldPath : $this->getPath()),1);
	}

	/* get the HTTP-Path of the Object */
	function getHttpPath(){
		$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";
		$prot = getServerProtocol(true);
		return $prot.SERVER_NAME.$port.$this->getPath();
	}

	/* get the HTTP-Path of the Object */
	function getHttpSitePath(){
		$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";
		$prot = getServerProtocol(true);
		return $prot.SERVER_NAME.$port.SITE_DIR.substr($this->getPath(),1);
	}

######################

	function editor(){
	}


	function getParentIDFromParentPath(){
		return 0;
	}

	function makeHrefByID($id,$db=""){
		$db = $db ? $db : new DB_WE;
		return f("SELECT Path FROM " . FILE_TABLE . " WHERE ID=".$id,"Path",$this->DB_WE);
	}


	function save(){
		return $this->we_save();
	}


	#### Neu

# public ##################

	function we_new(){
		we_class::we_new();
		$this->CreatorID=isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : 0;
		if(isset($this->ContentType) && $this->ContentType){
			$this->Icon = $GLOBALS["WE_CONTENT_TYPES"][$this->ContentType]["Icon"];
		}
		$this->ParentPath = $this->getParentPath();

	}

	function we_load($from=LOAD_MAID_DB){
		we_class::we_load($from);
		$this->i_getContentData($this->LoadBinaryContent);
		$this->OldPath = $this->Path;

	}

	function we_save($resave=0){
		//$this->i_setText;
		if($this->PublWhenSave){
			$this->Published = time();
		}
		if($resave==0){
			$this->ModDate = time();
			$this->ModifierID = isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : 0;
		}
		if(!we_class::we_save($resave)) return false;
		$a = $this->i_saveContentDataInDB();
		if($resave==0 && $this->ClassName!="we_class_folder"){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_history.class.php");
			we_history::insertIntoHistory($this);
		}	
		
		return $a;
	}

	/**
	 * resave weDocumentCustomerFilter
	 *
	 */
	function resaveWeDocumentCustomerFilter() {

		if (isset($this->documentCustomerFilter) && $this->documentCustomerFilter) {
			weDocumentCustomerFilter::saveForModel( $this );

		}
	}

	function we_delete(){
		if(!we_class::we_delete()) return false;
		return deleteContentFromDB($this->ID,$this->Table);
	}

	function i_getDefaultFilename(){
	 	return f("SELECT MAX(ID) as ID FROM ".$this->Table,"ID",$this->DB_WE)+1;
	}

	function we_initSessDat($sessDat){
		we_class::we_initSessDat($sessDat);
		if(is_array($sessDat)){
			for($i=0;$i<sizeof($this->persistent_slots);$i++){
				if(isset($sessDat[0][$this->persistent_slots[$i]])){
					eval('$this->'.$this->persistent_slots[$i].'=$sessDat[0][$this->persistent_slots[$i]];');
				}
			}
			if(isset($sessDat[1])){
				$this->elements = $sessDat[1];
			}
		}
		$this->i_setElementsFromHTTP();
/* TODO: WECF  Brauchen wir das noch ?
		// weDocumentCustomerFilter
		if ( isset( $_REQUEST["we_edit_weDocumentCustomerFilter"] ) ) {
			$this->documentCustomerFilter = weDocumentCustomerFilter::getCustomerFilterFromRequest($this);

		} else if (isset($sessDat[3])) { // init webUser from session
			$this->documentCustomerFilter = unserialize($sessDat[3]);

		}
*/
	}

	function i_initSerializedDat($sessDat){
		if(is_array($sessDat)){
			for($i=0;$i<sizeof($this->persistent_slots);$i++){
				if(isset($sessDat[0][$this->persistent_slots[$i]])){
					eval('$this->'.$this->persistent_slots[$i].'=$sessDat[0][$this->persistent_slots[$i]];');
				}
			}
			if(isset($sessDat[1])){
				$this->elements = $sessDat[1];
			}
			if(isset($sessDat[2])){
				$this->NavigationItems = $sessDat[2];
			} else {
				$this->i_loadNavigationItems();
			}
		}
		$this->Name = md5(uniqid(rand()));
	}

# private ###################

	function i_setText(){
		$this->Text = $this->Filename;
	}

	function i_convertElemFromRequest($type,&$v,$k){
		if($type=="float") $v= str_replace(",",".",$v);
		if($type=="float" || $type=="int") $v = abs($v);
		if($type=="int") $v=floor($v);
		if($type == "text" || $type=="input"){
			if($this->DefArray[$type."_".$k]["forbidphp"] == "on"){
				$v = removePHP($v);
			}
			if($this->DefArray[$type."_".$k]["forbidhtml"] == "on"){
				$v = removeHTML($v);
			}
		}else if($type == "float"){
			$v = we_util::std_numberformat($v);
		}
	}

	function i_set_PersistentSlot($name,$value){
		if(in_array($name,$this->persistent_slots)){
			eval('$this->'.$name.'=$value;');
		}
	}

	function i_setElementsFromHTTP(){
		
		// do not set REQUEST VARS into the document
		if (isset($_REQUEST['we_cmd'][0])) {
			if(		($_REQUEST['we_cmd'][0] == "switch_edit_page" && isset($_REQUEST['we_cmd'][3]))
				||	($_REQUEST['we_cmd'][0] == "save_document" && isset($_REQUEST['we_cmd'][7]) && $_REQUEST['we_cmd'][7] == "save_document")) {
				return true;
			}
		}
		if(sizeof($_REQUEST)){
			$dates = array();
			foreach($_REQUEST as $n=>$v){
				if(ereg('^we_'.$this->Name.'_([^\[]+)$',$n,$regs)){
					if(is_array($v)){
						foreach($v as $n2=>$v2){
							$v2 = we_util::cleanNewLine($v2);
							//$v2 = eregi_replace("&quot;","\"",$v2);  // check ob benoetigt
							$type=$regs[1];
							if($type=="date"){
								$name = ereg_replace('^(.+)_[^_]+$','\1',$n2);
								$what = ereg_replace('^.+_([^_]+)$','\1',$n2);
								$dates[$name][$what] = $v2;

							}else{
								$name = $n2;
								if(ereg("(.+)#(.+)",$name,$regs2)){
									$this->elements[$regs2[1]]["type"] = $type;
									$this->elements[$regs2[1]][$regs2[2]] = $v2;
								}else{
									$this->elements[$name]["type"] = $type;
									$this->i_convertElemFromRequest("",$v2,$name);
									$this->elements[$name]["dat"] = $v2;
								}
							}
						}
					}else{
						$this->i_set_PersistentSlot($regs[1],$v);
					}
				}else if($n=='we_owners_read_only'){
					$this->OwnersReadOnly=serialize($v);
				}else if($n=='we_users_read_only'){
					$this->UsersReadOnly=serialize($v);
				}
			}
			foreach($dates as $k=>$v){
				$this->elements[$k]["type"] = "date";
				$this->elements[$k]["dat"] = mktime($dates[$k]["hour"],
															$dates[$k]["minute"],
															0,
															$dates[$k]["month"],
															$dates[$k]["day"],
															$dates[$k]["year"]);

			}
		}
		$this->Path = $this->getPath();
	}



	function i_isElement($Name){
		return true; // overwrite
	}

	function i_getContentData($loadBinary=0){

		$this->DB_WE->query("SELECT * FROM " . CONTENT_TABLE . "," . LINK_TABLE . " WHERE " . LINK_TABLE . ".DID='".$this->ID.
				"' AND " . LINK_TABLE . ".DocumentTable='".substr($this->Table, strlen(TBL_PREFIX)).
				"' AND " . CONTENT_TABLE . ".ID=" . LINK_TABLE . ".CID ".
				($loadBinary ? "" : " AND " . CONTENT_TABLE . ".IsBinary=0"));
		$filter = array("Name","DID","Ord");
		while($this->DB_WE->next_record()){
			$Name = $this->DB_WE->f("Name");
			$type = $this->DB_WE->f("Type");

			if($type == "formfield"){ // Artjom garbage fix!
				$this->elements[$Name] = unserialize($this->DB_WE->f("Dat"));
			}else{
				if($this->i_isElement($Name)){
					while(list($k,$v) = each($this->DB_WE->Record)){
						if(!in_array($k,$filter) &&  !ereg('^[0-9]+$',$k)){
							$k = strtolower($k);
							$this->elements[$Name][$k] = $v;
						}
					}
					$this->elements[$Name]["table"] = CONTENT_TABLE;
				}
			}
		}
	}

	function i_saveContentDataInDB(){
		if(!deleteContentFromDB($this->ID,$this->Table)) return false;
		if(is_array($this->elements)){

			foreach($this->elements as $k=>$v){
				if($this->i_isElement($k)){

//					if( (!isset($v["type"]) || $v["type"] != "vars") && (( isset($v["dat"]) && $v["dat"] != "" ) || (isset($v["bdid"]) && $v["bdid"]) || (isset($v["ffname"]) && $v["ffname"])) && (!isset($v["type"]) || $v["type"] != "variants")){
					if( (!isset($v["type"]) || $v["type"] != "vars") && (( isset($v["dat"]) && $v["dat"] != "" ) || (isset($v["bdid"]) && $v["bdid"]) || (isset($v["ffname"]) && $v["ffname"]))){

						$tableInfo = $this->DB_WE->metadata(CONTENT_TABLE);
						$keys = "";
						$vals = "";
						for($i=0;$i<sizeof($tableInfo);$i++){
							$fieldName = $tableInfo[$i]["name"];
							$val = isset($v[strtolower($fieldName)]) ? $v[strtolower($fieldName)] : "";
							if($k=="data" && $this->IsBinary){
								break;
							}
							if($fieldName == "Dat" && (isset($v["ffname"]) && $v["ffname"])){
								$v["type"] = "formfield";
								$val = serialize($v);
								// Artjom garbage fix
							}

							if(!isset($v["type"]) || $v["type"] == ""){
								$v["type"] = "txt";
							}
							if($v["type"] == "date"){
								$val = sprintf("%016d",$val);
							}
							if($fieldName != "ID"){
								$keys .= $fieldName.",";
								$vals .= "'".addslashes($val)."',";
							}
						}
						if($keys){
							$keys = "(".substr($keys,0,strlen($keys)-1).")";
							$vals = "VALUES(".substr($vals,0,strlen($vals)-1).")";
							$q = "INSERT INTO " . CONTENT_TABLE . " $keys $vals";
							if(isset($debug) && $debug) print "$q<br>\n";
							else $this->DB_WE->query($q);
							$cid = f("SELECT max(ID) as ID FROM " . CONTENT_TABLE, "ID", $this->DB_WE);
							$this->elements[$k]["id"]=$cid; // update Object itself
							$q = "INSERT INTO " . LINK_TABLE . " (DID,CID,Name,Type,DocumentTable) VALUES ('".$this->ID."',$cid,'$k','".$v["type"]."','".substr($this->Table, strlen(TBL_PREFIX))."')";
							if(!$this->DB_WE->query($q)) return false;
						}
					}
				}
			}
		}
		return true;
	}



	function i_getPersistentSlotsFromDB($felder="*"){
		we_class::i_getPersistentSlotsFromDB($felder);
		$this->ParentPath = $this->getParentPath();
	}

	function i_areVariantNamesValid() {
		return true;

	}

	function i_canSaveDirinDir(){
        return true;
	}

	function i_sameAsParent(){
		return false;
	}
	function i_filenameEmpty(){
		return ($this->Filename == "") ? true : false;
	}

	function i_filenameNotValid(){
		return we_filenameNotValid($this->Filename);
	}

	function i_filenameNotAllowed(){
		if($this->Table == FILE_TABLE && $this->ParentID == 0){
			if(strtolower($this->Filename.(isset($this->Extension) ? $this->Extension : "")) == "webedition"){
				return true;
			}
		}
		if(substr(strtolower($this->Filename.(isset($this->Extension) ? $this->Extension : "")), -1) == ".") {
			return true;
		}
		return false;
	}
	
	function i_fileExtensionNotValid(){
		if(isset($this->Extension)) {
			if(substr($this->Extension,0,1) == ".") {
				$ext = substr($this->Extension,1);
			} else {
				$ext = $this->Extension;
			}
			if(preg_match('/^[a-zA-Z0-9]+$/iD',$ext) || $ext=="") {
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}

	function i_filenameDouble(){
		return f("SELECT ID FROM ".$this->Table." WHERE ParentID='".$this->ParentID."' AND Filename='".$this->Filename."' AND ID != '".$this->ID."'","ID",new DB_WE());
	}


	### check if ParentPath is diffrent as ParentID, so we need to look what ParentID it is.
	### If it donesn't exists we have to create the folders (for auto Date-Folder Names)
	function i_checkPathDiffAndCreate(){
		if($this->getParentPath() != $this->ParentPath && $this->ParentPath != "" && $this->ParentPath != "/"){
			if (!$this->IsTextContentDoc || empty($this->DocType)) {
				return false;
			} else if($this->IsTextContentDoc && $this->DocType) {
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_docTypes.inc.php");
				$doctype = new we_docTypes();
				$doctype->initByID($this->DocType,DOC_TYPES_TABLE);
				if (empty($doctype->SubDir) ) {
					return false;
				}
				$_pathFirstPart = substr($this->getParentPath(),-1) == "/" ? "" : "/";
				$tail = '';
				switch($doctype->SubDir){
					case SUB_DIR_YEAR:
						$tail = $_pathFirstPart.date("Y");
						break;
					case SUB_DIR_YEAR_MONTH:
						$tail = $_pathFirstPart.date("Y")."/".date("m");
						break;
					case SUB_DIR_YEAR_MONTH_DAY:
						$tail = $_pathFirstPart.date("Y")."/".date("m")."/".date("d");
						break;
				}
				if ($this->getParentPath().$tail != $this->ParentPath) {
					return false;
				}
			}

			$this->ParentID = $this->getParentIDFromParentPath();
			$this->Path = $this->getPath();
		}
		if($this->ParentID == -1){
			return false;
		}
		return true;
	}

	function  i_correctDoublePath(){
		if($this->Filename){
				if(f("SELECT ID  FROM  " . $this->Table . "  WHERE ID!='".abs($this->ID)."' AND Text='".$this->Filename.(isset($this->Extension)  ?  $this->Extension  : "")."' AND ParentID='".$this->ParentID."'","ID",$this->DB_WE)){
					$z=0;
					$footext = $this->Filename."_".$z.(isset($this->Extension)  ?  $this->Extension  : "");
					while(f("SELECT ID FROM ".$this->Table." WHERE ID!='".abs($this->ID)."' AND Text='$footext' AND ParentID='".$this->ParentID."'","ID",$this->DB_WE)){
						$z++;
						$footext = $this->Filename."_".$z.(isset($this->Extension)  ?  $this->Extension  : "");
					}
					$this->Text = $footext;
					$this->Filename = $this->Filename."_".$z;
					$this->Path=$this->getParentPath().(($this->getParentPath() != "/") ? "/" : "").$this->Text;

				}
		}else{
				if(f("SELECT ID  FROM  " . $this->Table . "  WHERE ID!='".abs($this->ID)."' AND Text='".$this->Text."' AND ParentID='".$this->ParentID."'","ID",$this->DB_WE)){
					$z=0;
					$footext = $this->Text."_".$z;
					while(f("SELECT ID FROM ".$this->Table." WHERE ID!='".abs($this->ID)."' AND Text='$footext' AND ParentID='".$this->ParentID."'","ID",$this->DB_WE)){
						$z++;
						$footext = $this->Text."_".$z;
					}
					$this->Text = $footext;
					$this->Path=$this->getParentPath().(($this->getParentPath() != "/") ? "/" : "").$this->Text;

				}
		}
	}

	function i_check_requiredFields(){
		return ""; // overwrite
	}

	function i_scheduleToBeforeNow(){
		return false; // overwrite
	}

	function i_publInScheduleTable(){
		return false; // overwrite
	}

	function i_hasDoubbleFieldNames(){
		return false;
	}

	function we_resaveTemporaryTable(){
		return true;
	}
	function we_resaveMainTable(){
		return we_root::we_save(1);
	}
	function we_rewrite(){
		return true;
	}
	function correctFields(){}
	function we_republish(){
		return true;
	}

   /**
	* @return	int
	* @desc	checks if the user can modify a document, or only read the doc (only preview tab).
			returns	 1	if doc is not restricted any rules
					-1	if doc is not in workspace of user
					-2	if doc is restricted and user has nor rights
					-3	if doc is locked by another user
					-4	if user has not the right to save a file.
	*/
	function userHasAccess(){

		if($this->isLockedByUser() != 0 && $this->isLockedByUser() != $_SESSION["user"]["ID"] && $GLOBALS["we_doc"]->ID){				// file is locked
			return -3;
		}

		if(!$this->userHasPerms()){					//	File is restricted !!!!!
			return -2;
		}

		if(!$this->userCanSave()){					//	user has no right to save.
			return -4;
		}

		if(we_isOwner($this->CreatorID)){			//	user is creator of doc - all is allowed.
			return 1;
		}

		if( we_isOwner($this->Owners) ) {			//	user is owner of doc - all is allowed.
			return 1;
		}

		if($this->userHasPerms()) {									//	access to doc is not restricted, check workspaces of user
			if($GLOBALS["we_doc"]->ID) {		//	userModule installed
				if($ws = get_ws($GLOBALS["we_doc"]->Table)) {		//	doc has workspaces
					if(!(in_workspace($GLOBALS["we_doc"]->ID,$ws,$GLOBALS["we_doc"]->Table,$GLOBALS["DB_WE"]))) {
						return -1;
					}
				}
			}
			return 1;
		}
	}

   /**
	* @return int
	* @desc	checks if a file is locked by another user. returns that userID
			or 0 when file is not locked
	*/
	function isLockedByUser(){

		$DB_WE = new DB_WE();
		$DB_WE->query("SELECT * FROM " . LOCK_TABLE . " WHERE ID='".$this->ID."' AND tbl='".$this->Table."'");
		$_userId = 0;
		while($DB_WE->next_record()) {
			$_userId = $DB_WE->f("UserID");
		}
		return $_userId;
	}

	function lockDocument(){

		if ($_SESSION['user']['ID']) { // only if user->id != 0

			$DB_WE = new DB_WE();
			$DB_WE->query("INSERT INTO " . LOCK_TABLE . " (ID,UserID,tbl) VALUES('".$this->ID."','".$_SESSION["user"]["ID"]."','".$this->Table."')");
		}
	}

	function i_loadNavigationItems() {
		if($this->Table==FILE_TABLE  && $this->ID && $this->InWebEdition) {
			$_items = array();
			$this->DB_WE->query('SELECT Path FROM '.NAVIGATION_TABLE.' WHERE ((Selection="static" AND SelectionType="docLink") OR (IsFolder=1)) AND LinkID="'.$this->ID.'";');
			while($this->DB_WE->next_record()) {
				$_items[] = $this->DB_WE->f('Path');
			}
			$this->NavigationItems = makeCSVFromArray($_items,true);
		}
	}

	/**
	 * Gets the navigation folders for the current document
	 *
	 * @return Array
	 */
	function getNavigationFoldersForDoc() {
		if($this->Table==FILE_TABLE) {
			if(isset($this->DocType)) {
				$where = '((Selection="dynamic") AND (DocTypeID="'.$this->DocType.'" OR FolderID="'.$this->ParentID.'")) OR ';
				$where .= '(((Selection="static" AND SelectionType="docLink") OR (IsFolder=1 AND FolderSelection="docLink")) AND LinkID="'.$this->ID.'");';
				$query = 'SELECT ParentID FROM '.NAVIGATION_TABLE.' WHERE '.$where;
				$this->DB_WE->query($query);
				$return = array();
				while ($this->DB_WE->next_record()) {
					array_push($return,$this->DB_WE->f('ParentID'));
				}			
				return $return;
			} else {
				$query('SELECT ParentID FROM '.NAVIGATION_TABLE.' WHERE ((Selection="static" AND SelectionType="docLink") OR (IsFolder=1 AND FolderSelection="docLink")) AND LinkID="'.$this->ID.'";',$this->DB_WE);
				$this->DB_WE->query($query);
				$return = array();
				while ($this->DB_WE->next_record()) {
					array_push($return,$this->DB_WE->f('ParentID'));
				}			
				return $return;
			}
		}
		return array();
	}
	
	function insertAtIndex(){

	}

	/**
	 * Rewrites the navigation cache files
	 *
	 */
	function rewriteNavigation() {
		// rewrite filter
		if (defined('CUSTOMER_TABLE') && isset($this->documentCustomerFilter) && $this->documentCustomerFilter != false) {
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/customer/weNavigationCustomerFilter.class.php');
			weNavigationCustomerFilter::updateByFilter($this->documentCustomerFilter, $this->ID, $this->Table);
		}

		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationCache.class.php');
		$_folders = $this->getNavigationFoldersForDoc();
		$_folders = array_unique($_folders);
		foreach ($_folders as $_f) {
			weNavigationCache::cacheNavigationTree($_f);
		}

	}

	function revert_published() {

	}
}



?>