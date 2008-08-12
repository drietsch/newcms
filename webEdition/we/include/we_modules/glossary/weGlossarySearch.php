<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");

class weGlossarySearch {

	/**
	 * Database Object DB_WE
	 *
	 * @var object
	 */
	var $DatabaseObject = null;
	
	/**
	 * Tablename
	 *
	 * @var string
	 */
	var $Table = "";
	
	/**
	 * fields which have to be selected
	 *
	 * @var array
	 */
	var $Fields = array();
	
	/**
	 * where clause
	 *
	 * @var string
	 */
	var $Where = "";
	
	/**
	 * group by clause
	 *
	 * @var string
	 */
	var $GroupBy = "";
	
	/**
	 * having clause
	 *
	 * @var string
	 */
	var $Having = "";
	
	/**
	 * order clause
	 *
	 * @var string
	 */
	var $Order = "";
	
	/**
	 * offset of the queryresult
	 *
	 * @var integer
	 */
	var $Offset = 0;
	
	/**
	 * Rows of the result 
	 *
	 * @var integer
	 */
	var $Rows = 10;
	
	
	/**
	 * PHP 5 Constructor
	 *
	 */
	function __construct($table) {
		
		$this->weGlossarySearch($table);
		
	}

	
	/**
	 * PHP 4 Constructor
	 *
	 * @return weGlossarySearch
	 */
	function weGlossarySearch($table) {
		
		$this->DatabaseObject = new DB_WE();
		
		$this->Table = $table;

	}
	
	
	/**
	 * set the fields wich have to be selected
	 *
	 * @param array $fields
	 */
	function setFields($fields = array()) {
		
		$this->Fields = $fields;
		
	}
	
	
	/**
	 * set the where clause
	 *
	 * @param string $where
	 */
	function setWhere($where = "") {
		
		$this->Where = $where;
		
	}
	
	
	/**
	 * set the group by clause
	 *
	 * @param string $groupBy
	 */
	function setGroupBy($groupBy = "") {
		
		$this->GroupBy = $groupBy;
		
	}
	
	
	/**
	 * set the where clause
	 *
	 * @param string $where
	 */
	function setHaving($having = "") {
		
		$this->Having = $having;
		
	}
	
	
	/**
	 * set the order clause
	 *
	 * @param string $order
	 */
	function setOrder($order = "", $sort = "ASC") {
		
		$this->Order = $order;
		$this->Sort = $sort;
		
	}
	
	
	/**
	 * set the offset and the count
	 *
	 * @param integer $offset
	 * @param integer $count
	 */
	function setLimit($offset = 0, $rows = 10) {
		
		$this->Offset = $offset;
		$this->Rows = $rows; 
		
	}
	
	
	/**
	 * get statement
	 *
	 * @param boolean $countStmt
	 * @return string
	 */
	function _getStatement($countStmt = false) {
		
		$stmt = "SELECT ";
		
		if($countStmt) {
			$stmt .= "COUNT(*) ";
			
		} else {
			$stmt .= implode(", ", $this->Fields). " ";
			
		}
		
		$stmt .= "FROM " . $this->Table . " ";
		
		$stmt .= "WHERE " . ($this->Where == "" ? "1" : $this->Where) . " ";
		
		if($this->GroupBy != "") {
			$stmt .= "GROUP BY " . $this->GroupBy . " ";
			
		}
		
		if($this->Having != "") {
			$stmt .= "HAVING " . $this->Having . " ";
			
		}
		
		if(!$countStmt) {
			if($this->Order != "") {
				$stmt .= "ORDER BY " . $this->Order . " " . $this->Sort . " ";
				
			}
			
			$stmt .= "LIMIT " . $this->Offset . ", " . $this->Rows;
			
		}
		
		return trim($stmt);
		
	}


	/**
	 * count the items
	 *
	 * @return integer
	 */
	function countItems() {

		$this->DatabaseObject->query($this->_getStatement(true));
		
		$this->DatabaseObject->next_record();

		return $this->DatabaseObject->f("COUNT(*)");
		
	}
	
	
	/**
	 * execute the saerch query
	 *
	 */
	function execute() {

		$this->DatabaseObject->query($this->_getStatement());
		
	}
	
	
	/**
	 * iterate over the whole resultset
	 * 
	 * @return mixed
	 */
	function next() {
		
		return $this->DatabaseObject->next_record();
		
	}
	
	
	/**
	 * get the value of a field
	 *
	 * @param string $field
	 * @return mixed
	 */
	function getField($field) {
		
		return $this->DatabaseObject->f($field);
		
	}
	
	
	/**
	 * get the pages as array (key = pageNr, value = start)
	 *
	 * @return array
	 */
	function getPages() {
		
		$_count = $this->countItems();
		
		$_pages = ceil($_count / $this->Rows);
		
		$pages = array();
		for($i = 1; $i <= $_pages; $i++) {
			$pages[($i-1)*$this->Rows] = $i;
			
		}
		
		return $pages;
		
	}
	
	
	/**
	 * get the number of the active page
	 *
	 * @return integer
	 */
	function getActivePage() {
		
		return ceil(($this->Offset-1) / $this->Rows);
		
	}

}
?>