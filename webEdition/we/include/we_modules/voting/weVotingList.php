<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_modules/voting/"."weVoting.php");


/**
* General Definition of WebEdition Voting
*
*/
class weVotingList{

	//properties
	var $Name;	
	var $Version;
	var $Offset=0;
	var $Start=0;
	
	var $CountAll=0;
	/**
	* Default Constructor
	* Can load or create new Newsletter depends of parameter
	*/
	
	
	function weVotingList($name,$groupid,$version=0,$rows=0,$offset=0,$desc=false,$order='PublishDate',$subgroup=false){

			$this->Name = $name;
			$this->Version = $version;
			$this->Offset = $offset;
			$this->Rows = $rows;
			$this->Start = (isset($_REQUEST["_we_vl_start_".$this->Name]) && $_REQUEST["_we_vl_start_".$this->Name]) ? abs($_REQUEST["_we_vl_start_".$this->Name]) : 0;
			if($this->Start == 0) $this->Start += $offset;			

			$childs_query = '';
			if($groupid!=0){
				$childs_query = '(ParentID=' . $groupid;
				if($subgroup) {
					$childs = array();		
					we_readChilds($groupid,$childs,VOTING_TABLE,true,'','IsFolder',1);
					$childs_query .= ' OR ParentID=' . implode(' OR ParentID=',$childs);
				}
				$childs_query .= ')';
				
			}

			if($rows || $this->Start) $limit = ' LIMIT ' . $this->Start . ',' . ($rows==0 ? 9999999 : $rows);
			else $limit = '';
			
			if($order!="") {
				$order_sql = ' ORDER BY ' . $order;
				if($desc){
					$order_sql .= ' DESC ';
				} else {
					$order_sql .= ' ASC ';
				}				
			}			
			
			$this->db = new DB_WE();
			
			
			$this->CountAll = f('SELECT count(ID) as CountAll FROM ' . VOTING_TABLE . ' WHERE IsFolder=0 ' . (!empty($childs_query) ? ' AND ' . $childs_query : '') . $order_sql . ';', 'CountAll',$this->db);
			$_we_voting_query = 'SELECT ID FROM ' . VOTING_TABLE . ' WHERE IsFolder=0 ' . (!empty($childs_query) ? ' AND ' . $childs_query : '') . $order_sql . $limit . ';';
				
			$this->db->query($_we_voting_query);
		
		
	}

	function getNext(){

		if($this->db->next_record()) {
				$GLOBALS['_we_voting'] = new weVoting($this->db->f('ID'));
				$GLOBALS['_we_voting']->setDefVersion($this->Version);
				return true;
		}
		return false;
       		
	}
	
	function getNextLink($attribs){
	    
		if($this->hasNextPage()){
		    		    
			$foo = $this->Start + $this->Rows;
			$attribs["href"] = $_SERVER["PHP_SELF"].'?'. htmlspecialchars($this->we_makeQueryString("_we_vl_start_".$this->Name."=$foo"));

            return getHtmlTag("a", $attribs, "", false, true);


		}else{
			return "";
		}
	}	
	
	
	function hasNextPage(){
		return (($this->Start + $this->Rows) < $this->CountAll);
	}

	
	function getBackLink($attribs){
	    
		if($this->hasPrevPage()){
		    		    
			$foo = $this->Start - $this->Rows;
			$attribs["href"] = $_SERVER["PHP_SELF"].'?'. htmlspecialchars($this->we_makeQueryString("_we_vl_start_".$this->Name."=$foo"));
			
			return getHtmlTag("a", $attribs, "", false, true);

		}else{
			return "";
		}
	}

	function hasPrevPage(){
		return (abs($this->Start) != abs($this->Offset));
	}	
	
	function we_makeQueryString($queryString="",$filter="") {
		$usedKeys = array();
		if($filter){
		    $filterArr = explode(",",$filter);
		} else {
		    $filterArr = array();
		}
		array_push($filterArr,"edit_object");
		array_push($filterArr,"edit_document");
		array_push($filterArr,"we_editObject_ID");
		array_push($filterArr,"we_editDocument_ID");
		if($queryString) {
			$foo = explode("&",$queryString);
			$queryString = "";
			for($i=0;$i<sizeof($foo);$i++) {
				list($key,$val) = explode("=",$foo[$i]);
				array_push($usedKeys,$key);
				$queryString .= $key."=".rawurlencode($val)."&";
			}
			$queryString = ereg_replace('(.*)&$','\1',$queryString);
		}
		$url_tail = "";
		if(isset($_GET)) {
			foreach($_GET as $key => $val){
				if ((!in_array($key,$usedKeys)) && (!in_array($key,$filterArr)) && (!ereg("^we_ui_",$key))) {
					if (is_array($val)) {
						for($i=0;$i<sizeof($val);$i++){
						    if(isset($key[$i])){
						        $url_tail .= "$key"."[".$i."]=". (isset($val) && isset($val[$i]) ? rawurlencode($val[$i]) : "") ."&";
						    }
						}
					} else {
						$url_tail .= "$key=".rawurlencode($val)."&";
					}
				}
			}
		}
		if(isset($_POST)) {
			foreach($_POST as $key => $val){
				if ((!in_array($key,$usedKeys)) && (!in_array($key,$filterArr)) && (!ereg("^we_ui_",$key))) {
					if (is_array($val)) {
						for($i=0;$i<sizeof($val);$i++){
						    if(isset($key[$i])){
						        $url_tail .= "$key"."[".$i."]=". (isset($val) && isset($val[$i]) ? rawurlencode($val[$i]) : "") ."&";
						    }
						}
					} else {
						$url_tail .= "$key=".rawurlencode($val)."&";
					}
				}
			}
		}
		$url_tail .= $queryString;
		$url_tail = ereg_replace('(.*)&$','\1',$url_tail);
		return $url_tail;
	}
	
}


?>