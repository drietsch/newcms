<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_db.inc.php");

class we_search extends DB_WE{


	var $rows = -1;
	var $start = 0;
	var $order = "";
	var $desc = 0;
	var $tablename;

	var $GreenOnly;
	var $defaultanzahl=10;
	var $where;
	var $get;

	var $Order;
	var $anzahl = 10;
	var $searchstart = 0;

	function we_search(){

	}

	function init($sessDat=""){
		for($i=0;$i<=sizeof($sessDat);$i++){
			if(isset($GLOBALS["we_".$this->Name."_".$sessDat[$i]])){
				 $v=$GLOBALS["we_".$this->Name."_".$sessDat[$i]];
				 $v = (get_magic_quotes_gpc() == 1) ? stripslashes($v) : $v;
				 eval('$this->'.$sessDat[$i].'=$v;');
			}
		}
	}

	// select expects an array with 	Searchid["field"] => "searchstring"
	// 									Searchid["search"] => "searchstring"
	//									Searchid["concat"] => "AND"
	//																("OR","XOR")
	//									Searchid["type"] => "START"
	//																("IS","END","CONTAIN","<","<=",">",..)
	function searchfor($searchname,$searchfield,$searchlocation,$tablename,$rows=-1,$start=0,$order="",$desc=0){

		$this->tablename=$tablename;
		$i=0;
		$sql = "";

		for($i=0;$i<sizeof($searchfield);$i++){

			if(!empty($searchname[$i])){
				if(ereg('^(.*)_(.*)$',$searchfield[$i],$regs) && $regs[1] == "date") {
						
					$year   = ($searchname[$i]['year']&&$searchname[$i]['year']!=""?$searchname[$i]['year']:date("Y"));
					$month  = ($searchname[$i]['month']&&$searchname[$i]['month']!=""?$searchname[$i]['month']:"");
					$day    = ($searchname[$i]['day']&&$searchname[$i]['day']!=""?$searchname[$i]['day']:"");
					$hour   = ($searchname[$i]['hour']&&$searchname[$i]['hour']!=""?$searchname[$i]['hour']:"");
					$minute = ($searchname[$i]['minute']&&$searchname[$i]['minute']!=""?$searchname[$i]['minute']:"");
					
					$from = mktime(($hour!=""?$hour:0), ($minute!=""?$minute:0), 0, ($month!=""?$month:1), ($day!=""?$day:1), $year);
					$till = mktime(($hour!=""?$hour:23), ($minute!=""?$minute:59), 59, ($month!=""?$month:12), ($day!=""?$day:date("t", mktime(0, 0, 0, ($month!=""?$month:12), 1, $year))), $year);
					
					switch ($searchlocation[$i]){	
						case "<":
						case "<=":
						case ">":
						case ">=":
							$searching = " ".$searchlocation[$i]." ".$from." ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							break;
						default :
							$searching = " BETWEEN $from AND $till ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							break;
	
					}
					
				} else {
				
					switch ($searchlocation[$i]){
						case "END":
							$searching = " LIKE '%".mysql_real_escape_string($searchname[$i])."' ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							break;
						case "START":
							$searching = " LIKE '".mysql_real_escape_string($searchname[$i])."%' ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							//$sql .= " �".$val["field"]."� LIKE �".$val["search"]."%� ";
							break;
	
						case "IS":
							$searching = " = '".mysql_real_escape_string($searchname[$i])."' ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							break;
						case "<":
						case "<=":
						case ">":
						case ">=":
							$searching = " ".$searchlocation[$i]." '".mysql_real_escape_string($searchname[$i])."' ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							break;
						default :
							$searching = " LIKE '%".mysql_real_escape_string($searchname[$i])."%' ";
							$sql .= $this->sqlwhere($searchfield[$i],$searching, null);
							break;
	
					}
				}
			}
		}

		return $sql;
	}



	function sqlwhere($we_SearchField,$searchlocation,$concat){
			$concat = (isset($concat))?$concat:"AND";
			if(ereg(',',$we_SearchField)){
						$foo = makeArrayFromCSV($we_SearchField);
						$q = "";
						foreach($foo as $f){
								$q .= " $f $searchlocation OR ";
						}
						$q = ereg_replace('^(.*)OR ','\1',$q);
						$where = " $concat ( $q ) ";
					}else{
						$where = " $concat $we_SearchField $searchlocation  ";
					}
			return $where;

	}


	function countitems($where = "",$table = ""){

			$this->table = (empty($table))?((empty($this->table))?"":$this->table):$table;

			if(!empty($this->table)){
				$this->where = (empty($where))?((empty($this->where))?"1":$this->where):$where;

				$this->query("SELECT count(*) as c FROM ".mysql_real_escape_string($this->table)." WHERE ".$this->where);
				$this->next_record();

				return $this->f("c");
			}else{
				return -1;
			}
	}


	function searchquery($where = "",$get="*",$table="",$order="",$limit=""){

			$this->table = (empty($table))?((empty($this->table))?"":$this->table):$table;

			if(!empty($this->table)){
				$this->where = (empty($where))?((empty($this->where))?"":" WHERE ".$this->where):" WHERE ".$where;
				$this->get =  (empty($get))?((empty($this->get))?"*":$this->get):$get;
				$this->Order = (!empty($order))?$order:$this->Order;
				$order = ((empty($this->Order))?"":" ORDER BY ".$this->Order);

				$this->limit = " ".$this->searchstart.",".$this->anzahl." ";

				$this->limit = (empty($limit))?((empty($this->limit))?"":" LIMIT ".($this->limit)):" LIMIT ".($limit);

				//echo "SELECT ".$this->get." FROM ".$this->table." ".$this->where." ".$order." ".$this->limit;
				$this->query("SELECT ".ereg_replace('^(.+),$','\1',$this->get)." FROM ".mysql_real_escape_string($this->table)." ".$this->where." ".$order." ".$this->limit);
			}else{
				return -1;
			}
	}


	function setlimit($anzahl="",$searchstart=""){

		$this->anzahl = (empty($anzahl))?((empty($this->anzahl))?$this->defaultanzahl:$this->anzahl):$anzahl;
		$this->searchstart = (empty($searchstart))?((empty($this->searchstart))?"0":$this->searchstart):$searchstart;

			$this->limit = " ".$this->searchstart.",".$this->anzahl." ";

		return $this->limit;
	}

	function getlimit(){

		return $this->limit;

	}


	function setstart($z){

		$this->searchstart = $z;

	}

	function setorder($z){

		$this->Order = $z;

	}

	function setwhere($z){

		$this->where = $z;

	}

	function settable($z){

		$this->table = $z;

	}

	function setget($z){

		$this->get = $z;

	}

	function getJSinWElistnavigation($name){

		return $this->getJSinWEforwardbackward($name).$this->getJSinWEorder($name);
	}

	function getJSinWEforwardbackward($name){

			return '<script language="JavaScript" type="text/javascript" src="'.JS_DIR.'tooltip.js"></script>
				<script language="JavaScript" type="text/javascript"><!--
				_EditorFrame.setEditorIsHot(false);

			function next(){
				document.we_form.elements[\'SearchStart\'].value = parseInt(document.we_form.elements[\'SearchStart\'].value) + '.$this->anzahl.';
				top.we_cmd("reload_editpage");
			}
			function back(){
				document.we_form.elements[\'SearchStart\'].value = parseInt(document.we_form.elements[\'SearchStart\'].value) - '.$this->anzahl.';
				top.we_cmd("reload_editpage");
			}
		//-->
		</script>';


	}

    function getJSinWEorder($name){

		return '<script language="JavaScript" type="text/javascript"><!--
			function setOrder(order){

				foo = document.we_form.elements[\'Order\'].value;

				if(((foo.substring(foo.length-5,foo.length) == " DESC") && (foo.substring(0,order.length-5) == order)) || foo != order){
					document.we_form.elements[\'Order\'].value=order;
				}else{
					document.we_form.elements[\'Order\'].value=order+" DESC";
				}
				top.we_cmd("reload_editpage");
			}
		//-->
		</script>';

	}




	function getLocation($name="locationField",$select="",$size=1,$sprach=array()){
	// get Class
	global $l_object;
			$opts = "";
			$loc = array("CONTAIN","IS","START","END","<","<=",">=",">");
			for($i=0;$i<sizeof($loc);$i++){
						$opts .= '<option value="'.$loc[$i].'" '.(($select==$loc[$i])?"selected":"").'>'
						      . htmlspecialchars((( isset($sprach[$loc[$i]]) && $sprach[$loc[$i]]  )?$sprach[$loc[$i]]:$loc[$i]))
						      . '</option>'."\n";
			}

	return '<select name="'.$name.'" class="weSelect" size="'.$size.'">'.$opts.'</select>';
	}

	function getLocationDate($name="locationField",$select="",$size=1,$sprach=array()){
	// get Class
	global $l_object;
			$opts = "";
			$loc = array("IS","<","<=",">=",">");
			for($i=0;$i<sizeof($loc);$i++){
						$opts .= '<option value="'.$loc[$i].'" '.(($select==$loc[$i])?"selected":"").'>'
						      . htmlspecialchars((( isset($sprach[$loc[$i]]) && $sprach[$loc[$i]]  )?$sprach[$loc[$i]]:$loc[$i]))
						      . '</option>'."\n";
			}

	return '<select name="'.$name.'" class="weSelect" size="'.$size.'">'.$opts.'</select>';
	}

	function getLocationMeta($name="locationField",$select="",$size=1,$sprach=array()){
	// get Class
	global $l_object;
			$opts = "";
			$loc = array("IS");
			for($i=0;$i<sizeof($loc);$i++){
						$opts .= '<option value="'.$loc[$i].'" '.(($select==$loc[$i])?"selected":"").'>'
						      . htmlspecialchars((( isset($sprach[$loc[$i]]) && $sprach[$loc[$i]]  )?$sprach[$loc[$i]]:$loc[$i]))
						      . '</option>'."\n";
			}

	return '<select name="'.$name.'" class="weSelect" size="'.$size.'">'.$opts.'</select>';
	}



	function getNextPrev($we_search_anzahl){

		$we_button = new we_button();

		$out = 		'<table cellpadding="0" cellspacing="0" border="0">'
				.	'<tr>'
				.	'<td>';
		if($this->searchstart){
			$out .= $we_button->create_button("back", "javascript:back();"); //bt_back
		}else{
			$out .= $we_button->create_button("back", "",true, 100, 22, "", "", true);
		}

		$out .=		'</td>'
				.	'<td>'.getPixel(10,2).'</td>'
				.	'<td class="defaultfont"><b>'.(($we_search_anzahl)?$this->searchstart+1:0).'-';

		if( ($we_search_anzahl-$this->searchstart) < $this->anzahl){
			$out .= $we_search_anzahl;
		}else{
			$out .= $this->searchstart+$this->anzahl;
		}

		$out .= 	' '.$GLOBALS["l_global"]["from"].' '.$we_search_anzahl.'</b></td>'
				.	'<td>'.getPixel(10,2).'</td>'
				.	'<td>';

		if(($this->searchstart+$this->anzahl) < $we_search_anzahl){
			$out .= $we_button->create_button("next", "javascript:next();"); //bt_back
		}else{
			$out .= $we_button->create_button("next", "", true, 100, 22, "", "", true);
		}
		$out .= 	'</td>'
				.	'<td>'.getPixel(10,2).'</td>'
				.	'<td>';
				
		$pages = array();
		for($i = 0; $i < ceil($we_search_anzahl / $this->anzahl); $i++) {
			$pages[($i*$this->anzahl)] = ($i+1);
		}
		
		$page = ceil($this->searchstart / $this->anzahl) * $this->anzahl;
		
		$select = htmlSelect("page", $pages, 1, $page, false, "onChange=\"this.form.elements['SearchStart'].value = this.value;we_cmd('reload_editpage');\"");
		if(!defined("SearchStart")) {
			define("SearchStart", true);
			$out .= hidden("SearchStart", $this->searchstart);
		}
		
		$out .= $select;
		
		$out .= 	'</td>'
				. 	'</tr>'
				.	'</table>';
		return $out;
	}



}
?>