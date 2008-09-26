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



include_once(WE_CUSTOMER_MODULE_DIR."weCustomer.php");

/**
* General Definition of Customer's Prefers
*
*/

define("DATE_FORMAT","Y-m-d H:i:s");

class weCustomerSettings{

	var $db;
	var $table=CUSTOMER_ADMIN_TABLE;
	var $customer;
	var $properties=array();

	var $field_types=array("input"=>"varchar(255)",
							"select"=>"varchar(200)",
							"textarea"=>"text",
							"date"=>"varchar(24)",
							"password"=>"varchar(32)",
							"img"=>"bigint(20)"
	);

	var $default_fields_settings=array("type"=>"input","default"=>"");

	var $FieldAdds=array();
	var $SortView=array();
	var $Prefs=array();

	var $OrderTable=array(
			"ASC"=>"ASC",
			"DESC"=>"DESC"
	);
	var $FunctionTable=array(
			"ALPH1"=>"UPPER(SUBSTRING(%s,1,1))",
			"ALPH2"=>"UPPER(SUBSTRING(%s,1,2))",
			"ALPH3"=>"UPPER(SUBSTRING(%s,1,3))",
			"MINUTE" => "DATE_FORMAT(%s,'%%i')",
			"HOUR" => "DATE_FORMAT(%s,'%%H')",
			"DAY"=>"DAYOFMONTH(%s)",
			"MONTH"=>"MONTH(%s)",
			"YEAR"=>"YEAR(%s)",
			"DAYOFWEEK"=>"DAYOFWEEK(%s)",
			"DAYOFMONTH"=>"DAYOFMONTH(%s)",
			"DAYOFYEAR"=>"DAYOFYEAR(%s)",
			"DAYNAME"=>"DAYNAME(%s)",
			"MONTHNAME"=>"MONTHNAME(%s)",
			"QUARTER"=>"QUARTER(%s)"
	);

	var $TypeFunction=array(
			"ALPH1"=>"input,select,textarea,password",
			"ALPH2"=>"input,select,textarea,password",
			"ALPH3"=>"input,select,textarea,password",
			"MINUTE" => "date",
			"HOUR" => "date",
			"DAY"=>"date",
			"MONTH"=>"date",
			"YEAR"=>"date",
			"DAYOFWEEK"=>"date",
			"DAYOFMONTH"=>"date",
			"DAYOFYEAR"=>"date",
			"DAYNAME"=>"date",
			"MONTHNAME"=>"date",
			"QUARTER"=>"date"
	);

	var $PropertyTitle=array();

	var $MaxSearchResults=99999;

	var $reservedWords=array("select","straight_join","sql_small_result","sql_buffer_result",
       "sql_cache","sql_no_cache","sql_cals_found_rows","high_priority","distinct","distinctrow","all","into",
       "outfile","dumpfile","from","where","group","by","asc","desc","with","rollup","having","order","limit",
       "procedure","for","update","lock","in","share","mode","insert","alter","grant","option","to","require",
       "none","revoke","privileges","password","low_priority","delayed","ignore","values","on","duplicate",
       "key","set","default","where","group","by","order","add","column","table","index","constraint","primary",
       "unique","foreign","change","modify","drop","disable","enable","charachter","collate","first","rename",
       "fulltext","quick","using","truncate",
       "id","username","isfolder","icon","parentid","membersince","lastlogin","lastaccess","path","text","forename","surname","logindenied"
       );

    var $treeTextFormat="#Text";
    var $formatFields=array();

	function weCustomerSettings(){
		global $l_customer;

		$this->db=new DB_WE();
		$this->table=CUSTOMER_ADMIN_TABLE;
		$this->customer=new weCustomer();
		$this->properties=array();

		$this->PropertyTitle=array(
			"Username"=>$l_customer["Username"],
			"Password"=>$l_customer["Password"],
			"Forename"=>$l_customer["Forname"],
			"Surname"=>$l_customer["Surname"],
			"LoginDenied"=>$l_customer["login"],
			"MemberSince"=>$l_customer["MemeberSince"],
			"LastLogin"=>$l_customer["LastLogin"],
			"LastAccess"=>$l_customer["LastAccess"],
			"ID"=>"ID",
		);
		// additional date function
		include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/we_editor_info.inc.php');
		$this->FunctionTable['FORMAT_DATETIME'] = "DATE_FORMAT(%s,'" . str_replace('%','%%',$l_we_editor_info['mysql_date_format']) . "')" ;
		$this->FunctionTable['FORMAT_DATE'] = "DATE_FORMAT(%s,'" . str_replace('%','%%',$l_we_editor_info['mysql_date_only_format']) . "')" ;
		$this->FunctionTable['FORMAT_TIME'] = "DATE_FORMAT(%s,'" . str_replace('%','%%',$l_we_editor_info['mysql_time_only_format']) . "')" ;
		$this->FunctionTable['HOUR'] = "DATE_FORMAT(%s,'%%H')" ;

		$this->TypeFunction['FORMAT_DATETIME'] = 'date';
		$this->TypeFunction['FORMAT_DATE'] = 'date';
		$this->TypeFunction['FORMAT_TIME'] = 'date';
		$this->TypeFunction['HOUR'] = 'date';


		$this->Prefs=array(
										'treetext_format'=>'#Username (#Forename #Surname)',
										'start_year'=>1900,
										'default_sort_view'=>'',
										'default_order' => ''
		);

	}

	function load($tryFromSession=true){

		$this->db->query("SELECT * FROM ".$this->table.";");
		while($this->db->next_record()){
			$this->properties[$this->db->f("Name")]=$this->db->f("Value");
		}

		if(isset($this->properties["SortView"])) $this->SortView=@unserialize($this->properties["SortView"]);
		if(!is_array($this->SortView)) $this->SortView=array();

		if(isset($this->properties["FieldAdds"])) $this->FieldAdds=@unserialize($this->properties["FieldAdds"]);

		$defprefs=$this->Prefs;
		if(isset($this->properties["Prefs"])) $this->Prefs=@unserialize($this->properties["Prefs"]);

		foreach($defprefs as $k=>$v){
			if(!isset($this->Prefs[$k])){
				$this->Prefs[$k]=$v;
			}
		}

		$this->formatFields=array();
		$this->treeTextFormat=$this->Prefs["treetext_format"];
		$field_names=$this->customer->getFieldsDbProperties();
		$field_names=array_keys($field_names);

		foreach($field_names as $fieldname){
			if(ereg("#".$fieldname,$this->treeTextFormat)) $this->formatFields[]=$fieldname;
			$this->treeTextFormat=str_replace("#".$fieldname,'".$ttrow["'.$fieldname.'"]."',$this->treeTextFormat);
		}

	}

	function save() {

		$this->properties["FieldAdds"]=serialize($this->FieldAdds);
		$this->properties["SortView"]=serialize($this->SortView);
		$this->properties["Prefs"]=addslashes(serialize($this->Prefs));

		foreach ($this->properties as $key=>$value) {
			if(f("SELECT Name FROM ".$this->table." WHERE Name='".$key."';","Name",$this->db)==$key) {
				$this->db->query("UPDATE ".$this->table." SET Value='$value' WHERE Name='$key';");
			} else {
				$this->db->query("INSERT INTO ".$this->table." (Name,Value) VALUES ('$key','$value');");
			}
		}

		return true;
	}


	function getPref($pref_name){
		return $this->properties[$pref_name];
	}

	function setPref($pref_name,$pref_value){
		$this->properties[$pref_name]=$pref_value;
	}

	function isFunctionForField($function,$field){
		global $l_customer;

		if(ereg($l_customer["other"],$field)) $field=str_replace($l_customer["other"]."_","",$field);
		$fieldprops=$this->customer->getFieldDbProperties($field);

		$fieldtype=$this->getFieldType($fieldprops["Type"]);
		if($fieldtype!="")
			foreach ($this->TypeFunction as $fk=>$fv){
				$tmp=explode(",",$fv);
				if(($fk==$function) && (in_array($fieldtype,$tmp))) return true;
			}

		return false;

	}

	//returns db field type
	function getDbType($field_type){
		return $this->field_types[$field_type];
	}

	//returns predefined  field type
	function getFieldType($field_type){
		foreach($this->field_types as $k=>$v){
				if($v==$field_type) return $k;
		}
		return "input";
	}

	function getPropertyTitle($prop){
		if(isset($this->PropertyTitle[$prop])) return $this->PropertyTitle[$prop];
		else return $prop;
	}

	function initCustomerWithDefaults(&$customer){
		if(is_array($this->FieldAdds))
		foreach ($this->FieldAdds as $k=>$v){
			if(in_array($k,$customer->persistent_slots) && isset($v["default"])){
				$value=$v["default"];
				$props=$customer->getFieldDbProperties($k);
				if(isset($props["Type"])){
					if($this->getFieldType($props["Type"])=="select"){
						$tmp=explode(",",$value);
						$value=$tmp[0];
					}
				}
				eval('$customer->'.$k.'=$value;');
			}
		}
	}

	//field adds operations
	function storeFieldAdd($fieldName,$addName,$value){
		$this->FieldAdds[$fieldName][$addName]=$value;
	}

	function retriveFieldAdd($fieldName,$addName,$value){
		return $this->FieldAdds[$fieldName][$addName];
	}

	function removeFieldAdd($fieldName){
		$this->new_array_splice($this->FieldAdds,$fieldName);
	}

	function renameFieldAdds($old,$new){
		foreach($this->FieldAdds as $k=>$v){
			if($k==$old){
				$tmp=$this->FieldAdds[$k];
				$this->new_array_splice($this->FieldAdds,$k);
				$this->FieldAdds[$new]=$tmp;
			}
		}
	}
	//field adds operations ends
	function new_array_splice(&$a,$start,$len=1){
		$ks=array_keys($a);
		$k=array_search($start,$ks);
		if($k!==false){
			$ks=array_splice($ks,$k,$len);
			foreach($ks as $k) unset($a[$k]);
		}
	}


	function getMaxSearchResults(){
		return $this->MaxSearchResults;
	}

	/*
		The function returns an associative array containing the date information from given string
		for dates before 1970. The date string should be in given format.
		Equivalent to getdate(strtotime($date) for dates after 1970
	*/
	function getDate($date,$format=DATE_FORMAT){
		$order=array();

		$date_format_table=array(
				"m"=>"([0-9]{2})",
				"n"=>"([0-9]{1,2})",
				"d"=>"([0-9]{2})",
				"j"=>"([0-9]{1,2})",
				"y"=>"([0-9]{2})",
				"Y"=>"([0-9]{4})",
				"H"=>"([0-9]{2})",
				"i"=>"([0-9]{2})",
				"s"=>"([0-9]{2})"
		);



		$new=$format;
		foreach($date_format_table as $k=>$v){
			$pos=strpos($new,$k);
			if($pos!==false){
				$order[$k]=$pos;
				$new=str_replace($k,$v,$new);
			}
		}

		$regex=array();
		if(ereg($new,$date,$regex)){
			asort($order);
			$c=1;
			foreach($order as $ok=>$ov){
				$order[$ok]=$c;
				$c++;
			}

			$ret=array(
				"day"=>"0",
				"month"=>"0",
				"year"=>"0",
				"hour"=>"0",
				"minute"=>"0",
				"second"=>"0"
			);
			if(isset($order["d"])) $ret["day"]=$regex[$order["d"]];
			if(isset($order["m"])) $ret["month"]=$regex[$order["m"]];
			if(isset($order["n"])) $ret["month"]=$regex[$order["n"]];
			if(isset($order["y"])) $ret["year"]=$regex[$order["y"]];
			if(isset($order["Y"])) $ret["year"]=$regex[$order["Y"]];

			if(isset($order["H"])) $ret["hours"]=$regex[$order["H"]];
			if(isset($order["i"])) $ret["minutes"]=$regex[$order["i"]];
			if(isset($order["s"])) $ret["seconds"]=$regex[$order["s"]];

			return $ret;
		}

		return array();
	}

	function isReserved($field){
		return in_array(trim(strtolower($field)),$this->reservedWords);
	}

	function getSettings($settings){
		return isset($this->Prefs[$settings]) ? $this->Prefs[$settings] : "";
	}

}
?>
