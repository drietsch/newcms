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

	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weRefTable.class.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weContentProvider.class.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLExImConf.inc.php');
	include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLExIm.class.php');

	class weXMLExport extends weXMLExIm{

		var $db;
		var $prepare = true;

		function weXMLExport() {
			$this->RefTable = new RefTable();
		}

		function setRefTable(&$rTable) {
			$this->RefTable = $rTable;
		}

		function export($id,$ct,$fname,$table="",$export_binary=true,$compression=""){
			@set_time_limit(0);
			$doc=weContentProvider::getInstance($ct,$id,$table);
			// add binary data separately to stay compatible with the new binary feature in v5.1
			if(isset($doc->ContentType) && (ereg("^image/",$doc->ContentType) || ereg("^application/",$doc->ContentType) || ereg("^video/",$doc->ContentType))) {
				$doc->setElement("data",weFile::load($_SERVER['DOCUMENT_ROOT'] . SITE_DIR . $doc->Path));
			}
			
			$fh=fopen($fname,"ab");
			if(!$fh){
			    return -1;
			}

			$params=array();
			if(isset($doc->ID)) $params["ID"]=$doc->ID;
			if(isset($doc->ContentType)) $params["ContentType"]=$doc->ContentType;
			else{
				if(isset($doc->Table) && $doc->Table==DOC_TYPES_TABLE) $params["ContentType"]="doctype";
			}

			$this->RefTable->setProp($params,"Eximed",1);

			if(isset($doc->Pseudo)) $classname=$doc->Pseudo;
			else $classname=$doc->ClassName;

			if($classname=="weBinary" && !is_numeric($id)){
					$doc->Path=$doc->ID;
					$doc->ID=0;
			}

			if($classname=="weTable"){
				if(defined("OBJECT_X_TABLE") && strtolower(substr($doc->table,0,10))==strtolower(substr(OBJECT_X_TABLE, strlen(TBL_PREFIX)))) $doc->getColumns();
			    if(defined("CUSTOMER_TABLE")) $doc->getColumns();
			}

			if(isset($doc->attribute_slots)){
                $attribute=$doc->attribute_slots;
            } else {
                $attribute=array();
            }

			if($classname=="weBinary"){
				weContentProvider::binary2file($doc,$fh);
			}
			else{
				weContentProvider::object2xml($doc,$fh,$attribute);
			}

			fwrite($fh,we_htmlElement::htmlComment("webackup")."\n");

			if($classname=="weTableItem" && $export_binary){
				if(strtolower($doc->table)==strtolower(FILE_TABLE)){
					if($doc->ContentType=="image/*" || eregi("application/",$doc->ContentType)){
						$bin=weContentProvider::getInstance("weBinary",$doc->ID);
						if(isset($bin->attribute_slots)) $attribute=$bin->attribute_slots;
						else $attribute=array();
						weContentProvider::binary2file($bin,$fh);
					}
				}
			}

			fclose($fh);
			unset($doc);
		}

		function getSelectedItems($selection,$extype,$art,$type,$doctype,$classname,$categories,$dir,&$selDocs,&$selTempl,&$selObjs,&$selClasses) {
				$this->db = new DB_WE();
				if ($selection=="manual"){
						if($extype=="wxml"){
							$selDocs = array_unique($this->getIDs($selDocs,FILE_TABLE,false));
							$selTempl = array_unique($this->getIDs($selTempl,TEMPLATES_TABLE,false));
							$selObjs = defined("OBJECT_FILES_TABLE") ? array_unique($this->getIDs($selObjs,OBJECT_FILES_TABLE,false)) : "";
							$selClasses = defined("OBJECT_FILES_TABLE") ? array_unique($this->getIDs($selClasses,OBJECT_TABLE,false)) : "";
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

					$ids=array();
					foreach($selDocs as $k=>$v){
						$ct=f("Select ContentType FROM ".FILE_TABLE." WHERE ID=".$v.";","ContentType",$this->db);
						$this->RefTable->add2(array(
								"ID"=>$v,
								"ContentType"=>$ct,
								"level"=>0
							)
						);


					}

					foreach($selTempl as $k=>$v){

						$this->RefTable->add2(array(
							"ID"=>$v,
							"ContentType"=>"text/weTmpl",
							"level"=>0
							)
						);
					}
					if(is_array($selObjs)){
						foreach($selObjs as $k=>$v){
							$this->RefTable->add2(array(
								"ID"=>$v,
								"ContentType"=>"objectFile",
								"level"=>0
								)
							);
						}
					}
					if(is_array($selClasses)){
						foreach($selClasses as $k=>$v){
							$this->RefTable->add2(array(
								"ID"=>$v,
								"ContentType"=>"object",
								"level"=>0
								)
							);
						}
					}

					//return $ids;


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

		function prepareExport(){
			//$this->RefTable = new RefTable();
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weExportPreparer.class.php');
			$_preparer = new weExportPreparer($this->options,$this->RefTable);
			$_preparer->prepareExport();
		}

		function getHeader($encoding=''){

			return $GLOBALS['weXmlExImHeader'];

			/*if($encoding==''){
				$encoding = $GLOBALS["_language"]["charset"];
			}
			return "<?xml version=\"1.0\" encoding=\"" . $encoding . "\" standalone=\"yes\"?>"."\n".
					 "<webEdition version=\"".WE_VERSION."\" xmlns:we=\"we-namespace\">"."\n";*/
		}

		function getFooter(){


			return $GLOBALS['weXmlExImFooter'];
		}


		function exportInfoMap($info){
			$out="<we:info>";
			foreach ($info as $inf) {
				$out.='<we:map';
				foreach($inf as $key=>$value) {
					$out.=' '.$key.'="'.$value.'"';
				}
				$out.="></we:map>";
			}
			$out.="</we:info>";
			$out.=we_htmlElement::htmlComment("webackup")."\n";
			return $out;
		}

		function loadPerserves(){
			parent::loadPerserves();
			if(isset($_SESSION['ExImPrepare'])) $this->prepare = $_SESSION['ExImPrepare'];
			if(isset($_SESSION['ExImOptions'])) $this->options = $_SESSION['ExImOptions'];
		}

		//---------------------
		function savePerserves(){
			parent::savePerserves();
			$_SESSION['ExImPrepare'] = $this->prepare;
			$_SESSION['ExImOptions'] = $this->options;
		}

		//---------------------
		function unsetPerserves(){
			parent::unsetPerserves();
			if(isset($_SESSION['ExImPrepare'])) unset($_SESSION['ExImPrepare']);
			if(isset($_SESSION['ExImOptions'])) unset($_SESSION['ExImOptions']);
		}


	}



?>