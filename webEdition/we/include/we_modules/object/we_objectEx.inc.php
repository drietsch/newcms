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

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/"."we_object.inc.php");

	class we_objectEx extends we_object{

		function we_objectEx() {
			$this->we_object();
		}

		function saveToDB(){

			$this->wasUpdate = $this->ID ? true : false;

			$this->i_savePersistentSlotsToDB();
			$ctable = OBJECT_X_TABLE.($this->ID);

			if(!$this->wasUpdate){
				$q = " ID BIGINT NOT NULL AUTO_INCREMENT, ";
				$q .= " OF_ID BIGINT NOT NULL, ";
				$q .= " OF_ParentID BIGINT NOT NULL, ";
				$q .= " OF_Text VARCHAR(255) NOT NULL, ";
				$q .= " OF_Path VARCHAR(255) NOT NULL, ";
				$q .= " OF_Workspaces VARCHAR(255) NOT NULL, ";
				$q .= " OF_ExtraWorkspaces VARCHAR(255) NOT NULL, ";
				$q .= " OF_ExtraWorkspacesSelected VARCHAR(255) NOT NULL, ";
				$q .= " OF_Templates VARCHAR(255) NOT NULL, ";
				$q .= " OF_ExtraTemplates VARCHAR(255) NOT NULL, ";
				$q .= " OF_Category VARCHAR(255) NOT NULL,";
				$q .= " OF_Published int(11) NOT NULL,";
				$q .= " OF_IsSearchable tinyint(1) NOT NULL default '1',";
				$q .= " OF_Charset VARCHAR(64) NOT NULL, ";
				$q .= " OF_WebUserID BIGINT NOT NULL, ";

				$indexe = "";
				$indexe .= ', KEY OF_WebUserID (OF_WebUserID)';

				$this->SerializedArray = unserialize($this->DefaultValues);

				$qarr = array();
				$noFields = array('WorkspaceFlag','elements','WE_CSS_FOR_CLASS');
				foreach ($this->SerializedArray as $key=>$value) {
					if(!in_array($key,$noFields)){
						$arr = explode('_',$key);
						$len = isset($value['length']) ? $value['length'] : $this->getElement($key."length","dat");
						$type = $this->switchtypes2($arr[0],$len);
						if(!empty($type)){
							$qarr[] = $key . $type;
						}
					}
				}

				$q .= implode(',',$qarr);

				// Charset and Collation
				$charset_collation = "";
				if (defined("DB_CHARSET") && DB_CHARSET != "" && defined("DB_COLLATION") && DB_COLLATION != "") {
					$Charset = DB_CHARSET;
					$Collation = DB_COLLATION;
					$charset_collation = " CHARACTER SET " . $Charset . " COLLATE " . $Collation;

				}

				$this->DB_WE->query("DROP TABLE IF EXISTS $ctable");
				$this->DB_WE->query("CREATE TABLE $ctable ($q, UNIQUE (ID)$indexe)$charset_collation");

				//dummy eintrag schreiben
				$this->DB_WE->query("INSERT INTO $ctable (OF_ID) VALUES (0)");


				// folder in object schreiben
				if(!($this->OldPath && ($this->OldPath != $this->Path))){
					$fold = new we_class_folder();
					$fold -> initByPath($this->getPath(),OBJECT_FILES_TABLE,1,0);
				}

				////// resave the line O to O.....
		    	$this->DB_WE->query("DELETE FROM $ctable where OF_ID=0 OR ID=0");
		    	$this->DB_WE->query("INSERT INTO $ctable (OF_ID) VALUES(0)");
				////// resave the line O to O.....
			}else {
				$this->SerializedArray = unserialize($this->DefaultValues);

				$noFields = array('WorkspaceFlag','elements','WE_CSS_FOR_CLASS');
				$tableInfo = $this->DB_WE->metadata($ctable,true);
				$size = count($tableInfo);

				$add = array();
				$drop = array();
				$alter = array();

				foreach($this->SerializedArray as $fieldname=>$value){

					$arr = explode('_',$fieldname);
					if(!isset($arr[0])) continue;

					$fieldtype = $this->getFieldType($arr[0]);
					if(isset($value['length'])) $len = ($fieldtype == 'string') ? ($value['length']>255 ? 255 : $value['length']) : $value['length'];
					else $len=0;
					$type = $this->switchtypes2($arr[0],$len);

					if(isset($tableInfo['meta'][$fieldname])){
						$props = $tableInfo[$tableInfo['meta'][$fieldname]];
						// the field exists
						if(!empty($fieldtype) && (strtolower($fieldtype) == strtolower($props['type']))){
							if($len!=$props['len']){
								$alter[$fieldname] = $fieldname . $type;
							}
						}
					} else {
						if(!empty($type)){
							$add[$fieldname] = $fieldname . $type;
						}
					}

				}
				
				if (isset($tableInfo['meta'])) {

					foreach($tableInfo['meta'] as $key=>$value) {
						if(!isset($this->SerializedArray[$key]) && substr($key,0,3)!='OF_' && $key!='ID') {
							$drop[$key] = $key;
						}
					}
				}

				foreach($drop as $key=>$value) {
					$this->DB_WE->query("ALTER TABLE $ctable DROP $value;");
				}

				foreach($alter as $key=>$value) {
					$this->DB_WE->query("ALTER TABLE $ctable CHANGE $key $value;");
				}

				foreach($add as $key=>$value) {
					$this->DB_WE->query("ALTER TABLE $ctable ADD $value;");
				}

			}

			unset($this->elements);
			$this->i_getContentData();

		}


		function getFieldType($type) {
	    	$q = "";
			switch($type){
				case "meta":
				case "input":
				case "link":
				case "href":
					$q = "string";
				break;
				case "float":
					$q = "real";
				break;
				case "img":
				case "binary":
				case "object":
				case "date":
				case "int":
					$q = "int";
				break;
				case "text":
					$q = "blob";
				break;
			}
			return $q;

		}

		function switchtypes2($type,$len){

		    $q = "";
			switch($type){
				case "meta":
					$q .= " VARCHAR(".(($len>0 && ($len < 256))?$len:"255").") NOT NULL ";
				break;
				case "date":
					$q .= " INT(11) NOT NULL ";
				break;
				case "input":
					$q .= " VARCHAR(".(($len>0 && ($len < 256))?$len:"255").") NOT NULL ";
				break;
				case "link":
				case "href":
					$q .= " TEXT NOT NULL ";
				break;
				case "text":
					$q .= " LONGTEXT NOT NULL ";
				break;
				case "img":
				case "binary":
					$q .= " BIGINT(22) DEFAULT '0' NOT NULL ";
				break;
				case "int":
					$q .= " INT(".(($len>0  && ($len < 256))?$len:"11").") DEFAULT NULL ";
				break;
				case "float":
					$q .= " DOUBLE DEFAULT NULL ";
				break;
				case "object":
					$q .= " BIGINT(22) DEFAULT '0' NOT NULL ";
				break;
				case "multiobject":
					$q .= " TEXT NOT NULL ";
				break;
				case 'shopVat':
					$q .= ' TEXT NOT NULL';
				break;
			}
			return $q;
		}


	}
?>