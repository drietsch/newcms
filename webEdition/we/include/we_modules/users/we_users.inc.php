<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/* the parent class of storagable webEdition classes */
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/weSuggest.class.inc.php');
if ( !( (isset($_POST["username"]) && isset($_POST["md5password"])) )) { // don't include during login
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_dynamicControls.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlTable.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_multibox.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/users.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/javaMenu/javaMenu_users.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/we_tabs.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/prefs.inc.php");
}


class we_user {

	/*
	 * VARIABLES
	 */

	// Name of the class => important for reconstructing the class from outside the class
	var $ClassName="we_user";

	// In this array are all storagable class variables
	var $persistent_slots=array();

	// Name of the Object that was createt from this class
	var $Name="";

	// ID from the database record
	var $ID=0;

	// database table in which the object is stored
	var $Table=USER_TABLE;

	// Database Object
	var $DB_WE;

	// Parent identificator
	var $ParentID=0;

	// Flag which indicates which kind of user is 0-user;1-group;2-owner group;3 - alias
	var $Type=0;

	// Flag which indicates if user is group
	var $IsFolder=0;

	// Salutation
	var $Salutation="";

	// User first name
	var $First="";

	// User second name
	var $Second="";

	// Address
	var $Address="";

	// House number
	var $HouseNo="";

	// City
	var $City="";

	// ZIP Code
	var $PLZ="";

	// Country
	var $Country="";

	// Telephone preselection
	var $Tel_preselection="";

	// Telephone
	var $Telephone="";

	// Fax preselection
	var $Fax_preselection="";

	// Fax
	var $Fax="";

	// Cell phone
	var $Handy="";

	// Email
	var $Email="";

	// Username
	var $username="";

	// User password
	var $passwd="";

	// User permissions
	var $Permissions="";

	// Flag which indicated if user inherits permissions from parent
	var $ParentPerms=0;

	// Description
	var $Description="";

	// User Prefrences
	var $Preferences=array();

	var $Text="";
	var $Path="";
	var $Alias="";
	var $Icon="user.gif";

	// Ping flag
	var $Ping=0;

	// Documents workspaces
	var $workSpace="";

	// Default documents workspaces
	var $workSpaceDef="";

	// Templpates workspaces
	var $workSpaceTmp="";

	// Navigation workspaces
	var $workSpaceNav="";

	// Objects workspaces
	var $workSpaceObj="";

	// Newsletter workspaces
	var $workSpaceNwl="";

	// Flag which indicated if user inherits files workspaces from parent
	var $ParentWs=0;

	// Flag which indicated if user inherits templates workspaces from parent
	var $ParentWst=0;

	// Flag which indicated if user inherits templates workspaces from parent
	var $ParentWsn=0;

	// Flag which indicated if user inherits objetcs workspaces from parent
	var $ParentWso=0;

	// Flag which indicated if user inherits newsletters workspaces from parent
	var $ParentWsnl=0;

	var $LoginDenied = 0;


	// Flag which indicated if user inherits templates workspaces from parent
	var $initExt=0;

	/*
	 * ADDITIONAL
	 */

	// Workspace array
	var $workspaces=array();

	// Workspace array
	var $workspaces_defaults=array();

	// Aliases array
	var $aliases=array();

	// Permissions headers array
	var $permissions_main_titles=array();

	// Permissions values array
	var $permissions_slots=array();

	// Permissions titles
	var $permissions_titles=array();

	// Extensions array
	var $extensions_slots=array();

	// Preferences array
	var $preference_slots=array();

	/*
	 * FUNCTIONS
	 */

	// Constructor
	function we_user() {
		$this->ClassName="we_user";
		$this->Name = "user_".md5(uniqid(rand()));
		array_push($this->persistent_slots,"ID","Type","ParentID","Salutation","First","Second","Address","HouseNo","City","PLZ","State","Country","Tel_preselection","Telephone","Fax","Fax_preselection","Handy","Email","username","passwd","Text","Path","Permissions","ParentPerms","Description","Alias","Icon","IsFolder","Ping","workSpace","workSpaceDef","workSpaceTmp","workSpaceNav","workSpaceNwl","workSpaceObj","ParentWs","ParentWst","ParentWsn","ParentWso","ParentWsnl","altID", "LoginDenied");

		array_push($this->preference_slots,"sizeOpt","weWidth","weHeight","usePlugin","autostartPlugin","promptPlugin","Language","seem_start_file","seem_start_type","editorSizeOpt","editorWidth","editorHeight","editorFontname","editorFontsize","editorFont","default_tree_count","force_glossary_action","force_glossary_check","cockpit_amount_columns","cockpit_amount_last_documents", "cockpit_rss_feed_url", "use_jupload");

		$this->DB_WE = new DB_WE;

		$this->workspaces[FILE_TABLE]=array();
		$this->workspaces[TEMPLATES_TABLE]=array();
		$this->workspaces[NAVIGATION_TABLE]=array();
		if(defined("OBJECT_TABLE")) {
			$this->workspaces[OBJECT_FILES_TABLE]=array();
		}
		if(defined('NEWSLETTER_TABLE')) {
			$this->workspaces[NEWSLETTER_TABLE]=array();
		}

		$this->workspaces_defaults[FILE_TABLE]=array();
		$this->workspaces_defaults[TEMPLATES_TABLE]=array();
		$this->workspaces_defaults[NAVIGATION_TABLE]=array();
		if(defined("OBJECT_TABLE")) {
			$this->workspaces_defaults[OBJECT_FILES_TABLE]=array();
		}
		if(defined('NEWSLETTER_TABLE')) {
			$this->workspaces_defaults[NEWSLETTER_TABLE]=array();
		}

		$this->Preferences['use_jupload'] = f("SELECT MAX(use_jupload) as mju FROM " . PREFS_TABLE . ";",'mju',$this->DB_WE);

		foreach($this->preference_slots as $key => $val) {
			$value = null;
			$this->Preferences[$val]	= $value;
		}

		$this->initType(0);
	}

	#--------------------------------------------------------------------------#

	function initType($typ,$ext=0) {
		$this->Type=$typ;
		if($typ==2)
			$this->Icon="user_alias.gif";
		else if($typ==1)
			$this->Icon="usergroup.gif";
		else
			$this->Icon="user.gif";
		$this->mapPermissions();
		if($ext) {
			$this->initExt=$ext;
			foreach($this->extensions_slots as $k=>$v)
				$this->extensions_slots[$k]->init($this);
		}
	}

	#--------------------------------------------------------------------------#

	// Intialize the class
	function initFromDB($id) {
		$ret=false;
		if($id) {
			$this->DB_WE->query("SELECT * FROM ".USER_TABLE." WHERE ID='".$id."'");
			if($this->DB_WE->next_record()) {
				$this->ID=$id;
				$this->getPersistentSlotsFromDB();
				$this->getPreferenceSlotsFromDB();
				$ret=true;
			}
			$this->loadWorkspaces();
			$this->mapPermissions();
		}
		return $ret;
	}

	#--------------------------------------------------------------------------#

	function savePersistentSlotsInDB() {
		$this->ModDate = time();
		$tableInfo = $this->DB_WE->metadata($this->Table);
		if($this->ID) {
			$updt = "";
			for($i=0;$i<sizeof($tableInfo);$i++) {
				$fieldName = $tableInfo[$i]["name"];
				eval('$val = isset($this->'.$fieldName.') ? $this->'.$fieldName.' : "0";');
				if($fieldName != 'ID') {
					if($fieldName == 'editorFontname' && $this->Preferences['editorFont'] == '0') {
						$val = 'none';
					} elseif($fieldName == 'editorFontsize' && $this->Preferences['editorFont'] == '0') {
						$val = '-1';
					}
					$updt .= $fieldName."='".addslashes($val)."',";
				}
			}
			$updt = ereg_replace('(.+),$','\1',$updt);
			$q = "UPDATE $this->Table SET $updt WHERE ID='$this->ID'";
			$this->DB_WE->query($q);
		}
		else {
			$keys = "";
			$vals = "";
			for($i=0;$i<sizeof($tableInfo);$i++) {
				$fieldName = $tableInfo[$i]["name"];
				eval('$val = isset($this->'.$fieldName.') ? $this->'.$fieldName.' : "" ;');
				if($fieldName != "ID") {
					$keys .= $fieldName.",";
					$vals .= "'".addslashes($val)."',";
				}
			}
			if($keys) {
				$keys = "(".substr($keys,0,strlen($keys)-1).")";
				$vals = "VALUES(".substr($vals,0,strlen($vals)-1).")";
				$q = "INSERT INTO ".$this->Table." $keys $vals";
				$this->DB_WE->query($q);
				$this->ID = f("SELECT max(ID) as ID from ".$this->Table,"ID",$this->DB_WE);
			}
		}
	}

	function createAccount(){
		if(defined('MESSAGING_SYSTEM')) {
			require_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_modules/messaging/messaging_interfaces.inc.php');
			msg_create_folders($this->ID);
		}
	}

	function removeAccount(){
		if(defined('MESSAGING_SYSTEM')) {
			$this->DB_WE->query('DELETE FROM ' . MSG_ADDRBOOK_TABLE . ' WHERE UserID = ' . $this->ID);
			$this->DB_WE->query('DELETE FROM ' . MESSAGES_TABLE . ' WHERE UserID = ' . $this->ID);
			$this->DB_WE->query('DELETE FROM ' . MSG_TODO_TABLE . ' WHERE UserID = ' . $this->ID);
			$this->DB_WE->query('DELETE FROM ' . MSG_TODOHISTORY_TABLE . ' WHERE UserID = ' . $this->ID);
			$this->DB_WE->query('DELETE FROM ' . MSG_FOLDERS_TABLE . ' WHERE UserID = ' . $this->ID);
			$this->DB_WE->query('DELETE FROM ' . MSG_ACCOUNTS_TABLE . ' WHERE UserID = ' . $this->ID);
			$this->DB_WE->query('DELETE FROM ' . MSG_SETTINGS_TABLE . ' WHERE UserID = ' . $this->ID);
		}
	}

	#--------------------------------------------------------------------------#

	function getPersistentSlotsFromDB() {
		$tableInfo = $this->DB_WE->metadata($this->Table);
		$this->DB_WE->query("SELECT * FROM ".USER_TABLE." WHERE ID='".$this->ID."'");
		for($i=0;$i<sizeof($tableInfo);$i++) {
			$fieldName = $tableInfo[$i]["name"];
			if(in_array($fieldName,$this->persistent_slots)) {
				$foo = $this->DB_WE->f($fieldName);
				eval('$this->'.$fieldName.'=$foo;');
			}
		}
	}

	#--------------------------------------------------------------------------#

	function saveToDB() {
		$db_tmp=new DB_WE();
		$isnew=$this->ID ? false : true;
		if($this->Type==1 && $this->ID!=0) {
			if($this->ParentID==0)
				$ppath="/";
			else
				$ppath=$this->getPath($this->ParentID);
			$dpath=$this->getPath($this->ID);
			if(ereg($dpath,$ppath))
				return -5;
		}
		if($this->Type==2) {
			$foo=getHash("SELECT ID,username FROM ".USER_TABLE." WHERE ID='".$this->Alias."'",$this->DB_WE);
			$uorginal=$foo["ID"];
			$search=true;
			$ount=0;
			$try_name="@".$foo["username"];
			$try_text=$foo["username"];
			while($search) {
				$this->DB_WE->query("SELECT username FROM ".USER_TABLE." WHERE ID<>'".$this->ID."' AND ID<> '".$uorginal."' AND username='".$try_name."'");
				if(!$this->DB_WE->next_record()) {
					$search=false;
				}
				else {
					$ount++;
					$try_name=$try_name."_".$ount;
				}
			}
			$this->username=$try_name;
			$this->Text=$try_text;
		}
		else {
			$this->Text=$this->username;
		}
		if($this->Type==1)
			$this->IsFolder=1;
		else
			$this->IsFolder=0;
		$this->Path=$this->getPath($this->ID);
		$oldpath=$this->Path;
		$this->saveWorkspaces();
		$this->savePermissions();
		$this->savePersistentSlotsInDB();
		$this->createAccount();
		if($oldpath!="" && $oldpath!="/" && isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])) {
			$this->DB_WE->query("SELECT ID,username FROM ".USER_TABLE." WHERE Path LIKE '".$oldpath."%'");
			while($this->DB_WE->next_record()) {
				$db_tmp->query("UPDATE ".USER_TABLE." SET Path='".$this->getPath($this->DB_WE->f("ID"))."' WHERE ID='".$this->DB_WE->f("ID")."'");
			}
		}
		$this->savePreferenceSlotsInDB($isnew);

		$_REQUEST["uid"]=$this->ID;

		return $this->saveToSession();
	}

	#--------------------------------------------------------------------------#

	function saveToSession() {

		if($this->ID != $_SESSION['user']['ID']) {
			return "";
		}

		$save_javascript = "
		var _multiEditorreload = false;
		";

		$save_javascript .= $this->rememberPreference(isset($this->Preferences['Language']) ? $this->Preferences['Language'] : null, 'Language');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['default_tree_count']) ? $this->Preferences['default_tree_count'] : null, 'default_tree_count');
		if(isset($this->Preferences['seem_start_type'])) {
			if($this->Preferences['seem_start_type'] == "cockpit") {
				$save_javascript .= $this->rememberPreference(0, 'seem_start_file');
				$save_javascript .= $this->rememberPreference("cockpit", 'seem_start_type');
			} elseif($this->Preferences['seem_start_type'] == "object") {
				$save_javascript .= $this->rememberPreference(isset($this->Preferences['seem_start_object']) ? $this->Preferences['seem_start_object'] : 0, 'seem_start_file');
				$save_javascript .= $this->rememberPreference("cockpit", 'seem_start_type');
			} else {
				$save_javascript .= $this->rememberPreference(isset($this->Preferences['seem_start_document']) ? $this->Preferences['seem_start_document'] : 0, 'seem_start_file');
				$save_javascript .= $this->rememberPreference("cockpit", 'seem_start_type');
			}
		}
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['sizeOpt']) ? $this->Preferences['sizeOpt'] : null, 'sizeOpt');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['weWidth']) ? $this->Preferences['weWidth'] : null, 'weWidth');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['weHeight']) ? $this->Preferences['weHeight'] : null, 'weHeight');

		$save_javascript .= $this->rememberPreference(isset($this->Preferences['editorFont']) ? $this->Preferences['editorFont'] : null, 'editorFont');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['editorFontname']) ? $this->Preferences['editorFontname'] : null, 'editorFontname');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['editorFontsize']) ? $this->Preferences['editorFontsize'] : null, 'editorFontsize');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['editorSizeOpt']) ? $this->Preferences['editorSizeOpt'] : null, '$_POST["editorSizeOpt');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['editorWidth']) ? $this->Preferences['editorWidth'] : null, 'editorWidth');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['editorHeight']) ? $this->Preferences['editorHeight'] : null, 'editorHeight');

		$save_javascript .= $this->rememberPreference(isset($this->Preferences['force_glossary_action']) ? $this->Preferences['force_glossary_action'] : null, 'force_glossary_action');
		$save_javascript .= $this->rememberPreference(isset($this->Preferences['force_glossary_check']) ? $this->Preferences['force_glossary_check'] : null, 'force_glossary_check');

		return $save_javascript;

	}

	#--------------------------------------------------------------------------#

function mapPermissions() {
		$this->permissions_main_titles=array();
		$this->permissions_slots=array();
		$this->permissions_titles=array();
		$permissions=unserialize($this->Permissions);

		$entries = array();
		include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
		$entries = weToolLookup::getPermissionIncludes();

		$d = dir(WE_USERS_MODULE_DIR."perms");
		while($file=$d->read()) {
			if(ereg('^we_perms_',$file)) {
				$entries[] = WE_USERS_MODULE_DIR . "perms/" . $file;
			}
		}
		$d->close();

		foreach($entries as $entry) {

				$perm_group_name="";
				$perm_values=array();
				$perm_titles=array();
				$perm_group_title=array();
				include($entry);
				if(!($perm_group_name=="administrator" && $this->Type!=0)) {
					if($perm_group_name) {
						if(!isset($this->permissions_main_titles[$perm_group_name]))
							$this->permissions_main_titles[$perm_group_name] = "";
						if(!isset($this->permissions_slots[$perm_group_name]))
							$this->permissions_slots[$perm_group_name]=array();
						if(!isset($this->permissions_titles[$perm_group_name]))
							$this->permissions_titles[$perm_group_name] = "";
						if(is_array($perm_values[$perm_group_name]))
							foreach($perm_values[$perm_group_name] as $k=>$v) {
								$set=false;
								if(is_array($permissions)) {
									foreach($permissions as $pk=>$pv) {
										if($v==$pk) {
											if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])) {
												$set=true;
												$this->permissions_slots[$perm_group_name][$pk]=$pv;
											}
											else {
												if($pk=="PUBLISH" || $pk=="ADMINISTRATOR") {
													$set=true;
													$this->permissions_slots[$perm_group_name][$pk]=$pv;
												}
											}
										}
									}
								}
								if(!$set) {
									if(is_array($perm_defaults[$perm_group_name]))
										$this->permissions_slots[$perm_group_name][$v]=$perm_defaults[$perm_group_name][$v];
									else
										$this->permissions_slots[$perm_group_name][$v]=0;
								}
							}

							$this->permissions_main_titles[$perm_group_name]=$perm_group_title[$perm_group_name];

							if(is_array($perm_titles[$perm_group_name])){
								foreach($perm_titles[$perm_group_name] as $key=>$val) {
									$this->permissions_titles[$perm_group_name][$key]=$val;
								}
							}
				}
			}
		}
	}

	#--------------------------------------------------------------------------#

	function setPermissions() {
		foreach($this->perm_branches as $key=>$val) {
			foreach($val as $k=>$v) {
				$this->Permissions[$k]=$this->permissions_slots[$v];
			}
		}
	}

	#--------------------------------------------------------------------------#

	function setPermission($perm_name,$perm_value) {
		foreach($this->permissions_slots as $key=>$val) {
			foreach($val as $k=>$v) {
				if($perm_name==$k)
					$this->permissions_slots[$key][$k]=$perm_value;
			}
		}
	}

	#--------------------------------------------------------------------------#

	function savePermissions() {
		$permissions=array();
		foreach($this->permissions_slots as $key=>$val) {
			foreach($val as $k=>$v) {
				$permissions[$k]=$v;
			}
		}
		$this->Permissions=serialize($permissions);
	}

	#--------------------------------------------------------------------------#

	function loadWorkspaces() {
		if($this->workSpace)
			$this->workspaces[FILE_TABLE]=makeArrayFromCSV($this->workSpace);
		if($this->workSpaceTmp)
			$this->workspaces[TEMPLATES_TABLE]=makeArrayFromCSV($this->workSpaceTmp);
		if($this->workSpaceNav)
			$this->workspaces[NAVIGATION_TABLE]=makeArrayFromCSV($this->workSpaceNav);
		if(defined("OBJECT_TABLE")) {
			if($this->workSpaceObj)
				$this->workspaces[OBJECT_FILES_TABLE]=makeArrayFromCSV($this->workSpaceObj);
		}
		if(defined("NEWSLETTER_TABLE")) {
			if($this->workSpaceNwl)
				$this->workspaces[NEWSLETTER_TABLE]=makeArrayFromCSV($this->workSpaceNwl);
		}

		if($this->workSpaceDef)
			$this->workspaces_defaults[FILE_TABLE]=makeArrayFromCSV($this->workSpaceDef);
	}

	#--------------------------------------------------------------------------#

	function saveWorkspaces() {
		foreach($this->workspaces as $k=>$v) {
			$new_array=array();
			foreach($v as $key=>$val)
				if($val!=0)
					array_push($new_array,$this->workspaces[$k][$key]);
			$this->workspaces[$k]=$new_array;
		}

		$this->workSpace=makeCSVFromArray($this->workspaces[FILE_TABLE],true,",");
		$this->workSpaceTmp=makeCSVFromArray($this->workspaces[TEMPLATES_TABLE],true,",");
		$this->workSpaceNav=makeCSVFromArray($this->workspaces[NAVIGATION_TABLE],true,",");
		if(defined("OBJECT_TABLE")) {
			$this->workSpaceObj=makeCSVFromArray($this->workspaces[OBJECT_FILES_TABLE],true,",");
		}
		if(defined("NEWSLETTER_TABLE")) {
			$this->workSpaceNwl=makeCSVFromArray($this->workspaces[NEWSLETTER_TABLE],true,",");
		}
		foreach($this->workspaces_defaults as $k=>$v) {
			$new_array=array();
			foreach($v as $key=>$val)
				if($val!=0)
					array_push($new_array,$this->workspaces_defaults[$k][$key]);
			$this->workspaces_defaults[$k]=$new_array;
		}
		if(count($this->workspaces[FILE_TABLE])!=0) {
			$this->workSpaceDef=makeCSVFromArray($this->workspaces_defaults[FILE_TABLE],true,",");
		}else{
			$this->workSpaceDef="";
		}

		// if no workspaces are set, take workspaces from creator
		if(empty($this->workSpace)) {
        	$_uws = get_ws(FILE_TABLE,true);
        	if(!empty($_uws)){
        		$this->workSpace = $_uws;
        		$this->workspaces[FILE_TABLE] = makeArrayFromCSV($_uws);
        	}
        }
        if(empty($this->workSpaceTmp)) {
        	$_uws = get_ws(TEMPLATES_TABLE,true);
        	if(!empty($_uws)){
        		$this->workSpaceTmp = $_uws;
        		$this->workspaces[TEMPLATES_TABLE] = makeArrayFromCSV($_uws);
        	}
        }
        if(empty($this->workSpaceNav)) {
        	$_uws = get_ws(NAVIGATION_TABLE,true);
        	if(!empty($_uws)){
        		$this->workSpaceNav = makeArrayFromCSV($_uws);
        		$this->workspaces[NAVIGATION_TABLE] = makeArrayFromCSV($_uws);
        	}
        }

        if(defined('OBJECT_FILES_TABLE') &&  empty($this->workSpaceObj)) {
        	$_uws = get_ws(OBJECT_FILES_TABLE,true);
        	if(!empty($_uws)){
        		$this->workSpaceObj = makeArrayFromCSV($_uws);
        		$this->workspaces[OBJECT_FILES_TABLE] = makeArrayFromCSV($_uws);
        	}
        }
         if(defined('NEWSLETTER_TABLE') &&empty($this->workSpaceNwl)) {
        	$_uws = get_ws(NEWSLETTER_TABLE,true);
        	if(!empty($_uws)){
        		$this->workSpaceNwl = makeArrayFromCSV($_uws);
        		$this->workspaces[NEWSLETTER_TABLE] = makeArrayFromCSV($_uws);
        	}
        }

	}

	#--------------------------------------------------------------------------#

	function getPreferenceSlotsFromDB() {
		$tableInfo = $this->DB_WE->metadata(PREFS_TABLE);
		$this->DB_WE->query("SELECT * FROM ".PREFS_TABLE." WHERE userID='".$this->ID."'");
		$this->DB_WE->next_record();
		for($i=0;$i<sizeof($tableInfo);$i++) {
			$fieldName = $tableInfo[$i]["name"];
			if(in_array($fieldName,$this->preference_slots)) {
				$this->Preferences[$fieldName] = $this->DB_WE->f($fieldName);
			}
		}

	}

	#--------------------------------------------------------------------------#

	function setPreference($name, $value) {
		foreach($this->preference_slots as $key => $val) {
			if($name == $val) {
				$this->Preferences[$name] = $value;
			}
		}
	}

	#--------------------------------------------------------------------------#

	function savePreferenceSlotsInDB($isnew = false) {
		if($this->Type != 0) {
			return;
		}

		$this->ModDate = time();
		$tableInfo = $this->DB_WE->metadata(PREFS_TABLE);
		if(!$isnew) {
			$updt = "";
			for($i = 0; $i < sizeof($tableInfo); $i++) {
				$fieldName = $tableInfo[$i]["name"];
				if(in_array($fieldName, $this->preference_slots) && $fieldName != "userID") {
					if($fieldName == "editorFontsize" && $this->Preferences['editorFont'] != "1") {
						$this->Preferences[$fieldName] = "-1";
					} elseif($fieldName == "editorFontname" && $this->Preferences['editorFont'] != "1") {
						$this->Preferences[$fieldName] = "none";
					}
					$updt .= $fieldName."='".addslashes($this->Preferences[$fieldName])."',";
				}
			}
			$updt = ereg_replace('(.+),$','\1', $updt);
			$q = 'UPDATE '.PREFS_TABLE.' SET '.$updt.' WHERE userID="'.$this->ID.'"';
			$this->DB_WE->query($q);
		} else {
			$q = 		"INSERT INTO ".PREFS_TABLE." ("
					.	"userID, "
					.	"FileFilter, "
					.	"openFolders_tblFile, "
					.	"openFolders_tblTemplates, "
					.	"DefaultTemplateID, "
					.	"sizeOpt, "
					.	"weWidth, "
					.	"weHeight, "
					.	"usePlugin, "
					.	"autostartPlugin, "
					.	"promptPlugin, "
					.	"Language,"
					.	"seem_start_file,"
					.	"seem_start_type,"
					.	"editorSizeOpt,"
					.	"editorWidth,"
					.	"editorHeight,"
					.	"editorFontname,"
					.	"editorFontsize,"
					.	"editorFont,"
					.	"default_tree_count,"
					.	"force_glossary_check,"
					.	"force_glossary_action,"
					.	"cockpit_amount_columns,"
					.	"cockpit_amount_last_documents,"
					.	"cockpit_rss_feed_url,"
					.	"use_jupload"
					.	") VALUES ("
					.	"'".$this->ID."', "
					.	"'0', "
					.	"'', "
					.	"'', "
					.	"'0', "
					.	"'".($this->Preferences['sizeOpt'] ? 1 : 0)."', "
					.	"'".($this->Preferences['weWidth'] ? $this->Preferences['weWidth'] : 0)."', "
					.	"'".($this->Preferences['weHeight'] ? $this->Preferences['weHeight'] : 0)."', "
					.	"'".($this->Preferences['usePlugin'] == '1' ? 1 : 0)."', "
					.	"'".($this->Preferences['autostartPlugin'] == '1' ? 1 : 0)."', "
					.	"'".($this->Preferences['promptPlugin'] == '1' ? 1 : 0)."', "
					.	"'".$this->Preferences['Language']."', "
					.	"'".($this->Preferences['seem_start_file'] ? $this->Preferences['seem_start_file'] : 0)."', "
					.	"'".$this->Preferences['seem_start_type']."', "
					.	"'".($this->Preferences['editorSizeOpt'] == '1' ? 1 : 0)."', "
					.	"'".($this->Preferences['editorWidth'] ? $this->Preferences['editorWidth'] : 0)."', "
					.	"'".($this->Preferences['editorHeight'] ? $this->Preferences['editorHeight'] : 0)."', "
					.	"'".($this->Preferences['editorFont'] == '1' ? $this->Preferences['editorFontname'] : 'none')."', "
					.	"'".($this->Preferences['editorFont'] == '1' ? $this->Preferences['editorFontsize'] : '-1')."', "
					.	"'".($this->Preferences['editorFont'] ? '1' : '0')."', "
					.	"'".($this->Preferences['default_tree_count'] ? $this->Preferences['default_tree_count'] : 0)."',"
					.	"'".($this->Preferences['force_glossary_check'] == '1' ? 1 : 0)."',"
					.	"'".($this->Preferences['force_glossary_action'] == '1' ? 1 : 0)."',"
					.	"'".$this->Preferences['cockpit_amount_columns']."',"
					.	"'".$this->Preferences['cockpit_amount_last_documents']."',"
					.	"'".$this->Preferences['cockpit_rss_feed_url']."',"
					.	"'".$this->Preferences['use_jupload']."'"
					.	")";
			$this->DB_WE->query($q);
		}
	}

	#--------------------------------------------------------------------------#

	function rememberPreference($settingvalue, $settingname) {

		$save_javascript = "";

		if (isset($settingvalue) && ($settingvalue != null)) {
			switch ($settingname) {
				case 'Language':
					$_SESSION["prefs"]["Language"] = $settingvalue;

					if ($settingvalue != $GLOBALS["WE_LANGUAGE"]) {
						$save_javascript .= "
							if (top.frames[0]) {
								top.frames[0].location.reload();
							}

							if (parent.frames[0]) {
								parent.frames[0].location.reload();
							}

							// Tabs Module User
							if (top.content.user_resize.user_right.user_editor.user_edheader) {
								top.content.user_resize.user_right.user_editor.user_edheader.location = top.content.user_resize.user_right.user_editor.user_edheader.location +'?tab='+top.content.user_resize.user_right.user_editor.user_edheader.activeTab;
							}

							// Editor Module User
							if (top.content.user_resize.user_right.user_editor.user_properties) {
								top.content.user_resize.user_right.user_editor.user_properties.location = top.content.user_resize.user_right.user_editor.user_properties.location +'?tab=".$_REQUEST['tab']."&perm_branch='+top.content.user_resize.user_right.user_editor.user_properties.opened_group;
							}

							// Save Module User
							if (top.content.user_resize.user_right.user_editor.user_edfooter) {
								top.content.user_resize.user_right.user_editor.user_edfooter.location.reload();
							}
							if (top.opener.top.header) {
								top.opener.top.header.location.reload();
							}
							if (top.opener.top.rframe && top.opener.top.rframe.bframe && top.opener.top.rframe.bframe.bm_vtabs) {
								if (top.opener.top.table) {
									top.opener.top.weEditorFrameController.getActiveDocumentReference().bm_vtabs.location='/webEdition/we_vtabs.php?table=' + top.opener.top.table;
								}
							}
							if (top.opener.top.rframe.bframe.bm_vtabs) {
								top.opener.top.rframe.bframe.bm_vtabs.location.reload();
							}

							// reload all frames of an editor
							// reload current document => reload all open Editors on demand
							var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
							for (frameId in _usedEditors) {

								if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
									_usedEditors[frameId].setEditorReloadAllNeeded(true);
									_usedEditors[frameId].setEditorIsActive(true);

								} else {
									_usedEditors[frameId].setEditorReloadAllNeeded(true);
								}
							}
							_multiEditorreload = true;
							";
					}
					break;

				case 'seem_start_type':
					if($settingvalue == "cockpit") {
						$_SESSION["prefs"]["seem_start_file"] = 0;
						$_SESSION["prefs"]["seem_start_type"] = "cockpit";

					} elseif($settingvalue == "object") {
						$_SESSION["prefs"]["seem_start_file"] = $_REQUEST["seem_start_object"];
						$_SESSION["prefs"]["seem_start_type"] = "object";

					} else {
						$_SESSION["prefs"]["seem_start_file"] = $_REQUEST["seem_start_document"];
						$_SESSION["prefs"]["seem_start_type"] = "document";

					}
					break;

				case 'sizeOpt':
					if ($settingvalue == 0) {
						$_SESSION["prefs"]["weWidth"] = 0;
						$_SESSION["prefs"]["weHeight"] = 0;
						$_SESSION["prefs"]["sizeOpt"] = 0;
					} else if (($settingvalue == 1) && (isset($_POST["weWidth"]) && is_numeric($_POST["weWidth"])) && (isset($_POST["weHeight"]) && is_numeric($_POST["weHeight"]))) {
						$_SESSION["prefs"]["sizeOpt"] = 1;
					}
					break;

				case 'weWidth':
					if ($_SESSION["prefs"]["sizeOpt"] == 1) {
						$_generate_java_script = false;

						if ($_SESSION["prefs"]["weWidth"] != $settingvalue) {
							$_generate_java_script = true;
						}

						$_SESSION["prefs"]["weWidth"] = $settingvalue;

						if ($_generate_java_script) {
							$save_javascript .= "
								top.opener.top.resizeTo(" . $settingvalue . ", " . $_POST["weHeight"] . ");
								top.opener.top.moveTo((screen.width / 2) - " . ($settingvalue / 2) . ", (screen.height / 2) - " . ($_POST["weHeight"] / 2) . ");
							";
						}
					}
					break;

				case 'weHeight':
					if ($_SESSION["prefs"]["sizeOpt"] == 1) {
						$_SESSION["prefs"]["weHeight"] = $settingvalue;
					}
					break;


				case 'editorFont':
					if ($settingvalue == 0) {
						$_SESSION["prefs"]["editorFontname"] = "none";
						$_SESSION["prefs"]["editorFontsize"] = -1;
						$_SESSION["prefs"]["editorFont"] = 0;
					} else if (($settingvalue == 1) && isset($_POST["editorFontname"]) && isset($_POST["editorFontsize"])) {
						$_SESSION["prefs"]["editorFont"] = 1;
					}

					$save_javascript .= "
					if ( !_multiEditorreload ) {
						var _usedEditors =  top.opener.top.weEditorFrameController.getEditorsInUse();

							for (frameId in _usedEditors) {

								if ( (_usedEditors[frameId].getEditorEditorTable() == \"" . TEMPLATES_TABLE . "\" || " . (defined("OBJECT_TABLE") ? " _usedEditors[frameId].getEditorEditorTable() == \"" . OBJECT_FILES_TABLE . "\" || " : "") . " _usedEditors[frameId].getEditorEditorTable() == \"" . FILE_TABLE . "\") &&
									_usedEditors[frameId].getEditorEditPageNr() == " . WE_EDITPAGE_CONTENT . " ) {

									if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
										_usedEditors[frameId].setEditorReloadNeeded(true);
										_usedEditors[frameId].setEditorIsActive(true);
									} else {
										_usedEditors[frameId].setEditorReloadNeeded(true);
									}
								}
							}
					}
					_multiEditorreload = true;
					";
					break;

				case 'editorFontname':
					if ($_SESSION["prefs"]["editorFont"] == 1) {
						$_SESSION["prefs"]["editorFontname"] = $settingvalue;
					}
					break;

				case 'editorFontsize':
					if ($_SESSION["prefs"]["editorFont"] == 1) {
						$_SESSION["prefs"]["editorFontsize"] = $settingvalue;
					}
					break;

				case 'editorSizeOpt':
					if ($settingvalue == 0) {
						$_SESSION["prefs"]["editorWidth"] = 0;
						$_SESSION["prefs"]["editorHeight"] = 0;
						$_SESSION["prefs"]["editorSizeOpt"] = 0;
					} else if (($settingvalue == 1) && isset($_POST["editorWidth"]) && isset($_POST["editorHeight"])) {
						$_SESSION["prefs"]["editorSizeOpt"] = 1;
					}

					if (!$editor_reloaded) {
						$editor_reloaded = true;

						$save_javascript .= "
					if ( !_multiEditorreload ) {
						var _usedEditors =  top.opener.top.weEditorFrameController.getEditorsInUse();

							for (frameId in _usedEditors) {

								if ( (_usedEditors[frameId].getEditorEditorTable() == \"" . TEMPLATES_TABLE . "\" || " . (defined("OBJECT_TABLE") ? " _usedEditors[frameId].getEditorEditorTable() == \"" . OBJECT_FILES_TABLE . "\" || " : "") . " _usedEditors[frameId].getEditorEditorTable() == \"" . FILE_TABLE . "\") &&
									_usedEditors[frameId].getEditorEditPageNr() == " . WE_EDITPAGE_CONTENT . " ) {

									if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
										_usedEditors[frameId].setEditorReloadNeeded(true);
										_usedEditors[frameId].setEditorIsActive(true);
									} else {
										_usedEditors[frameId].setEditorReloadNeeded(true);
									}
								}
							}
					}
					_multiEditorreload = true;
					";
					}
					break;

				case 'editorWidth':
					if ($_SESSION["prefs"]["editorSizeOpt"] == 1) {
						$_SESSION["prefs"]["editorWidth"] = $settingvalue;
					}
					break;

				case 'editorHeight':
					if ($_SESSION["prefs"]["editorSizeOpt"] == 1) {
						$_SESSION["prefs"]["editorHeight"] = $settingvalue;
					}
					break;

				case 'default_tree_count':
					$_SESSION["prefs"]["default_tree_count"] = $settingvalue;
					break;

				case 'force_glossary_check':
					$_SESSION["prefs"]["force_glossary_check"] = $settingvalue;
					break;

				case 'force_glossary_action':
					$_SESSION["prefs"]["force_glossary_action"] = $settingvalue;
					break;

				case 'cockpit_amount_columns':
					$_SESSION["prefs"]["cockpit_amount_columns"] = $settingvalue;
					break;

				default:
					break;
			}

		} else {

			switch ($settingname) {

				case 'editorFont':
					$_SESSION["prefs"]["editorFontname"] = "none";
					$_SESSION["prefs"]["editorFontsize"] = -1;
					$_SESSION["prefs"]["editorFont"] = 0;

					$save_javascript .= "
					if ( !_multiEditorreload ) {
						var _usedEditors =  top.opener.top.weEditorFrameController.getEditorsInUse();

							for (frameId in _usedEditors) {

								if ( (_usedEditors[frameId].getEditorEditorTable() == \"" . TEMPLATES_TABLE . "\" || " . (defined("OBJECT_TABLE") ? " _usedEditors[frameId].getEditorEditorTable() == \"" . OBJECT_FILES_TABLE . "\" || " : "") . " _usedEditors[frameId].getEditorEditorTable() == \"" . FILE_TABLE . "\") &&
									_usedEditors[frameId].getEditorEditPageNr() == " . WE_EDITPAGE_CONTENT . " ) {

									if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
										_usedEditors[frameId].setEditorReloadNeeded(true);
										_usedEditors[frameId].setEditorIsActive(true);
									} else {
										_usedEditors[frameId].setEditorReloadNeeded(true);
									}
								}
							}
					}
					_multiEditorreload = true;
					";
					break;

				case 'force_glossary_check':
					$_SESSION["prefs"]["force_glossary_check"] = 0;
					break;

				case 'force_glossary_action':
					$_SESSION["prefs"]["force_glossary_action"] = 0;
					break;

				default:
					break;
			}

		}

		return $save_javascript;

	}

	#--------------------------------------------------------------------------#

	function preserveState($tab,$sub_tab) {

		if($tab==0) {
			foreach($this->persistent_slots as $pkey=>$pval) {
				$obj=$this->Name."_".$pval;
				if(isset($_POST[$obj])) {
					if($pval=="passwd" && $_POST[$obj]!="")
						eval('$this->'.$pval.'="'.$_POST[$obj].'";');
					else
						eval('$this->'.$pval.'="'.$_POST[$obj].'";');
				}
			}
			if($this->Type==2) {
				$obj=$this->Name.'_ParentPerms';
				if(isset($_POST[$obj]))
					$this->ParentPerms=1;
				else
					$this->ParentPerms=0;
				$obj=$this->Name.'_ParentWs';
				if(isset($_POST[$obj]))
					$this->ParentWs=1;
				else
					$this->ParentWs=0;
				$obj=$this->Name.'_ParentWst';
				if(isset($_POST[$obj]))
					$this->ParentWst=1;
				else
					$this->ParentWst=0;

				$obj=$this->Name.'_ParentWso';
				if(isset($_POST[$obj]))
					$this->ParentWso=1;
				else
					$this->ParentWso=0;

				$obj=$this->Name.'_ParentWsn';
				if(isset($_POST[$obj]))
					$this->ParentWsn=1;
				else
					$this->ParentWsn=0;

				$obj=$this->Name.'_ParentWsnl';
				if(isset($_POST[$obj]))
					$this->ParentWsnl=1;
				else
					$this->ParentWsnl=0;

			}
		}
		if($tab==0 && !(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"]))) {
			if(isset($_POST[$this->Name.'_ADMIN']) && $_POST[$this->Name.'_ADMIN']){
				$this->setPermission("ADMINISTRATOR",1);
			}else{
				$this->setPermission("ADMINISTRATOR",0);
			}
			if(isset($_POST[$this->Name.'_PUBLISH']) && $_POST[$this->Name.'_PUBLISH']){
				$this->setPermission("PUBLISH",1);
			}else{
				$this->setPermission("PUBLISH",0);
			}
			$obj=$this->Name.'_workSpace';
			if(isset($_POST[$obj])){
				$this->workspaces[FILE_TABLE][0]=$_POST[$obj];
			}else{
				$this->workspaces[FILE_TABLE][0]=array();
			}
			return;
		}
		if($tab==1) {
			foreach($this->permissions_slots as $pkey=>$pval) {
				foreach($pval as $k=>$v) {

					$obj=$this->Name.'_Permission_'.$k;
					if(isset($_POST[$obj]))
						$this->setPermission($k,1);
					else
						$this->setPermission($k,0);
				}
			}
			$obj=$this->Name.'_ParentPerms';
			if(isset($_POST[$obj]))
				$this->ParentPerms=1;
			else
				$this->ParentPerms=0;
		}
		if($tab==2) {
			foreach($this->workspaces as $k=>$v) {
				$obj=$this->Name.'_Workspace_'.$k.'_Values';
				if(isset($_POST[$obj])) {
					if($_POST[$obj]!="")
						$this->workspaces[$k]=explode(",",$_POST[$obj]);
					else
						$this->workspaces[$k]=array();
				}
				$obj=$this->Name.'_defWorkspace_'.$k.'_Values';
				if(isset($_POST[$obj])) {
					if($_POST[$obj]!="") {
						$this->workspaces_defaults[$k]=explode(",",$_POST[$obj]);
					}
					else
						$this->workspaces_defaults[$k]=array();
				}
			}
			$obj=$this->Name.'_ParentWs';
			if(isset($_POST[$obj]))
				$this->ParentWs=1;
			else
				$this->ParentWs=0;
			$obj=$this->Name.'_ParentWst';
			if(isset($_POST[$obj]))
				$this->ParentWst=1;
			else
				$this->ParentWst=0;

			$obj=$this->Name.'_ParentWso';
			if(isset($_POST[$obj]))
				$this->ParentWso=1;
			else
				$this->ParentWso=0;

			$obj=$this->Name.'_ParentWsn';
			if(isset($_POST[$obj]))
				$this->ParentWsn=1;
			else
				$this->ParentWsn=0;

			$obj=$this->Name.'_ParentWsnl';
			if(isset($_POST[$obj]))
				$this->ParentWsnl=1;
			else
				$this->ParentWsnl=0;
		}
		if($tab==3) {
			foreach($this->preference_slots as $key => $val) {
				if($val == "seem_start_file" || $val == "seem_start_type") {
				} else {
					$obj=$this->Name.'_Preference_'.$val;
				}
				if(isset($_POST[$obj])) {
					$this->setPreference($val,$_POST[$obj]);
				} else {
					$this->setPreference($val,0);
				}
			}
			if($_REQUEST['seem_start_type'] == "cockpit") {
				$this->setPreference("seem_start_file", 0);
				$this->setPreference("seem_start_type", "cockpit");

			} elseif($_REQUEST['seem_start_type'] == "object") {
				$this->setPreference("seem_start_file", $_REQUEST["seem_start_object"]);
				$this->setPreference("seem_start_type", "object");

			} else {
				$this->setPreference("seem_start_file", $_REQUEST["seem_start_document"]);
				$this->setPreference("seem_start_type", "document");

			}
		}
		foreach($this->extensions_slots as $k=>$v) {
			$this->extensions_slots[$k]->perserve($tab,$sub_tab);
		}
	}

	#--------------------------------------------------------------------------#

	function checkPermission($perm) {
		foreach($this->permissions_slots as $key=>$val) {
			foreach($val as $key=>$val) {
				if($key==$perm) {
					if($val) {
						return true;
					}
					else {
						return false;
					}
				}
			}
		}
		return false;
	}

	#--------------------------------------------------------------------------#

	function resetOwnersCreatorModifier() {
		$newID = $_SESSION["user"]["ID"];
		$this->DB_WE->query("UPDATE ".FILE_TABLE." SET Owners=REPLACE(Owners,',".$this->ID.",',',')");
		$this->DB_WE->query("UPDATE ".FILE_TABLE." SET Owners='' WHERE Owners=','");
		$this->DB_WE->query("UPDATE ".TEMPLATES_TABLE." SET Owners=REPLACE(Owners,',".$this->ID.",',',')");
		$this->DB_WE->query("UPDATE ".TEMPLATES_TABLE." SET Owners='' WHERE Owners=','");
		$this->DB_WE->query("UPDATE ".FILE_TABLE." SET CreatorID='$newID'  WHERE CreatorID=".$this->ID);
		$this->DB_WE->query("UPDATE ".TEMPLATES_TABLE." SET CreatorID='$newID'  WHERE CreatorID=".$this->ID);
		$this->DB_WE->query("UPDATE ".FILE_TABLE." SET ModifierID='$newID'  WHERE ModifierID=".$this->ID);
		$this->DB_WE->query("UPDATE ".TEMPLATES_TABLE." SET ModifierID='$newID'  WHERE ModifierID=".$this->ID);

		if(defined("OBJECT_TABLE")) {
			$this->DB_WE->query("UPDATE ".OBJECT_TABLE." SET Owners=REPLACE(Owners,',".$this->ID.",',',')");
			$this->DB_WE->query("UPDATE ".OBJECT_TABLE." SET Owners='' WHERE Owners=','");
			$this->DB_WE->query("UPDATE ".OBJECT_FILES_TABLE." SET Owners=REPLACE(Owners,',".$this->ID.",',',')");
			$this->DB_WE->query("UPDATE ".OBJECT_FILES_TABLE." SET Owners='' WHERE Owners=','");
			$this->DB_WE->query("UPDATE ".OBJECT_TABLE." SET CreatorID='$newID'  WHERE CreatorID=".$this->ID);
			$this->DB_WE->query("UPDATE ".OBJECT_FILES_TABLE." SET CreatorID='$newID'  WHERE CreatorID=".$this->ID);
			$this->DB_WE->query("UPDATE ".OBJECT_TABLE." SET ModifierID='$newID'  WHERE ModifierID=".$this->ID);
			$this->DB_WE->query("UPDATE ".OBJECT_FILES_TABLE." SET ModifierID='$newID'  WHERE ModifierID=".$this->ID);
		}
	}

	function deleteMe() {
		foreach($this->extensions_slots as $k=>$v) {
			$this->extensions_slots[$k]->delete();
		}
		if($this->Type==0) {
			$this->DB_WE->query("DELETE FROM ".USER_TABLE." WHERE ID='".$this->ID."'");
			$this->DB_WE->query("DELETE FROM ".PREFS_TABLE." WHERE userID='".$this->ID."'");
			$this->resetOwnersCreatorModifier();
			$this->removeAccount();
			return true;
		}
		if($this->Type==1) {
			$this->DB_WE->query("SELECT ID FROM ".USER_TABLE." WHERE ParentID=".$this->ID);
			while($this->DB_WE->next_record()) {
				$tmpobj=new we_user();
				$tmpobj->initFromDB($this->DB_WE->f("ID"));
				$tmpobj->deleteMe();
			}
			$this->DB_WE->query("DELETE FROM ".USER_TABLE." WHERE ID='".$this->ID."'");
			$this->resetOwnersCreatorModifier();
			return true;
		}
		if($this->Type==2) {
			$this->DB_WE->query("DELETE FROM ".USER_TABLE." WHERE ID='".$this->ID."'");
			return true;
		}
		return false;
	}

	#--------------------------------------------------------------------------'

	function isLastAdmin() {
		$this->DB_WE->query("SELECT ID FROM ".USER_TABLE." WHERE Permissions LIKE ('%\"ADMINISTRATOR\";i:1;%') AND ID<>".$this->ID);
		if($this->DB_WE->next_record()) {
			return false;
		}
		else {
			$this->DB_WE->query("SELECT ID FROM ".USER_TABLE." WHERE Permissions LIKE ('%\"ADMINISTRATOR\";s:1:\"1\";%') AND ID<>".$this->ID);
			if($this->DB_WE->next_record()) {
				print $this->DB_WE->f("ID")."<br>";
				return false;
			}
			else {
				return true;
			}
		}
		return false;
	}

	#--------------------------------------------------------------------------#

	function getPath($id=0) {
		$db_tmp=new DB_WE();
		$path = "";
		if($id==0) {
			$id=$this->ParentID;
			$path=$this->username;
		}
		if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])) {
			$foo=getHash("SELECT username,ParentID FROM ".USER_TABLE." WHERE ID='".$id."';",$db_tmp);
			$path="/". (isset($foo["username"]) ? $foo["username"] : "") .$path;
		} else {
			if ($id) {
				$foo=getHash("SELECT username FROM ".USER_TABLE." WHERE ID='".$id."';",$db_tmp);
				return "/".(isset($foo["username"]) ? $foo["username"] : "");
			} else {
				return "/" . $this->username;
			}
		}
		$pid=isset($foo["ParentID"]) ? $foo["ParentID"] : "";
		while($pid > 0) {
				$db_tmp->query("SELECT username,ParentID FROM ".USER_TABLE." WHERE ID='$pid'");
				while($db_tmp->next_record()) {
					$path = "/".$db_tmp->f("username").$path;
					$pid = $db_tmp->f("ParentID");
				}
		}
		return $path;
	}

	#--------------------------------------------------------------------------#

	function getAllPermissions() {
		$user_permissions=array();
		foreach($this->permissions_slots as $key=>$val) {
			foreach($val as $k=>$v) {
				$user_permissions[$k]=$v;
			}
		}
		$db_tmp=new DB_WE;
		$this->DB_WE->query((isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"])) ? ("SELECT ParentID,ParentPerms,Permissions,Alias FROM ".USER_TABLE." WHERE ID='".$this->ID."' OR Alias='".$this->ID."'") : ("SELECT Permissions FROM ".USER_TABLE." WHERE ID='".$this->ID."'"));
		$group_permissions=array();
		while($this->DB_WE->next_record()) {
			if($this->DB_WE->f("Alias")!=$this->ID) {
				$group_permissions=unserialize($this->DB_WE->f("Permissions"));
				if(is_array($group_permissions)) {
					foreach($user_permissions as $key=>$val) {
						if (isset($group_permissions[$key])) {
							$user_permissions[$key]=$user_permissions[$key] | $group_permissions[$key];
						}
					}
				}
			}
			$lpid=$this->DB_WE->f("ParentID");
			if($this->DB_WE->f("ParentPerms")) {
				while($lpid) {
					$db_tmp->query("SELECT ParentID,ParentPerms,Permissions FROM ".USER_TABLE." WHERE ID='".$lpid."'");
					if($db_tmp->next_record()) {
						$group_permissions=unserialize($db_tmp->f("Permissions"));
						if(is_array($group_permissions)) {
							foreach($user_permissions as $key=>$val) {
								if (isset($group_permissions[$key])) {
									$user_permissions[$key]=$user_permissions[$key] | $group_permissions[$key];
								}
							}
							if($db_tmp->f("ParentPerms")) {
								$lpid=$db_tmp->f("ParentID");
							}
							else {
								$lpid=0;
							}
						}
						else {
							$lpid=0;
						}
					}
					else {
						$lpid=0;
					}
				}
			}
		}
		return $user_permissions;
	}

	#--------------------------------------------------------------------------#

	function getState() {
		$state="";
		$state.='$this->Name="'.$this->Name.'";';
		$state.='$this->Table="'.$this->Table.'";';

		foreach($this->persistent_slots as $k=>$v) {
			eval('$attrib=isset($this->'.$v.') ? $this->'.$v.' : null;');
			$state.='$this->'.$v.'="'.addslashes($attrib).'";';
		}

		foreach($this->permissions_slots as $key=>$val) {
			foreach($val as $k=>$v) {
				$state.='$this->permissions_slots["'.$key.'"]["'.$k.'"]="'.$v.'";';
			}
		}

		foreach($this->workspaces as $key=>$val) {
			foreach($val as $k=>$v) {
				$state.='$this->workspaces["'.$key.'"]["'.$k.'"]="'.$v.'";';
			}
		}

		foreach($this->workspaces_defaults as $key=>$val) {
			foreach($val as $k=>$v) {
				$state.='$this->workspaces_defaults["'.$key.'"]["'.$k.'"]="'.$v.'";';
			}
		}

		foreach($this->preference_slots as $key => $val) {
			$state.='$this->Preferences["'.$val.'"] = "'.$this->Preferences[$val].'";';
		}

		foreach($this->extensions_slots as $k=>$v) {
			$state.='$this->extensions_slots["'.$k.'"]=new '.$v->ClassName.'();';
			$state.='$this->extensions_slots["'.$k.'"]->init($this);';
			$state.=$this->extensions_slots[$k]->getState('$this->extensions_slots["'.$k.'"]');
		}

		return serialize($state);
	}

	#--------------------------------------------------------------------------#

	function setState($state) {
        $code=unserialize($state);
	    eval($code);
	}

	/**
	 * LAYOUT FUNCTIONS
	 */

	function formDefinition($tab,$perm_branch) {
		$yuiSuggest =& weSuggest::getInstance();
		if(!(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"] && in_array("busers",$GLOBALS["_pro_modules"]))) {
			switch ($tab) {
				case 3:
					return $this->formPreferences($perm_branch);
				default:
					return $this->formSmallProperties();
			}
		}
		switch ($tab) {
			case 0:
				$out  = $yuiSuggest->getYuiJsFiles();
				$out .= $this->formGeneralData();
				$out .= $yuiSuggest->getYuiCss();
				//$out .= $yuiSuggest->getYuiJs();
				return $out;
				break;
			case 1:
				return $this->formPermissions($perm_branch);
				break;
			case 2:
				$out  = $yuiSuggest->getYuiJsFiles();
				$out .= $this->formWorkspace();
				$out .= $yuiSuggest->getYuiCss();
				//$out .= $yuiSuggest->getYuiJs();
				return $out;
				break;
			case 3:
				return $this->formPreferences($perm_branch);
				break;
		}
		foreach($this->extensions_slots as $k=>$v) {
			return $this->extensions_slots[$k]->formDefinition($tab,$perm_branch);
		}
		return $this->formGeneralData();
	}

	#--------------------------------------------------------------------------#

	function formGeneralData() {
		if(!file_exists(WE_USERS_MODULE_DIR . "edit_users_bcmd.php")) {
			return $this->formSmallProperties();
		}
		if($this->Type==0) {
			return $this->formUserData();
		}
		else if($this->Type==1) {
			return $this->formGroupData();
		}
		else if($this->Type==2) {
			return $this->formAliasData();
		}
	}

	#--------------------------------------------------------------------------#

	function formSmallProperties() {

		$we_button = new we_button();

		$out="";
		$js='
			<script language="JavaScript" type="text/javascript"><!--
				preload("auswaehlen","'.IMAGE_DIR.'buttons/auswaehlen_'.$GLOBALS["WE_LANGUAGE"].'.gif");
				preload("auswaehlen_d","'.IMAGE_DIR.'buttons/auswaehlen_d_'.$GLOBALS["WE_LANGUAGE"].'.gif");

				function doClick() {
					var a=document.we_form.'.$this->Name.'_ADMIN[0];
					var b=document.we_form.'.$this->Name.'_ADMIN[1];
					var e=document.we_form.specify_location;
					var f=document.we_form.specify_check;
					var g=document.we_form.'.$this->Name.'_PUBLISH;
					var h=document.we_form.'.$this->Name.'_workSpace;

					if(a.checked) { //user
						e.value="";
						f.checked=false;
						g.checked=false;
						h.value=0;
						select_enabled = switch_button_state("select", "select_enabled", "disabled");
					}
					top.content.setHot();
				}

				function choseDir() {
					if(document.we_form.'.$this->Name.'_ADMIN[1].checked) {
						top.content.setHot();
						we_cmd("openDirselector",document.we_form.'.$this->Name.'_workSpace.value,"'.FILE_TABLE.'","document.we_form.'.$this->Name.'_workSpace.value","document.we_form.specify_location.value","","'.session_id().'","'. (isset($_REQUEST["rootDirID"]) ? $_REQUEST["rootDirID"] : "") .'")
					}
				}

				function specifyCheck() {
					var a=document.we_form.specify_check;
					var c=document.we_form.specify_location;
					var d=document.we_form.'.$this->Name.'_ADMIN[1];
					var e=document.we_form.'.$this->Name.'_workSpace;
					var f=document.we_form.'.$this->Name.'_ADMIN[0];

					if(!a.checked) {
						c.value="";
						e.value=0;
						select_enabled = switch_button_state("select", "select_enabled", "disabled");
					}
					else {
						if(d.checked) {
							select_enabled = switch_button_state("select", "select_enabled", "enabled");
							choseDir();
						} else if (f.checked) {
							d.checked = true;
							select_enabled = switch_button_state("select", "select_enabled", "enabled");
							choseDir();
						}
					}
					top.content.setHot();
				}
			//-->
			</script>';

		$_username = ($this->ID) ? htmlFormElementTable('<b class="defaultfont">'.$this->username.'</b>',$GLOBALS['l_users']["username"]) : $this->getUserfield("username","username");
		$_password = '<input type="hidden" name="'.$this->Name.'_passwd" value="'.$this->passwd.'">' . htmlTextInput('input_pass',20,"","255",'onchange="top.content.setHot()"','password',240);



		$_attr = array("border" => "0", "cellpadding" => "2", "cellspacing" => "0");
		$_tableObj = new we_htmlTable($_attr, 5, 2);

		$_tableObj->setCol(0, 0, null, $this->getUserfield("First","first_name"));
		$_tableObj->setCol(0, 1, null, $this->getUserfield("Second","second_name"));
		$_tableObj->setCol(1, 0, null, getPixel(280,20));
		$_tableObj->setCol(1, 1, null, getPixel(280,5));
		$_tableObj->setCol(2, 0, null, we_forms::checkboxWithHidden($this->LoginDenied, $this->Name.'_LoginDenied', $GLOBALS["l_users"]["login_denied"], false, "defaultfont", "", ($_SESSION["user"]["ID"]==$this->ID || !we_hasPerm("ADMINISTRATOR")) ));
		$_tableObj->setCol(3, 0, null, getPixel(280,20));
		$_tableObj->setCol(3, 1, null, getPixel(280,5));
		$_tableObj->setCol(4, 0, null, $_username);
		$_tableObj->setCol(4, 1, null,htmlFormElementTable($_password,$GLOBALS['l_users']["password"]));

		$parts = array();
		array_push($parts,
						array(
							"headline"=>$GLOBALS['l_users']["user_data"],
							"html"=>$_tableObj->getHtmlCode(),
							"space"=>120
							)
					);



		$wpath="";
		$_ws = isset($this->workspaces[FILE_TABLE][0]) ? $this->workspaces[FILE_TABLE][0] : 0;
		if($_ws) {
			$wpath=f("SELECT Path FROM ".FILE_TABLE." WHERE ID='".$this->workspaces[FILE_TABLE][0]."'","Path",$this->DB_WE);
		}

		$adminperm=$this->checkPermission("ADMINISTRATOR");
		$publishperm=$this->checkPermission("PUBLISH");
		$_input = '<input type="hidden" name="'.$this->Name.'_workSpace" value="'.$_ws.'">'.htmlTextInput('specify_location',40,$wpath,"",'onchange="top.content.setHot()" readonly="readonly"','text',365);
		$_button = $we_button->create_button("select", "javascript:choseDir()",true,-1,-1,"","",$adminperm,false);
		$_chooser = $we_button->create_button_table(array($_input,$_button));

		$_tableObj = new we_htmlTable($_attr, 6, 3);

		$_tableObj->setCol(0, 0, array("colspan"=>"3"), we_forms::radiobutton("1",$adminperm,$this->Name.'_ADMIN',$GLOBALS['l_users']["admin_permissions"],true,"defaultfont","top.content.setHot();doClick()"));
		$_tableObj->setCol(1, 0, array("colspan"=>"3"), we_forms::radiobutton("0",!$adminperm,$this->Name.'_ADMIN',$GLOBALS['l_users']["user_permissions"],true,"defaultfont","top.content.setHot();doClick()"));
		$_tableObj->setCol(2, 0, null);
		$_tableObj->setCol(2, 1, array("colspan"=>"2"), we_forms::checkbox("1",($_ws!=0),"specify_check",$GLOBALS['l_users']["workspace_specify"],false,"defaultfont","top.content.setHot();specifyCheck()"));
		$_tableObj->setCol(3, 0, null);
		$_tableObj->setCol(3, 1, null);
		$_tableObj->setCol(3, 2, null, $_chooser);
		$_tableObj->setCol(4, 0, null);
		$_tableObj->setCol(4, 1, array("colspan"=>"2"), we_forms::checkbox("1",($adminperm=="0") && $publishperm==1,$this->Name.'_PUBLISH',$GLOBALS['l_users']["publish_specify"],false,"defaultfont","top.content.setHot()"));
		$_tableObj->setCol(5, 0, null,getPixel(20,1));
		$_tableObj->setCol(5, 1, null,getPixel(20,1));
		$_tableObj->setCol(5, 2, null,getPixel(400,1));



		array_push($parts,
						array(
							"headline"=>$GLOBALS['l_users']["permissions"],
							"html"=>$_tableObj->getHtmlCode(),
							"space"=>120
							)
					);

		// Permission, if user can change seem-startdocument of other users not in ISP_VERSION
		if (we_hasPerm("ADMINISTRATOR")){

			//	First get the startdocument of the selected User!
			$userID = $this->ID;

			if(isset($_REQUEST["seem_start_type"])) {
				if($_REQUEST["seem_start_type"] == "cockpit") {
					$startDocid = 0;
					$startType = "cockpit";

				} elseif($_REQUEST["seem_start_type"] == "object") {
					$startDocid = $_REQUEST["seem_start_object"];
					$startType = "object";

				} else {
					$startDocid = $_REQUEST["seem_start_document"];
					$startType = "document";

				}

			} else if(isset($_SESSION["save_user_seem_start_file"][$userID])){

				$startDocid = $_SESSION["save_user_seem_start_file"][$userID];
			} else {

				$startDocid = f("SELECT seem_start_file FROM ".PREFS_TABLE." WHERE userID = " . $userID ,"seem_start_file",$this->DB_WE);
			}

			$startDocPath = "";

			if(isset($startDocid) && $startDocid != 0){
				$startDocPaths = getPathsFromTable(FILE_TABLE, "", FILE_ONLY, $startDocid);
				$startDocPath = $startDocPaths[$startDocid];
			}


			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/SEEM.inc.php");

			$title = $l_we_SEEM["workspace_seem_startdocument"];

			$docPath = "none";

			$content1 = '
						<table border="0" cellpadding="0" cellspacing="2">
						<tr>
							<td><input type="hidden" name="seem_start_file" value="' . $startDocid . '"></td>
							<td valign="middle">'.htmlTextInput('seem_start_file_name',40,$startDocPath,"",'readonly="readonly" onChange="top.content.setHot();"','text',411).'</td>
							<td width="5"></td>
							<td>' . $we_button->create_button("select", "javascript:top.content.setHot(); we_cmd('select_seem_start');") . '</td>
						</tr>
						</table>';

			array_push($parts,
						array(
							"headline"=>$title,
							"html"=>$content1,
							"space"=>120
							)
					);

			}

		$js .= $we_button->create_state_changer();
		return $js.we_multiIconBox::getHTML("","100%",$parts,30);
	}

	#--------------------------------------------------------------------------#

	function formGroupData() {
		$_attr = array("border" => "0", "cellpadding" => "2", "cellspacing" => "0");
		$we_button = new we_button();
		$js = $we_button->create_state_changer();

		$_tableObj = new we_htmlTable($_attr, 5, 1);

		$_username = ($this->ID) ? htmlFormElementTable('<b class="defaultfont">'.$this->username.'</b><input type="hidden" id="yuiAcInputPathName" value="'.($this->username).'">',$GLOBALS['l_users']["group_name"]) : $this->getUserfield("username","group_name","text","255",false,'id="yuiAcInputPathName" onblur="parent.frames[0].setPathName(this.value); parent.frames[0].setTitlePath();"');
		$_description = '<textarea name="'.$this->Name.'_Description" cols="25" rows="5" style="width:560px" class="defaultfont" onChange="top.content.setHot();">'.$this->Description.'</textarea>';
		$this->DB_WE->query("SELECT Path FROM ".USER_TABLE." WHERE ID='".$this->ParentID."'");

		if ($this->DB_WE->next_record()) {
			$parent_name=$this->DB_WE->f("Path");
		} else {
			$parent_name="/";
		}

		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("PathGroup");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($this->Name.'_ParentID_Text',$parent_name,array("onChange"=>"top.content.setHot()"));
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(false);
		$yuiSuggest->setResult($this->Name.'_ParentID',$this->ParentID);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable(USER_TABLE);
		$yuiSuggest->setWidth(450);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:we_cmd('browse_users','document.we_form.".$this->Name."_ParentID.value','document.we_form.".$this->Name."_ParentID_Text.value','group',document.we_form.".$this->Name."_ParentID.value);"));
		
		$weAcSelector = $yuiSuggest->getHTML();

		$_tableObj->setCol(0, 0, null, $_username);
		$_tableObj->setCol(1, 0, null, getPixel(560,4));
		$_tableObj->setCol(2, 0, null, htmlFormElementTable($_description,$GLOBALS['l_users']["description"]));
		$_tableObj->setCol(3, 0, null, getPixel(560,10));
		$_tableObj->setCol(4, 0, null, htmlFormElementTable($weAcSelector,$GLOBALS['l_users']["group"]));

		$parts = array();

		array_push($parts,
						array(
							"headline"=>$GLOBALS['l_users']["group_data"],
							"html"=>$_tableObj->getHtmlCode(),
							"space"=>120
							)
					);

		$content='<select name="'.$this->Name.'_Users" size="8" style="width:560px" onChange="if(this.selectedIndex > -1){edit_enabled = switch_button_state(\'edit\', \'edit_enabled\', \'enabled\');}else{edit_enabled = switch_button_state(\'edit\', \'edit_enabled\', \'disabled\');}" ondblclick="top.content.we_cmd(\'display_user\',document.we_form.'.$this->Name.'_Users.value)">';
		if($this->ID) {
			$this->DB_WE->query("SELECT ID,username,Text,Type FROM ".USER_TABLE." WHERE Type IN (0,2) AND ParentID=".$this->ID);
			while($this->DB_WE->next_record()) {
				$content.='<option value="'.$this->DB_WE->f("ID").'">'.(($this->DB_WE->f("Type")==2) ? "[" : "").$this->DB_WE->f("Text").(($this->DB_WE->f("Type")==2) ? "]" : "");
			}
		}

		$content.='</select><br>'.getPixel(5,10).'<br>'.$we_button->create_button("edit", "javascript:we_cmd('display_user',document.we_form.".$this->Name."_Users.value)",true,-1,-1,"","",true,false);

			array_push($parts,
						array(
							"headline"=>$GLOBALS['l_users']["user"],
							"html"=>$content,
							"space"=>120
							)
					);


		return $js.we_multiIconBox::getHTML("","100%",$parts,30);

	}

	#--------------------------------------------------------------------------#

	function getUserfield($name,$lngkey,$type="text",$maxlen="255",$noNull=false, $attribs=""){
		eval('$val = $this->'.$name.';');
		if($noNull){
			if(!$val){
				$val = "";
			}
		}
		return htmlFormElementTable(htmlTextInput($this->Name.'_'.$name,20,$val,$maxlen,'onchange="top.content.setHot()" '.(empty($attribs)?'':$attribs),$type,240),$GLOBALS["l_users"][$lngkey]);
	}

	function formUserData() {

		$_attr = array("border" => "0", "cellpadding" => "2", "cellspacing" => "0");
		$_tableObj = new we_htmlTable($_attr, 10, 2);

		$_tableObj->setCol(0, 0, null, $this->getUserfield("Salutation","salutation"));
		$_tableObj->setCol(0, 1, "");
		$_tableObj->setCol(1, 0, null, $this->getUserfield("First","first_name"));
		$_tableObj->setCol(1, 1, null, $this->getUserfield("Second","second_name"));
		$_tableObj->setCol(2, 0, null, getPixel(280,20));
		$_tableObj->setCol(2, 1, null, getPixel(280,5));
		$_tableObj->setCol(3, 0, null, $this->getUserfield("Address","address"));
		$_tableObj->setCol(3, 1, null, $this->getUserfield("HouseNo","houseno"));
		$_tableObj->setCol(4, 0, null, $this->getUserfield("PLZ","PLZ","text","16",true));
		$_tableObj->setCol(4, 1, null, $this->getUserfield("City","city"));
		$_tableObj->setCol(5, 0, null, $this->getUserfield("State","state"));
		$_tableObj->setCol(5, 1, null, $this->getUserfield("Country","country"));
		$_tableObj->setCol(6, 0, null, getPixel(280,20));
		$_tableObj->setCol(6, 1, null, getPixel(280,5));
		$_tableObj->setCol(7, 0, null, $this->getUserfield("Tel_preselection","tel_pre"));
		$_tableObj->setCol(7, 1, null, $this->getUserfield("Telephone","telephone"));
		$_tableObj->setCol(8, 0, null, $this->getUserfield("Fax_preselection","fax_pre"));
		$_tableObj->setCol(8, 1, null, $this->getUserfield("Fax","fax"));
		$_tableObj->setCol(9, 0, null, $this->getUserfield("Handy","mobile"));
		$_tableObj->setCol(9, 1, null, $this->getUserfield("Email","email"));

		$we_button = new we_button();

		$parts = array();
		array_push($parts,
						array(
							"headline"=>$GLOBALS['l_users']["general_data"],
							"html"=>$_tableObj->getHtmlCode(),
							"space"=>120
							)
					);




		$_tableObj = new we_htmlTable($_attr, 5, 2);

		$_username = ($this->ID) ? htmlFormElementTable('<b class="defaultfont">'.$this->username.'</b>',$GLOBALS['l_users']["username"]) : $this->getUserfield("username","username","text","255",false,'id="yuiAcInputPathName" onblur="parent.frames[0].setPathName(this.value); parent.frames[0].setTitlePath();"');

		if(isset($_SESSION["user"]["ID"]) && $_SESSION["user"]["ID"] && $_SESSION["user"]["ID"]==$this->ID && !we_hasPerm("EDIT_PASSWD"))
			$_password="****************";
		else
			$_password = '<input type="hidden" name="'.$this->Name.'_passwd" value="'.$this->passwd.'">' . htmlTextInput('input_pass',20,"","255",'onchange="top.content.setHot()"','password',240);

		$this->DB_WE->query("SELECT Path FROM ".USER_TABLE." WHERE ID='".$this->ParentID."'");

		if ($this->DB_WE->next_record()) {
			$parent_name=$this->DB_WE->f("Path");
		} else {
			$parent_name="/";
		}

		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("PathGroup");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($this->Name.'_ParentID_Text',$parent_name,array("onChange"=>"top.content.setHot()"));
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($this->Name.'_ParentID',$this->ParentID);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable(USER_TABLE);
		$yuiSuggest->setWidth(403);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:we_cmd('browse_users','document.we_form.".$this->Name."_ParentID.value','document.we_form.".$this->Name."_ParentID_Text.value','group',document.we_form.".$this->Name."_ParentID.value);"));
		
		$weAcSelector = $yuiSuggest->getHTML();
		
		$_tableObj->setCol(0, 0, null, $_username);
		$_tableObj->setCol(0, 1, null, htmlFormElementTable($_password, $GLOBALS['l_users']["password"]));
		$_tableObj->setCol(1, 0, null, getPixel(280,10));
		$_tableObj->setCol(1, 1, null, getPixel(280,5));
		$_tableObj->setCol(2, 0, null, we_forms::checkboxWithHidden($this->LoginDenied, $this->Name.'_LoginDenied', $GLOBALS["l_users"]["login_denied"], false, "defaultfont", "top.content.setHot();", ($_SESSION["user"]["ID"]==$this->ID || !we_hasPerm("ADMINISTRATOR")) ));
		$_tableObj->setCol(3, 0, null, getPixel(280,10));
		$_tableObj->setCol(3, 1, null, getPixel(280,5));
		$_tableObj->setCol(4, 0, array("colspan"=>"2"), htmlFormElementTable($weAcSelector,$GLOBALS['l_users']["group"]));

		array_push($parts,
							array(
								"headline"=>$GLOBALS['l_users']["user_data"],
								"html"=>$_tableObj->getHtmlCode(),
								"space"=>120
								)
						);



		return we_multiIconBox::getHTML("","100%",$parts,30);

	}

	#--------------------------------------------------------------------------#

	/**
	 * This function outputs the group of selectable user permissions
	 *
	 * @param      $branch                                 string
	 *
	 * @return     string
	 */

	function formPermissions($branch) {
		global $perm_defaults;

		// Set output text

		// Create a object of the class dynamicControls
		$dynamic_controls = new we_dynamicControls();
		// Now we create the overview of the user rights
		$content = $dynamic_controls->fold_checkbox_groups(	$this->permissions_slots,
															$this->permissions_main_titles,
															$this->permissions_titles,
															$this->Name,
															$branch,
															array("administrator"),
															true,
															true,
															"we_form",
															"perm_branch",
															true,
															true);



		$javascript ='
			<script language="JavaScript" type="text/javascript"><!--

				function rebuildCheckboxClicked() {
					toggleRebuildPerm(false);
				}

				function toggleRebuildPerm(disabledOnly) {

				';
		if(isset($this->permissions_slots['rebuildpermissions']) && is_array($this->permissions_slots['rebuildpermissions'])) {



			foreach($this->permissions_slots['rebuildpermissions'] as $pname=>$pvalue) {
				if($pname!='REBUILD') {
					$javascript .= '
					if (document.we_form.' . $this->Name . '_Permission_REBUILD && document.we_form.' . $this->Name . '_Permission_' . $pname . ') {
						if(document.we_form.' . $this->Name . '_Permission_REBUILD.checked) {
							document.we_form.' . $this->Name . '_Permission_' . $pname . '.disabled = false;
							if (!disabledOnly) {
								document.we_form.' . $this->Name . '_Permission_' . $pname . '.checked = true;
							}
						} else {
							document.we_form.' . $this->Name . '_Permission_' . $pname . '.disabled = true;
							if (!disabledOnly) {
								document.we_form.' . $this->Name . '_Permission_' . $pname . '.checked = false;
							}
						}
					}
					';
				} else {
					$handler = "
					if (document.we_form." . $this->Name . "_Permission_" . $pname . ") {
						document.we_form." . $this->Name . "_Permission_" . $pname . ".onclick = rebuildCheckboxClicked;
					} else {
						document.we_form." . $this->Name . "_Permission_" . $pname . ".onclick = top.content.setHot();
					}
					toggleRebuildPerm(true);
					";
				}
			}
		}
		$javascript .= '
				}
						';
		if(isset($handler)) {
			$javascript .= $handler;
		}
		$javascript .= '
			//--></script>';

		$parts = array();

		array_push($parts,
							array(
								"headline"=>"",
								"html"=>$content,
								"space"=>0,
								"noline"=>1
								)
		);

		// js to uncheck all permissions
		$uncheckjs = '';
		$checkjs = '';
		foreach($this->permissions_slots as $group) {
			foreach($group as $pname=>$pvalue) {
				if($pname!='ADMINISTRATOR') {
					$uncheckjs .= 'document.we_form.' . $this->Name . '_Permission_' . $pname . '.checked = false;';
					$checkjs .= 'document.we_form.' . $this->Name . '_Permission_' . $pname . '.checked = true;';
				}
			}
		}

		$we_button = new we_button();
		$button_uncheckall = $we_button->create_button('uncheckall', 'javascript:' . $uncheckjs);
		$button_checkall = $we_button->create_button('checkall', 'javascript:' . $checkjs);
		array_push($parts,
							array(
								'headline'=>'',
								'html'=>$we_button->create_button_table(array($button_uncheckall,$button_checkall)),
								'space'=>0
								)
		);



		// Check if user has right to decide to give administrative rights
		if(is_array($this->permissions_slots["administrator"]) && we_hasPerm("ADMINISTRATOR") && $this->Type==0) {
			foreach($this->permissions_slots["administrator"] as $k=>$v) {
				$content='
					<table cellpadding="0" cellspacing="0" border="0" width="500">
						<tr>
							<td>
								' . getPixel(1, 5) . '</td>
						</tr>
						<tr>
							<td>
								' . we_forms::checkbox(($v ? $v : "0"), ($v ? true : false), $this->Name . "_Permission_" . $k , $this->permissions_titles["administrator"][$k], false, "defaultfont", ($k=="REBUILD"?"setRebuidPerms();":"")) . '</td>
						</tr>
					</table>';
			}
			array_push($parts,
							array(
								"headline"=>"",
								"html"=>$content,
								"space"=>0
								)
			);
		}



		array_push($parts,
							array(
								"headline"=>"",
								"html"=>$this->formInherits("_ParentPerms",$this->ParentPerms,$GLOBALS['l_users']["inherit"]),
								"space"=>0
								)
		);



		return we_multiIconBox::getHTML("","100%",$parts,30).$javascript;
	}

	#--------------------------------------------------------------------------#

	function formWorkspace() {

		$we_button = new we_button();
		$parts = array();
		$content ='
			<script language="JavaScript" type="text/javascript"><!--
				function addElement(elvalues) {
					if(elvalues.value=="") {
						elvalues.value="0";
					}
					else {
						elvalues.value=elvalues.value+",0";
					}
					switchPage(2);
				}

				function setValues(section) {
					if(section==2) {
						table="'.TEMPLATES_TABLE.'";
					}';
		if(defined("OBJECT_TABLE")) {
			$content .='
					else if(section==3) {
						table="'.OBJECT_FILES_TABLE.'";
					}';
		}

		if(defined('NEWSLETTER_TABLE')) {
			$content .='
					else if(section==5) {
						table="'.NEWSLETTER_TABLE.'";
					}';
		}

		$content.='
					else if(section==4) {
						table="'.NAVIGATION_TABLE.'";
					}
					else {
						table="'.FILE_TABLE.'";
					}
					eval(\'fillValues(document.we_form.'.$this->Name.'_Workspace_\'+table+\'_Values,"'.$this->Name.'_Workspace_\'+table+\'")\');
				}

				function fillValues(elvalues,names) {
					var stack=elvalues.value.split(",");
					elcount=stack.length;
					for(i=0;i<elcount;i++) {
						eval("if(document.we_form."+names+"_"+i+") stack[i]=document.we_form."+names+"_"+i+".value");
					}
					elvalues.value=stack.join();
				}

				function fillDef(elvalues,elvalues2,names,names2) {
					var stack=elvalues2.value.split(",");
					elcount=stack.length;
					for(i=0;i<elcount;i++) {
						if(document.we_form.elements[names+"_"+i]){
							if(document.we_form.elements[names+"_"+i].checked){
								stack[i]=document.we_form.elements[names2+"_"+i].value;
							} else{
								 stack[i]=0;
							}
						}
					}
					elvalues.value=stack.join();
				}

				function delElement(elvalues,elem) {
					var stack=elvalues.value.split(",");
					var res=new Array();
					var c=-1;

					for(i=0;i<stack.length;i++) {
						if(i!=elem) {
							c++;
							res[c]=stack[i];
						}
					}
					elvalues.value=res.join();
					top.content.setHot();
				}
			//-->
			</script>';
		$content1 = "";

		foreach($this->workspaces as $k=>$v) {
			if($k==TEMPLATES_TABLE) {
				if(defined("WK")) {
					break;
				}
				$title=$GLOBALS['l_users']["workspace_templates"];
			} else if($k==NAVIGATION_TABLE) {
				if(defined("WK")) {
					break;
				}
				$title=$GLOBALS['l_users']["workspace_navigations"];
			} else if(defined("NEWSLETTER_TABLE") && $k==NEWSLETTER_TABLE) {
				if(defined("WK")) {
					break;
				}
				$title=$GLOBALS['l_users']["workspace_newsletter"];
			}
			elseif(defined("OBJECT_TABLE") && $k==OBJECT_FILES_TABLE) {
				if(defined("WK")) {
					break;
				}
				$title=$GLOBALS['l_users']["workspace_objects"];
			}
			else {
				$title=$GLOBALS['l_users']["workspace_documents"];
			}
			$obj_values=$this->Name.'_Workspace_'.$k.'_Values';
			$obj_names=$this->Name.'_Workspace_'.$k;
			$obj_def_values=$this->Name.'_defWorkspace_'.$k.'_Values';
			$obj_def_names=$this->Name.'_defWorkspace_'.$k;

			if($k == TEMPLATES_TABLE) {
				$content1 .= $this->formInherits("_ParentWst",$this->ParentWst,$GLOBALS['l_users']["inherit_wst"]);
			} else if($k == NAVIGATION_TABLE) {
				$content1 .= $this->formInherits("_ParentWsn",$this->ParentWsn,$GLOBALS['l_users']["inherit_wsn"]);
			} elseif(defined("OBJECT_TABLE") && $k == OBJECT_FILES_TABLE) {
				$content1 .= $this->formInherits("_ParentWso",$this->ParentWso,$GLOBALS['l_users']["inherit_wso"]);
			} elseif(defined('NEWSLETTER_TABLE') && $k == NEWSLETTER_TABLE) {
				$content1 .= $this->formInherits("_ParentWsnl",$this->ParentWsnl,$GLOBALS['l_users']["inherit_wsnl"]);
			} else {
				$content1 .= $this->formInherits("_ParentWs",$this->ParentWs,$GLOBALS['l_users']["inherit_ws"]);
			}
			$content .= "<p>";

			$content1.='
				<input type="hidden" name="'.$obj_values.'" value="'.implode(",",$v).'">
				<input type="hidden" name="'.$obj_def_values.'" value="'.implode(",",$this->workspaces_defaults[$k]).'">
				<table border="0" cellpadding="0" cellspacing="2" width="520">';
			foreach($v as $key=>$val) {
				$path="/";
				$value=$val;
				$this->DB_WE->query("SELECT Path FROM ".$k." WHERE ".$k.".ID=".$value);
				if($this->DB_WE->next_record()) {
					$path=$this->DB_WE->f("Path");
				}
				else {
					$foo = get_def_ws($k);
					$fooA = makeArrayFromCSV($foo);
					if(sizeof($fooA)) {
						$value = $fooA[0];
						$path = id_to_path($value);
					}
					else {
						$value=0;
					}
				}
				$default=false;
				foreach($this->workspaces_defaults[$k] as $k1=>$v1) {
					if($v1==$val && $v1!=0) {
						$default=true;
					}
				}

				if($k == TEMPLATES_TABLE) {
					$setValue = 2;
				} elseif(defined("OBJECT_TABLE") && $k == OBJECT_FILES_TABLE) {
					$setValue = 3;
				} elseif(defined('NEWSLETTER_TABLE') && $k == NEWSLETTER_TABLE) {
					$setValue = 5;
				} elseif($k == NAVIGATION_TABLE) {
					$setValue = 4;
				} else {
					$setValue = 1;
				}

				if(defined('NEWSLETTER_TABLE') && $k == NEWSLETTER_TABLE) {
					$button = $we_button->create_button("select", "javascript:we_cmd('openNewsletterDirselector',document.forms[0].".$obj_names."_".$key.".value,'document.we_form.".$obj_names."_".$key.".value','document.we_form.".$obj_names."_".$key."_Text.value','opener.top.content.user_resize.user_right.user_editor.user_properties.setValues(".$setValue.")','".session_id()."','" . (isset($_REQUEST["rootDirID"]) ? $_REQUEST["rootDirID"] : "") . "' )");
				} else if($k == NAVIGATION_TABLE) {
					$button = $we_button->create_button("select", "javascript:we_cmd('openNavigationDirselector',document.forms[0].".$obj_names."_".$key.".value,'document.we_form.".$obj_names."_".$key.".value','document.we_form.".$obj_names."_".$key."_Text.value','opener.top.content.user_resize.user_right.user_editor.user_properties.setValues(".$setValue.")','".session_id()."','" . (isset($_REQUEST["rootDirID"]) ? $_REQUEST["rootDirID"] : "") . "' )");
				} else {
					$button = $we_button->create_button("select", "javascript:we_cmd('openDirselector',document.forms[0].".$obj_names."_".$key.".value,'".$k."','document.we_form.".$obj_names."_".$key.".value','document.we_form.".$obj_names."_".$key."_Text.value','opener.top.content.user_resize.user_right.user_editor.user_properties.setValues(".$setValue.")','".session_id()."','" . (isset($_REQUEST["rootDirID"]) ? $_REQUEST["rootDirID"] : "") . "' )");
				}

				$yuiSuggest =& weSuggest::getInstance();
				$yuiSuggest->setAcId("WS".$k.$key);
				$yuiSuggest->setContentType("folder");
				$yuiSuggest->setInput($obj_names.'_'.$key.'_Text',$path);
				$yuiSuggest->setMaxResults(10);
				$yuiSuggest->setMayBeEmpty(true);
				$yuiSuggest->setResult($obj_names.'_'.$key,$value);
				$yuiSuggest->setSelector("Dirselector");
				$yuiSuggest->setTable($k);
				$yuiSuggest->setWidth(290);
				$yuiSuggest->setSelectButton($button,10);
				$yuiSuggest->setDoOnTextfieldBlur('setValues('.$setValue.');');
				
				$weAcSelector = $yuiSuggest->getHTML();

				$content1.='
					<tr>
						<td colspan="2">
							'.$weAcSelector.'
						</td>
						<td><div style="position:relative; top:-1px">
							' . $we_button->create_button("image:btn_function_trash", "javascript:fillValues(document.we_form." .$obj_values. ",'" . $obj_names . "');fillDef(document.we_form." . $obj_def_values . ",document.we_form." .$obj_values.",'" . $obj_def_names . "','" . $obj_names . "');delElement(document.we_form.".$obj_values.",".$key.");delElement(document.we_form.".$obj_def_values.",".$key.");switchPage(2);",true) . '</td></div>';

				if($k == FILE_TABLE) {
					$content1.='
						<td class="defaultfont">'.we_forms::checkbox("1",$default,$obj_def_names."_$key",$GLOBALS['l_users']["make_def_ws"],true,"defaultfont",'top.content.setHot();fillDef(document.we_form.'.$obj_def_values.',document.we_form.'.$obj_values.',\''.$obj_def_names.'\',\''.$obj_names.'\');').'</td>';
				}
				else {
					$content1.='
						<td>
							'.getPixel(5,5).'</td>';
				}
				$content1.='</tr>';
			}
			$content1.='
					<tr>
						<td>'.getPixel(300,3).'</td>
						<td>'.getPixel(110,3).'</td>
						<td>'.getPixel(40,3).'</td>
						<td>'.getPixel(90,3).'</td>
					</tr>
					<tr>
						<td colspan="4">
						' . $we_button->create_button("image:btn_function_plus", "javascript:top.content.setHot();fillValues(document.we_form.".$obj_values.",'".$obj_names."');fillDef(document.we_form.".$obj_def_values.",document.we_form.".$obj_values.",'".$obj_def_names."','".$obj_names."');addElement(document.we_form.".$obj_values.");addElement(document.we_form.".$obj_def_values.");", true)
						  . '</td>
					</tr>
				</table>';
				array_push($parts,
							array(
								"headline"=>$title,
								"html"=>$content1,
								"space"=>200
								)
						);

			$content1="";
		}

		return $content . we_multiIconBox::getHTML("","100%",$parts,30);
	}

	#--------------------------------------------------------------------------#

	function formPreferences($branch = "") {

		$dynamic_controls = new we_dynamicControls();

		$groups = array(
			'glossary'	=> $GLOBALS['l_prefs']['tab_glossary'],
			'ui'		=> $GLOBALS['l_prefs']['tab_ui'],
			'editor'	=> $GLOBALS['l_prefs']['tab_editor'],
		);

		$titles = $groups;

		$multiboxes = array(
			'glossary'	=> $this->formPreferencesGlossary(),
			'ui'		=> $this->formPreferencesUI(),
			'editor'	=> $this->formPreferencesEditor(),
		);

		$content = $dynamic_controls->fold_multibox_groups($groups, $titles, $multiboxes, $branch);

		$parts = array();

		array_push(
			$parts,
			array(
				"headline"	=> "",
				"html"		=> $content,
				"space"		=> 0
			)
		);

		return we_multiIconBox::getHTML("","100%",$parts,30);

	}

	function formPreferencesGlossary() {

		$_settings = array();

		$_settings = array();

		// Create checkboxes
		$_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 3, 1);

		$_table->setCol(0, 0, null, we_forms::checkbox(1, $this->Preferences['force_glossary_check'], $this->Name."_Preference_force_glossary_check", $GLOBALS['l_prefs']["force_glossary_check"], "false", "defaultfont", "top.content.setHot()" ));
		$_table->setCol(1, 0, null, getPixel(1, 5));
		$_table->setCol(2, 0, null, we_forms::checkbox(1, $this->Preferences['force_glossary_action'], $this->Name."_Preference_force_glossary_action", $GLOBALS['l_prefs']["force_glossary_action"], "false", "defaultfont", "top.content.setHot()" ));

		// Build dialog if user has permission
		if (we_hasPerm("ADMINISTRATOR")) {
			array_push($_settings, array("headline" => $GLOBALS['l_prefs']["glossary_publishing"], "html" => $_table->getHtmlCode(), "space" => 200, "noline" => 1));
		}

		return $_settings;

	}


	function formPreferencesUI() {
		global $BROWSER;
		$we_button = new we_button();

		$_settings = array();


		/*****************************************************************
		 * LANGUAGE
		 *****************************************************************/

		//	Look which languages are installed ...
		$_language_directory = dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language");

		while (false !== ($entry = $_language_directory->read())) {
		  	if($entry != "." && $entry != "..") {
				if (is_dir($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry)
					&& is_file($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry."/translation.inc.php")) {
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$entry."/translation.inc.php");
					$_languages["translation"][] = $entry;
				} else {
					// do nothing
				}
		  	} else {
		  		// do nothing
		  	}
		}

		if(sizeof($_languages["translation"]) > 1) { // Build language select box
			$_languages = new we_htmlSelect(array("name" => $this->Name.'_Preference_'.'Language', "class" => "weSelect", "onChange"=> "top.content.setHot();"));
			foreach ($_language["translation"] as $key=>$value) {
			   	$_languages->addOption($key, $value);

			   	// Set selected extension
			   	if ($key == $this->Preferences['Language']) {
			   		$_languages->selectOption($key);
			   	} else {
			    	// do nothing
			    }
			}

			// Build dialog
			array_push($_settings, array("headline" => $GLOBALS['l_prefs']["choose_language"], "html" => $_languages->getHtmlCode(), "space" => 200));
		} else { // Just one Language Installed, no select box needed
			foreach ($_language["translation"] as $key=>$value) {
		    	$_languages = $value;
		  	}
			// Build dialog
			array_push($_settings, array("headline" => $GLOBALS['l_prefs']["choose_language"], "html" => $_languages, "space" => 200));
		}


		/*****************************************************************
		 * AMOUNT Number of Columns
		 *****************************************************************/

		$_amount = new we_htmlSelect(array("name" => $this->Name.'_Preference_'.'cockpit_amount_columns', "class" => "weSelect", "onChange"=> "top.content.setHot();"));
		if($this->Preferences['cockpit_amount_columns']=="") {
			$this->Preferences['cockpit_amount_columns'] = 3;
		}
		for($i = 1; $i <= 10; $i++) {
			$_amount->addOption($i, $i);
			if ($i == $this->Preferences['cockpit_amount_columns']) {
				$_amount->selectOption($i);
			}
		}

		array_push($_settings, array("headline" => $GLOBALS['l_prefs']["cockpit_amount_columns"], "html" => $_amount->getHtmlCode(), "space" => 200));



		/*****************************************************************
		 * SEEM
		 *****************************************************************/

		$_document_path = "";

		// Generate needed JS
		$js = "
					<script language=\"JavaScript\" type=\"text/javascript\"><!--
						function select_seem_start() {
							myWind = false;

							for(k=top.opener.top.jsWindow_count;k>-1;k--){

								eval(\"if(top.opener.top.jsWindow\" + k + \"Object){\" +
									 \"	if(top.opener.top.jsWindow\" + k + \"Object.ref == 'edit_module'){\" +
									 \"		myWind = top.opener.top.jsWindow\" + k + \"Object.wind.content.user_resize.user_right.user_editor.user_properties;\" +
									 \"		myWindStr = 'top.jsWindow\" + k + \"Object.wind.content.user_resize.user_right.user_editor.user_properties';\" +
									 \"	}\" +
									 \"}\");
								if(myWind){
									break;
								}
							}

							if(document.getElementById('seem_start_type').value == 'object') {
								top.opener.top.we_cmd('openDocselector', document.forms[0].elements['seem_start_object'].value, '" . (defined("OBJECT_FILES_TABLE") ? OBJECT_FILES_TABLE : "") . "', myWindStr + '.document.forms[0].elements[\'seem_start_object\'].value', myWindStr + '.document.forms[0].elements[\'seem_start_object_name\'].value', '', '" . session_id() . "', '', 'objectFile','objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_OBJECTS") ? 0 : 1).");
							} else {
								top.opener.top.we_cmd('openDocselector', document.forms[0].elements['seem_start_document'].value, '" . FILE_TABLE . "', myWindStr + '.document.forms[0].elements[\'seem_start_document\'].value', myWindStr + '.document.forms[0].elements[\'seem_start_document_name\'].value', '', '" . session_id() . "', '', 'text/webedition','objectFile',".(we_hasPerm("CAN_SELECT_OTHER_USERS_FILES") ? 0 : 1).");
							}
						}

						function show_seem_chooser(val) {
							if(val == 'document') {
								if(document.getElementById('seem_start_object')) {
									document.getElementById('seem_start_object').style.display = 'none';
								}
								document.getElementById('seem_start_document').style.display = 'block';
				";
			if(defined("OBJECT_FILES_TABLE")) {
				$js .= "
							} else if(val == 'object') {
								document.getElementById('seem_start_document').style.display = 'none';
								document.getElementById('seem_start_object').style.display = 'block';
						";
			}
			$js .= "
							} else {
								document.getElementById('seem_start_document').style.display = 'none';
								if(document.getElementById('seem_start_object')) {
									document.getElementById('seem_start_object').style.display = 'none';
								}

							}
						}
					//-->
					</script>";

		// Cockpit
		$_object_path = "";
		$_object_id = 0;
		$_document_path = "";
		$_document_id = 0;

		if($this->Preferences['seem_start_type'] == "cockpit") {
			$_SESSION["prefs"]["seem_start_file"] = 0;
			$_seem_start_type = "cockpit";


		// Object
		} else if($this->Preferences['seem_start_type'] == "object") {
			$_seem_start_type = "object";
			if ($this->Preferences['seem_start_file'] != 0) {
				$_object_id = $this->Preferences['seem_start_file'];
				$_get_object_paths = getPathsFromTable(OBJECT_FILES_TABLE, "", FILE_ONLY, $_object_id);

				if(isset($_get_object_paths[$_object_id])){	//	seeMode start file exists
					$_object_path = $_get_object_paths[$_object_id];

				}

			}

		// Document
		} else {
			$_seem_start_type = "document";
			if ($this->Preferences['seem_start_file'] != 0) {
				$_document_id = $this->Preferences['seem_start_file'];
				$_get_document_paths = getPathsFromTable(FILE_TABLE, "", FILE_ONLY, $_document_id);

				if(isset($_get_document_paths[$_document_id])){	//	seeMode start file exists
					$_document_path = $_get_document_paths[$_document_id];

				}

			}

		}

		$_start_type = new we_htmlSelect(array("name" => "seem_start_type","class" => "weSelect", "id" => "seem_start_type", "onchange" => "show_seem_chooser(this.value); top.content.setHot();"));

		$_start_type->addOption("cockpit", $GLOBALS['l_prefs']["seem_start_type_cockpit"]);
		$_start_type->addOption("document", $GLOBALS['l_prefs']["seem_start_type_document"]);
		if(defined("OBJECT_FILES_TABLE")) {
			$_start_type->addOption("object", $GLOBALS['l_prefs']["seem_start_type_object"]);

		}
		$_start_type->selectOption($_seem_start_type);

		// Build SEEM select start document chooser
		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("Doc");
		$yuiSuggest->setContentType("folder,text/webedition,image/*,text/js,text/css,text/html,application/*,video/quicktime");
		$yuiSuggest->setInput("seem_start_document_name", $_document_path);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult("seem_start_document",$_document_id);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setWidth(191);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:select_seem_start()", true, 100, 22, "", "", false, false),10);
		$yuiSuggest->setContainerWidth(299);
		
		$weAcSelector = $yuiSuggest->getHTML();
		
		$_seem_document_chooser = $we_button->create_button_table(array($weAcSelector), 0, array("id"=>"seem_start_document", "style"=>"display:none"));

		// Build SEEM select start object chooser
		$yuiSuggest->setAcId("Obj");
		$yuiSuggest->setContentType("folder,objectFile");
		$yuiSuggest->setInput("seem_start_object_name", $_object_path);
		$yuiSuggest->setMaxResults(20);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult("seem_start_object", $_object_id);
		$yuiSuggest->setSelector("Docselector");
		if(defined('OBJECT_FILES_TABLE')) {
			$yuiSuggest->setTable(OBJECT_FILES_TABLE);
		}
		$yuiSuggest->setWidth(191);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:select_seem_start()", true, 100, 22, "", "", false, false),10);
		$yuiSuggest->setContainerWidth(299);
		
		$weAcSelector = $yuiSuggest->getHTML();
		
		$_seem_object_chooser = $we_button->create_button_table(array($weAcSelector), 10, array("id"=>"seem_start_object", "style"=>"display:none"));

		// Build final HTML code
		$_seem_html = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 2, 1);
		$_seem_html->setCol(0, 0, array("class" => "defaultfont"), $_start_type->getHtmlCode() . getPixel(200,1));
		$_seem_html->setCol(1, 0, null, $_seem_document_chooser . $_seem_object_chooser);

		if (we_hasPerm("CHANGE_START_DOCUMENT")) {
			array_push($_settings,
					array(
						"headline" => $GLOBALS['l_prefs']["seem_startdocument"],
						"html" => $js . $_seem_html->getHtmlCode().'<script language="JavaScript" type="text/javascript">show_seem_chooser("'.$_seem_start_type.'");</script>',
						"space" => 200
					)
				);
		}

		/*****************************************************************
		 * TREE
		 *****************************************************************/

		$_value_selected=false;
		$_tree_count=$this->Preferences['default_tree_count'];

		$_file_tree_count = new we_htmlSelect(array("name" => $this->Name."_Preference_default_tree_count", "class" => "weSelect", "onChange"=> "top.content.setHot();"));

		$_file_tree_count->addOption(0, $GLOBALS['l_prefs']["all"]);
		if (0 == $_tree_count) {
				$_file_tree_count->selectOption(0);
				$_value_selected = true;
		}

		for ($i = 10; $i < 51; $i+=10) {
			$_file_tree_count->addOption($i, $i);

			// Set selected extension
			if ($i == $_tree_count) {
				$_file_tree_count->selectOption($i);
				$_value_selected = true;
			}
		}

		for ($i = 100; $i < 501; $i+=100) {
			$_file_tree_count->addOption($i, $i);

			// Set selected extension
			if ($i == $_tree_count) {
				$_file_tree_count->selectOption($i);
				$_value_selected = true;
			}
		}

		if (!$_value_selected) {
			$_file_tree_count->addOption($_tree_count, $_tree_count);
			// Set selected extension
			$_file_tree_count->selectOption($_tree_count);
		}

		array_push($_settings, array("headline" => $GLOBALS['l_prefs']["tree_title"], "html" => htmlAlertAttentionBox($GLOBALS['l_prefs']["tree_count_description"],2)."<br>".$_file_tree_count->getHtmlCode(), "space" => 200));


		/*****************************************************************
		 * WINDOW DIMENSIONS
		 *****************************************************************/

		$_window_max = false;
		$_window_specify = false;

		if ($this->Preferences['sizeOpt'] == 0) {
			$_window_max = true;
		}

		if ($this->Preferences['sizeOpt'] == 1) {
			$_window_specify = true;
		}

		// Build maximize window
		$_window_max_code = we_forms::radiobutton(0, $this->Preferences['sizeOpt'] == 0, $this->Name."_Preference_sizeOpt", $GLOBALS['l_prefs']["maximize"], true, "defaultfont", "document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = true;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = true;top.content.setHot();");

		// Build specify window dimension
		$_window_specify_code = we_forms::radiobutton(1, !($this->Preferences['sizeOpt'] == 0), $this->Name."_Preference_sizeOpt", $GLOBALS['l_prefs']["specify"], true, "defaultfont", "document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = false;top.content.setHot();");

		// Create specify window dimension input
		$_window_specify_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 4, 4);

		$_window_specify_table->setCol(0, 0, null, getPixel(1, 10));
		$_window_specify_table->setCol(1, 0, null, getPixel(40, 1));
		$_window_specify_table->setCol(2, 0, null, getPixel(1, 5));
		$_window_specify_table->setCol(3, 0, null, getPixel(40, 1));

		$_window_specify_table->setCol(1, 1, array("class" => "defaultfont"), $GLOBALS['l_prefs']["width"] . ":");
		$_window_specify_table->setCol(3, 1, array("class" => "defaultfont"), $GLOBALS['l_prefs']["height"] . ":");

		$_window_specify_table->setCol(1, 2, null, getPixel(10, 1));
		$_window_specify_table->setCol(3, 2, null, getPixel(10, 1));

		$_window_specify_table->setCol(1, 3, null, htmlTextInput($this->Name."_Preference_weWidth", 6, ($this->Preferences['sizeOpt'] != $this->Preferences['weWidth'] ? 800 : ""), 4, ($this->Preferences['sizeOpt'] == 0 ? "disabled=\"disabled\"" : "") . "onChange='top.content.setHot();'", "text", 60));
		$_window_specify_table->setCol(3, 3, null, htmlTextInput($this->Name."_Preference_weHeight", 6, ($this->Preferences['sizeOpt'] != $this->Preferences['weWidth'] ? 600 : ""), 4, ($this->Preferences['sizeOpt'] == 0 ? "disabled=\"disabled\"" : "") . "onChange='top.content.setHot();'", "text", 60));

		// Build apply current window dimension
		$_window_current_dimension_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 1, 2);

		$_window_current_dimension_table->setCol(0, 0, null, getPixel(90, 1));
		$_window_current_dimension_table->setCol(0, 1, null, $we_button->create_button("apply_current_dimension", "javascript:top.content.setHot();document.getElementsByName('".$this->Name."_Preference_sizeOpt')[1].checked = true;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].value = " . ($GLOBALS['BROWSER'] == "IE" ? "top.opener.top.document.body.clientWidth" : "top.opener.top.window.outerWidth") . ";document.getElementsByName('".$this->Name."_Preference_weHeight')[0].value = " . ($GLOBALS['BROWSER'] == "IE" ? "top.opener.top.document.body.clientHeight;" : "top.opener.top.window.outerHeight;"), true,210));

		// Build final HTML code
		$_window_html = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 5, 1);
		$_window_html->setCol(0, 0, null, $_window_max_code);
		$_window_html->setCol(1, 0, null, getPixel(1, 10));
		$_window_html->setCol(2, 0, null, $_window_specify_code . $_window_specify_table->getHtmlCode());
		$_window_html->setCol(3, 0, null, getPixel(1, 10));
		$_window_html->setCol(4, 0, null, $_window_current_dimension_table->getHtmlCode());

		// Build dialog
		array_push($_settings, array("headline" => $GLOBALS['l_prefs']["dimension"], "html" => $_window_html->getHtmlCode(), "space" => 200));

		// Create predefined window dimension buttons
		$_window_predefined_table = new we_htmlTable(array("border"=>"0", "align"=>"right", "cellpadding"=>"1", "cellspacing"=>"0"), 3, 1);

		$_window_predefined_table->setCol(0, 0, null, $we_button->create_button_table(array($we_button->create_button("res_800", "javascript:top.content.setHot();document.getElementsByName('".$this->Name."_Preference_sizeOpt')[1].checked = true;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].value = '800';document.getElementsByName('".$this->Name."_Preference_weHeight')[0].value = '600';", true), $we_button->create_button("res_1024", "javascript:top.content.setHot();document.getElementsByName('".$this->Name."_Preference_sizeOpt')[1].checked = true;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].value = '1024';document.getElementsByName('".$this->Name."_Preference_weHeight')[0].value = '768';", true))));
		$_window_predefined_table->setCol(2, 0, null, $we_button->create_button_table(array($we_button->create_button("res_1280", "javascript:top.content.setHot();document.getElementsByName('".$this->Name."_Preference_sizeOpt')[1].checked = true;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].value = '1280';document.getElementsByName('".$this->Name."_Preference_weHeight')[0].value = '960';", true), $we_button->create_button("res_1600", "javascript:top.content.setHot();document.getElementsByName('".$this->Name."_Preference_sizeOpt')[1].checked = true;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weHeight')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_weWidth')[0].value = '1600';document.getElementsByName('".$this->Name."_Preference_weHeight')[0].value = '1200';", true))));

		$_window_predefined_table->setCol(1, 0, null, getPixel(1, 10));

		// Build dialog
		array_push($_settings, array("headline" => $GLOBALS['l_prefs']["predefined"], "html" => $_window_predefined_table->getHtmlCode(), "space" => 200));

		$_settings_cookie = weGetCookieVariable("but_settings_predefined");

		/**
		 * BUILD FINAL DIALOG
		 */

		return $_settings;

	}

	function formPreferencesEditor() {

		$we_button = new we_button();

		$_settings = array();

		/*********************************************************************
		 * TEMPLATE EDITOR
		 *********************************************************************/

		$_template_fonts = array("Courier New", "Courier", "mono", "Verdana", "Arial", "Helvetica", "sans-serif", "none");
		$_template_font_sizes = array(8, 9, 10, 11, 12, 14, 16, 18, 24, 32, 48, 72, -1);

		$_template_editor_font_specify = false;
		$_template_editor_font_size_specify = false;

		if ($this->Preferences['editorFontname'] != "" && $this->Preferences['editorFontname'] != "none") {
			$_template_editor_font_specify = true;
		}

		if ($this->Preferences['editorFontsize'] != "" && $this->Preferences['editorFontsize'] != -1) {
			$_template_editor_font_size_specify = true;
		}

		// Build specify font
		$_template_editor_font_specify_code = we_forms::checkbox(1, $_template_editor_font_specify, $this->Name."_Preference_editorFont", $GLOBALS['l_prefs']["specify"], true, "defaultfont", "top.content.setHot(); if (document.getElementsByName('".$this->Name."_Preference_editorFont')[0].checked) { document.getElementsByName('".$this->Name."_Preference_editorFontname')[0].disabled = false;document.getElementsByName('".$this->Name."_Preference_editorFontsize')[0].disabled = false; } else { document.getElementsByName('".$this->Name."_Preference_editorFontname')[0].disabled = true;document.getElementsByName('".$this->Name."_Preference_editorFontsize')[0].disabled = true; }");

		// Create specify window dimension input
		$_template_editor_font_specify_table = new we_htmlTable(array("border"=>"0", "cellpadding"=>"0", "cellspacing"=>"0"), 4, 4);

		$_template_editor_font_specify_table->setCol(0, 0, null, getPixel(1, 10));
		$_template_editor_font_specify_table->setCol(1, 0, null, getPixel(50, 1));
		$_template_editor_font_specify_table->setCol(2, 0, null, getPixel(1, 5));
		$_template_editor_font_specify_table->setCol(3, 0, null, getPixel(50, 1));

		$_template_editor_font_specify_table->setCol(1, 1, array("class" => "defaultfont"), $GLOBALS['l_prefs']["editor_fontname"] . ":");
		$_template_editor_font_specify_table->setCol(3, 1, array("class" => "defaultfont"), $GLOBALS['l_prefs']["editor_fontsize"] . ":");

		$_template_editor_font_specify_table->setCol(1, 2, null, getPixel(10, 1));
		$_template_editor_font_specify_table->setCol(3, 2, null, getPixel(10, 1));

		$_template_editor_font_select_box = new we_htmlSelect(array("class" => "weSelect", "name" => $this->Name."_Preference_editorFontname",  "size" => "1", "style" => "width: 90px;", ($_template_editor_font_specify ? "enabled" : "disabled") => ($_template_editor_font_specify ? "enabled" : "disabled"), "onChange" => "top.content.setHot();" ));

		for ($i = 0; $i < (count($_template_fonts) - 1); $i++) {
			$_template_editor_font_select_box->addOption($_template_fonts[$i], $_template_fonts[$i]);

			if (!$_template_editor_font_specify) {
				if ($_template_fonts[$i] == "Courier New") {
					$_template_editor_font_select_box->selectOption($_template_fonts[$i]);
				}
			} else {
				if ($_template_fonts[$i] == $this->Preferences['editorFontname']) {
					$_template_editor_font_select_box->selectOption($_template_fonts[$i]);
				}
			}
		}

		$_template_editor_font_sizes_select_box = new we_htmlSelect(array("class" => "weSelect", "name" => $this->Name."_Preference_editorFontsize",  "size" => "1", "style" => "width: 90px;", ($_template_editor_font_size_specify ? "enabled" : "disabled") => ($_template_editor_font_size_specify ? "enabled" : "disabled"), "onChange" => "top.content.setHot();"));

		for ($i = 0; $i < (count($_template_font_sizes) - 1); $i++) {
			$_template_editor_font_sizes_select_box->addOption($_template_font_sizes[$i], $_template_font_sizes[$i]);

			if (!$_template_editor_font_specify) {
				if ($_template_font_sizes[$i] == 11) {
					$_template_editor_font_sizes_select_box->selectOption($_template_font_sizes[$i]);
				}
			} else {
				if ($_template_font_sizes[$i] == $this->Preferences['editorFontsize']) {
					$_template_editor_font_sizes_select_box->selectOption($_template_font_sizes[$i]);
				}
			}
		}

		$_template_editor_font_specify_table->setCol(1, 3, null, $_template_editor_font_select_box->getHtmlCode());
		$_template_editor_font_specify_table->setCol(3, 3, null, $_template_editor_font_sizes_select_box->getHtmlCode());

		// Build dialog
		array_push($_settings, array("headline" => $GLOBALS['l_prefs']["editor_font"], "html" => $_template_editor_font_specify_code . $_template_editor_font_specify_table->getHtmlCode(), "space" => 200));

		$_settings_cookie = weGetCookieVariable("but_settings_editor_predefined");

		return $_settings;

	}

	#--------------------------------------------------------------------------#

	function formAliasData() {

		$we_button = new we_button();


		$alias_text="";
		$parent_text="/";
		if($this->ID) {
			$foo=getHash("SELECT Path FROM ".USER_TABLE." WHERE ID='".$this->Alias."'",$this->DB_WE);
			$alias_text=$foo["Path"];
			if($this->ParentID==0) {
				$parent_text="/";
			}
			else {
				$foo=getHash("SELECT Path FROM ".USER_TABLE." WHERE ID='".$this->ParentID."'",$this->DB_WE);
				$parent_text=$foo["Path"];
			}
		}
		if($this->ParentID != 0){
            $foo=getHash("SELECT Path FROM ".USER_TABLE." WHERE ID='".$this->ParentID."'",$this->DB_WE);
            $parent_text=$foo["Path"];
		}

		$yuiSuggest =& weSuggest::getInstance();
		$yuiSuggest->setAcId("PathName");
		$yuiSuggest->setContentType("0,1"); // in USER_TABLE is Type 0 folder, Type 1 user and Type 2 alias. Field ContentType is not setted so in weSelectorQuery is a workaroun for USER_TABLE
		$yuiSuggest->setInput($this->Name.'_Alias_Text',$alias_text,array("onChange"=>"top.content.setHot();"));
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(false);
		$yuiSuggest->setResult($this->Name.'_Alias',$this->Alias);
		$yuiSuggest->setSelector("Docselector");
		$yuiSuggest->setTable(USER_TABLE);
		$yuiSuggest->setWidth(200);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:we_cmd('browse_users','document.we_form.".$this->Name."_Alias.value','document.we_form.".$this->Name."_Alias_Text.value','noalias',document.we_form.".$this->Name."_Alias.value)"));

		$weAcSelectorName = $yuiSuggest->getHTML();

		$yuiSuggest->setAcId("PathGroup");
		$yuiSuggest->setContentType("folder");
		$yuiSuggest->setInput($this->Name.'_ParentID_Text',$parent_text,array("onChange"=>"top.content.setHot();"));
		$yuiSuggest->setMaxResults(10);
		$yuiSuggest->setMayBeEmpty(true);
		$yuiSuggest->setResult($this->Name.'_ParentID',$this->ParentID);
		$yuiSuggest->setSelector("Dirselector");
		$yuiSuggest->setTable(USER_TABLE);
		$yuiSuggest->setWidth(200);
		$yuiSuggest->setSelectButton($we_button->create_button("select", "javascript:we_cmd('browse_users','document.we_form.".$this->Name."_ParentID.value','document.we_form.".$this->Name."_ParentID_Text.value','group',document.we_form.".$this->Name."_ParentID.value)"));

		$weAcSelectorGroup = $yuiSuggest->getHTML();

		$content='
			<table cellpadding="0" cellspacing="0" border="0" width="530">
				<tr>
					<td class="defaultfont">
						'.$GLOBALS['l_users']["user"].':</td>
					<td>
						' . $weAcSelectorName . '
					</td>
				</tr>
				<tr>
					<td>
						'.getPixel(170,5).'</td>
					<td>
						'.getPixel(330,5).'</td>
				</tr>
				<tr>
					<td class="defaultfont">
						'.$GLOBALS['l_users']["group_member"].':</td>
					<td>
						' . $weAcSelectorGroup . '
					</td>
				</tr>
				<tr>
					<td>
						'.getPixel(170,1).'</td>
					<td>
						'.getPixel(330,1).'</td>
				</tr>
			</table>';

			$parts = array();

			array_push($parts,
						array(
							"headline"=>$GLOBALS['l_users']["alias_data"],
							"html"=>$content,
							"space"=>120
							)
					);

		$content = $this->formInherits("_ParentPerms",$this->ParentPerms,$GLOBALS['l_users']["inherit"]) . getPixel(5,5) .
										$this->formInherits("_ParentWs",$this->ParentWs,$GLOBALS['l_users']["inherit_ws"]) . getPixel(5,5) .
										$this->formInherits("_ParentWst",$this->ParentWst,$GLOBALS['l_users']["inherit_wst"]);


			array_push($parts,
							array(
								"headline"=>$GLOBALS['l_users']["rights_and_workspaces"],
								"html"=>$content,
								"space"=>120
								)
						);

		return we_multiIconBox::getHTML("","100%",$parts,30);

	}

	#--------------------------------------------------------------------------#

	function formInherits($name,$value,$title) {
		$content='
			<table cellpadding="0" cellspacing="0" border="0" width="500">
				<tr>
					<td class="defaultfont">' .
					we_forms::checkbox(1, ($value ? true: false), $this->Name.$name, $title, "", "defaultfont", "top.content.setHot();") . '

				</tr>
			</table>';
		return $content;
	}

	#--------------------------------------------------------------------------#

	function formHeader($tab = 0) {

		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_tabs.class.inc.php");

		$big=false;
		if(file_exists(WE_USERS_MODULE_DIR . "edit_users_bcmd.php")) {
			$big=true;
		}

		$we_tabs = new we_tabs();

		if ($this->Type == 2) {
			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["data"], "TAB_ACTIVE", "setTab(0);"));
		} else {
			$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["data"], ($tab==0?"TAB_ACTIVE":"TAB_NORMAL"), "self.setTab(0);"));

			if (isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"]  && in_array("busers",$GLOBALS["_pro_modules"]) && $big) {
				$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["permissions"], ($tab==1?"TAB_ACTIVE":"TAB_NORMAL"), "self.setTab(1);"));
				$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["workspace"], ($tab==2?"TAB_ACTIVE":"TAB_NORMAL"), "self.setTab(2);"));

			}
			if($this->Type == 0) {
				$we_tabs->addTab(new we_tab("#", $GLOBALS["l_tabs"]["module"]["preferences"], ($tab==3?"TAB_ACTIVE":"TAB_NORMAL"), "self.setTab(3);"));
			}
		}

		$we_tabs->onResize();
		$tab_header = $we_tabs->getHeader();
		$tab_body = $we_tabs->getJS();

		$out ='
			<script language="JavaScript" type="text/javascript"><!--
				var activeTab = 0;
				function setTab(tab) {
					switch(tab) {
						case 0:
							top.content.user_resize.user_right.user_editor.user_properties.switchPage(0);
							activeTab = 0;
							break;
						case 1:
							if(top.content.user_resize.user_right.user_editor.user_properties.switchPage(1)==false){
								setTimeout("resetTabs()",50);
							}
							activeTab = 1;
							break;
						case 2:
							if(top.content.user_resize.user_right.user_editor.user_properties.switchPage(2)==false) {
								setTimeout("resetTabs()",50);
							}
							activeTab = 2;
							break;
						case 3:
							if(top.content.user_resize.user_right.user_editor.user_properties.switchPage(3)==false) {
								setTimeout("resetTabs()",50);
							}
							activeTab = 3;
							break;
					}
				}

				function resetTabs(){
						top.content.user_resize.user_right.user_editor.user_properties.document.we_form.tab.value = 0;
						top.content.user_resize.user_right.user_editor.user_edheader.tabCtrl.setActiveTab(0);
				}

				top.content.hloaded=1;
			//-->
			</script>
			' .
			$tab_header;

		if($this->Type==1) {
			$headline1=$GLOBALS['l_users']["group"].': ';
		}
		else if($this->Type==2) {
			$headline1=$GLOBALS["l_javaMenu"]["users"]["menu_alias"].': ';
		}
		else {
			$headline1=$GLOBALS["l_javaMenu"]["users"]["menu_user"].': ';
		}
		/*
		if(isset($GLOBALS["BIG_USER_MODULE"]) && $GLOBALS["BIG_USER_MODULE"]  && in_array("busers",$GLOBALS["_pro_modules"]) && $big) {
			$headline2=$this->Text;
		}
		else {
			$headline2=$this->username;
		}
		*/
		$headline2=empty($this->Path)?$this->getPath($this->ParentID):$this->Path;
		$out .= '<div id="main" >' . getPixel(100,3).'<div style="margin:0px;padding-left:10px;" id="headrow"><nobr><b>'.str_replace(" ","&nbsp;",$headline1).'&nbsp;</b><span id="h_path" class="header_small"><b id="titlePath">'.str_replace(" ","&nbsp;",$headline2).'</b></span></nobr></div>'.getPixel(100,3).$we_tabs->getHTML().'</div>';

		$out .= $tab_body ;
		return $out;
	}
}

?>