<?php

class we_version {


	function todo($data, $printIt=true) {
		
		$db = new DB_WE();

		if ($printIt) {
			$_newLine = count($_SERVER['argv']) ? "\n" : "<br>\n";
		}

//		if($data["type"] == "version_delete"){
//			
//			weVersions::deleteVersion($data["ID"]);
//			$_SESSION['versions']['logDeleteIds'][$data["ID"]]['Version'] = $data["version"];
//			$_SESSION['versions']['logDeleteIds'][$data["ID"]]['Text'] = $data["text"];	
//			$_SESSION['versions']['logDeleteIds'][$data["ID"]]['ContentType'] = $data["contenttype"];
//			$_SESSION['versions']['logDeleteIds'][$data["ID"]]['Path'] = $data["path"];
//			$_SESSION['versions']['logDeleteIds'][$data["ID"]]['documentID'] = $data["documentID"];	
//
//		}
//		
//		else{
			
			switch($data["type"]){
				case "version_reset":
					$publish = isset($_REQUEST['reset_doPublish']) && $_REQUEST['reset_doPublish'] ? 1 : 0;
					weVersions::resetVersion($data["ID"], $data["version"], $publish);	
					
					$_SESSION['versions']['logResetIds'][$data["ID"]]['Text'] = $data["text"];	
					$_SESSION['versions']['logResetIds'][$data["ID"]]['ContentType'] = $data["contenttype"];
					$_SESSION['versions']['logResetIds'][$data["ID"]]['Path'] = $data["path"];
					$_SESSION['versions']['logResetIds'][$data["ID"]]['Version'] = $data["version"];	
					$_SESSION['versions']['logResetIds'][$data["ID"]]['documentID'] = $data["documentID"];				
					
				break;
				
				default: return false;

			}

		//}
	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding documents
	*
	* @return array
	* @param string $btype "rebuild_all" or "rebuild_filter"
	* @param string $categories csv value of category IDs
	* @param boolean $catAnd true if AND should be used for more than one categories (default=OR)
	* @param string $doctypes csv value of doctypeIDs
	* @param string $folders csv value of directory IDs
	* @param boolean $maintable if the main table should be rebuilded
	* @param boolean $tmptable if the tmp table should be rebuilded
	* @param int $templateID ID of a template (All documents of this template should be rebuilded)
	*/
	function getDocuments($type='delete_versions',$version){
		switch($type){
			case "delete_versions":
				return we_version::getDocumentsDelete($version);
				break;
			case "reset_versions":
				return we_version::getDocumentsReset($version);
				break;

		}
	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding all documents and templates (Called from getDocuments())
	*
	* @return array
	* @param boolean $maintable if the main table should be rebuilded
	* @param boolean $tmptable if the tmp table should be rebuilded
	*/
	function getDocumentsDelete($version){
		$data = array();
		if(we_hasPerm("ADMINISTRATOR")){
			
			$GLOBALS["DB_WE"]->query($_SESSION['versions']['query']);
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"ID"=>$GLOBALS["DB_WE"]->f("ID"),
										"documentID"=>$GLOBALS["DB_WE"]->f("documentID"),
										"type"=>"version_delete",
										"version"=>$GLOBALS["DB_WE"]->f("version"),
										"timestamp"=>$GLOBALS["DB_WE"]->f("timestamp"),
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"table"=>$GLOBALS["DB_WE"]->f("documentTable"),
										"contenttype"=>$GLOBALS["DB_WE"]->f("ContentType"),
										"text"=>$GLOBALS["DB_WE"]->f("Text")
										));
			}
			unset($_SESSION['versions']['query']);

		}
		return $data;
	}
	function getDocumentsReset($version){
		$data = array();
		if(we_hasPerm("ADMINISTRATOR")){
			
			$GLOBALS["DB_WE"]->query($_SESSION['versions']['query']);
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"ID"=>$GLOBALS["DB_WE"]->f("ID"),
										"documentID"=>$GLOBALS["DB_WE"]->f("documentID"),
										"type"=>"version_reset",
										"version"=>$GLOBALS["DB_WE"]->f("version"),
										"timestamp"=>$GLOBALS["DB_WE"]->f("timestamp"),
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"table"=>$GLOBALS["DB_WE"]->f("documentTable"),
										"contenttype"=>$GLOBALS["DB_WE"]->f("ContentType"),
										"text"=>$GLOBALS["DB_WE"]->f("Text")
										));
			}
			unset($_SESSION['versions']['query']);

		}
		return $data;
	}


	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding metadata
	*
	* @return array
	* @param array $metaFields array which meta fields should be rebuilt
	* @param boolean $onlyEmpty if this is true, only empty fields will be imported
	* @param array $metaFolders array with folder Ids
	*/
	function getMetadata($metaFields, $onlyEmpty, $metaFolders) {

		if (!is_array($metaFolders)) {
			$metaFolders = makeArrayFromCSV($metaFolders);
		}
		$data = array();
		if(we_hasPerm("REBUILD_META")){
			$foldersQuery = count($metaFolders) ? ' AND ParentId IN('.implode(",", $metaFolders) .') ' : '';
			$GLOBALS["DB_WE"]->query("SELECT ID,path FROM ". FILE_TABLE . " WHERE ContentType='image/*' AND (Extension='.jpg' OR Extension='jpeg' OR Extension='wbmp') $foldersQuery");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push(
					$data,
					array(
						"id"=>$GLOBALS["DB_WE"]->f("ID"),
						"type"=>"metadata",
						"onlyEmpty"=>$onlyEmpty,
						"path"=>$GLOBALS["DB_WE"]->f("path"),
						"metaFields"=>$metaFields
					)
				);
			}
		}
		return $data;
	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding all documents and templates (Called from getDocuments())
	*
	* @return array
	*/
	function getTemplates(){
		$data = array();
		if(we_hasPerm("REBUILD_TEMPLATES")){
			$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path FROM ". TEMPLATES_TABLE . " ORDER BY ID");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
										"type"=>"template",
										"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>0));
			}
		}
		return $data;
	}
	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding filtered documents (Called from getDocuments())
	*
	* @return array
	* @param string $categories csv value of category IDs
	* @param boolean $catAnd true if AND should be used for more than one categories (default=OR)
	* @param string $doctypes csv value of doctypeIDs
	* @param string $folders csv value of directory IDs
	* @param int $templateID ID of a template (All documents of this template should be rebuilded)
	*/
	function getFilteredDocuments($categories,$catAnd,$doctypes,$folders,$templateID){
		$data = array();
		if(we_hasPerm("REBUILD_FILTERD")){
			$_cat_query = "";
			$_doctype_query = "";
			$_folders_query = "";
			$_template_query = "";

			if($categories){
				$bool = $catAnd ? "AND" : "OR";
				$_foo = makeArrayFromCSV($categories);
				foreach($_foo as $catID){
					$_cat_query .= " Category like '%,$catID,%' $bool ";
				}
				$_cat_query = ereg_replace('^(.+)'.$bool.' $','\1',$_cat_query);
				$_cat_query = "(".$_cat_query.")";
			}
			if($doctypes){
				$_foo = makeArrayFromCSV($doctypes);
				foreach($_foo as $doctypeID){
					$_doctype_query .= " Doctype = '$doctypeID' OR ";
				}
				$_doctype_query = ereg_replace('^(.+)OR $','\1',$_doctype_query);
				$_doctype_query = "(".$_doctype_query.")";
			}
			if($folders){
				$_foo = makeArrayFromCSV($folders);
				$_foldersList = "";
				foreach($_foo as $folderID){
					$_foldersList .= makeCSVFromArray(we_version::getFoldersInFolder($folderID)) . ",";
				}
				$_foldersList = ereg_replace('^(.+),$','\1',$_foldersList);
				$_folders_query = "( ParentID IN($_foldersList) )";
			}

			if($templateID){

				$arr = getTemplAndDocIDsOfTemplate($templateID);

				if(count($arr["templateIDs"])) {
					$where = "";
					foreach ($arr["templateIDs"] as $tid) {
						$where .= " ID=".abs($tid)." OR ";
					}
					$where = substr($where, 0, strlen($where) - 3);
					$where = '(' . $where . ')';

					$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path FROM ". TEMPLATES_TABLE . " WHERE $where ORDER BY ID");
					while($GLOBALS["DB_WE"]->next_record()){
						array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
												"type"=>"template",
												"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
												"mt"=>0,
												"tt"=>0,
												"path"=>$GLOBALS["DB_WE"]->f("Path"),
												"it"=>0));
					}

					$_template_query = " TemplateID='".$templateID."' OR ";
					foreach ($arr["templateIDs"] as $tid) {
						$_template_query .= " TemplateID='".$tid."' OR ";
					}
					// remove last OR
					$_template_query = substr($_template_query, 0, strlen($_template_query) - 3);
					$_template_query = '(' . $_template_query . ')';

				} else {
					$_template_query = "( TemplateID='$templateID' )";
				}

			}

			$query = ($_cat_query ? " AND $_cat_query " : "")  .
						($_doctype_query ? " AND $_doctype_query " : "") .
						($_folders_query ? " AND $_folders_query " : "") .
						($_template_query ? " AND $_template_query " : "");

			$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path FROM ". FILE_TABLE . " WHERE IsDynamic=0 AND Published > 0 AND ContentType='text/webedition' $query ORDER BY ID");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
										"type"=>"document",
										"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>0));
			}
		}
		return $data;

	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding the OBJECTFILES_TABLE
	*
	* @return array
	*/
	function getObjects(){
		$data = array();
		if(we_hasPerm("REBUILD_OBJECTS")){
			$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path FROM ". OBJECT_FILES_TABLE . " WHERE Published > 0 ORDER BY ID");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
										"type"=>"object",
										"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>0));
			}
		}
		return $data;
	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding the INDEX_TABLE
	*
	* @return array
	*/
	function getNavigation(){
		$data = array();
		if(we_hasPerm("REBUILD_NAVIGATION")){
			$GLOBALS["DB_WE"]->query("SELECT ID,Path FROM ". NAVIGATION_TABLE . " WHERE IsFolder=0 ORDER BY ID");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
										"type"=>"navigation",
										"cn"=>"weNavigation",
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>0));
			}
			array_push($data,array(	"id"=>0,
										"type"=>"navigation",
										"cn"=>"weNavigation",
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>0)
			);
		}

		if (isset($_REQUEST['rebuildStaticAfterNavi']) && $_REQUEST['rebuildStaticAfterNavi']==1) {
			$data2 = we_version::getFilteredDocuments('','','','','');
			$data = array_merge($data, $data2);
		}

		return $data;
	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding the INDEX_TABLE
	*
	* @return array
	*/
	function getIndex(){
		$data = array();
		if(we_hasPerm("REBUILD_INDEX")){
			$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path FROM ". FILE_TABLE . " WHERE Published > 0 AND IsSearchable='1' ORDER BY ID");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
										"type"=>"document",
										"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>1));
			}
			if(defined("OBJECT_FILES_TABLE")){
				$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path FROM ". OBJECT_FILES_TABLE . " WHERE Published > 0 ORDER BY ID");
				while($GLOBALS["DB_WE"]->next_record()){
					array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
											"type"=>"object",
											"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
											"mt"=>0,
											"tt"=>0,
											"path"=>$GLOBALS["DB_WE"]->f("Path"),
											"it"=>1));
				}
			}
			$GLOBALS["DB_WE"]->query("DELETE FROM ".INDEX_TABLE);
		}
		return $data;
	}

	/**
	* Create and returns data Array with IDs and other information for the fragmment class for rebuilding thumbnails
	*
	* @return array
	* @param string $thumbs csv value of IDs which thumbs to create
	* @param string $thumbsFolders csv value of directory IDs => Create Thumbs for images in these directories.
	*/
	function getThumbnails($thumbs="",$thumbsFolders=""){
		$data = array();
		if(we_hasPerm("REBUILD_THUMBS")){
			$_folders_query = "";
			if($thumbsFolders){
				$_foo = makeArrayFromCSV($thumbsFolders);
				$_foldersList = "";
				foreach($_foo as $folderID){
					$_foldersList .= makeCSVFromArray(we_version::getFoldersInFolder($folderID)) . ",";
				}
				$_foldersList = ereg_replace('^(.+),$','\1',$_foldersList);
				$_folders_query = "( ParentID IN($_foldersList) )";
			}
			$GLOBALS["DB_WE"]->query("SELECT ID,ClassName,Path,Extension FROM ". FILE_TABLE . " WHERE ContentType='image/*'".($_folders_query ? " AND $_folders_query " : "")." ORDER BY ID");
			while($GLOBALS["DB_WE"]->next_record()){
				array_push($data,array(	"id"=>$GLOBALS["DB_WE"]->f("ID"),
										"type"=>"thumbnail",
										"cn"=>$GLOBALS["DB_WE"]->f("ClassName"),
										"thumbs"=>$thumbs,
										"extension"=>$GLOBALS["DB_WE"]->f("Extension"),
										"mt"=>0,
										"tt"=>0,
										"path"=>$GLOBALS["DB_WE"]->f("Path"),
										"it"=>0));
			}
		}
		return $data;
	}

	/**
	* returns array of directory IDs of all directories which are located inside $folderID (recursive)
	*
	* @return array
	* @param int $folderID
	*/
	function getFoldersInFolder($folderID){
		$outArray = array($folderID);
		$db = new DB_WE();
		$db->query("SELECT ID FROM ".FILE_TABLE." WHERE ParentID='".$folderID."' AND IsFolder='1'");
		while($db->next_record()){
			$tmpArray = we_version::getFoldersInFolder($db->f("ID"));
			foreach($tmpArray as $foo){
				array_push($outArray,$foo);
			}
		}
		return $outArray;
	}

}

?>