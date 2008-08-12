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
 * Class we_htmlTable
 *
 * Provides functions for creating html tags used in forms.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_baseCollection.inc.php");

class we_htmlTable extends we_baseCollection {

	
	/**
	 * Constructor of class we_htmlTable
	 *
	 * @param      $attribs                                array
	 * @param      $rows_num                               int                 (optional)
	 * @param      $cols_num                               int                 (optional)
	 *
	 * @return     we_htmlTable
	 */

	function we_htmlTable($attribs=array(), $rows_num = 0, $cols_num = 0) {
		$this->we_baseCollection("table", true, $attribs);
		$this->addRow($rows_num);
		$this->addCol($cols_num);
	}

	/**
	 * This function adds a row to the table
	 *
	 * @param      $rows_num                               int                 (optional)
	 *
	 * @see        we_htmlTable()
	 *
	 * @return     void
	 */

	function addRow($rows_num = 1) {
		$cols_num=0;
		if(isset($this->childs)){
			if(array_key_exists(0,$this->childs)){
				if(is_array($this->childs[0]->childs)){
					$cols_num=count($this->childs[0]->childs);
				}
			}		
		}
		for ($i = 0; $i < $rows_num; $i++) {
			$this->childs[] = new we_baseCollection("tr");
			for($j=0;$j<$cols_num;$j++) $this->childs[count($this->childs)-1]->childs[]=new we_baseElement("td"); 
		}
	}

	/**
	 * This function adds a column to the table
	 *
	 * @param      $cols_num                               int                 (optional)
	 *
	 * @see        we_htmlTable()
	 *
	 * @return     void
	 */

	function addCol($cols_num = 1) {
		for($i = 0; $i < $cols_num; $i++) {
			foreach($this->childs as $k => $v) {
				$this->childs[$k]->childs[]=new we_baseElement("td");
			}
		}
	}
	
	/**
	 * This functions sets the current row being edited
	 *
	 * @param      $rowid                                  int
	 * @param      $attribs                                array
	 * @param      $cols_num                               int                 (optional)
	 *
	 * @return     void
	 */

	function setRow($rowid, $attribs = array(), $cols_num = 0) {
		$row=& $this->getChild($rowid);
		$row->setAttributes($attribs);

		if($cols_num) {
			if($cols_num>count($row->childs)) {
				$row->addChild(new we_baseElement("td"));
			} else if($cols_num < count($row->childs)) {
				$row->childs=array_splice($row->childs, ($cols_num - 1));
			}
		}
	}

	/**
	 * This function sets the current column being edited
	 *
	 * @param      $rowid                                  int
	 * @param      $colid                                  int
	 * @param      $attribs                                array               (optional)
	 * @param      $content                                string              (optional)
	 *
	 * @return     void
	 */

	function setCol($rowid, $colid, $attribs = array(), $content = "") {
		$row=& $this->getChild($rowid);
		$col=& $row->getChild($colid);
		$col->setAttributes($attribs);
		$col->setContent($content);
	}

	/**
	 * Assigns the attributes of a column
	 *
	 * @param      $rowid                                  int
	 * @param      $colid                                  int
	 * @param      $attribs                                array               (optional)
	 *
	 * @return     void
	 */

	function setRowAttributes($rowid, $attribs = array()) {		
		$row=& $this->getChild($rowid);
		$row->setAttributes($attribs);
	}

	/**
	 * Assigns the attributes of a column
	 *
	 * @param      $rowid                                  int
	 * @param      $colid                                  int
	 * @param      $attribs                                array               (optional)
	 *
	 * @return     void
	 */

	function setColAttributes($rowid, $colid, $attribs = array()) {
		$row=& $this->getChild($rowid);
		$col=& $row->getChild($colid);
		$col->setAttributes($attribs);
	}

	/**
	 * Sets the content of a column
	 *
	 * @param      $rowid                                  int
	 * @param      $colid                                  int
	 * @param      $content                                string              (optional)
	 *
	 * @return     void
	 */

	function setColContent($rowid, $colid, $content = "") {
		$row=& $this->getChild($rowid);
		$col=& $row->getChild($colid);
		$col->setContent($content);
	}	

	/**
	* Returns the rendered HTML code
	*
	* @return     string
	*/
	function getHtmlCode() {
		
		$copy=$this->copy();
	 	$rows_num=count($copy->childs);
		 
		for($i=0;$i<$rows_num;$i++){
			$row=& $copy->getChild($i);
			$cols_num=count($row->childs);
			$colspan=0;
			for($j=0;$j<$cols_num;$j++){
				if($colspan){
					$row->delChild($j);
					$j--;
					$cols_num=count($row->childs);
					$colspan--;
				}
				else{
					$col=$row->getChild($j);
					if(in_array("colspan",array_keys($col->attribs))){
						$colspan=$col->getAttribute("colspan");
						$colspan--;
					}
				}
			}
		}
		
		return we_baseCollection::getHtmlCode($copy);
	}	

}

?>