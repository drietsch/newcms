<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/"."listviewBase.class.php");

/**
 * class    we_search_listview
 * @desc    class for tag <we:listview type="search">
 *          the difference to the normal listview is, that you can only
 *          display the fields from the index table (tblIndex) which are
 *          Title, Description we_text, we_path
 *
 */
class we_search_listview extends listviewBase {

	var $docType = ""; /* doctype string */
	var $class = 0;   /* ID of a class. Search only in Objects of this class */
	var $casesensitive = false; /* set to true when a search should be case sensitive */
	var $ClassName = "we_search_listview";
	var $customerFilterType = 'off';
	/**
	 * we_search_listview()
	 * @desc    constructor of class
	 *
	 * @param   name         string - name of listview
	 * @param   rows          integer - number of rows to display per page
	 * @param   offset        integer - start offset of first page
	 * @param   order         string - field name(s) to order by
	 * @param   desc          boolean - set to true, if order should be descendend
	 * @param   docType       string - doctype
	 * @param   class         integer - ID of a class. Search only in Objects of this class
	 * @param   cats          string - comma separated categories
	 * @param   catOr         boolean - set to true if it should be an "OR condition"
	 * @param   casesensitive boolean - set to true when a search should be case sensitive
	 * @param   workspaceID   string - commaseperated list of id's of workspace
	 * @param   cols   		  integer - to display a table this is the number of cols
	 *
	 */

	function we_search_listview($name="0", $rows=99999999, $offset=0, $order="", $desc=false, $docType="", $class=0, $cats="", $catOr=false, $casesensitive=false, $workspaceID="", $cols="", $customerFilterType='off'){

		listviewBase::listviewBase($name, $rows, $offset, $order, $desc, $cats, $catOr, $workspaceID, $cols);
		$this->customerFilterType = $customerFilterType;

		// correct order
		$orderArr = array();
		if($this->order){
			if(	$this->order == "we_id" ||  $this->order == "we_creationdate" || $this->order == "we_filename"){

					$ord = str_replace("we_id",INDEX_TABLE . ".DID".($this->desc ? " DESC" : "").",".INDEX_TABLE . ".OID".($this->desc ? " DESC" : ""),$this->order);
					//$ord = str_replace("we_creationdate",INDEX_TABLE . ".CreationDate",$ord);
					$this->order = str_replace("we_filename",INDEX_TABLE . ".Path",$ord);


			}else{
				$orderArr1 = makeArrayFromCSV($this->order);
				foreach($orderArr1 as $o){
					if(trim($o)){
						$foo = split(' +',$o);
						$oname = $foo[0];
						$otype = isset($foo[1]) ? $foo[1] : "";
						array_push($orderArr,array("oname"=>$oname,"otype"=>$otype));
					}
				}
				$this->order = "";
				foreach($orderArr as $o){
					if( $o["oname"] == "Title" ||
						$o["oname"] == "Path" ||
						$o["oname"] == "Text" ||
						$o["oname"] == "OID" ||
						$o["oname"] == "DID" ||
						$o["oname"] == "ID" ||
						$o["oname"] == "Workspace" ||
						$o["oname"] == "Description"){

						$this->order .= $o["oname"].((trim(strtolower($o["otype"]))=="desc") ? " DESC" : "").",";
					}

				}
				$this->order = ereg_replace('^(.*),$','\1',$this->order);
			}
		}

		if($this->order && $this->desc && (!eregi(".+ desc$",$this->order))){
			$this->order .= " DESC";
		}

		$this->docType = trim($docType);
		$this->class = $class;
		$this->casesensitive = $casesensitive;

		$searchfield = $this->casesensitive ? "BText" : "Text";


		$cat_tail = getCatSQLTail($this->cats,INDEX_TABLE,$this->catOr,$this->DB_WE);

		$dt = ($this->docType) ? f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType like '".$this->docType."'","ID",$this->DB_WE) : "";

		$cl = $this->class;

		if($dt && $cl){
			$dtcl_query = " AND (" . INDEX_TABLE . ".Doctype='$dt' OR " . INDEX_TABLE . ".ClassID='$cl') ";
		}else if($dt){
			$dtcl_query = " AND " . INDEX_TABLE . ".Doctype='$dt' ";
		}else if($cl){
			$dtcl_query = " AND " . INDEX_TABLE . ".ClassID='$cl' ";
		}else{
			$dtcl_query = "";
		}



		$bedingungen = split(" +",$this->search);
		$ranking = "0";
		$worte = array();
		$spalten=array(INDEX_TABLE . ".".$searchfield);
		reset($bedingungen);
		while(list($k1,$v1) = each($bedingungen)) {
			if (ereg("^[-\+]",$v1)) {
				$not = (ereg("^-",$v1))?"NOT ":"";
				$bed = ereg_replace("^[-\+]","",$v1);
				$klammer = array();
				reset($spalten);
				while(list($k,$v) = each($spalten)) {
					$klammer[] = sprintf("%s LIKE '%%%s%%'",$v,addslashes($bed));
				}
				if($not) $bedingungen3_sql[] = $not."(".join($klammer," OR ").")";
				else $bedingungen_sql[] = "(".join($klammer," OR ").")";
			} else {
				$klammer = array();
				reset($spalten);
				while(list($k,$v) = each($spalten)) {
					$klammer[] = sprintf("%s LIKE '%%%s%%'",$v,addslashes($v1));
				}
				$bed2 = "(".join($klammer," OR ").")";
				$ranking .= "-".$bed2;
				$bedingungen2_sql[] = $bed2;
			}
		}

		if (isset($bedingungen_sql) && count($bedingungen_sql)>0) {
			$bedingung_sql1 = " ( ".join($bedingungen_sql," AND ").(isset($bedingungen3_sql) && count($bedingungen3_sql) ? (" AND ".join($bedingungen3_sql," AND ")) : "")." ) ";
		}
		else if (isset($bedingungen2_sql) && count($bedingungen2_sql)>0)  {
			$bedingung_sql2 = " ( ( ".join($bedingungen2_sql," OR ").(isset($bedingungen3_sql) && count($bedingungen3_sql) ? (" ) AND ".join($bedingungen3_sql," AND ")) : " ) ")." ) ";
		}else if(isset($bedingungen3_sql) && count($bedingungen3_sql)>0){
			$bedingung_sql2 = join($bedingungen3_sql," AND ");
		}

		if(isset($bedingung_sql1) && $bedingung_sql1 && isset($bedingung_sql2) && $bedingung_sql2){
			$bedingung_sql = " ( ".$bedingung1_sql." AND ".$bedingung2_sql." ) ";
		}else if(isset($bedingung_sql1) && $bedingung_sql1){
			$bedingung_sql = $bedingung_sql1;
		}else{
			$bedingung_sql  = $bedingung_sql2;
		}
		if($this->workspaceID != ""){
			$workspaces = makeArrayFromCSV($this->workspaceID);
			$cond = array();
			foreach($workspaces as $id) {
				$workspace=id_to_path($id, FILE_TABLE, $this->DB_WE);
				array_push($cond, "(" . INDEX_TABLE . ".Workspace like '$workspace/%' OR " . INDEX_TABLE . ".Workspace='$workspace')");
			}
			$ws_where = " AND (".implode(" OR ", $cond).")";
		}else{
			$ws_where = "";
		}

		$weDocumentCustomerFilter_tail = "";
		if ($this->customerFilterType != 'off' && defined("CUSTOMER_FILTER_TABLE")) {
			$weDocumentCustomerFilter_tail = weDocumentCustomerFilter::getConditionForListviewQuery($this);

		}

		$q = "SELECT ID FROM " . INDEX_TABLE . " WHERE $bedingung_sql $dtcl_query $cat_tail $ws_where $weDocumentCustomerFilter_tail";
		$this->DB_WE->query($q);
		$this->anz_all = $this->DB_WE->num_rows();

		if($this->order == "random()"){
			$q = "SELECT " . INDEX_TABLE . ".Category as Category, " . INDEX_TABLE . ".DID as DID," . INDEX_TABLE . ".OID as OID," . INDEX_TABLE . ".Text as Text," . INDEX_TABLE . ".Workspace as Workspace," . INDEX_TABLE . ".WorkspaceID as WorkspaceID," . INDEX_TABLE . ".Title as Title," . INDEX_TABLE . ".Description as Description," . INDEX_TABLE . ".Path as Path, RAND() as RANDOM FROM " . INDEX_TABLE . " WHERE $bedingung_sql $dtcl_query $cat_tail $ws_where $weDocumentCustomerFilter_tail ORDER BY RANDOM".(($rows > 0) ? (" limit ".$this->start.",".$this->rows) : "");

		}else{
			$q = "SELECT " . INDEX_TABLE . ".Category as Category, " . INDEX_TABLE . ".DID as DID," . INDEX_TABLE . ".OID as OID," . INDEX_TABLE . ".Text as Text," . INDEX_TABLE . ".Workspace as Workspace," . INDEX_TABLE . ".WorkspaceID as WorkspaceID," . INDEX_TABLE . ".Title as Title," . INDEX_TABLE . ".Description as Description," . INDEX_TABLE . ".Path as Path, $ranking as ranking FROM " . INDEX_TABLE . " WHERE $bedingung_sql $dtcl_query $cat_tail $ws_where $weDocumentCustomerFilter_tail ORDER BY ranking".($this->order ? (",".$this->order) : "").(($rows > 0) ? (" limit ".$this->start.",".$this->rows) : "");

		}
		$this->DB_WE->query($q);
		$this->anz = $this->DB_WE->num_rows();


	}

	function next_record(){
		$ret = $this->DB_WE->next_record();
		if($ret){
			$this->DB_WE->Record["wedoc_Path"] = $this->DB_WE->Record["Path"];
			$this->DB_WE->Record["WE_PATH"] = $this->DB_WE->Record["Path"];
			$this->DB_WE->Record["WE_TEXT"] = $this->DB_WE->Record["Text"];
			$this->DB_WE->Record["wedoc_Category"] = $this->DB_WE->Record["Category"];
			$this->DB_WE->Record["WE_ID"] = (isset($this->DB_WE->Record["DID"]) && $this->DB_WE->Record["DID"]) ? $this->DB_WE->Record["DID"] : (isset($this->DB_WE->Record["OID"]) ? $this->DB_WE->Record["OID"] : 0);
			$this->count++;
			return true;
		}else if($this->cols && ($this->count < $this->rows)){
			$this->DB_WE->Record = array();
			$this->DB_WE->Record["WE_PATH"] = "";
			$this->DB_WE->Record["WE_TEXT"] = "";
			$this->DB_WE->Record["WE_ID"] = "";
			$this->count++;
			return true;
		}
		return false;
	}

	function f($key){
		return $this->DB_WE->f($key);
	}

}

?>