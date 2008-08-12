<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");

	class we_updater{

	function updateTables(){
		global $DB_WE;
		$db2 = new DB_WE();
		$tables = $DB_WE->table_names();
		$hasOwnertable=false;
		foreach($tables as $t){
			// old Version of small User Module
			if($t["table_name"] == "tblOwner"){
				$hasOwnertable = true;
				break;
			}
		}
		if(!$this->isColExist(FILE_TABLE,"CreatorID")) $this->addCol(FILE_TABLE,"CreatorID","BIGINT DEFAULT '0' NOT NULL");
		if(!$this->isColExist(FILE_TABLE,"ModifierID")) $this->addCol(FILE_TABLE,"ModifierID","BIGINT DEFAULT '0' NOT NULL");
		if(!$this->isColExist(FILE_TABLE,"WebUserID")) $this->addCol(FILE_TABLE,"WebUserID","BIGINT DEFAULT '0' NOT NULL");
		if($hasOwnertable){
			$DB_WE->query("SELECT * FROM tblOwner");
			while($DB_WE->next_record()){
				$table = $DB_WE->f("DocumentTable");
				if($table==TEMPLATES_TABLE || $table == FILE_TABLE){
					$id = $DB_WE->f("fileID");
					if($table && $id){
						$Owners = ($DB_WE->f("OwnerID") && ($DB_WE->f("OwnerID") != $DB_WE->f("CreatorID"))) ? (",".$DB_WE->f("OwnerID").",") : "";
						$CreatorID = $DB_WE->f("CreatorID") ? $DB_WE->f("CreatorID") : $_SESSION["user"]["ID"];
						$ModifierID = $DB_WE->f("ModifierID") ? $DB_WE->f("ModifierID") : $_SESSION["user"]["ID"];
						$db2->query("UPDATE $table SET CreatorID='$CreatorID' , ModifierID='$ModifierID' , Owners='$Owners' WHERE ID='$id'");
						$db2->query("DELETE FROM tblOwner WHERE fileID='$id'");
						@set_time_limit(30);
					}
				}
			}
			$DB_WE->query("DROP TABLE tblOwner");
		}
		//$DB_WE->query("ALTER TABLE " . INDEX_TABLE . " DROP PRIMARY KEY");
		if(!$this->isColExist(FILE_TABLE,"Owners")) $this->addCol(FILE_TABLE,"Owners","VARCHAR(255)  DEFAULT ''");
		if(!$this->isColExist(FILE_TABLE,"RestrictOwners")) $this->addCol(FILE_TABLE,"RestrictOwners","TINYINT(1)  DEFAULT ''");
		if(!$this->isColExist(FILE_TABLE,"OwnersReadOnly")) $this->addCol(FILE_TABLE,"OwnersReadOnly","TEXT DEFAULT ''");

		if(!$this->isColExist(CATEGORY_TABLE,"IsFolder")) $this->addCol(CATEGORY_TABLE,"IsFolder","TINYINT(1) DEFAULT 0");
		if(!$this->isColExist(CATEGORY_TABLE,"ParentID")) $this->addCol(CATEGORY_TABLE,"ParentID","BIGINT(20) DEFAULT 0");
		if(!$this->isColExist(CATEGORY_TABLE,"Text")) $this->addCol(CATEGORY_TABLE,"Text","VARCHAR(64) DEFAULT ''");
		if(!$this->isColExist(CATEGORY_TABLE,"Path")) $this->addCol(CATEGORY_TABLE,"Path","VARCHAR(255)  DEFAULT ''");
		if(!$this->isColExist(CATEGORY_TABLE,"Icon")) $this->addCol(CATEGORY_TABLE,"Icon","VARCHAR(64) DEFAULT 'cat.gif'");
		$DB_WE->query("SELECT * FROM " . CATEGORY_TABLE);
		while($DB_WE->next_record()){
			if(($DB_WE->f("Text")==""))
				$db2->query("UPDATE " . CATEGORY_TABLE . " SET Text='".$DB_WE->f("Category")."' WHERE ID='".$DB_WE->f("ID")."'");
			if(($DB_WE->f("Path")==""))
				$db2->query("UPDATE " . CATEGORY_TABLE . " SET Path='/".$DB_WE->f("Category")."' WHERE ID='".$DB_WE->f("ID")."'");
		}

		if(!$this->isColExist(PREFS_TABLE,"seem_start_file")) $this->addCol(PREFS_TABLE,"seem_start_file","INT");
		if(!$this->isColExist(PREFS_TABLE,"phpOnOff")) $this->addCol(PREFS_TABLE,"phpOnOff","TINYINT(1) DEFAULT '0' NOT NULL");
		if(!$this->isColExist(PREFS_TABLE,"editorSizeOpt")) $this->addCol(PREFS_TABLE,"editorSizeOpt","TINYINT( 1 ) DEFAULT '0' NOT NULL");
		if(!$this->isColExist(PREFS_TABLE,"editorWidth")) $this->addCol(PREFS_TABLE,"editorWidth","INT( 11 ) DEFAULT '0' NOT NULL");
		if(!$this->isColExist(PREFS_TABLE,"editorHeight")) $this->addCol(PREFS_TABLE,"editorHeight","INT( 11 ) DEFAULT '0' NOT NULL");
		if(!$this->isColExist(PREFS_TABLE,"debug_normal")) $this->addCol(PREFS_TABLE,"debug_normal","TINYINT( 1 ) DEFAULT '0' NOT NULL");
		if(!$this->isColExist(PREFS_TABLE,"debug_seem")) $this->addCol(PREFS_TABLE,"debug_seem","TINYINT( 1 ) DEFAULT '0' NOT NULL");

		if(!$this->isColExist(PREFS_TABLE,"xhtml_show_wrong")) $this->addCol(PREFS_TABLE,"xhtml_show_wrong","TINYINT(1) DEFAULT '0' NOT NULL");
  		if(!$this->isColExist(PREFS_TABLE,"xhtml_show_wrong_text")) $this->addCol(PREFS_TABLE,"xhtml_show_wrong_text","TINYINT(2) DEFAULT '0' NOT NULL");
  		if(!$this->isColExist(PREFS_TABLE,"xhtml_show_wrong_js")) $this->addCol(PREFS_TABLE,"xhtml_show_wrong_js","TINYINT(2) DEFAULT '0' NOT NULL");
  		if(!$this->isColExist(PREFS_TABLE,"xhtml_show_wrong_error_log")) $this->addCol(PREFS_TABLE,"xhtml_show_wrong_error_log","TINYINT(2) DEFAULT '0' NOT NULL");
  		if(!$this->isColExist(PREFS_TABLE,"default_tree_count")) $this->addCol(PREFS_TABLE,"default_tree_count","INT(11) DEFAULT '0' NOT NULL");



	}



	function convertPerms(){
			global $DB_WE;
			if($this->isColExist(USER_TABLE,"Permissions") && $this->getColTyp(USER_TABLE,"Permissions")!="text") $this->changeColTyp(USER_TABLE,"Permissions","TEXT");
			else return;
			$db_tmp=new DB_WE();
			$DB_WE->query("SELECT ID,username,Permissions from " . USER_TABLE);
			while($DB_WE->next_record()){
			  $perms_slot=array();
			  $pstr=$DB_WE->f("Permissions");
			  $perms_slot["ADMINISTRATOR"]=$pstr["0"];
			  $perms_slot["PUBLISH"]=$pstr["1"];
			  if(count($perms_slot)>0){
				 $db_tmp->query("UPDATE " . USER_TABLE . " SET Permissions='".serialize($perms_slot)."' WHERE ID=".$DB_WE->f("ID"));
			  }
			}
	}

	function fix_path(){
		$db = new DB_WE();
		$db2 = new DB_WE();
		if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){
			$db->query("SELECT ID,username,ParentID FROM " . USER_TABLE);
			while($db->next_record()){
						set_time_limit(30);
						$id = $db->f("ID");
						$pid = $db->f("ParentID");
						$path = "/".$db->f("username");
						while($pid > 0){
					$db2->query("SELECT username,ParentID FROM " . USER_TABLE . " WHERE ID='$pid'");
					if($db2->next_record()){
									$path = "/".$db2->f("username").$path;
									$pid = $db2->f("ParentID");
					}
					else $pid=0;
						}
						$db2->query("UPDATE " . USER_TABLE . " SET Path='$path' WHERE ID='$id'");
			}
		}
		else{
			$db->query("SELECT ID,username FROM " . USER_TABLE);
			while($db->next_record()){
						set_time_limit(30);
						$id = $db->f("ID");
						$path = "/".$db->f("username");
						$db2->query("UPDATE " . USER_TABLE . " SET Path='$path' WHERE ID='$id'");
			}

		}
	}

	function fix_icon(){
		$db = new DB_WE();
		$db2 = new DB_WE();
		$db->query("SELECT ID,Type FROM " . USER_TABLE);
		while($db->next_record()){
			set_time_limit(30);
			$id = $db->f("ID");
			if($db->f("Type")==2) {
				$icon="user_alias.gif";
			} else if($db->f("Type")==1) {
				$icon="usergroup.gif";
			} else {
				$icon="user.gif";
			}
			$db2->query("UPDATE " . USER_TABLE . " SET Icon='$icon' WHERE ID='$id'");
		}
	}

	function fix_icon_small(){
				$db = new DB_WE();
				$db2 = new DB_WE();
				$db->query("SELECT ID,IsFolder FROM " . USER_TABLE);
				while($db->next_record()){
					set_time_limit(30);
					$id = $db->f("ID");
			if($db->f("IsFolder")==1) $icon="usergroup.gif";
			else $icon="user.gif";
					$db2->query("UPDATE " . USER_TABLE . " SET Icon='$icon' WHERE ID='$id'");
				}
	}

	function fix_text(){
		$db = new DB_WE();
		$db2 = new DB_WE();
		$db->query("SELECT ID,username FROM " . USER_TABLE);
		while($db->next_record()){
			set_time_limit(30);
			$id = $db->f("ID");
			$text = $db->f("username");
			$db2->query("UPDATE " . USER_TABLE . " SET Text='$text' WHERE ID='$id'");
		}
	}

	function isColExist($tab,$col){
			global $DB_WE;
			$DB_WE->query("SHOW COLUMNS FROM ".$tab." LIKE '$col';");
			if($DB_WE->next_record()) return true; else return false;
	}

	function isTabExist($tab){
			global $DB_WE;
			$DB_WE->query("SHOW TABLES LIKE '$tab';");
			if($DB_WE->next_record()) return true; else return false;
	}

	function addTable($tab,$cols){
			   global $DB_WE;

			   if(!is_array($cols)) return;
			   if(!count($cols)) return;
			   $cols_sql=array();
			   $key_sql=array();
			   foreach($cols as $name=>$type){
			   		$cols_sql[]=$name." ".$type;
			   }
			   $sql_array=array_merge($cols_sql,$key_sql);

			   $DB_WE->query("CREATE TABLE $tab (".implode(",",$sql_array).")");
	}

	function addCol($tab,$col,$typ,$pos=""){
			   global $DB_WE;
			   $DB_WE->query("ALTER TABLE $tab ADD $col $typ".(($pos!="") ? " ".$pos : "").";");
	}

	function changeColTyp($tab,$col,$newtyp){
			   global $DB_WE;
			   $DB_WE->query("ALTER TABLE $tab CHANGE $col $col $newtyp;");
	}

	function getColTyp($tab,$col){
			   global $DB_WE;
			   $DB_WE->query("SHOW COLUMNS FROM ".$tab." LIKE '$col';");
			   if($DB_WE->next_record()) return $DB_WE->f("Type"); else return "";
	}

	function delCol($tab,$col){
			   global $DB_WE;
			   $DB_WE->query("ALTER TABLE $tab DROP $col;");
	}

	function updateUsers(){
		global $DB_WE;
		$db123=new DB_WE();
		if(!$this->isTabExist(USER_TABLE)) return;
		$this->convertPerms();
		if(!$this->isColExist(USER_TABLE,"Path")) $this->addCol(USER_TABLE,"Path","VARCHAR(255)  DEFAULT ''","AFTER ID");
		if(!$this->isColExist(USER_TABLE,"ParentID")) $this->addCol(USER_TABLE,"ParentID","BIGINT(20) DEFAULT '0' NOT NULL","AFTER ID");

		if(!$this->isColExist(USER_TABLE,"Icon")) $this->addCol(USER_TABLE,"Icon","VARCHAR(64)  DEFAULT ''","AFTER Permissions");
		if(!$this->isColExist(USER_TABLE,"IsFolder")) $this->addCol(USER_TABLE,"IsFolder","TINYINT(1) DEFAULT '0' NOT NULL","AFTER Permissions");
		if(!$this->isColExist(USER_TABLE,"Text")) $this->addCol(USER_TABLE,"Text","VARCHAR(255)  DEFAULT ''","AFTER Permissions");

		if($this->isColExist(USER_TABLE,"First")) $this->changeColTyp(USER_TABLE,"First","VARCHAR(255)");
		if($this->isColExist(USER_TABLE,"Second")) $this->changeColTyp(USER_TABLE,"Second","VARCHAR(255)");
		if($this->isColExist(USER_TABLE,"username")) $this->changeColTyp(USER_TABLE,"username","VARCHAR(255) NOT NULL");
		if($this->isColExist(USER_TABLE,"workSpace")) $this->changeColTyp(USER_TABLE,"workSpace","VARCHAR(255)");
		$this->fix_path();
		$this->fix_text();
		$this->fix_icon_small();

		 if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){
			if(!$this->isColExist(USER_TABLE,"Salutation")) $this->addCol(USER_TABLE,"Salutation","VARCHAR(32) DEFAULT ''","AFTER ParentID");
			if(!$this->isColExist(USER_TABLE,"Type")) $this->addCol(USER_TABLE,"Type","TINYINT(4) DEFAULT '0' NOT NULL","AFTER ParentID");
			if(!$this->isColExist(USER_TABLE,"Address")) $this->addCol(USER_TABLE,"Address","VARCHAR(255) DEFAULT ''","AFTER Second");
			if(!$this->isColExist(USER_TABLE,"HouseNo")) $this->addCol(USER_TABLE,"HouseNo","VARCHAR(32) DEFAULT ''","AFTER Address");
			if(!$this->isColExist(USER_TABLE,"PLZ")) $this->addCol(USER_TABLE,"PLZ","VARCHAR(32) DEFAULT ''","AFTER HouseNo");
			if(!$this->isColExist(USER_TABLE,"City")) $this->addCol(USER_TABLE,"City","VARCHAR(255) DEFAULT ''","AFTER PLZ");
			if(!$this->isColExist(USER_TABLE,"State")) $this->addCol(USER_TABLE,"State","VARCHAR(255) DEFAULT ''","AFTER City");
			if(!$this->isColExist(USER_TABLE,"Country")) $this->addCol(USER_TABLE,"Country","VARCHAR(255) DEFAULT ''","AFTER State");
			if(!$this->isColExist(USER_TABLE,"Tel_preselection")) $this->addCol(USER_TABLE,"Tel_preselection","VARCHAR(32) DEFAULT ''","AFTER Country");
			if(!$this->isColExist(USER_TABLE,"Telephone")) $this->addCol(USER_TABLE,"Telephone","VARCHAR(64) DEFAULT ''","AFTER Tel_preselection");
			if(!$this->isColExist(USER_TABLE,"Fax_preselection")) $this->addCol(USER_TABLE,"Fax_preselection","VARCHAR(32) DEFAULT ''","AFTER Telephone");
			if(!$this->isColExist(USER_TABLE,"Fax")) $this->addCol(USER_TABLE,"Fax","VARCHAR(64) DEFAULT ''","AFTER Fax_preselection");
			if(!$this->isColExist(USER_TABLE,"Handy")) $this->addCol(USER_TABLE,"Handy","VARCHAR(64) DEFAULT ''","AFTER Fax");
			if(!$this->isColExist(USER_TABLE,"Email")) $this->addCol(USER_TABLE,"Email","VARCHAR(255) DEFAULT ''","AFTER Handy");
			if(!$this->isColExist(USER_TABLE,"Description")) $this->addCol(USER_TABLE,"Description","TEXT DEFAULT ''","AFTER Email");
			if(!$this->isColExist(USER_TABLE,"workSpaceTmp")) $this->addCol(USER_TABLE,"workSpaceTmp","VARCHAR(255) DEFAULT ''","AFTER workSpace");
			if(!$this->isColExist(USER_TABLE,"workSpaceDef")) $this->addCol(USER_TABLE,"workSpaceDef","VARCHAR(255) DEFAULT ''","AFTER workSpaceTmp");
			if(!$this->isColExist(USER_TABLE,"ParentPerms")) $this->addCol(USER_TABLE,"ParentPerms","TINYINT DEFAULT '0' NOT NULL","AFTER passwd");
			if(!$this->isColExist(USER_TABLE,"ParentWs")) $this->addCol(USER_TABLE,"ParentWs","TINYINT DEFAULT '0' NOT NULL","AFTER workSpaceDef");
			if(!$this->isColExist(USER_TABLE,"ParentWst")) $this->addCol(USER_TABLE,"ParentWst","TINYINT DEFAULT '0' NOT NULL","AFTER ParentWs");
			if(!$this->isColExist(USER_TABLE,"Alias")) $this->addCol(USER_TABLE,"Alias","BIGINT DEFAULT '0' NOT NULL");

			if($this->isColExist(USER_TABLE,"workSpace")){
				$this->changeColTyp(USER_TABLE,"workSpace","VARCHAR(255)");
				$DB_WE->query("UPDATE " . USER_TABLE . " SET workSpace='' WHERE workSpace='0';");
			}
			if($this->isColExist(USER_TABLE,"IsFolder")){
				$DB_WE->query("SELECT ID FROM " . USER_TABLE . " WHERE Type=1");
				while($DB_WE->next_record()) $db123->query("UPDATE " . USER_TABLE . " SET IsFolder=1 WHERE ID=".$DB_WE->f("ID"));
			}
			$this->fix_icon();

		}

	}

	function updateCustomers(){
		global $DB_WE;

		if(defined("CUSTOMER_TABLE")){
			if(weModuleInfo::isModuleInstalled("customer")){
				if(!$this->isTabExist(CUSTOMER_ADMIN_TABLE)){
						$cols=array(
							"Name"=>"VARCHAR(255) NOT NULL",
							"Value"=>"TEXT NOT NULL"
						);

						$this->addTable(CUSTOMER_ADMIN_TABLE,$cols);

						$DB_WE->query("INSERT INTO " . CUSTOMER_ADMIN_TABLE . "(Name,Value) VALUES('FieldAdds','');");
						$DB_WE->query("INSERT INTO " . CUSTOMER_ADMIN_TABLE . "(Name,Value) VALUES('SortView','');");
						$DB_WE->query("INSERT INTO " . CUSTOMER_ADMIN_TABLE . "(Name,Value) VALUES('Prefs','');");

						include($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/"."weCustomerSettings.php");
						$settings=new weCustomerSettings();
						$settings->customer=new weCustomer();
						$fields=$settings->customer->getFieldsDbProperties();
						$_keys = array_keys($fields);
						foreach($_keys as $name){
							if(!$settings->customer->isProtected($name) && !$settings->customer->isProperty($name)){
								$settings->FieldAdds[$name]["type"]="input";
								$settings->FieldAdds[$name]["default"]="";
							}
						}
						$settings->save();
				}

			}

			if(!$this->isColExist(CUSTOMER_TABLE,"ParentID")) $this->addCol(CUSTOMER_TABLE,"ParentID","BINGINT DEFAULT '0' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"Path")) $this->addCol(CUSTOMER_TABLE,"Path","VARCHAR(255) DEFAULT '' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"IsFolder")) $this->addCol(CUSTOMER_TABLE,"IsFolder","TINYINT(1) DEFAULT '0' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"Icon")) $this->addCol(CUSTOMER_TABLE,"Icon","VARCHAR(255) DEFAULT 'customer.gif' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"Text")) $this->addCol(CUSTOMER_TABLE,"Text","VARCHAR(255) DEFAULT '' NOT NULL");

			if(!$this->isColExist(CUSTOMER_TABLE,"Username")) $this->addCol(CUSTOMER_TABLE,"Username","VARCHAR(255) DEFAULT '' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"Password")) $this->addCol(CUSTOMER_TABLE,"Password","VARCHAR(32) DEFAULT '' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"Forename")) $this->addCol(CUSTOMER_TABLE,"Forename","VARCHAR(255) DEFAULT '' NOT NULL");
			if(!$this->isColExist(CUSTOMER_TABLE,"Surname")) $this->addCol(CUSTOMER_TABLE,"Surname","VARCHAR(255) DEFAULT '' NOT NULL");

			if(!$this->isColExist(CUSTOMER_TABLE,"MemberSince")){
				$this->addCol(CUSTOMER_TABLE,"MemberSince","VARCHAR(24) DEFAULT '' NOT NULL");
				$DB_WE->query("UPDATE " . CUSTOMER_ADMIN_TABLE . " SET MemberSince='".time()."';");
			}
			else $this->changeColTyp(CUSTOMER_TABLE,"MemberSince","VARCHAR(24) DEFAULT '' NOT NULL");

			if(!$this->isColExist(CUSTOMER_TABLE,"LastLogin")) $this->addCol(CUSTOMER_TABLE,"LastLogin","VARCHAR(24) DEFAULT '' NOT NULL");
			else $this->changeColTyp(CUSTOMER_TABLE,"LastLogin","VARCHAR(24) DEFAULT '' NOT NULL");

			if(!$this->isColExist(CUSTOMER_TABLE,"LastAccess")) $this->addCol(CUSTOMER_TABLE,"LastAccess","VARCHAR(24) DEFAULT '' NOT NULL");
			else $this->changeColTyp(CUSTOMER_TABLE,"LastAccess","VARCHAR(24) DEFAULT '' NOT NULL");

		}
	}

	function updateScheduler(){
		if(defined("SCHEDULE_TABLE")){
			if(!$this->isColExist(SCHEDULE_TABLE,"Schedpro")) $this->addCol(SCHEDULE_TABLE,"Schedpro","longtext DEFAULT ''");
			if(!$this->isColExist(SCHEDULE_TABLE,"Type")) $this->addCol(SCHEDULE_TABLE,"Type","TINYINT(3) DEFAULT '0' NOT NULL");
			if(!$this->isColExist(SCHEDULE_TABLE,"Active")) $this->addCol(SCHEDULE_TABLE,"Active","TINYINT(1) DEFAULT '1'");
		}
	}

	function updateNewsletter(){
		if(defined("NEWSLETTER_LOG_TABLE")){
				if(!$this->isColExist(NEWSLETTER_LOG_TABLE,"Param")) $this->addCol(NEWSLETTER_LOG_TABLE,"Param","VARCHAR(255) DEFAULT ''");
		}
		if(defined("NEWSLETTER_BLOCK_TABLE")){
				if(!$this->isColExist(NEWSLETTER_BLOCK_TABLE,"Pack")) $this->addCol(NEWSLETTER_BLOCK_TABLE,"Pack","TINYINT(1) DEFAULT '0'");
		}
	}

	function updateShop(){
		if(defined("SHOP_TABLE")){
			if($this->isColExist(SHOP_TABLE,"Price")) $this->changeColTyp(SHOP_TABLE,"Price","VARCHAR(20)");
		}
	}

	function doUpdate(){
		$this->updateTables();
		$this->updateShop();
		$this->updateNewsletter();


	}

}
?>