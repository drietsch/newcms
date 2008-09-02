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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/listview/"."listviewBase.class.php");
include_once(WE_OBJECT_MODULE_DIR . "we_objectFile.inc.php");

/**
* class    we_listview_object
* @desc    class for tag <we:listview type="object">
*
*/

class we_listview_object extends listviewBase {

	var $DB_WE2; /* 2nd DB Object */
	var $classID = "";  /* ID of a class */
	var $triggerID = 0; /* ID of a document which to use for displaying thr detail page */
	var $condition = ""; /* condition string (like SQL) */
	var $ClassName = "we_listview_object";
	var $Path=""; /* internal: Path of document which to use for displaying thr detail page */
	var $IDs=array();
	var $searchable = true;
	var $customerFilterType = 'off';
	var $customers = "";

	function we_listview_object($name="0", $rows=9999999, $offset=0, $order="", $desc=false, $classID=0, $cats="", $catOr="", $condition="", $triggerID="",$cols="", $seeMode=true, $searchable=true, $calendar="", $datefield="", $date="", $weekstart="", $categoryids='', $workspaceID='', $customerFilterType='off', $docID=0, $customers="", $id=""){

		listviewBase::listviewBase($name, $rows, $offset, $order, $desc, $cats, $catOr, $workspaceID, $cols, $calendar, $datefield, $date, $weekstart, $categoryids, $customerFilterType, $id);


		$this->DB_WE2    = new DB_WE();
		$this->classID   = $classID;
		$this->triggerID = $triggerID;
		$this->condition = $condition;
		$this->seeMode   = $seeMode;	//	edit objects in seeMode
		$this->searchable = $searchable;
		$this->docID = $docID;
		$this->customers = $customers;
		$this->customerArray = array();

		$this->condition = $this->condition ? $this->condition : (isset($GLOBALS["we_lv_condition"]) ? $GLOBALS["we_lv_condition"] : "");

		$_obxTable = OBJECT_X_TABLE.$this->classID;

		if($this->desc && (!eregi(".+ desc$",$this->order))){
			$this->order .= " DESC";
		}


		if($this->docID){
			$this->Path = id_to_path($this->docID,FILE_TABLE,$this->DB_WE);
		}else{
			if($this->triggerID){
				$this->Path = id_to_path($this->triggerID,FILE_TABLE,$this->DB_WE);
			}else{
				$this->Path = (isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"]->Path : '');
			}
		}


		// IMPORTANT for seeMode !!!! #5317
		$this->LastDocPath = '';
		if (isset($_SESSION['last_webEdition_document'])) {
			$this->LastDocPath = $_SESSION['last_webEdition_document']['Path'];
		}

		$joinTable = "";
		$joinWhere  = "";

		$orderArr = array();
		$descArr = array();
		$order = "";

		$matrix = array();

		$join = $this->fillMatrix($matrix, $this->classID, $this->DB_WE);		

		$calendar_select="";
		$calendar_where="";
		if($calendar!="") $this->fetchCalendar($this->condition,$calendar_select,$calendar_where,$matrix);

		$sqlParts = $this->makeSQLParts($matrix,$this->classID,$this->order,$this->condition);
		if (isset($GLOBALS['we_doc'])) {
			$pid_tail = makePIDTail($GLOBALS["we_doc"]->ParentID,$this->classID,$this->DB_WE,$GLOBALS["we_doc"]->Table);
		} else {
			$pid_tail = '1';
		}

		$cat_tail = getCatSQLTail($this->cats,$_obxTable,$this->catOr,$this->DB_WE,"OF_Category", true, $this->categoryids);

		$weDocumentCustomerFilter_tail = "";
		if ($this->customerFilterType != 'off' && defined("CUSTOMER_FILTER_TABLE")) {
			$weDocumentCustomerFilter_tail = weDocumentCustomerFilter::getConditionForListviewQuery($this);
		}

		$webUserID_tail = "";
		if ($this->customers && $this->customers !== "*") {
			$custArr = makeArrayFromCSV($this->customers);

			$_wsql = " ". $_obxTable . ".OF_WebUserID IN(".$this->customers.") ";

			foreach ($custArr as $cid) {
				$customerData = getHash("SELECT * FROM " . CUSTOMER_TABLE . " WHERE ID=".abs($cid), $this->DB_WE);
				$this->customerArray["cid_".$customerData["ID"]] = $customerData;
			}
			$webUserID_tail = " AND (" . $_wsql. ") ";
		}

		if($sqlParts["tables"]){
			
			$_idTail = $this->getIdQuery($_obxTable . ".ID");
			
			$ws_tail = "";
			
			if($this->workspaceID != ""){
				$workspaces = makeArrayFromCSV($this->workspaceID);
				$cond = array();
				foreach($workspaces as $id) {
					$workspace=id_to_path($id, OBJECT_FILES_TABLE, $this->DB_WE);
					array_push($cond, "(" . $_obxTable .".OF_Path like '$workspace/%' OR " . $_obxTable .".OF_Path='$workspace')");
				}
				$ws_tail = " AND (".implode(" OR ", $cond).") ";
			}
			$q = "SELECT " . $_obxTable . ".ID as ID $calendar_select FROM ".$sqlParts["tables"]." WHERE ".($this->searchable ? " ". $_obxTable . ".OF_IsSearchable=1 AND" : "")." ".$pid_tail." AND " . $_obxTable.".OF_ID != 0 ".($join ? " AND ($join) " : "").$cat_tail." ".($sqlParts["publ_cond"] ? (" AND ".$sqlParts["publ_cond"]) : "")." ".($sqlParts["cond"] ? (" AND (".$sqlParts["cond"].") ") : "").$calendar_where.$ws_tail.$weDocumentCustomerFilter_tail.$webUserID_tail.$_idTail.$sqlParts['groupBy'];
			$this->DB_WE->query($q);
			$this->anz_all = $this->DB_WE->num_rows();
			if($calendar!=""){
				while($this->DB_WE->next_record()){
					array_push($this->IDs,$this->DB_WE->f("ID"));
					if($calendar!=""){
						$this->calendar_struct["storage"][$this->DB_WE->f("ID")]=(int)$this->DB_WE->f("Calendar");
					}
				}
			}
			$q = "SELECT ".$sqlParts["fields"].$calendar_select." FROM ".$sqlParts["tables"]." WHERE ".($this->searchable ? " ". $_obxTable . ".OF_IsSearchable=1 AND" : "")." ".$pid_tail." AND " . $_obxTable.".OF_ID != 0 ".($join ? " AND ($join) " : "").$cat_tail." ".($sqlParts["publ_cond"] ? (" AND ".$sqlParts["publ_cond"]) : "")." ".($sqlParts["cond"] ? (" AND (".$sqlParts["cond"].") ") : "").$calendar_where.$ws_tail.$weDocumentCustomerFilter_tail.$webUserID_tail.$_idTail.$sqlParts['groupBy'].$sqlParts["order"].(($rows > 0) ? (" limit ".$this->start.",".$this->rows) : "");;
			$this->DB_WE->query($q);
			$this->anz = $this->DB_WE->num_rows();

			if ($this->customers === "*") {
				$_idListArray = array();
				while($this->DB_WE->next_record()) {
					if (abs($this->DB_WE->f("OF_WebUserID")) > 0) {
						$_idListArray[] = $this->DB_WE->f("OF_WebUserID");
					}
				}
				if (count($_idListArray) > 0) {
					$_idListArray = array_unique($_idListArray);
					$_idlist = implode(",", $_idListArray);
					$db = new DB_WE();
					$db->query("SELECT * FROM " . CUSTOMER_TABLE . " WHERE ID IN($_idlist)");
					while ($db->next_record()) {
						$this->customerArray["cid_".$db->f("ID")] = $db->Record;
					}
				}
				unset($_idListArray);

				$this->DB_WE->seek(0);

			}

		}else{
			$this->anz_all = 0;
			$this->anz = 0;
		}
		if($calendar!="") $this->postFetchCalendar();

		if ($this->cols && $this->anz_all) {
			// Bugfix #1715
			$_rows = floor($this->anz_all / $this->cols);
			$_rest = ($this->anz_all % $this->cols);
			$_add = $_rest ? $this->cols - $_rest : 0;
			$this->rows = min($this->rows, $_rows+$_add);

		}


	}

	function tableInMatrix($matrix,$table){
		if(OBJECT_X_TABLE.$this->classID == $table) return true;
		foreach($matrix as $foo){
			if($foo["table"] == $table) return true;
		}
		return false;
	}

	function fillMatrix(&$matrix,$classID,$db=""){
		if(!$db) $db = new DB_WE();
		$table = OBJECT_X_TABLE . $classID;
		$joinWhere = "";
		$tableInfo = we_objectFile::getSortedTableInfo($classID,true,$db);
		foreach($tableInfo as $fieldInfo){
			if(ereg('^(.+)_(.+)$',$fieldInfo["name"],$regs)){
				$temp = explode("_", $fieldInfo["name"]);
				$type = $temp[0];
				unset($temp[0]);
				$name = implode("_", $temp);
				if($type == "object" && $name != $this->classID){
					if(!isset($matrix["we_object_".$name]["type"]) || !$matrix["we_object_".$name]["type"]){
						$matrix["we_object_".$name]["type"] = $type;
						$matrix["we_object_".$name]["table"] = $table;
						$matrix["we_object_".$name]["table2"] = OBJECT_X_TABLE.$name;
						$matrix["we_object_".$name]["classID"] = $classID;
						$foo = $this->fillMatrix($matrix,$name,$db);
						$joinWhere .= " ".OBJECT_X_TABLE.$classID.".object_".$name."=". OBJECT_X_TABLE.$name.".OF_ID AND ".($foo ? "$foo AND " : "");
					}
				}else{
					$matrix[$name]["type"] = $type;
					$matrix[$name]["table"] = $table;
					$matrix[$name]["classID"] = $classID;
					$matrix[$name]["table2"] = $table;
				}
			}
		}
		return ereg_replace('^(.*)AND $','\1',$joinWhere);
	}


	function encodeEregString($in){

		$out = "";
		for($i=0;$i<strlen($in);$i++){
			$out .= "&".ord(substr($in,$i,1)).";";
		}
			return "'".$out."'";
	}

	function decodeEregString($in){
		return "'".preg_replace("/&([^;]+);/e","chr('\\1')",$in)."'";
	}

	function makeSQLParts($matrix,$classID,$order,$cond){
		
		$out = array();
		$from = array();
		$orderArr = array();
		$descArr = array();
		$ordertmp = array();

		$cond = str_replace('&gt;','>',$cond);
		$cond = str_replace('&lt;','<',$cond);

		$cond = " ".preg_replace("/'([^']*)'/e","\$this->encodeEregString('\\1')",$cond)." ";


		if($order && ($order != "random()")){
			$foo = makeArrayFromCSV($order);
			foreach($foo as $f){
				$g = explode(" ",trim($f));
				array_push($orderArr,$g[0]);
				if(isset($g[1]) && strtolower(trim($g[1])) == "desc"){
					array_push($descArr,1);
				}else{
					array_push($descArr,0);
				}
			}
		}

		$f = OBJECT_X_TABLE . $classID . ".ID as ID," . OBJECT_X_TABLE . $classID . ".OF_Templates as OF_Templates," . OBJECT_X_TABLE . $classID . ".OF_ID as OF_ID," . OBJECT_X_TABLE . $classID . ".OF_Category as OF_Category," . OBJECT_X_TABLE . $classID . ".OF_Text as OF_Text," . ($this->customers ? OBJECT_X_TABLE . $classID . ".OF_WebUserID as OF_WebUserID," : "");
		foreach($matrix as $n=>$p){
			$n2 = $n;
			if(substr($n,0,10) =="we_object_"){
				$n = substr($n,10);
			}
			$f .= $p["table"].".".$p["type"]."_".$n." as we_".$n2.",";
			array_push($from,$p["table"]);
			array_push($from,$p["table2"]);
			if(in_array($n,$orderArr)){
				$pos = getArrayKey($n,$orderArr);
				$ordertmp[$pos] = $p["table"].".".$p["type"]."_".$n.($descArr[$pos] ? " DESC" : "");
			}
			$cond = preg_replace("/([\!\=%&\(\*\+\.\/<>|~ ])$n([\!\=%&\)\*\+\.\/<>|~ ])/","$1".$p["table"].".".$p["type"]."_".$n."$2",$cond);
		}

		$cond = preg_replace("/'([^']*)'/e","\$this->decodeEregString('\\1')",$cond);

		ksort($ordertmp);
		$_tmporder = trim(preg_replace("/desc/i","",$order));
		if(	$_tmporder == "we_id" || $_tmporder == "we_filename" || $_tmporder == "we_published"){
				$_tmporder = str_replace("we_id",OBJECT_X_TABLE . $classID . ".OF_ID",$_tmporder);
				$_tmporder = str_replace("we_filename",OBJECT_X_TABLE . $classID . ".OF_Text",$_tmporder);
				$_tmporder = str_replace("we_published",OBJECT_X_TABLE . $classID . ".OF_Published",$_tmporder);

				$order = " ORDER BY $_tmporder ".($this->desc ? " DESC" : "");
		}else if($order == "random()"){
			$order = " ORDER BY RANDOM ";
		}else{
			$order = "";
			$order = makeCSVFromArray($ordertmp);
			if($order){
				$order = " ORDER BY $order ";
			}
		}

		$tb = array();
		$from = array_unique($from);
		foreach($from as $val){
			array_push($tb,$val);
		}

		$out["fields"] = ereg_replace('^(.*),$','\1',$f);
		if($order==" ORDER BY RANDOM "){
			$out["fields"] .= ", RAND() as RANDOM ";
		}
		$out["order"] = $order;
		$out["tables"] = makeCSVFromArray($tb);
		
		if (count($tb) > 1) {
			$out["groupBy"] = " GROUP BY " . OBJECT_X_TABLE . $classID . ".ID ";
		} else {
			$out["groupBy"] = "";
		}
		
		$out["publ_cond"] = "";
		foreach($tb as $t){
			$out["publ_cond"] .= " ( $t.OF_Published > 0 OR $t.OF_ID = 0) AND ";
		}
		$out["publ_cond"] = ereg_replace('^(.*)AND $','\1',$out["publ_cond"]);
		if($out["publ_cond"]){
			$out["publ_cond"]  = " ( ".$out["publ_cond"] ." ) ";
		}
		$out["cond"] = trim($cond);
		return $out;
	}


	function next_record(){

		$count=$this->count;
		$fetch=false;
		if($this->calendar_struct["calendar"]!=""){
			if($this->count < $this->anz){
				listviewBase::next_record();
				$count=$this->calendar_struct["count"];
				$fetch=$this->calendar_struct["forceFetch"];
				$this->DB_WE->Record = array();
			}
			else return false;
		}

		if($this->calendar_struct["calendar"]=="" || $fetch){
			$ret = $this->DB_WE->next_record();

			if($ret){
				$paramName = $this->docID ? "we_oid" : "we_objectID";
				$this->DB_WE->Record["we_wedoc_Path"] = $this->Path."?$paramName=".$this->DB_WE->Record["OF_ID"];
				$this->DB_WE->Record["we_wedoc_WebUserID"] = isset($this->DB_WE->Record["OF_WebUserID"]) ? $this->DB_WE->Record["OF_WebUserID"] : 0; // needed for ifRegisteredUserCanChange tag
				$this->DB_WE->Record["we_WE_CUSTOMER_ID"] = $this->DB_WE->Record["we_wedoc_WebUserID"];
				$this->DB_WE->Record["we_WE_PATH"] = $this->Path."?$paramName=".$this->DB_WE->Record["OF_ID"];
				$this->DB_WE->Record["we_WE_TEXT"] = $this->DB_WE->Record["OF_Text"];
				$this->DB_WE->Record["we_WE_ID"] = $this->DB_WE->Record["OF_ID"];
				$this->DB_WE->Record["we_wedoc_Category"] = $this->DB_WE->Record["OF_Category"];
				// for seeMode #5317
				$this->DB_WE->Record["we_wedoc_lastPath"] = $this->LastDocPath."?$paramName=".$this->DB_WE->Record["OF_ID"];
				if ($this->customers && $this->DB_WE->Record["we_wedoc_WebUserID"]) {
					if (isset($this->customerArray["cid_".$this->DB_WE->Record["we_wedoc_WebUserID"]])) {
						foreach ($this->customerArray["cid_".$this->DB_WE->Record["we_wedoc_WebUserID"]] as $key=>$value) {
							$this->DB_WE->Record["we_WE_CUSTOMER_$key"] = $value;
						}
					}
				}

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
		}
		if($this->calendar_struct["calendar"]!="") return true;

		return false;
	}

	function f($key){
		return $this->DB_WE->f("we_".$key);
	}


}

?>
