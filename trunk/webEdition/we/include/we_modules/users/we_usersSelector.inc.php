<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_multiSelector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");

define("FS_SETDIR",5);


class we_usersSelector extends we_multiSelector{
	
	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon";
	var $filter="";
	
	function we_usersSelector($id,
	$table=FILE_TABLE,
	$JSIDName="",
	$JSTextName="",
	$JSCommand="",
	$order="",
	$sessionID="",
	$rootDirID=0,
	$filter="",
	$multiple=true){
		
		$this->we_multiSelector($id,
		$table,
		$JSIDName,
		$JSTextName,
		$JSCommand,
		$order,
		$sessionID,
		$rootDirID,
		$multiple);
				
		$this->filter=$filter;
		$GLOBALS["l_fileselector"]["filename"] = ($this->filter == "group") ? $GLOBALS["l_fileselector"]["groupname"] : $GLOBALS["l_fileselector"]["username"];
	}
	
	function setDefaultDirAndID($setLastDir){
		$this->dir = $setLastDir ? (isset($_SESSION["we_fs_lastDir"][$this->table]) ? abs($_SESSION["we_fs_lastDir"][$this->table]) : 0 ) : 0;
		$foo = getHash("SELECT IsFolder,Text,Path FROM $this->table WHERE ID='".$this->dir."'",$this->db);
		if(isset($foo["IsFolder"]) && $foo["IsFolder"] && $this->dir){
			$this->values = array("ParentID"=>$this->dir,
			"Text"=>$foo["Text"],
			"Path"=>$foo["Path"],
			"IsFolder"=>1);
			$this->path = $foo["Path"];
			$this->id = $this->dir;
		}else{
			$this->dir = 0;
			$this->values = array("ParentID"=>0,
			"Text"=>"",
			"Path"=>"",
			"IsFolder"=>1);
			$this->path = "";
			$this->id = 0;
		}
	}
	
	function printHTML($what=FS_FRAMESET){
		switch($what){
			case FS_HEADER:
			$this->printHeaderHTML();
			break;
			case FS_FOOTER:
			$this->printFooterHTML();
			break;
			case FS_BODY:
			$this->printBodyHTML();
			break;
			case FS_SETDIR:
			$this->printSetDirHTML();
			break;
			case FS_CMD:
			$this->printCmdHTML();
			break;
			case FS_FRAMESET:
			default:
			$this->printFramesetHTML();
		}
	}
	
	
	function getFsQueryString($what){
		return $_SERVER["PHP_SELF"]."?what=$what&table=".$this->table."&id=".$this->id."&order=".$this->order."&filter=".$this->filter;
	}
	
	function query(){
		switch($this->filter){
			case "group":
			$q = " AND IsFolder=1 ";
			break;
			case "noalias":
				$q = " AND Alias='0' ";
			break;			
			default:
			$q="";
		}
		//if(!$_SESSION["perms"]["ADMINISTRATOR"]){
		//	$upid = f("SELECT ParentID FROM ".USER_TABLE." WHERE ID='".$_SESSION["user"]["ID"]."'","ParentID",$this->db);
		//	if($upid) $upath = f("SELECT Path FROM ".USER_TABLE." WHERE ID='".$upid."'","Path",$this->db);
		//	else $upath = "/";
		//}else{
		$upath = "";
		//}
		$this->db->query("SELECT ".$this->fields." FROM ".
		$this->table.
		" WHERE ParentID='".$this->dir."'".
		($upath ? " AND Path LIKE '".$upath."%' " : "").
		$q.($this->order ? (' ORDER BY '.$this->order) : ''));
		
	}
	
	function printFramesetJSFunctionQueryString(){
?>

function queryString(what,id,o){
	if(!o) o=top.order;
	return '<?php print $_SERVER["PHP_SELF"]; ?>?what='+what+'&table=<?php print $this->table; ?>&id='+id+"&order="+o+"&filter=<?php print $this->filter; ?>";
}

<?php
	}
	
	function printFramesetJSsetDir(){
		
		if($this->filter=="user"){
?>
function setDir(id){
	currentDir = id;
	top.fscmd.location.replace(top.queryString(<?php print FS_CMD; ?>,id));
}
<?php

		}else{
			
		?>

	function setDir(id){
		top.fscmd.location.replace(top.queryString(<?php print FS_SETDIR; ?>,id));
	}

<?php
		}
	}
	
	function printSetDirHTML(){
		print '<script>
top.clearEntries();
';
		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();
		
		if(abs($this->dir)==abs($this->rootDirID)){
			print 'top.fsheader.disableRootDirButs();
';
		}else{
			print 'top.fsheader.enableRootDirButs();
';
		}
		
		if($_SESSION["perms"]["ADMINISTRATOR"]) $go=true;
		else{
			$rootID=f("SELECT ParentID FROM ".USER_TABLE." WHERE ID='".$_SESSION["user"]["ID"]."'","ParentID",$this->db);
			$rootPath=f("SELECT Path FROM ".USER_TABLE." WHERE ID='".$rootID."'","Path",$this->db);
			$this->db->query("SELECT ID FROM ".USER_TABLE." WHERE ID='".$this->dir."' AND Path LIKE '".$rootPath."%'");
			if($this->db->next_record()) $go=true; else $go=false;
		}
		if($go){
			if($this->id==0) $this->path="/";
			print 'top.currentPath = "'.$this->path.'";
top.currentID = "'.$this->id.'";
top.fsfooter.document.we_form.fname.value = "'.$this->values["Text"].'";
';
		}
		$_SESSION["we_fs_lastDir"][$this->table] = $this->dir;
		print 'top.currentDir = "'.$this->dir.'";
top.parentID = "'.$this->values["ParentID"].'";
';
		print '</script>';
	}
	
	function printFramesetSelectFileHTML(){
?>	

function selectFile(id){
	if(id){
		e=top.getEntry(id);
<?php if($this->filter=="user"): ?>

		if(!e.isFolder){
		
<?php endif ?>
			
		
		
		if( top.fsfooter.document.we_form.fname.value != e.text &&
			top.fsfooter.document.we_form.fname.value.indexOf(e.text+",") == -1 && 
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 ){
		
				top.fsfooter.document.we_form.fname.value =  top.fsfooter.document.we_form.fname.value ?
																(top.fsfooter.document.we_form.fname.value + "," + e.text) :
																e.text;
		}
		top.fsbody.document.getElementById("line_"+id).style.backgroundColor="#DFE9F5";
		currentPath = e.path;
		currentID = id;

<?php if($this->filter=="user"): ?>

		}

<?php endif ?>

	}else{
		top.fsfooter.document.we_form.fname.value = "";
		currentPath = "";
	}
}


<?php
	}

	function printFooterTable() {
		$we_button = new we_button();
		print '
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="5"><img src="'.IMAGE_DIR.'umr_h_small.gif" width="100%" height="2" border="0"></td>
				</tr>
				<tr>
					<td colspan="5">'.getPixel(5,5).'</td>
				</tr>';
		$cancel_button = $we_button->create_button("cancel", "javascript:top.exit_close();");		
		$yes_button = $we_button->create_button("ok", "javascript:press_ok_button();");
		$buttons = $we_button->position_yes_no_cancel(
												$yes_button,
												null,
												$cancel_button);
		print '
				<tr>
					<td></td>
					<td class="defaultfont">
						<b>'.$GLOBALS["l_fileselector"]["name"].'</b>
					</td>
					<td></td>
					<td class="defaultfont" align="left">'.htmlTextInput("fname",24,$this->values["Text"],"","style=\"width:100%\" readonly=\"readonly\"").'
					</td>
					<td></td>
				</tr>
				<tr>
					<td width="10">'.getPixel(10,5).'</td>
					<td width="70">'.getPixel(70,5).'</td>
					<td width="10">'.getPixel(10,5).'</td>
					<td>'.getPixel(5,5).'</td>
					<td width="10">'.getPixel(10,5).'</td>
				</tr>
			</table><table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td align="right">'.$buttons.'</td>
					<td width="10">'.getPixel(10,5).'</td>
				</tr>
			</table>';
	}


}
?>