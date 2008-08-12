<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


/**
 * Class weDBUtil
 *
 * Implements db operations
 */

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

	class weDBUtil {

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
	
		function addTable($tab,$cols,$keys=array()){
			global $DB_WE;

			if(!is_array($cols)) return;
			if(!count($cols)) return;			   
			$cols_sql=array();
			foreach($cols as $name=>$type){			   		
				$cols_sql[]="`" . $name."` ".$type;
			}
			if(count($keys)) {
				foreach($keys as $key){			   		
			   		$cols_sql[]=$key;
			   	}
			}
				   	
			// Charset and Collation
			$charset_collation = "";
			if (defined("DB_CHARSET") && DB_CHARSET != "" && defined("DB_COLLATION") && DB_COLLATION != "") {
				$Charset = DB_CHARSET;
				$Collation = DB_COLLATION;
				$charset_collation = " CHARACTER SET " . $Charset . " COLLATE " . $Collation;
		
			}

			return $DB_WE->query("CREATE TABLE $tab (".implode(",",$cols_sql).")$charset_collation;") ? true : false;
			
			
		}
	
		function delTable($tab){
			   global $DB_WE;
				$DB_WE->query("DROP TABLE IF EXISTS $tab;");
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
	
	}
