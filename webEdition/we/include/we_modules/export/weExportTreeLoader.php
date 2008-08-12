<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");

define("EXPORT_ITEMS",1);
define("EXPORT_SORT_ITEMS",2);
define("ADMIN_ITEMS",3);

class weExportTreeLoader{

	function getItems($pid,$offset=0,$segment=500,$sort=""){
		return weExportTreeLoader::getItemsFromDB($pid,$offset,$segment);

	}


	function getItemsFromDB($ParentID=0,$offset=0,$segment=500,$elem="ID,ParentID,Path,Text,Icon,IsFolder",$addWhere="",$addOrderBy=""){
		$db=new DB_WE();
		$table=EXPORT_TABLE;
		
		$items=array();
		
		$prevoffset=$offset-$segment;
		$prevoffset=($prevoffset<0) ? 0 : $prevoffset;
		if($offset && $segment){	
				$items[]=array(
										"icon"=>"arrowup.gif",
										"id"=>"prev_".$ParentID,
										"parentid"=>$ParentID,
										"text"=>"display (".$prevoffset."-".$offset.")",
										"contenttype"=>"arrowup",
										"table"=>EXPORT_TABLE,
										"typ"=>"threedots",
										"open"=>0,
										"published"=>0,
										"disabled"=>0,
										"tooltip"=>"",
										"offset"=>$prevoffset
				);	
		}		
		


		
		$where=" WHERE ParentID=$ParentID ".$addWhere;

		$db->query("SELECT $elem, abs(text) as Nr, (text REGEXP '^[0-9]') as isNr from $table $where ORDER BY isNr DESC,Nr,Text " . ($segment ?  "LIMIT $offset,$segment;" : ";" ));
		
		while($db->next_record()){

			if($db->f("IsFolder")==1) $typ=array("typ"=>"group");
			else $typ=array("typ"=>"item");

			$typ["open"]=0;
			$typ["disabled"]=0;
			$typ["tooltip"]=$db->f("ID");
			$typ["offset"]=$offset;
			
			$tt="";
			//$ttrow=getHash("SELECT * FROM ".RAW_TABLE." WHERE ID='".$db->f("ID")."';",new DB_WE());
			$ttrow=$db->Record;

			$fileds=array();

			foreach($db->Record as $k=>$v)
				if(!is_numeric($k)) $fileds[strtolower($k)]=$v;

			$fileds["text"] = trim($tt)!="" ? $tt : $db->f("Text");
			$items[]=array_merge($fileds,$typ);
			
		}
		
		$total=f("SELECT COUNT(*) as total FROM $table $where;","total",$db);
		$nextoffset=$offset+$segment;
		if($segment && ($total>$nextoffset)){
			$items[]=array(
									"icon"=>"arrowdown.gif",
									"id"=>"next_".$ParentID,
									"parentid"=>0,
									"text"=>"display (".$nextoffset."-".($nextoffset+$segment).")",
									"contenttype"=>"arrowdown",
									"table"=>EXPORT_TABLE,
									"typ"=>"threedots",
									"open"=>0,
									"disabled"=>0,
									"tooltip"=>"",
									"offset"=>$nextoffset
			);		
		}		
		
		return $items;

	}


}


?>