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
include_once(WE_USERS_MODULE_DIR . "we_users.inc.php");


function getGroupList($id){
   $ret=array();
   if($id){
    $db_tmp=new DB_WE;
    $db_tmp->query("SELECT ID,username WHERE ParentID='".$id."' AND Type=1");
    while($db_tmp->next_record()){
        $ret[$db_tmp->f("ID")]=$db_tmp->f("username");
        $section=array();
        $section=getGroupList($db_tmp->f("ID"));
        $ret=array_merge($ret,$section);
    }
   }
   return $ret;
}

function getUserTree($id){
    $ret=array();
    $db_tmp=new DB_WE;
    $db_tmp->query("SELECT ID,username,Type WHERE ParentID='".$id."'");
    while($db_tmp->next_record()){
        $ret[$db_tmp->f("ID")]["name"]=$db_tmp->f("username");
        $ret[$db_tmp->f("ID")]["ParentID"]=$id;
        $ret[$db_tmp->f("ID")]["Type"]=$db_tmp->f("Type");
        $section=array();
        $section=getUserTree($db_tmp->f("ID"));
        $ret=array_merge($ret,$section);
    }
    return $ret;
}


function isUserInUsers($uid,$users){  // $users can be a csv string or an array
	if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
	if(!is_array($users)){
		$users = makeArrayFromCSV($users);
	}

	if(in_array($uid,$users)){
		return true;
	}else{
		$db = new DB_WE();

		$aliases=array();
		we_getAliases($uid,$aliases,$db);
      foreach($aliases as $aid)if(in_array($aid,$users)) return true;

		for($i=0;$i<sizeof($users);$i++){
			$isGroup = f("SELECT IsFolder FROM ".USER_TABLE." WHERE ID='".$users[$i]."'","IsFolder",$db);
			if($isGroup){
				if (isUserInGroup($uid,$users[$i])){
					return true;
				}
				foreach($aliases as $aid)if(isUserInGroup($aid,$users[$i])) return true;
			}
		}

	}

	return false;

}

function isUserInGroup($uid,$groupID,$db=""){
	if(!$db) $db = new DB_WE();
	$pid = f("SELECT ParentID FROM ".USER_TABLE." WHERE ID='".$uid."'","ParentID",$db);
	if($pid == $groupID){
		return true;
	}else if($pid != 0){
		return isUserInGroup($pid,$groupID);
	}else{
		return false;
	}
}

function addAllUsersAndGroups($uid,&$arr){
	$db = new DB_WE();
	$db->query("SELECT ID,IsFolder FROM ".USER_TABLE." WHERE ParentID='".$uid."'");
	while($db->next_record()){
		array_push($arr,$db->f("ID"));
		if($db->f("IsFolder")){
			addAllUsersAndGroups($db->f("ID"),$arr);
		}
	}
}



function removeNonAsociative(&$array)
{
	if (!is_array($array)) return $array;

	reset($array);

	while(list($k) = each($array))
		if ((string)(int)$k == $k) unset($array[$k]);

	return $array;
}

function getUsersForDocWorkspace($id,$wsField="workSpace") {

	$db = new DB_WE();
	if (is_array($id)){
		$ids = $id;
	} else {
		$ids = array($id);
	}

	$where = array();
	foreach($ids as $id) {
		$where[] = $wsField.' LIKE "%,' . $id . ',%"';
	}

	$out = array();

	$db->query('SELECT ID,username FROM ' . USER_TABLE . ' WHERE '. implode(' OR ',$where));

	while ($db->next_record()) {
		$out[$db->f('ID')] = $db->f('username');
	}

	return $out;

}


?>