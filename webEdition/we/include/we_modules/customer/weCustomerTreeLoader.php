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

define("CUSTOMER_ITEMS",1);
define("CUSTOMER_SORT_ITEMS",2);
define("ADMIN_ITEMS",3);

class weCustomerTreeLoader{

	function getItems($pid,$offset=0,$segment=500,$sort=""){
		$db=new DB_WE();
		if($sort!="") return weCustomerTreeLoader::getSortFromDB($pid,$sort,$offset,$segment);
		else return weCustomerTreeLoader::getItemsFromDB($pid,$offset,$segment);

	}


	function getItemsFromDB($ParentID=0,$offset=0,$segment=500,$elem="ID,ParentID,Path,Text,Icon,IsFolder,Forename,Surname",$addWhere="",$addOrderBy=""){
		$db=new DB_WE();
		$table=CUSTOMER_TABLE;

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
										"table"=>CUSTOMER_TABLE,
										"typ"=>"threedots",
										"open"=>0,
										"published"=>0,
										"disabled"=>0,
										"tooltip"=>"",
										"offset"=>$prevoffset
				);
		}

		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerSettings.php");
		$settings=new weCustomerSettings();
		$settings->load();


		$where=" WHERE ParentID=$ParentID ".$addWhere;

		$_formatFields=implode(',',$settings->formatFields);
		if($_formatFields!=''){
			$_formatFields.=',';
		}

		$_order = '';
		if(!empty($settings->Prefs['default_order'])){

			if($_formatFields!=''){
				$_order = implode(' ' . $settings->Prefs['default_order'] . ',' , $settings->formatFields) . ' ' . $settings->Prefs['default_order'];
			} else {
				$_order = 'Text ' . $settings->Prefs['default_order'];
			}
		}

		$query = "SELECT $_formatFields $elem FROM $table $where " . (!empty($_order) ? "ORDER BY $_order" : '') . ($segment ?  " LIMIT $offset,$segment;" : ";" );
		$db->query($query);

		while($db->next_record()){

			if($db->f("IsFolder")==1) $typ=array("typ"=>"group");
			else $typ=array("typ"=>"item");

			$typ["disabled"]=0;
			$typ["tooltip"]=$db->f("ID");
			$typ["offset"]=$offset;

			$tt="";
			$ttrow=$db->Record;
			eval('$tt="'.$settings->treeTextFormat.'";');

			$fileds=array();

			foreach($db->Record as $k=>$v) {
				if(!is_numeric($k)) $fileds[strtolower($k)]=$v;
			}

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
									"table"=>CUSTOMER_TABLE,
									"typ"=>"threedots",
									"open"=>0,
									"disabled"=>0,
									"tooltip"=>"",
									"offset"=>$nextoffset
			);
		}

		return $items;

	}

	function getSortFromDB($pid,$sort,$offset=0,$segment=500){
		global $l_customer;

		$db=new DB_WE();

		include_once(WE_CUSTOMER_MODULE_DIR."weCustomerSettings.php");

		$table=CUSTOMER_TABLE;

		$fieldarr=array();

		$havingarr=array();
		$pidarr=array();
		$check=array();
		$level=0;

		$notroot = (ereg("\{.\}",$pid)) ? true : false;

		$pid=str_replace("{","",$pid);
		$pid=str_replace("}","",$pid);
		$pid=str_replace("*****quot*****","\\\\\'",$pid);
		
		if($pid || $notroot){
			$pidarr=explode("-|-",$pid);
			$tmp="";
		}

		$settings=new weCustomerSettings();
		$settings->load(false);

		$sort_defs=$settings->SortView[$sort];

		$c=0;
		$select = array();
		$grouparr = array();
		$orderarr = array();

		foreach($sort_defs as $sortdef){
			if($sortdef["function"]){
				if($settings->customer->isInfoDate($sortdef["field"])){
					$select[]=sprintf($settings->FunctionTable[$sortdef["function"]],"FROM_UNIXTIME(".$sortdef["field"].")")." AS ".$sortdef["field"]."_".$sortdef["function"];
				}
				else {
					$select[]=sprintf($settings->FunctionTable[$sortdef["function"]],$sortdef["field"])." AS ".$sortdef["field"]."_".$sortdef["function"];
				}
				$grouparr[]=$sortdef["field"]."_".$sortdef["function"];
				$orderarr[]=$sortdef["field"]."_".$sortdef["function"]." ".$sortdef["order"];
				$orderarr[]=$sortdef["field"]." ".$sortdef["order"];
				if(isset($pidarr[$c]))
					if($pidarr[$c]==$l_customer["no_value"])
						$havingarr[]="(".$sortdef["field"]."_".$sortdef["function"]."='' OR ".$sortdef["field"]."_".$sortdef["function"]." IS NULL)";
					else
						$havingarr[]=$sortdef["field"]."_".$sortdef["function"]."='".$pidarr[$c]."'";
			}
			else{
				$select[]=$sortdef["field"];
				$grouparr[]=$sortdef["field"];
				$orderarr[]=$sortdef["field"]." ".$sortdef["order"];
				if(isset($pidarr[$c]) && $pidarr[$c])
					if($pidarr[$c]==$l_customer["no_value"])
						$havingarr[]="(".$sortdef["field"]."='' OR ".$sortdef["field"]." IS NULL)";
					else
						$havingarr[]=$sortdef["field"]."='".$pidarr[$c]."'";
			}
			$c++;
		}

		$level=count($pidarr);
		$levelcount=count($grouparr);


		$grp=isset($grouparr[0]) ? $grouparr[0] : null;

		if($level!=0) for($i=1;$i<$level;$i++) $grp.=",".$grouparr[$i];

		$_formatFields=implode(',',$settings->formatFields);
		if($_formatFields!=''){
			$_formatFields.=',';
		}

		$items=array();

		$_order = '';
		if(!empty($settings->Prefs['default_order'])){

			if($_formatFields!=''){
				$_order = implode(' ' . $settings->Prefs['default_order'] . ',' , $settings->formatFields) . ' ' . $settings->Prefs['default_order'];
			} else {
				$_order = 'Text ' . $settings->Prefs['default_order'];
			}
		}

		$query="SELECT $_formatFields ID,ParentID,Path,Text,Icon,IsFolder,Forename,Surname".(count($select) ? ",".implode(",",$select) : "")." FROM ".$table." GROUP BY ".$grp.(count($grouparr) ? ($level!=0 ? ",ID" : "") : "ID").(count($havingarr) ? " HAVING ".implode(" AND ",$havingarr) : "")." ORDER BY ".implode(",",$orderarr).(!empty($_order) ? (',' .$_order) : '' ).(($level==$levelcount && $segment) ? " LIMIT $offset,$segment;" : ";");

		$db->query($query);

		$sortarr=array();
		$foo=array();
		$gname="";
		$old="0";
		$first=true;

		while($db->next_record()){

			$old=0;

			if($level==0){
					$gname=$db->f($grouparr[0])!="" ? $db->f($grouparr[0]) : $l_customer["no_value"];
					$gid="{".$gname."}";

					$items[]=array(
												"id"=>str_replace("\'","*****quot*****",$gid),
												"parentid"=>$old,
												"path"=>"",
												"text"=>$gname,
												"icon"=>"folder.gif",
												"isfolder"=>1,
												"typ"=>"group",
												"disabled"=>"0",
												"open"=>"0"
					);
					$check[$gname]=1;
			}
			else{
				$foo=array();
				for($i=0;$i<$levelcount;$i++){
					if($i==0) $foo[]="{".($db->f($grouparr[$i])!="" ? $db->f($grouparr[$i]) : $l_customer["no_value"])."}";
					else $foo[]=$db->f($grouparr[$i])!="" ? $db->f($grouparr[$i]) : $l_customer["no_value"];
					$gname=implode("-|-",$foo);
					if($i>=$level){
						if(!isset($check[$gname])){
							$items[]=array(
														"id"=>$gname,
														"parentid"=>$old,
														"path"=>"","text"=>($db->f($grouparr[$i])!="" ? $db->f($grouparr[$i]) : $l_customer["no_value"]),
														"icon"=>"folder.gif",
														"isfolder"=>1,
														"typ"=>"group",
														"disabled"=>"0",
														"open"=>"0"
							);
							$check[$gname]=1;
						}
					}
					$old=$gname;
				}
				$gname=implode("-|-",$foo);
				if($level==$levelcount){
					$tt="";
					$ttrow=$db->Record;
					eval('$tt="'.$settings->treeTextFormat.'";');

					if($first){
								$prevoffset=$offset-$segment;
								$prevoffset=($prevoffset<0) ? 0 : $prevoffset;
								if($offset && $segment){
									$items[]=array(
										"icon"=>"arrowup.gif",
										"id"=>"prev_".$gname,
										"parentid"=>$gname,
										"text"=>"display (".$prevoffset."-".$offset.")",
										"contenttype"=>"arrowup",
										"table"=>CUSTOMER_TABLE,
										"typ"=>"threedots",
										"open"=>0,
										"published"=>0,
										"disabled"=>0,
										"tooltip"=>"",
										"offset"=>$prevoffset
									);
								}
								$first=false;
					}
					$items[]=array(
								"id"=>$db->f("ID"),
								"parentid"=>str_replace("\'", "*****quot*****", $gname),
								"path"=>"",
								"text"=>trim($tt)!="" ? $tt : $db->f("Text"),
								"icon"=>$db->f("Icon"),
								"isfolder"=>$db->f("IsFolder"),
								"typ"=>"item",
								"disabled"=>"0",
								"tooltip"=>$db->f("ID")
					);

				}
			}
		}

		if($level==$levelcount){
			$q="SELECT COUNT(ID) as total ".(count($select) ? ",".implode(",",$select) : "")." FROM ".$table." GROUP BY ".$grp.(count($grouparr) ? ($level!=0 ? ",ID" : "") : "ID").(count($havingarr) ? " HAVING ".implode(" AND ",$havingarr) : "")." ORDER BY ".implode(",",$orderarr).";";
			$db->query($q);
			$total=$db->affected_rows();

			$nextoffset=$offset+$segment;
			if($segment && ($total>$nextoffset)){
				$items[]=array(
									"icon"=>"arrowdown.gif",
									"id"=>"next_".str_replace("\'", "*****quot*****", $old),
									"parentid"=>str_replace("\'", "*****quot*****", $old),
									"text"=>"display (".$nextoffset."-".($nextoffset+$segment).")",
									"contenttype"=>"arrowdown",
									"table"=>CUSTOMER_TABLE,
									"typ"=>"threedots",
									"open"=>0,
									"disabled"=>0,
									"tooltip"=>"",
									"offset"=>$nextoffset
				);
			}
		}
		
		return $items;

	}

}


?>