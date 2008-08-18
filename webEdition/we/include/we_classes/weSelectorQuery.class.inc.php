<?php
// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+

/**
 * @name we_selectorQuery
 */
class weSelectorQuery {
	
	/*************************************************************************
	 * VARIABLES
	 *************************************************************************/
	var $db = "";
	var $result = array();
	var $fields;
	var $condition = array();
	
	/*************************************************************************
	 * CONSTRUCTOR
	 *************************************************************************/

	/**
	 * Constructor of class
	 * 
	 * @return weSelectorQuery
	 */
	function weSelectorQuery() {
		$this->db = new DB_WE();
		$this->fields = array('ID', 'Path');		
	}
	
	
	/*************************************************************************
	 * FUNCTIONS
	 *************************************************************************/
	
	/**
	 * query
	 * Die Funktion 'query' führt die Abfrage für den übergebenen Selektor-Typ durch.
	 * Mit dem Parameter 'limit' kann man die Anzahl der Suchergebnisse begrenzen.
	 * 
	 * @param search
	 * @param table
	 * @param types
	 * @param limit
	 * 
	 * @return void
	 */
	function queryTable($search, $table, $types=null, $limit=null) {
		$search = strtr($search, array("["=>"\\\[","]"=>"\\\]"));
		$_nlTable = defined('NEWSLETTER_TABLE') ? NEWSLETTER_TABLE : "";
		switch ($table) {
			case USER_TABLE:
				$this->addQueryField("IsFolder");
				$typeField = "Type";
				break;
			case CATEGORY_TABLE:
			case $_nlTable:
				break;
			default:
				$typeField = "ContentType";
		}

		$userExtraSQL = $this->getUserExtraQuery($table);	
		$where = "WHERE Path = '".$search."'";
		$isFolder = 1;
		$addCT = 0;

		if (isset($types) && is_array($types)) {
			for ($i=0; $i<count($types); $i++) {
				if ($types[$i]!="") {	
					$types[$i] = str_replace(" ","",$types[$i]);										
					if ($types[$i]=="folder") {
						$where .= empty($where) ? "WHERE (IsFolder=1" : ($i<1 ? " AND (" : " OR ") . "IsFolder=1";
					} elseif(isset($typeField) && $typeField != "") {
						$where .= empty($where) ? "WHERE ($typeField='".$types[$i]."'" : ($i<1 ? " AND (" : " OR ") . "$typeField='".$types[$i]."'";
						$isFolder = 0;
						$addCT = 1;
					}
					$where .= $i==(count($types)-1) ? ")" : "";
				}
			}
		}
		if ($addCT) {
			$this->addQueryField($typeField);
		}
		if (!empty($userExtraSQL)) {
			$where .= (empty($where) ? "WHERE " : " ") . $userExtraSQL;
		}

		if (count($this->condition)>0) {
			foreach ($this->condition as $val){
				$where .= (empty($where) ? "WHERE " : " " . $val['queryOperator']) . " " .$val['field'] . $val['conditionOperator'] . "'" . $val['value'] . "'";
			}
		}

		$order = "ORDER BY " . ($isFolder ? "Path" : "isFolder  ASC, Path") . " ASC ";
		$fields = implode(", ", $this->fields);
		$query = "SELECT $fields FROM $table $where $order" . ($limit ? " LIMIT $limit" : "");
		$this->db->query($query);
	}
	
	/**
	 * search
	 * Die Funktion 'search' führt die Suche nach den Anfangszeichen für den übergebenen Selektor-Typ durch.
	 * Mit dem Parameter 'limit' kann man die Anzahl der Suchergebnisse begrenzen.
	 * 
	 * @param search
	 * @param table
	 * @param types
	 * @param limit
	 * 
	 * @return void
	 */
	function search($search, $table, $types=null, $limit=null, $rootDir="") {
		$search = strtr($search, array("["=>"\\\[","]"=>"\\\]"));
		$_nlTable = defined('NEWSLETTER_TABLE') ? NEWSLETTER_TABLE : "";
		switch ($table) {
			case USER_TABLE:
				$this->addQueryField("IsFolder");
				$typeField = "Type";
				break;
			case CATEGORY_TABLE:
			case $_nlTable:
				break;
			default:
				$typeField = "ContentType";
		}

		$userExtraSQL = $this->getUserExtraQuery($table);	
		$where = "WHERE Path REGEXP '^".preg_quote(preg_quote($search))."[^/]*$'" . (isset($rootDir) && !empty($rootDir) ? " AND  (Path LIKE '".$rootDir."' OR Path LIKE '".$rootDir."%')" : "") ;
		$isFolder = 1;
		$addCT = 0;
		
		if (isset($types) && is_array($types)) {
			$types = array_unique($types);
			for ($i=0; $i<count($types); $i++) {
				if ($types[$i]!="") {		
					$types[$i] = str_replace(" ","",$types[$i]);								
					if ($types[$i]=="folder") {
						$where .= empty($where) ? "WHERE (IsFolder=1" : ($i<1 ? " AND (" : " OR ") . "IsFolder=1";
					} elseif(isset($typeField) && $typeField != "") {
						$where .= empty($where) ? "WHERE ($typeField='".$types[$i]."'" : ($i<1 ? " AND (" : " OR ") . "$typeField='".$types[$i]."'";
						$isFolder = 0;
						$addCT = 1;
					}
					$where .= $i==(count($types)-1) ? ")" : "";
				}
			}
		}
		if ($addCT) {
			$this->addQueryField($typeField);
		}
		if (!empty($userExtraSQL)) {
			$where .= (empty($where) ? "WHERE " : " ") . $userExtraSQL;
		}

		if (count($this->condition)>0) {
			foreach ($this->condition as $val){
				$where .= (empty($where) ? "WHERE " : " " . $val['queryOperator']) . " " .$val['field'] . $val['conditionOperator'] . "'" . $val['value'] . "'";
			}
		}

		$order = "ORDER BY " . ($isFolder ? "Path" : "isFolder  ASC, Path") . " ASC ";
		$fields = implode(", ", $this->fields);
		$query = "SELECT $fields FROM $table $where $order" . ($limit ? " LIMIT $limit" : "");
		$this->db->query($query);
	}
	
	
	/**
	 * Returns all entries of a folder, depending on the contenttype.
	 *
	 * @param integer $id
	 * @param string $table
	 * @param array $types
	 * @param integer $limit
	 */
	function queryFolderContents($id, $table, $types=null, $limit=null) {
		$userExtraSQL = $this->getUserExtraQuery($table);	
		if (is_array($types) &&  $table != CATEGORY_TABLE) {
			$this->addQueryField('ContentType');
		}
		
		$this->addQueryField("Text");
		$this->addQueryField("ParentID");
		
		// deal with contenttypes
		$ctntQuery = " OR ( 0 ";
		if ($table == CATEGORY_TABLE) {
			$ctntQuery .= " OR 1 ";
		}
		if ($types) {
			
			for ($i=0; $i<sizeof($types); $i++) {
				$ctntQuery .= " OR ContentType = \"" . $types[$i] . "\"";
			}
		}
		$ctntQuery .= " ) ";
		
		$query = "
			SELECT " . implode(", ", $this->fields) . "
			FROM $table
			WHERE 
				ParentID = $id
				AND ( IsFolder = 1 
					  $ctntQuery ) " .
			(empty($userExtraSQL) ? "" : " " . $userExtraSQL) . "
			ORDER BY IsFolder DESC, Path
		";
		$this->db->query($query);
	}
	
	/**
	 * returns single item by id
	 *
	 * @param integer $id
	 * @param string $table
	 */
	function getItemById($id, $table, $fields="",$useExtraSQL=true) {
		$_votingTable = defined('VOTING_TABLE') ? VOTING_TABLE : "";
		switch ($table) {
			case $_votingTable:
				$useCreatorID = false;
				break;
			default:
				$useCreatorID = true;
		}
		$userExtraSQL = $useExtraSQL ? $this->getUserExtraQuery($table, $useCreatorID) : "";	
		
		$this->addQueryField("Text");
		$this->addQueryField("ParentID");
		if (is_array($fields)) {
			foreach ($fields as $val) {
				$this->addQueryField($val);
			}
		}
		$query = "
			SELECT " . implode(", ", $this->fields) . "
			FROM $table
			WHERE 
				ID = $id
				" .	(empty($userExtraSQL) ? "" : " " . $userExtraSQL);
		$this->db->query($query);
		return $this->getResult();
	}
	
	/**
	 * returns single item by id
	 *
	 * @param integer $id
	 * @param string $table
	 */
	function getItemByPath($path, $table, $fields="") {
		$userExtraSQL = $this->getUserExtraQuery($table);	
		
		$this->addQueryField("Text");
		$this->addQueryField("ParentID");
		if (is_array($fields)) {
			foreach ($fields as $val) {
				$this->addQueryField($val);
			}
		}
		$query = "
			SELECT " . implode(", ", $this->fields) . "
			FROM $table
			WHERE 
				Path = '$path'
				" .	(empty($userExtraSQL) ? "" : " " . $userExtraSQL);
		$this->db->query($query);
		return $this->getResult();
	}
	
	/**
	 * getResult
	 * Liefert das komplette Ergäbnis der Abfrage als Hash mit den Feldnamen als Spalten.
	 * @return Array
	 */
	function getResult() {
		$i=0;
		$result = array();
		while ($this->db->next_record()) {
			foreach ($this->fields as $val) {
				$result[$i][$val] = $this->db->f($val);
			}
			$i++;
		}
		return $result;
	}
	
	/**
	 * addQueryField
	 * Fügt den übergebenen String zur Liste der gesuchten Felder hinzu.
	 * @param field 
	 * @return void
	 */
	function addQueryField($field) {
		array_push($this->fields, $field); 
	}
	
	/**
	 * delQueryField
	 * Entfernt den übergebenen String von der Liste der gesuchten Felder.
	 * @param field 
	 * @return void
	 */
	function delQueryField($field) {
		foreach ($this->fields as $key=>$val) {
			if ($val==$field) unset($this->fields[$key]);	
		}
	}
		
	/**
	 * addCondition
	 * Fügt die übergeben Abfragebedingung hinzu.
	 * @param array $condition
	 */
	function addCondition($condition) {
		if (is_array($condition)) {
			$arrayIndex = count($this->condition);
			$this->condition[$arrayIndex]['queryOperator'] = $condition[0];
			$this->condition[$arrayIndex]['conditionOperator'] = $condition[1];
			$this->condition[$arrayIndex]['field'] = $condition[2];
			$this->condition[$arrayIndex]['value'] = $condition[3];
		} 
	}
	
	/**
	 * getUserExtraQuery
	 * Erzeugt ein Bedingungen zur Filterung der Arbeitsbereiche
	 * @param string $table
	 * @return string
	 */
	function getUserExtraQuery($table, $useCreatorID=true){
		$userExtraSQL = makeOwnersSql(false) . " ";	 
		 
		if(get_ws($table)) {
			$userExtraSQL .= getWsQueryForSelector($table);
			
		}else if( defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE && (!$_SESSION["perms"]["ADMINISTRATOR"])){
			$wsQuery = "";
			$ac = getAllowedClasses($this->db);
			foreach($ac as $cid){
				$path = id_to_path($cid,OBJECT_TABLE);
				$wsQuery .= " Path like '$path/%' OR Path='$path' OR ";
			}
			if($wsQuery){
				$wsQuery = substr($wsQuery,0,strlen($wsQuery)-3);
				$wsQuery = " AND ($wsQuery) ";
			}
			$userExtraSQL .= $wsQuery;
		}
		return $userExtraSQL;
	}
}

?>