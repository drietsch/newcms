<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_ContentTypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/"."we_htmlElement.inc.php");

protect();

if(isset($_REQUEST["we_cmd"][5])){
    $_SESSION["prefs"]["FileFilter"] = $_REQUEST["we_cmd"][5];
}

$table = $_REQUEST["we_cmd"][1];
$parentFolder = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : 0;
$offset = isset($_REQUEST["we_cmd"][6]) ? $_REQUEST["we_cmd"][6] : 0;

//p_r($_REQUEST);

if(isset($_REQUEST["we_cmd"][0]) && $_REQUEST["we_cmd"][0]=="closeFolder"){
			$table = $_REQUEST["we_cmd"][1];
			$parentFolder = isset($_REQUEST["we_cmd"][2]) ? $_REQUEST["we_cmd"][2] : 0;
			$openDirs=makeArrayFromCSV($_SESSION["prefs"]["openFolders_" . substr($table, strlen(TBL_PREFIX))]);
			$openDirs=array_flip($openDirs);
			new_array_splice($openDirs,$parentFolder,1);
			$openDirs=array_keys($openDirs);
			$_SESSION["prefs"]["openFolders_" . substr($table, strlen(TBL_PREFIX))]=makeCSVFromArray($openDirs);
}
else{
$GLOBALS["OBJECT_FILES_TREE_COUNT"] = defined("OBJECT_FILES_TREE_COUNT") ? OBJECT_FILES_TREE_COUNT : 20;

$counts=array();
$parents=array();
$childs=array();
$parentlist = "";
$childlist = "";
$wsQuery = "";

$parentpaths = array();


function getQueryParents($path){
	$out = "";
	while($path != "/" && $path != "\\" && $path){
		$out .= "Path='$path' OR ";
		$path = dirname($path);
	}
	if($out){
		return substr($out,0,strlen($out)-3);
	}else{
		return "";
	}
}


function getItems($ParentID,$offset=0,$segment=0) {
	global $prefs,$table,$openFolders,$parentpaths,$wsQuery,$treeItems,$Tree;



	if($table==TEMPLATES_TABLE && !we_hasPerm("CAN_SEE_TEMPLATES"))
	return 0;
	if($table==FILE_TABLE && !we_hasPerm("CAN_SEE_DOCUMENTS"))
	return 0;
	$prevoffset=$offset-$segment;
	$prevoffset=($prevoffset<0) ? 0 : $prevoffset;
	if($offset && $segment){
				$treeItems[]=array(
										"icon"=>"arrowup.gif",
										"id"=>"prev_".$ParentID,
										"parentid"=>$ParentID,
										"text"=>"display (".$prevoffset."-".$offset.")",
										"contenttype"=>"arrowup",
										"isclassfolder"=>0,
										"isnoteditable"=>0,
										"table"=>$table,
										"checked"=>0,
										"typ"=>"threedots",
										"open"=>0,
										"published"=>0,
										"disabled"=>0,
										"tooltip"=>"",
										"offset"=>$prevoffset
				);
	}

	$DB_WE = new DB_WE;
	$where = " WHERE ";

	$where .= " ParentID=$ParentID ";
	$where .= makeOwnersSql();
	$where .= $wsQuery;

	$elem = "ID,ParentID,Path,Text,IsFolder,Icon,ModDate".(($table==FILE_TABLE || ( defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE )) ? ",Published" : "").(( defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE) ? ",IsClassFolder,IsNotEditable" : "");

	if ($table == FILE_TABLE || $table == TEMPLATES_TABLE) {
		$elem .= ",Extension";
	}

	$tree_count=0;
	if($table == FILE_TABLE || $table == TEMPLATES_TABLE || (defined("OBJECT_TABLE") && $table==OBJECT_TABLE) || (defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE))
	$elem .= ",ContentType";

	$query="SELECT $elem, LOWER(Text) AS lowtext, ABS(REPLACE(Text,'info','')) AS Nr, (Text REGEXP '^[0-9]') AS isNr FROM $table $where ORDER BY IsFolder DESC,isNr DESC,Nr,lowtext".($segment!=0 ? " LIMIT $offset,$segment;" : ";");
	$DB_WE->query($query);

	while($DB_WE->next_record()) {
		$tree_count++;
		$ID = $DB_WE->f("ID");
		$ParentID = $DB_WE->f("ParentID");
		$Text = $DB_WE->f("Text");
		$Path = $DB_WE->f("Path");
		$IsFolder = $DB_WE->f("IsFolder");
		$ContentType = $DB_WE->f("ContentType");
		$Icon = isset($GLOBALS["WE_CONTENT_TYPES"][$ContentType]) ? we_getIcon($ContentType, $DB_WE->f("Extension")) : "link.gif";
		$published = ($table==FILE_TABLE || ( defined("OBJECT_FILES_TABLE") && ($table==OBJECT_FILES_TABLE) ) ) ? ((($DB_WE->f("Published") != 0) && ($DB_WE->f("Published") < $DB_WE->f("ModDate"))) ? -1 : $DB_WE->f("Published")) : 1;
		$IsClassFolder = $DB_WE->f("IsClassFolder");
		$IsNotEditable = $DB_WE->f("IsNotEditable");

		if(in_array($ID,$openFolders)) $OpenCloseStatus=1; else $OpenCloseStatus=0;
		$disabled = in_array($Path,$parentpaths) ? 1 : 0;

		$typ= $IsFolder ? "group" : "item";

		$treeItems[]=array(
										"icon"=>$Icon,
										"id"=>"$ID",
										"parentid"=>$ParentID,
										"text"=>"$Text",
										"contenttype"=>$ContentType,
										"isclassfolder"=>$IsClassFolder,
										"isnoteditable"=>$IsNotEditable,
										"table"=>$table,
										"checked"=>0,
										"typ"=>$typ,
										"open"=>$OpenCloseStatus,
										"published"=>$published,
										"disabled"=>$disabled,
										"tooltip"=>$ID,
										"offset"=>$offset
							);

		if($typ=="group" && $OpenCloseStatus==1) getItems($ID,0,$segment);

	}
	$total=f("SELECT COUNT(*) as total FROM $table $where;","total",$DB_WE);
	$nextoffset=$offset+$segment;
	if($segment && $total>$nextoffset){
			$treeItems[]=array(
									"icon"=>"arrowdown.gif",
									"id"=>"next_".$ParentID,
									"parentid"=>$ParentID,
									"text"=>"display (".$nextoffset."-".($nextoffset+$segment).")",
									"contenttype"=>"arrowdown",
									"isclassfolder"=>0,
									"isnoteditable"=>0,
									"table"=>$table,
									"checked"=>0,
									"typ"=>"threedots",
									"open"=>0,
									"published"=>0,
									"disabled"=>0,
									"tooltip"=>"",
									"offset"=>$nextoffset
			);
	}


}

if($ws = get_ws($table)) {
	$wsPathArray = id_to_path($ws,$table,$DB_WE,false,true);
	foreach($wsPathArray as $path){
		$wsQuery .= " Path like '$path/%' OR ".getQueryParents($path). " OR ";
		while($path != "/" && $path != "\\" && $path){
			array_push($parentpaths,$path);
			$path = dirname($path);
		}
	}

}else if( defined("OBJECT_FILES_TABLE") && $table==OBJECT_FILES_TABLE && (!$_SESSION["perms"]["ADMINISTRATOR"])){
	$ac = getAllowedClasses($DB_WE);
	foreach($ac as $cid){
		$path = id_to_path($cid,OBJECT_TABLE);
		$wsQuery .= " Path like '$path/%' OR Path='$path' OR ";
	}
}

if($wsQuery){
	$wsQuery = substr($wsQuery,0,strlen($wsQuery)-3);
	$wsQuery = " AND ($wsQuery) ";
}

if(isset($_REQUEST["we_cmd"][3])) {
	$openFolders = explode(",",$_REQUEST["we_cmd"][3]);
	$_SESSION["prefs"]["openFolders_".substr($_REQUEST["we_cmd"][4], strlen(TBL_PREFIX))] = $_REQUEST["we_cmd"][3];
}

if(isset($_SESSION["prefs"]["openFolders_" . substr($table, strlen(TBL_PREFIX))])) {
	$openFolders = explode(",", $_SESSION["prefs"]["openFolders_" . substr($table, strlen(TBL_PREFIX))]);
} else {
	$openFolders = array();
}


if($parentFolder) {
	if(!in_array($parentFolder,$openFolders)) {
		array_push($openFolders,$parentFolder);
		$_SESSION["prefs"]["openFolders_" . substr($table, strlen(TBL_PREFIX))] = implode(",",$openFolders);
	}
}


$js = "";
if($_SESSION["we_mode"] != "seem"){

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."weMainTree.inc.php");

$Tree=new weMainTree("webEdition.php","top","top.resize.left.tree","top.load");

$treeItems=array();

getItems($parentFolder,$offset,$Tree->default_segment);

$js='
	if(!'.$Tree->topFrame.'.treeData) {
		' . we_message_reporting::getShowMessageCall("A fatal error occured", WE_MESSAGE_ERROR) . '
	}';

if(!$parentFolder)
		$js.='
		'.$Tree->topFrame.'.treeData.clear();
		'.$Tree->topFrame.'.treeData.add(new '.$Tree->topFrame.'.rootEntry(\''.$parentFolder.'\',\'root\',\'root\',\''.$offset.'\'));
';

$js.=$Tree->getJSLoadTree($treeItems);

$js.='
		first='.$Tree->topFrame.'.firstLoad;
		if(top.firstLoad)
			'.$Tree->topFrame.'.toggleBusy(0);
		else
			'.$Tree->topFrame.'.firstLoad = true;
';
}
$body=we_htmlElement::htmlBody(array("bgcolor"=>"white"));

$head=WE_DEFAULT_HEAD. "\n".we_htmlElement::jsElement($js);

print we_htmlElement::htmlHtml(
			we_htmlElement::htmlHead($head).
			$body
);
}
?>