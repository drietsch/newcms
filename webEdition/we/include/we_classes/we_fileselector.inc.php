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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_browserDetect.inc.php");

protect();

define("FS_FRAMESET",0);
define("FS_HEADER",1);
define("FS_FOOTER",2);
define("FS_BODY",3);
define("FS_CMD",4);


class we_fileselector{


	var $dir=0;
	var $id=0;
	var $path="/";
	var $lastdir="";
	var $table = FILE_TABLE;
	var $tableSizer = "";
	var $tableHeadlines = "";
	var $JSCommand="";
	var $JSTextName;
	var $JSIDName;
	var $db;
	var $sessionID="";
	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon";
	var $values = array();
	var $openerFormName="we_form";
	var $order = "IsFolder DESC, Text";
	var $canSelectDir=true;
	var $rootDirID=0;
	var $filter="";
	var $col2js;


	function we_fileselector($id,
		$table = FILE_TABLE,
		$JSIDName="",
		$JSTextName="",
		$JSCommand="",
		$order="",
		$sessionID="",
		$rootDirID=0,
		$filter=""){

		if(!isset($_SESSION["we_fs_lastDir"])){
			$_SESSION["we_fs_lastDir"] = array();
			$_SESSION["we_fs_lastDir"][$table] = 0;
		}
		if($order) $this->order = $order;
		$this->db = new DB_WE();
		$this->id = $id;
		$this->lastDir = isset($_SESSION["we_fs_lastDir"][$table]) ? abs($_SESSION["we_fs_lastDir"][$table]) : 0;
		$this->table = $table;
		$this->JSIDName = $JSIDName;
		$this->JSTextName = $JSTextName;
		$this->JSCommand = $JSCommand;
		$this->rootDirID = abs($rootDirID);
		$this->sessionID = $sessionID;
		$this->filter = $filter;
		//if($this->sessionID) session_id($this->sessionID);
		$this->setDirAndID();
		$this->setTableLayoutInfos();

	}


	function setDirAndID(){
		$id=$this->id;
		if($id == "0" && strlen($id)){
			$this->setDefaultDirAndID(false);
			return;
		}
		if($id != ""){
			// get default Directory
			$this->db->query("SELECT ".$this->fields. "
								FROM ".$this->table."
								WHERE ID='$id'");

			// getValues of selected Dir
			if($this->db->next_record()){
				$this->values = $this->db->Record;

				if($this->values["IsFolder"]){
					$this->dir = $id;
				}else{
					$this->dir = $this->values["ParentID"];
				}
				$this->path = $this->values["Path"];
				return;
			}else{
				$this->setDefaultDirAndID(false);
			}
		}else{
			$this->setDefaultDirAndID(true);
		}

	}
	
	function setDefaultDirAndID($setLastDir){
		
		$this->dir = $setLastDir ? ( isset($_SESSION["we_fs_lastDir"][$this->table]) ? abs($_SESSION["we_fs_lastDir"][$this->table]) : 0 ) : 0;
		$this->id = $this->dir;
		
		$this->path = "";

		$this->values = array(
			"ParentID"=>0,
			"Text"=>"/",
			"Path"=>"/",
			"IsFolder"=>1
		);
	}
	
	function isIDInFolder($ID,$folderID,$db=""){
		if($folderID==$ID) return true;
		if(!$db) $db = new DB_WE();
		$pid = f("SELECT ParentID FROM ".$this->table." WHERE ID='".$ID."'","ParentID",$db);
		if($pid == $folderID){
			return true;
		}else if($pid != 0){
			return $this->isIDInFolder($pid,$folderID);
		}else{
			return false;
		}
	}

	function query(){
		global $_isp_hide_files;	//	ISP_VERSION

		//	Changes for ISP_VERSION
		//	dont show files, folders given in $_isp_hide_files

		$this->db->query(
			"SELECT ".$this->fields."
			FROM ". $this->table ."
			WHERE ParentID='".$this->dir."' " .
			( ($this->filter != "" ? ($this->table == CATEGORY_TABLE ? "AND IsFolder = '".$this->filter."' " : "AND ContentType = '".$this->filter."' ") : '' ) ).
			( ((defined('ISP_VERSION') && ISP_VERSION) && is_array($_isp_hide_files) && sizeof($_isp_hide_files) > 0) ? "AND Path NOT IN ('" . implode("','", $_isp_hide_files) . "')" : '').
			($this->order ? (' ORDER BY '.$this->order) : ''));
		$_SESSION["we_fs_lastDir"][$this->table] = $this->dir;
	}

	function next_record(){
		return $this->db->next_record();
	}

	function f($key){
		return $this->db->f($key);
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
			case FS_CMD:
			$this->printCmdHTML();
			break;
			case FS_FRAMESET:
			default:
			$this->printFramesetHTML();
		}
	}

	##############################################
	############ FRAMESET FUNCTIONS ##############
	##############################################
	function printFramesetJavaScriptIncludes(){
		// overwrite
	}

	function printFramesetRootDirFn(){
		print 'function setRootDir(){
	setDir(0);
}
';
	}

	function getExitClose(){
		return '	function exit_close(){
		if(top.opener.top.opener && top.opener.top.opener.top.toggleBusy){
			top.opener.top.opener.top.toggleBusy();
		}else if(top.opener.top.toggleBusy){
			top.opener.top.toggleBusy();
		}
		self.close();
	}
';
	}
	
	function getJS_keyListenerFunctions() {
		
		return "
		function applyOnEnter(evt) {
			
			_elemName = \"target\";
			if ( typeof(evt[\"srcElement\"]) != \"undefined\" ) { // IE
				_elemName = \"srcElement\";
			}
			
			if (	!( evt[_elemName].tagName == \"SELECT\" ||
					 ( evt[_elemName].tagName == \"INPUT\" && evt[_elemName].name != \"fname\" )
				) ) {
				top.fsfooter.press_ok_button();
				return true;
			}
			
		}
		
		function closeOnEscape() {
			top.exit_close();
			
		}
		";
		
	}
	

	function printFramesetHTML(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_browser_check.inc.php");
		htmltop();
		print we_htmlElement::jsElement("", array("src" => JS_DIR . "keyListener.js" ));
		print we_htmlElement::jsElement("var weSelectorWindow = true;");
		$this->printFramesetJavaScriptIncludes();
		print $this->getFramesetJavaScriptDef();
		print $this->getJS_keyListenerFunctions();
		print $this->getExitClose();
		print '	function in_array(needle,haystack){
		for(var i=0;i<haystack.length;i++){
			if(haystack[i] == needle) return true;
		}
		return false;
	}
';
		print $this->getExitOpen();
		$this->printFramesetJSDoClickFn();
		$this->printFramesetJSsetDir();
?>
function orderIt(o){
	if(order == o){
		order=o+" DESC";
	}else{
		order=o;
	}
	top.fscmd.location.replace(top.queryString(<?php print FS_CMD; ?>,top.currentDir,order));
}
<?php
$this->printFramesetRootDirFn();
?>

function goBackDir(){
	setDir(parentID);
}

function getEntry(id){
	for(var i=0;i<entries.length;i++){
		if(entries[i].ID == id) return entries[i];
	}
	return new entry(0,"","/",1,"/");
}

<?php

$this->printFramesetSelectFileHTML();
$this->printFramesetUnselectFileHTML();
$this->printFramesetSelectFilesFromHTML();
$this->printFramesetGetFirstSelectedHTML();
$this->printFramesetGetPositionByIDHTML();
$this->printFramesetIsFileSelectedHTML();
$this->printFramesetUnselectAllFilesHTML();

?>

function cutText(text,l){
	if(text.length > l){
		return text.substring(0,l-8) + '...' + text.substring(text.length-5,text.length);
	}else{
		return text;
	}
}

<?php

print $this->printFramesetJSFunctions();
print '    self.focus();

</script>
</head>

';
print $this->getFrameset();

	}

	function printFramesetUnselectFileHTML(){}
	function printFramesetSelectFilesFromHTML(){}
	function printFramesetGetFirstSelectedHTML(){}
	function printFramesetGetPositionByIDHTML(){}
	function printFramesetIsFileSelectedHTML(){}
	function printFramesetUnselectAllFilesHTML(){}

function printFramesetSelectFileHTML(){

		?>

function selectFile(id){
	e = getEntry(id);
	top.fsfooter.document.we_form.fname.value = e.text;
	currentText = e.text;
	currentPath = e.path;
	currentID = id;
}

<?php
	}

	function getFramesetJavaScriptDef(){
		$startPathQuery = new DB_WE();
		$startPathQuery->query("SELECT Path FROM ".$this->table." WHERE ID='".$this->dir."'");
		$startPath = $startPathQuery->next_record() ? $startPathQuery->f('Path') : "/";

		return '<script language="JavaScript" type="text/javascript">
	var currentID="'.$this->id.'";
	var currentDir="'.$this->dir.'";
	var currentPath="'.$this->path.'";
	var currentText="'.$this->values["Text"].'";
	var currentType="'.(isset($this->filter) ? $this->filter : "").'";
	
	var startPath="'.$startPath.'";
	
	var parentID="'.
	($this->dir ?
	    f("SELECT ParentID FROM $this->table WHERE ID='".$this->dir."'","ParentID",$this->db) :
	    0).'";
    var table="'.$this->table.'";
	var order="'.$this->order.'";

	var entries = new Array();

	var clickCount=0;
	var wasdblclick=0;
	var tout=null;
	var mk=null;
';
	}

	function getFrameset(){
		return '<frameset rows="67,*,65,0" border="0">
	<frame src="'.$this->getFsQueryString(FS_HEADER).'" name="fsheader" noresize scrolling="no">
    <frame src="'.$this->getFsQueryString(FS_BODY).'" name="fsbody" noresize scrolling="auto">
    <frame src="'.$this->getFsQueryString(FS_FOOTER).'"  name="fsfooter" noresize scrolling="no">
    <frame src="'.HTML_DIR.'white.html"  name="fscmd" noresize scrolling="no">
</frameset>
<body>
</body>
</html>
';
	}

	function getExitOpen(){
		$out = '	function exit_open(){
';
		if($this->JSIDName){
			$out .= '		opener.'.$this->JSIDName.'=currentID;
';
		}
		if($this->JSTextName){
			$frameRef = strpos($this->JSTextName,".document.")>0 ? substr($this->JSTextName,0,strpos($this->JSTextName,".document.")+1) : "";
			$out .= 'opener.'.$this->JSTextName.'= currentID ? currentPath : "";
					if((!!opener.parent) && (!!opener.parent.frames[0]) && (!!opener.parent.frames[0].setPathGroup)) {
						switch(currentType){
							case "noalias":
								setTabsCurPath = "@"+currentText;									
								break;
							default:
								setTabsCurPath = currentPath;								
						}
						if(getEntry(currentID).isFolder) opener.parent.frames[0].setPathGroup(setTabsCurPath);
						else opener.parent.frames[0].setPathName(setTabsCurPath);
						opener.parent.frames[0].setTitlePath();
					}
					if(!!opener.'.$frameRef.'YAHOO && !!opener.'.$frameRef.'YAHOO.autocoml) {  opener.'.$frameRef.'YAHOO.autocoml.selectorSetValid(opener.'.str_replace('.value','.id',$this->JSTextName).'); } 
					';			
		}
		if($this->JSCommand){
			$out .= '	'.str_replace('WE_PLUS','+',$this->JSCommand).';

';
		}
		$out .= '	self.close();

';
		$out .= "	}\n";
		return $out;
	}

	############################################

	function printFramesetJSDoClickFn(){
?>
function doClick(id,ct){
	if(ct==1){
		if(wasdblclick){
			setDir(id);
			setTimeout('wasdblclick=0;',400);
		}
	}else{
		selectFile(id);
	}
}
<?php
	}

	############################################

	function printFramesetJSsetDir(){
?>
function setDir(id){
	e = getEntry(id);
	currentID = id;
	currentDir = id;
	currentPath = e.path;
	currentText = e.text;
	top.fsfooter.document.we_form.fname.value = e.text;
	top.fscmd.location.replace(top.queryString(<?php print FS_CMD; ?>,id));
}


<?php
	}

	############################################


	function getFsQueryString($what){
		return $_SERVER["PHP_SELF"]."?what=$what&table=".$this->table."&id=".$this->id."&order=".$this->order."&filter=".$this->filter;
	}

	function printFramesetJSFunctionQueryString(){
?>

function queryString(what,id,o){
	if(!o) o=top.order;
	return '<?php print $_SERVER["PHP_SELF"]; ?>?what='+what+'&table=<?php print $this->table; ?>&id='+id+"&order="+o+"&filter=<?php print $this->filter; ?>";
}

<?php
	}

	function printFramesetJSFunctioWriteBody(){
		global $BROWSER;
		$htmltop = ereg_replace("[[:cntrl:]]","",trim(str_replace("'","\\'",getHtmlTop())));
		$htmltop = str_replace('script', "scr' + 'ipt", $htmltop);
?>

function writeBody(d){
	d.open();
	d.writeln('<html><head>');
	d.writeln('<?php print STYLESHEET_SCRIPT; ?>');
	d.writeln('</head>');
	d.writeln('<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">');
	d.writeln('<table border="0" cellpadding="0" cellspacing="0">');
	for(i=0;i < entries.length; i++){
		d.writeln('<tr>');
		d.writeln('<td class="selector" align="center">');
		var link = '<a title="'+entries[i].text+'" href="javascript://"';
		if(entries[i].isFolder){
			link += ' onDblClick="this.blur();top.wasdblclick=1;clearTimeout(tout);top.doClick('+entries[i].ID+',1);return true;"';
		}
		link += ' onClick="this.blur();tout=setTimeout(\'if(top.wasdblclick==0){top.doClick('+entries[i].ID+',0);}else{top.wasdblclick=0;}\',300);return true">'+"\n";
		d.writeln(link+'<img src="<?php print ICON_DIR; ?>'+entries[i].icon+'" width="16" height="18" border="0"></a>');
		d.writeln('</td>');
		d.writeln('<td class="selector" title="'+entries[i].text+'">');
		d.writeln(link+cutText(entries[i].text,70)+'</a>');
		d.writeln('</td></tr>');
	d.writeln('<tr>');
	d.writeln('<td width="25"><?php print getPixel(25,2)?></td>');
	d.writeln('<td><?php print getPixel(200,2)?></td></tr>');
	}
	d.writeln('</table></body>');
	d.close();
}

<?php

	}

	function printFramesetJSFunctionEntry(){
?>

function entry(ID,icon,text,isFolder,path){
	this.ID=ID;
	this.icon=icon;
	this.text=text;
	this.isFolder=isFolder;
	this.path=path;
}

<?php
	}

	function printFramesetJSFunctionAddEntry(){
?>

function addEntry(ID,icon,text,isFolder,path){
	entries[entries.length] = new entry(ID,icon,text,isFolder,path);
}

<?php
	}

	function printFramesetJSFunctionClearEntry(){
?>

function clearEntries(){
	entries = new Array();
}

<?php
	}

	function printFramesetJSFunctionAddEntries(){
		while($this->next_record()){
			print 'addEntry('.$this->f("ID").',"'.$this->f("Icon").'","'.$this->f("Text").'",'.($this->f("IsFolder")|0).',"'.$this->f("Path").'");'."\n";
		}
	}

	function printFramesetJSFunctions(){
		$this->printFramesetJSFunctioWriteBody();
		$this->printFramesetJSFunctionQueryString();
		$this->printFramesetJSFunctionEntry();
		$this->printFramesetJSFunctionAddEntry();
		$this->printFramesetJSFunctionClearEntry();
		$this->query();
		$this->printFramesetJSFunctionAddEntries();
	}


	##############################################
	############## BODY FUNCTIONS ################
	##############################################

	function printBodyHTML(){
		print '<html><head></head>'."\n";
		print '<body bgcolor="white" onLoad="top.writeBody(self.document);"></body></html>'."\n";
	}
	
	function getJS_attachKeyListener() {
		
		// attach the keylistener
		$_attachKeyListener = file($_SERVER['DOCUMENT_ROOT'] . "/webEdition/js/attachKeyListener.js");
		$_addJs = "";
		for ($i=0; $i<sizeof($_attachKeyListener); $i++) {
			if ( trim($_attachKeyListener[$i]) ) {
				$_addJs .= "d.writeln('" . trim($_attachKeyListener[$i])  . "');\n";
			}
		}
		return $_addJs
		;
	}

	##############################################
	############## HEADER FUNCTIONS ################
	##############################################

	function printHeaderHTML(){
		htmlTop();
		print STYLESHEET;
		$this->setDirAndID();
		$this->printHeaderJSIncluddes();
		print '<script language="JavaScript" type="text/javascript">
';
		$this->printHeaderJSDef();
		$this->printHeaderJS();

		print '	function clearOptions(){
     var a=document.forms["we_form"].elements["lookin"];
     for(var i=a.options.length-1;i >= 0;i--){
     	a.options[i] = null;
     }
  }

	function addOption(txt,id){
      var a=document.forms["we_form"].elements["lookin"];
      a.options[a.options.length]=new Option(txt,id);
      if(a.options.length>0) a.selectedIndex=a.options.length-1;
      else a.selectedIndex=0;

  }
  function selectIt(){
      var a=document.forms["we_form"].elements["lookin"];
      a.selectedIndex=a.options.length-1;
  }

	</script>
</head>
	<body background="' . IMAGE_DIR . 'backgrounds/radient.gif" bgcolor="#bfbfbf"  LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
		<form name="we_form" method="post">
';
if((!defined("OBJECT_TABLE")) || $this->table != OBJECT_TABLE){
		$this->printHeaderTable();
		$this->printHeaderLine();
}
		$this->printHeaderHeadlines();
		$this->printHeaderLine();

		print '		</form>
	</body>
</html>
';
	}

	function printHeaderTableSpaceRow(){
		print '				<tr>
					<td colspan="9">'.getPixel(5,10).'</td>
				</tr>
';

	}

	function printHeaderTableExtraCols(){
		// overwrite
	}
	function printHeaderOptions(){
		$pid=$this->dir;
		$out="";
		$c=0;
		$z = 0;
		while($pid!=0){
			$c++;
			$this->db->query("SELECT ID,Text,ParentID FROM $this->table WHERE ID=$pid");
			if($this->db->next_record()){
				$out='<option value="'.$this->db->f("ID").'"'.(($z==0) ? ' selected' : '').'>'.$this->db->f("Text").'</options>'."\n".$out;
				$z++;
			}
			$pid=$this->db->f("ParentID");
			if($c>500){
				$pid=0;
			}
		}
		$out ='<option value="0">/</option>'.$out."\n";
		print $out;
	}

	function printHeaderTable(){
		$we_button = new we_button();
		print '			<table border="0" cellpadding="0" cellspacing="0" width="100%">
';
		$this->printHeaderTableSpaceRow();
		print '				<tr valign="middle">
					<td width="10">'.getPixel(10,29).'</td>
					<td width="70" class="defaultfont"><b>'.$GLOBALS["l_fileselector"]["lookin"].'</b></td>
					<td width="10">'.getPixel(10,29).'</td>
					<td>
					<select name="lookin" class="weSelect" size="1" onchange="top.setDir(this.options[this.selectedIndex].value);" class="defaultfont" style="width:100%">
';
		$this->printHeaderOptions();

		print '</select>
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="40">
						'. $we_button->create_button("root_dir", "javascript:if(rootDirButsState){top.setRootDir();}", false, 40, 22, "", "", ($this->dir == 0), false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="40">
						'. $we_button->create_button("image:btn_fs_back", "javascript:top.goBackDir();", false, 40, 22, "", "", ($this->dir == 0), false) . '
					</td>

';
		$this->printHeaderTableExtraCols();

		print '				<td width="10">'.getPixel(10,29).'</td></tr>
';
		$this->printHeaderTableSpaceRow();

		print '			</table>
';
	}

	function printHeaderHeadlines(){
		print '			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>'.getPixel(25,14).'</td>
					<td class="selector"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, Text\');">'.$GLOBALS["l_fileselector"]["filename"].'</a></b></td>
				</tr>
				<tr>
					<td width="25">'.getPixel(25,1).'</td>
					<td>'.getPixel(200,1).'</td>
				</tr>
			</table>
';

	}

	function printHeaderLine(){
		print '			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td><img src="'.IMAGE_DIR.'umr_h_small.gif" width="100%" height="2" border="0"></td>
				</tr>
			</table>
';

	}

	function printHeaderJS(){
		$we_button = new we_button();
		print '
' . $we_button->create_state_changer(false) . '

function disableRootDirButs(){

	root_dir_enabled = switch_button_state("root_dir", "root_dir_enabled", "disabled");
	btn_fs_back_enabled = switch_button_state("btn_fs_back", "back_enabled", "disabled", "image");
	rootDirButsState = 0;
}
function enableRootDirButs(){

	root_dir_enabled = switch_button_state("root_dir", "root_dir_enabled", "enabled");
	btn_fs_back_enabled = switch_button_state("btn_fs_back", "back_enabled", "enabled", "image");
	rootDirButsState = 1;
}
';
	}

	function printHeaderJSIncluddes(){
		print '<script language="JavaScript" type="text/javascript" src="'.WEBEDITION_DIR.'js/images.js"></script>
';
	}

	function printHeaderJSDef(){
		print 'var rootDirButsState = '.(($this->dir == 0) ? 0 : 1).';
';
	}


	##############################################
	############## CMD FUNCTIONS #################
	##############################################

	function printCmdHTML(){
		print '<script>
top.clearEntries();
';
		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

		if(abs($this->dir)==0){
			print 'top.fsheader.disableRootDirButs();
';
		}else{
			print 'top.fsheader.enableRootDirButs();
';
		}
		print 'top.currentPath = "'.$this->path.'";
top.parentID = "'.$this->values["ParentID"].'";
</script>
';
	}

	function printCmdAddEntriesHTML(){
		$this->query();
		while($this->next_record()){
			print 'top.addEntry('.$this->f("ID").',"'.$this->f("Icon").'","'.ereg_replace("[\n\r]","",$this->f("Text")).'",'.$this->f("IsFolder").',"'.ereg_replace("[\n\r]","",$this->f("Path")).'");'."\n";
		}
	}
	function printCMDWriteAndFillSelectorHTML(){
		print 'top.writeBody(top.fsbody.document);
top.fsheader.clearOptions();
';
		$pid=$this->dir;
		$out="";
		$c=0;
		while($pid!=0){
			$c++;
			$this->db->query("SELECT ID,Text,ParentID FROM $this->table WHERE ID=$pid");

			if($this->db->next_record()){
				$out = 'top.fsheader.addOption("'.$this->db->f("Text").'",'.$this->db->f("ID").');
'.$out;
			}
			$pid=$this->db->f("ParentID");
			if($c>500){
				$pid=0;
			}
		}
		$out = 'top.fsheader.addOption("/",0);
'.$out;
		print $out.'
top.fsheader.selectIt();
';
	}

	##############################################
	############ FOOTER FUNCTIONS ################
	##############################################

	function printFooterHTML(){
		htmlTop();

		print STYLESHEET;

		$this->printFooterJSIncluddes();
		print '<script language="JavaScript" type="text/javascript">
';
		$this->printFooterJSDef();
		$this->printFooterJS();

		print '</script>
</head>
	<body background="' . IMAGE_DIR . 'backgrounds/radient.gif" bgcolor="#bfbfbf"  LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
	<form name="we_form" target="fscmd">
';
		$this->printFooterTable();

		print '		</form>
	</body>
</html>
';
	}

	function printFooterJSIncluddes(){
		// do nothing here, overwrite!
	}
	function printFooterJSDef(){
		print "
		function press_ok_button() {
			if(document.we_form.fname.value==''){
				top.exit_close();
			}else{
				top.exit_open();
			};
		}
		";
	}
	function printFooterJS(){
		// do nothing here, overwrite!
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
	function setTableLayoutInfos() {
		
		$objectTable = defined("OBJECT_TABLE") ? OBJECT_TABLE : TEMPLATES_TABLE;
		
		switch ($this->table) {
			case $objectTable:
			case TEMPLATES_TABLE:
				$this->col2js = "entries[i].ID";
				$this->tableSizer = "<td>".getPixel( 25,1)."</td><td>".getPixel(350,1)."</td><td>".getPixel(70,1)."</td><td>".getPixel(150,1)."</td>";
				$this->tableHeadlines  = "
					<td></td>
					<td class='selector'><b><a href='#' onclick='javascript:top.orderIt(\"IsFolder DESC, Text\");'>".$GLOBALS['l_fileselector']['filename']."</a></b></td>
					<td class='selector'>&nbsp;<b>ID</b></td>
					<td class='selector'>&nbsp;<b><a href='#' onclick='javascript:top.orderIt(\"IsFolder DESC, ModDate\");'>".$GLOBALS['l_fileselector']['modified']."</a></b></td>
				";
				break;
			default:
				$this->col2js = "entries[i].title";
				$this->tableSizer = "<td>".getPixel( 25,1)."</td><td>".getPixel(200,1)."</td><td>".getPixel(220,1)."</td><td>".getPixel(150,1)."</td>";
				$this->tableHeadlines  = "
					<td></td>
					<td class='selector'><b><a href='#' onclick='javascript:top.orderIt(\"IsFolder DESC, Text\");'>".$GLOBALS['l_fileselector']['filename']."</a></b></td>
					<td class='selector'><b>".$GLOBALS['l_fileselector']['title']."</b></td>
					<td class='selector'><b><a href='#' onclick='javascript:top.orderIt(\"IsFolder DESC, ModDate\");'>".$GLOBALS['l_fileselector']['modified']."</a></b></td>
				";
		}	
	}
}