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


	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weXMLBrowser.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weContentProvider.class.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weXMLComposer.class.php");

	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weRefTable.class.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weExportPreparer.class.php');


	class weXMLExIm{

		//var $perserves_file=array();

		var $destination=array();
		var $RefTable;
		var $chunk_count;
		var $chunk_number;

		var $analyzed = array();

		var $level=0;
		//var $recover_mode=0; // 0 -	save all to selected folder; 1 - save with given path

		var $options=array(
			"handle_paths"=>0,
			"handle_def_templates"=>0,
			"handle_doctypes"=>0,
			"handle_categorys"=>0,
			"handle_def_classes"=>0,
			"handle_binarys"=>0,
			"update_mode"=>0,
			"handle_document_includes"=>0,
			"handle_document_linked"=>0,
			"handle_object_includes"=>0,
			"handle_object_embeds"=>0,
			"handle_class_defs"=>0,
			"export_depth"=>1,

			"handle_documents"=>0,
			"handle_templates"=>0,
			"handle_classes"=>0,
			"handle_objects"=>0,

			"handle_content"=>0,
			"handle_table"=>0,
			"handle_tableitems"=>0,
			"handle_binarys"=>0,

			"handle_doc_paths"=>0,
			"handle_templ_paths"=>0,
			"document_path"=>"",
			"template_path"=>"",
			"handle_collision"=>"",
			"restore_doc_path"=>1,
			"restore_tpl_path"=>1,

			"handle_owners"=>0,
			"owners_overwrite"=>0,
			"owners_overwrite_id"=>0,
			"handle_navigation"=>0,
			"navigation_path"=>0,
			"handle_thumbnails"=>0,
			"rebuild"=>1
		);

		var $xmlBrowser;

		function weXMLExIm($file=""){

			$this->RefTable=new RefTable();
			if($file!=""){
				$this->loadPerserves($file);
			}

			$this->destination[strtolower(FILE_TABLE)]=0;
			$this->destination[strtolower(TEMPLATES_TABLE)]=0;
			$this->destination[strtolower(DOC_TYPES_TABLE)]=0;
			if(defined("OBJECT_TABLE")) $this->destination[strtolower(OBJECT_TABLE)]=0;
			if(defined("OBJECT_FILES_TABLE")) $this->destination[strtolower(OBJECT_FILES_TABLE)]=0;

		}

		function setOptions($options){
			foreach($options as $k=>$v){
				if(isset($this->options[$k])) $this->options[$k]=$v;
			}
		}

		function setBackupProfle(){
			$options=array();
			$options["handle_content"]=1;
			$options["handle_table"]=1;
			$options["handle_tableitems"]=1;
			$options["handle_binarys"]=1;

			$this->setOptions($options);
		}

		function getTable($ClassName){
			if($ClassName=="we_template") return TEMPLATES_TABLE;
			if($ClassName=="we_docTypes") return DOC_TYPES_TABLE;
			if($ClassName=="we_category") return CATEGORY_TABLE;
			if($ClassName=="weNavigation") return NAVIGATION_TABLE;
			if($ClassName=="weNavigationRule") return NAVIGATION_RULE_TABLE;
			if($ClassName=="we_thumbnail") return THUMBNAILS_TABLE;
			if($ClassName=="weBinary") return '';

			if(defined("OBJECT_TABLE")){
				if($ClassName=="we_object") return OBJECT_TABLE;
				if($ClassName=="we_objectFile") return OBJECT_FILES_TABLE;
			}

			return FILE_TABLE;
		}


		function getTableForCT($we_ContentType,$table=""){
			switch($we_ContentType){
				case "doctype": return DOC_TYPES_TABLE;
				case "category": return CATEGORY_TABLE;
				case "object": if(defined("OBJECT_TABLE")) return OBJECT_TABLE; else return null;
				case "text/weTmpl": return TEMPLATES_TABLE;
				case "objectFile": if(defined("OBJECT_FILES_TABLE")) return OBJECT_FILES_TABLE;  else return null;
				case "weBinary": return null;
				case "weNavigation": return NAVIGATION_TABLE;
				case "weNavigationRule": return NAVIGATION_RULE_TABLE;
				case "weThumbnail": return THUMBNAILS_TABLE;
				case "folder": 
					if(!empty($table)) {
						return $table;
					}
					return FILE_TABLE;
				default: return FILE_TABLE;
			 }
		}


		//---------------------
		function loadPerserves(){
			if(isset($_SESSION["ExImRefTable"])) $this->RefTable->Array2RefTable($_SESSION["ExImRefTable"]);
			if(isset($_SESSION["ExImRefUsers"])) $this->RefTable->Users = $_SESSION["ExImRefUsers"];
			if(isset($_SESSION["ExImCurrentRef"])) $this->RefTable->current = $_SESSION["ExImCurrentRef"];

		}

		//---------------------
		function savePerserves(){
			$_SESSION["ExImRefTable"]=$this->RefTable->RefTable2Array();
			$_SESSION["ExImRefUsers"]=$this->RefTable->Users;
			$_SESSION["ExImCurrentRef"]=$this->RefTable->current;
		}

		//---------------------
		function unsetPerserves(){
			if(isset($_SESSION["ExImRefTable"])) unset($_SESSION["ExImRefTable"]);
			if(isset($_SESSION["ExImRefUsers"])) unset($_SESSION["ExImRefUsers"]);
			if(isset($_SESSION["ExImCurrentRef"])) unset($_SESSION["ExImCurrentRef"]);
		}


		//---------------------
		function resetContenID(&$object){
			if(isset($object->elements) && is_array($object->elements))
				foreach($object->elements  as $ek=>$ev) $object->elements[$ek]["id"]=0;
		}

		//---------------------


		function prepareExport($ids){

			$this->RefTable = new RefTable();
			$_preparer = new weExportPreparer($this->options,$this->RefTable);
			$_preparer->prepareExport($ids);
		}


		function handleTag($tag){
				switch($tag){
					case "we:document": return $this->options["handle_documents"];
					case "we:template": return $this->options["handle_templates"];
					case "we:class": return $this->options["handle_classes"];
					case "we:object": return $this->options["handle_objects"];
					case "we:doctype": return $this->options["handle_doctypes"];
					case "we:category": return $this->options["handle_categorys"];
					case "we:content": return $this->options["handle_content"];
					case "we:table": return $this->options["handle_table"];
					case "we:tableitem": return $this->options["handle_tableitems"];
					case "we:binary": return $this->options["handle_binarys"];
					case "we:navigation": return $this->options["handle_navigation"];
					case "we:navigationrule": return $this->options["handle_navigation"];
					case "we:thumbnail": return $this->options["handle_thumbnails"];
					default: return 1;
				}
		}

		function getHeader($encoding=''){
			if($encoding==''){
				$encoding = $GLOBALS["_language"]["charset"];
			}
			return "<?xml version=\"1.0\" encoding=\"" . $encoding . "\" standalone=\"yes\"?>"."\n".
					 "<webEdition version=\"".WE_VERSION."\" xmlns:we=\"we-namespace\">"."\n";
		}

		function getFooter(){
			return "</webEdition>";
		}


		function isCompressed($file){
			$part=weFile::loadPart($file,0,512);
			if(eregi("<?xml version=",$part)) return false;
			else return true;
		}

	 	function getIDs($selIDs,$table,$with_dirs=false){
			$ret=array();
			$tmp=array();
			$db = new DB_WE();
			$allow = $this->queryForAllowed($table);
			foreach($selIDs as $v){
				if ($v){
					$isfolder=f("SELECT IsFolder FROM ".$table." WHERE ID='".$v."'","IsFolder",$db);
					if ($isfolder){
						we_readChilds($v,$tmp,$table,false,$allow);
						if($with_dirs) $tmp[]=$v;
					}
					else $tmp[]=$v;
				}
			}
			if($with_dirs) return $tmp;
			foreach($tmp as $v){
				$isfolder=f("SELECT IsFolder FROM ".$table." WHERE ID='".$v."'","IsFolder",new DB_WE());
				if (!$isfolder) $ret[]=$v;
			}
			return $ret;
	 	}

		function getQueryParents($path){

			$out = "";
			while($path != "/" && $path){
				$out .= "Path='$path' OR ";
				$path = dirname($path);
			}
			if($out){
				return substr($out,0,strlen($out)-3);
			}else{
				return "";
			}
		}

	 	function queryForAllowed($table){
	 		$db = new DB_WE();
	 		$parentpaths = array();
	 		$wsQuery = '';
			if($ws = get_ws($table)) {
				$wsPathArray = id_to_path($ws,$table,$db,false,true);
				foreach($wsPathArray as $path){
					if($wsQuery!='') $wsQuery .=' OR ';
					$wsQuery .= " Path like '$path/%' OR ".weXMLExIm::getQueryParents($path);
					while($path != "/" && $path){
						array_push($parentpaths,$path);
						$path = dirname($path);
					}
				}
			}else if(defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE && (!$_SESSION["perms"]["ADMINISTRATOR"])){
				$ac = getAllowedClasses($db);
				foreach($ac as $cid){
					$path = id_to_path($cid,OBJECT_TABLE);
					if($wsQuery!='') $wsQuery .=' OR ';
					$wsQuery .= " Path like '$path/%' OR Path='$path'";
				}
			}

			return makeOwnersSql() . ( $wsQuery ? 'AND (' . $wsQuery . ')' : '');

	 	}


		function getSelectedItems($selection,$extype,$art,$type,$doctype,$classname,$categories,$dir,&$selDocs,&$selTempl,&$selObjs,&$selClasses) {
				$this->db = new DB_WE();
				if ($selection=="manual"){
						if($extype=="wxml"){
							$selDocs = $this->getIDs($selDocs,FILE_TABLE,false);
							$selTempl = $this->getIDs($selTempl,TEMPLATES_TABLE,false);
							$selObjs = defined("OBJECT_FILES_TABLE") ? $this->getIDs($selObjs,OBJECT_FILES_TABLE,false) : "";
							$selClasses = defined("OBJECT_FILES_TABLE") ? $this->getIDs($selClasses,OBJECT_TABLE,false) : "";
						}
						else{
							if($art=="docs") $selDocs = $this->getIDs($selDocs,FILE_TABLE);
							else if($art=="objects") $selObjs = defined("OBJECT_FILES_TABLE") ? $this->getIDs($selObjs,OBJECT_FILES_TABLE) : "";
						}

					}
					else{
						if ($type=="doctype"){
							$catss="";
							if ($categories){
								$catids=makeCSVFromArray(makeArrayFromCSV($categories));
								$this->db->query("SELECT Path FROM ".CATEGORY_TABLE." WHERE ID IN (".$catids.");");
								while($this->db->next_record()){
									$cats[]=$this->db->f("Path");
								}
								$catss=makeCSVFromArray($cats);
							}

							$cat_sql = getCatSQLTail($catss, FILE_TABLE, true,$this->db);
							$ws_where = "";
							if($dir != 0){
								$workspace=id_to_path($dir, FILE_TABLE, $this->db);
								$ws_where = " AND (" . FILE_TABLE . ".Path like '$workspace/%' OR " . FILE_TABLE . ".Path='$workspace') ";
							}

							$query = 'SELECT distinct ID FROM ' . FILE_TABLE . ' WHERE 1 ' . $ws_where . '  AND tblFile.IsFolder=0 AND tblFile.DocType="'.$doctype.'"'.$cat_sql;

							$this->db->query($query);
							while($this->db->next_record()){
								$selDocs[]=$this->db->f("ID");
							}
						}
						else {
							if (defined("OBJECT_FILES_TABLE")) {
								include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_listview_object.class.php");

								$catss = "";

								if ($categories) {
									$catss=$categories;
								}

								$where = $this->queryForAllowed(OBJECT_FILES_TABLE);

								$q = "SELECT ID FROM ".OBJECT_FILES_TABLE." WHERE IsFolder=0 AND TableID='".$classname."'".($catss!="" ? " AND Category IN (".$catss.");" : '') . $where .';';
								$this->db->query($q);
								$selObjs = array();
								while($this->db->next_record()){
									$selObjs[]=$this->db->f("ID");
								}
							}
						}
					}
		}

		function importInfoMap($nodeset) {

		}

		function isBinary() {
			
		}
		

		function saveObject(&$object){
			if(is_object($object)){
				// save binary data first to stay compatible with the new binary feature in v5.1
				if(in_array("savebinarydata",get_class_methods(get_class($object)))) {
					$object->savebinarydata();
				}
				 
				if($object->ClassName=='we_docTypes') {
					$object->we_save_exim();					
				} else {
					$GLOBALS["we_doc"]=$object;
					if(in_array("we_save",get_class_methods(get_class($object)))){
						$object->we_save();
					}
					
					if(in_array("we_publish",get_class_methods(get_class($object)))){
						$object->we_publish();
					}
					
					if(in_array("savebinarydata",get_class_methods(get_class($object)))) {
						$object->setElement("data", "");
					}
				 
					
					
				}
			}
		}

	}

?>