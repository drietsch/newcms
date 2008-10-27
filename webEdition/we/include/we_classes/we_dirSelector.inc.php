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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_multiSelector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/contenttypes.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/enc_we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor_info.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/date.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

define("FS_SETDIR",5);
define("FS_NEWFOLDER",7);
define("FS_CREATEFOLDER",8);
define("FS_RENAMEFOLDER",9);
define("FS_DORENAMEFOLDER",10);
define("FS_PREVIEW",11);

class we_dirSelector extends we_multiSelector{

	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon,ModDate,RestrictOwners,Owners,OwnersReadOnly,CreatorID";
	var $userCanMakeNewFolder = true;
	var $userCanRenameFolder = true;
	var $we_editDirID="";
	var $FolderText = "";
	var $rootDirID = 0;

	function we_dirSelector( $id, $table="", $JSIDName="", $JSTextName="", $JSCommand="", $order="", $sessionID="", $we_editDirID="", $FolderText="", $rootDirID=0, $multiple=0 ) {
		if ($table == "") {
			$table = FILE_TABLE;
		}
		$this->we_multiSelector( $id, $table, $JSIDName, $JSTextName, $JSCommand, $order, $sessionID, $rootDirID, $multiple);
		$this->userCanMakeNewFolder = $this->userCanMakeNewDir();
		$this->userCanRenameFolder = $this->userCanRenameFolder();
		$this->we_editDirID	= $we_editDirID;
		$this->FolderText	= $FolderText;
		$this->rootDirID	= $rootDirID;

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
			case FS_SETDIR:
				$this->printSetDirHTML();
				break;
			case FS_NEWFOLDER:
				$this->printNewFolderHTML();
				break;
			case FS_CREATEFOLDER:
				$this->printCreateFolderHTML();
				break;
			case FS_RENAMEFOLDER:
				$this->printRenameFolderHTML();
				break;
			case FS_DORENAMEFOLDER:
				$this->printDoRenameFolderHTML();
				break;
			case FS_PREVIEW:
				$this->printPreviewHTML();
				break;
			case FS_FRAMESET:
			default:
				$this->printFramesetHTML();
		}
	}

	function printCmdHTML(){
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
		print 'top.currentPath = "'.$this->path.'";
top.parentID = "'.$this->values["ParentID"].'";
</script>
';
	}
	function query(){

		global $_isp_hide_files;	//	ISP_VERSION

		//	Changes for ISP_VERSION
		//	dont look for files in array . $_isp_hide_files

		$wsQuery = getWsQueryForSelector($this->table);

		$_query = "	SELECT ".$this->fields."
					FROM ".mysql_real_escape_string($this->table)."
					WHERE IsFolder=1 AND ParentID='".abs($this->dir)."'".makeOwnersSql().
		$wsQuery .
		( ((defined('ISP_VERSION') && ISP_VERSION) && is_array($_isp_hide_files) && sizeof($_isp_hide_files) > 0) ? "AND Path NOT IN ('" . implode("','", $_isp_hide_files) . "')" : '').
		($this->order ? (' ORDER BY '.$this->order) : '');

		$this->db->query($_query);

	}

	function setDefaultDirAndID($setLastDir){
		$this->dir = $setLastDir ? (isset($_SESSION["we_fs_lastDir"][$this->table]) ? abs($_SESSION["we_fs_lastDir"][$this->table]) : 0 ) : 0;
		$ws = get_ws($this->table,true);
		if($ws && strpos($ws,(",".$this->dir.",")) !== true){
			$this->dir = "";
		}
		$this->id = $this->dir;
		if($this->rootDirID){
			if(!in_parentID($this->dir,$this->rootDirID,$this->table,$this->db)){
				$this->dir = $this->rootDirID;
				$this->id = $this->rootDirID;
			}
		}
		$this->path = "";

		$this->values = array("ParentID"=>0,
		"Text"=>"/",
		"Path"=>"/",
		"IsFolder"=>1,
		"ModDate"=>0,
		"RestrictOwners"=>0,
		"Owners"=>"",
		"OwnersReadOnly"=>"",
		"CreatorID"=>0);
	}

	function getFsQueryString($what){
		return $_SERVER["PHP_SELF"]."?what=$what&rootDirID=".$this->rootDirID."&table=".$this->table."&id=".$this->id."&order=".$this->order.(isset($this->open_doc) ? ("&open_doc=".$this->open_doc) : "");
	}

	function printFramesetJSFunctions(){
		parent::printFramesetJSFunctions();
?>

function drawNewFolder(){
	unselectAllFiles();
	top.fscmd.location.replace(top.queryString(<?php print FS_NEWFOLDER; ?>,currentDir));
}
function RenameFolder(id){
	unselectAllFiles();
	top.fscmd.location.replace(top.queryString(<?php print FS_RENAMEFOLDER; ?>,currentDir,'',id));
}

<?php

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
	
	function printFramesetJSFunctioWriteBody(){
		global $BROWSER;
		$htmltop = ereg_replace("[[:cntrl:]]","",trim(str_replace("'","\\'",getHtmlTop())));
		$htmltop = str_replace('script', "scr' + 'ipt", $htmltop);
?>
function writeBody(d){
	d.open();
	//d.writeln('<?php print $htmltop; ?>');
	d.writeln('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>webEdition (c) living-e AG</title><meta http-equiv="expires" content="0"><meta http-equiv="pragma" content="no-cache"><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><meta http-equiv="imagetoolbar" content="no"><meta name="generator" content="webEdition Version 4.9.0.0">');
	d.writeln('<?php print STYLESHEET_SCRIPT; ?>');
	d.writeln('</head>');
	d.writeln('<scr'+'ipt>');
	
	<?php print $this->getJS_attachKeyListener(); ?>
	
	//from we_showMessage.js
	d.writeln('var WE_MESSAGE_INFO = -1;');
	d.writeln('var WE_MESSAGE_FRONTEND = -2;');
	d.writeln('var WE_MESSAGE_NOTICE = 1;');
	d.writeln('var WE_MESSAGE_WARNING = 2;');
	d.writeln('var WE_MESSAGE_ERROR = 4;');
	d.writeln('function we_showMessage (message, prio, win) {');
	d.writeln('if (win.top.showMessage != null) {');
	d.writeln('win.top.showMessage(message, prio, win);');
	d.writeln('} else if (win.top.opener) {');
	d.writeln('if (win.top.opener.top.showMessage != null) {');
	d.writeln('win.top.opener.top.showMessage(message, prio, win);');
	d.writeln('} else if (win.top.opener.top.opener.top.showMessage != null) {');
	d.writeln('win.top.opener.top.opener.top.showMessage(message, prio, win);');
	d.writeln('} else if (win.top.opener.top.opener.top.opener.top.showMessage != null) {');
	d.writeln('win.top.opener.top.opener.top.showMessage(message, prio, win);');
	d.writeln('}');
	d.writeln('} else { // there is no webEdition window open, just show the alert');
	d.writeln('if (!win) {');
	d.writeln('win = window;');
	d.writeln('}');
	d.writeln('win.alert(message);');
	d.writeln('}');
	d.writeln('}');

	d.writeln('var ctrlpressed=false');
	d.writeln('var shiftpressed=false');
	d.writeln('var inputklick=false');
	d.writeln('var wasdblclick=false');
	d.writeln('var tout=null');
	d.writeln('function submitFolderMods(){');
//	d.writeln('document.we_form.we_FolderText.value=escape(document.we_form.we_FolderText_tmp.value); document.we_form.submit();');
	d.writeln('}');
	d.writeln('document.onclick = weonclick;');
	d.writeln('function weonclick(e){');
	d.writeln('top.fspreview.document.body.innerHTML = "";');
	if(makeNewFolder ||  we_editDirID){
	d.writeln('if(!inputklick){');
	d.writeln('document.we_form.we_FolderText.value=escape(document.we_form.we_FolderText_tmp.value);document.we_form.submit();');
	d.writeln('}else{  ');
	d.writeln('inputklick=false;');
	d.writeln('}  ');
	}else{
	d.writeln('inputklick=false;');
	d.writeln('if(document.all){');
	d.writeln('if(event.ctrlKey || event.altKey){ ctrlpressed=true;}');
	d.writeln('if(event.shiftKey){ shiftpressed=true;}');
	d.writeln('}else{  ');
	d.writeln('if(e.altKey || e.metaKey || e.ctrlKey){ ctrlpressed=true;}');
	d.writeln('if(e.shiftKey){ shiftpressed=true;}');
	d.writeln('}');
<?php if($this->multiple): ?>
	d.writeln('if((self.shiftpressed==false) && (self.ctrlpressed==false)){top.unselectAllFiles();}');
<?php else: ?>
	d.writeln('top.unselectAllFiles();');
<?php endif ?>
	}
	d.writeln('}');
	d.writeln('</scr'+'ipt>');
	d.writeln('<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0"'+((makeNewFolder || top.we_editDirID) ? '  onload="document.we_form.we_FolderText_tmp.focus();document.we_form.we_FolderText_tmp.select();"' : '')+'>');
	d.writeln('<form name="we_form" target="fscmd" action="<?php print $_SERVER["PHP_SELF"]; ?>" onsubmit="document.we_form.we_FolderText.value=escape(document.we_form.we_FolderText_tmp.value);return true;">');

	if(we_editDirID){
		d.writeln('<input type="hidden" name="what" value="<?php print FS_DORENAMEFOLDER; ?>">');
		d.writeln('<input type="hidden" name="we_editDirID" value="'+top.we_editDirID+'">');
	}else{
		d.writeln('<input type="hidden" name="what" value="<?php print FS_CREATEFOLDER; ?>">');
	}
	d.writeln('<input type="hidden" name="order" value="'+top.order+'">');
	d.writeln('<input type="hidden" name="rootDirID" value="<?php print $this->rootDirID; ?>">');
	d.writeln('<input type="hidden" name="table" value="<?php print $this->table; ?>">');
	d.writeln('<input type="hidden" name="id" value="'+top.currentDir+'">');
	d.writeln('<table border="0" cellpadding="0" cellspacing="0" width="100%">');
	if(makeNewFolder){
		d.writeln('<tr style="background-color:#DFE9F5;">');
		d.writeln('<td align="center"><img src="<?php print ICON_DIR?>folder.gif" width="16" height="18" border="0"></td>');
		d.writeln('<td><input type="hidden" name="we_FolderText" value="<?php print $GLOBALS["l_fileselector"]["new_folder_name"]; ?>"><input onMouseDown="self.inputklick=true" name="we_FolderText_tmp" type="text" value="<?php print $GLOBALS["l_fileselector"]["new_folder_name"]; ?>" class="wetextinput" onblur="submitFolderMods(); this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%"></td>');
		d.writeln('<td class="selector"><?php print date($GLOBALS["l_global"]["date_format"])?></td>');
		d.writeln('</tr>');
	}
	for(i=0;i < entries.length; i++){
		var onclick = ' onClick="weonclick(<?php echo ($BROWSER=="IE"?"this":"event")?>);tout=setTimeout(\'if(top.wasdblclick==0){top.doClick('+entries[i].ID+',0);}else{top.wasdblclick=0;}\',300);return true"';
		var ondblclick = ' onDblClick="top.wasdblclick=1;clearTimeout(tout);top.doClick('+entries[i].ID+',1);return true;"';
		d.writeln('<tr id="line_'+entries[i].ID+'" style="' + ((entries[i].ID == top.currentID && (!makeNewFolder) )  ? 'background-color:#DFE9F5;' : '')+'cursor:pointer;'+((we_editDirID != entries[i].ID) ? '-moz-user-select: none;' : '' )+'"'+((we_editDirID || makeNewFolder) ? '' : onclick)+ (entries[i].isFolder ? ondblclick : '') + ' unselectable="on">');
		d.writeln('<td class="selector" align="center">');
		d.writeln('<img src="<?php print ICON_DIR; ?>'+entries[i].icon+'" width="16" height="18" border="0">');
		d.writeln('</td>');
		if(we_editDirID == entries[i].ID){
			d.writeln('<td class="selector">');
			d.writeln('<input type="hidden" name="we_FolderText" value="'+entries[i].text+'"><input onMouseDown="self.inputklick=true" name="we_FolderText_tmp" type="text" value="'+entries[i].text+'" class="wetextinput" onblur="submitFolderMods(); this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%">');
		}else{
			d.writeln('<td class="selector" style="-moz-user-select: none;" unselectable="on" title="'+entries[i].text+'">');
			d.writeln(cutText(entries[i].text,30));
		}
		d.writeln('</td>');
		d.writeln('<td class="selector">');
		d.writeln(entries[i].modDate);
		d.writeln('</td>');
		d.writeln('</tr><tr><td colspan="3"><?php print getPixel(2,1); ?></td></tr>');
	}
	d.writeln('<tr>');
	d.writeln('<td width="25"><?php print getPixel(25,2)?></td>');
	d.writeln('<td width="200"><?php print getPixel(200,2)?></td>');
	d.writeln('<td><?php print getPixel(300,2)?></td>');
	d.writeln('</tr>');
	d.writeln('</table></form>');
	d.writeln('</body>');
	d.close();
}

<?php

	}


	function printFramesetJSFunctionQueryString(){
?>

function queryString(what,id,o,we_editDirID){
	if(!o) o=top.order;
	if(!we_editDirID) we_editDirID="";
	return '<?php print $_SERVER["PHP_SELF"]; ?>?what='+what+'&rootDirID=<?php print $this->rootDirID; ?><?php if(isset($this->open_doc)){print "&open_doc=".$this->open_doc;} ?>&table=<?php print $this->table; ?>&id='+id+(o ? ("&order="+o) : "")+(we_editDirID ? ("&we_editDirID="+we_editDirID) : "");
}

<?php

	}

	function printFramesetJSFunctionEntry(){
?>

function entry(ID,icon,text,isFolder,path,modDate){
	this.ID=ID;
	this.icon=icon;
	this.text=text;
	this.isFolder=isFolder;
	this.path=path;
	this.modDate=modDate;
}

<?php
	}

	function printFramesetJSFunctionAddEntry(){
?>

function addEntry(ID,icon,text,isFolder,path,modDate){
	entries[entries.length] = new entry(ID,icon,text,isFolder,path,modDate);
}

<?php
	}

	function printFramesetJSFunctionAddEntries(){
		while($this->next_record()){
			print 'addEntry('.$this->f("ID").',"'.$this->f("Icon").'","'.$this->f("Text").'",'.$this->f("IsFolder").',"'.$this->f("Path").'","'.date($GLOBALS["l_global"]["date_format"],(is_numeric($this->f("ModDate"))  ? $this->f("ModDate") : 0)).'");'."\n";
		}
	}


	function printCmdAddEntriesHTML(){
		$this->query();
		while($this->next_record()){
			print 'top.addEntry('.$this->f("ID").',"'.$this->f("Icon").'","'.$this->f("Text").'",'.$this->f("IsFolder").',"'.$this->f("Path").'","'.date($GLOBALS["l_global"]["date_format"],(is_numeric($this->f("ModDate"))  ? $this->f("ModDate") : 0)).'");'."\n";
		}
		if($this->userCanMakeNewDir()){
			print 'top.fsheader.enableNewFolderBut();'."\n";
		}else{
			print 'top.fsheader.disableNewFolderBut();'."\n";
		}
	}

	function printHeaderHeadlines(){
		print '			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td>'.getPixel(25,14).'</td>
					<td class="selector"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, Text\');">'.$GLOBALS["l_fileselector"]["filename"].'</a></b></td>
					<td class="selector"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, ModDate\');">'.$GLOBALS["l_fileselector"]["modified"].'</a></b></td>
				</tr>
				<tr>
					<td width="25">'.getPixel(25,1).'</td>
					<td width="200">'.getPixel(200,1).'</td>
					<td>'.getPixel(300,1).'</td>
				</tr>
			</table>
';

	}

	function printHeaderJSDef(){
		we_fileselector::printHeaderJSDef();
		print 'var makefolderState = '.($this->userCanMakeNewFolder ? 1 : 0).';
';
	}

	function printHeaderJS(){
		$we_button = new we_button();
		we_fileselector::printHeaderJS();
		print '
' . $we_button->create_state_changer(false) . '
function disableNewFolderBut(){

	btn_new_dir_enabled = switch_button_state("btn_new_dir", "new_directory_enabled", "disabled", "image");
	makefolderState = 0;
}
function enableNewFolderBut(){

	btn_new_dir_enabled = switch_button_state("btn_new_dir", "new_directory_enabled", "enabled", "image");
	makefolderState = 1;
}
';
	}

	function userCanSeeDir($showAll=false){
		if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
		if(!$showAll){
			if(!in_workspace(abs($this->dir),get_ws($this->table),$this->table,$this->db)){
				return false;
			}
		}
		if(defined("BIG_USER_MODULE") && in_array("busers",$GLOBALS["_pro_modules"])){
			if(!userIsOwnerCreatorOfParentDir($this->dir,$this->table)){
				return false;
			}
		}
		return true;
	}

	function userCanRenameFolder(){

		if($_SESSION["perms"]["ADMINISTRATOR"]) {
			return true;
		}
		if (!$this->userHasRenameFolderPerms()) {

			return false;
		}
		return true;
	}

	function userCanMakeNewDir(){
		if(defined("OBJECT_FILES_TABLE")  && ($this->table==OBJECT_FILES_TABLE) && (!$this->dir)){
			return false;
		}
		if($_SESSION["perms"]["ADMINISTRATOR"]) return true;
		if(!$this->userCanSeeDir()) return false;
		if(!$this->userHasFolderPerms()){
			return false;
		}
		return true;
	}

	function userHasRenameFolderPerms() {

		switch($this->table){
			case FILE_TABLE:
				if(!we_hasPerm("CHANGE_DOC_FOLDER_PATH")){
					return false;
				}
				break;
		}
		return true;
	}

	function userHasFolderPerms(){

		switch($this->table){
			case FILE_TABLE:
				if(!we_hasPerm("NEW_DOC_FOLDER")){
					return false;
				}
				break;
			case TEMPLATES_TABLE:
				if(!we_hasPerm("NEW_TEMP_FOLDER")){
					return false;
				}
				break;
			default:
				if(defined("OBJECT_FILES_TABLE")){
					switch($this->table){
						case OBJECT_FILES_TABLE:
							if(!we_hasPerm("NEW_OBJECTFILE_FOLDER")){
								return false;
							}
							break;
					}
				}

		}
		return true;
	}

	function printFramesetRootDirFn(){
		print 'function setRootDir(){
	setDir('.abs($this->rootDirID).');
}
';
	}

	function printCMDWriteAndFillSelectorHTML(){
		print '
			top.writeBody(top.fsbody.document);
			top.fsheader.clearOptions();';

		$pid=$this->dir;
		$out="";
		$c=0;
		while( $pid != 0 ) {
			$c++;
			$this->db->query("SELECT ID,Text,ParentID FROM ".mysql_real_escape_string($this->table)." WHERE ID=".abs($pid)."");
			if( $this->db->next_record() ) {
				$out = 'top.fsheader.addOption("' . $this->db->f( "Text" ) . '",' . $this->db->f( "ID" ) . ');' . $out;
			}
			$pid=$this->db->f( "ParentID" );
			if( $c>500 ){
				$pid=0;
			}
			if( $this->rootDirID ) {
				if( $this->db->f( "ID" ) == $this->rootDirID) {
					$pid =0;
				}
			}
		}
		if( !$this->rootDirID ) {
			$out = 'top.fsheader.addOption("/",0);' . $out;
		}
		print $out . 'top.fsheader.selectIt();';
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
';
		if((!defined("OBJECT_TABLE")) || $this->table != OBJECT_TABLE){

			print '					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="40">
						'. $we_button->create_button("root_dir", "javascript:if(rootDirButsState){top.setRootDir();}", true, -1, 22, "", "", $this->dir == abs($this->rootDirID), false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="40">
						'. $we_button->create_button("image:btn_fs_back", "javascript:if(rootDirButsState){top.goBackDir();}", true, -1, 22, "", "", $this->dir == abs($this->rootDirID), false) . '
					</td>

';
			$this->printHeaderTableExtraCols();
		}
		print '				<td width="10">'.getPixel(10,29).'</td></tr>
';
		$this->printHeaderTableSpaceRow();

		print '			</table>
';
	}

	function printHeaderOptions() {
		$pid=$this->dir;
		$out="";
		$c=0;
		$z = 0;
		while( $pid != 0 ) {
			$c++;
			$this->db->query("SELECT ID,Text,ParentID FROM ".mysql_real_escape_string($this->table)." WHERE ID=".abs($pid)."");
			if( $this->db->next_record() ) {
				$out='<option value="'.$this->db->f("ID").'"'.(($z==0) ? ' selected' : '').'>'.$this->db->f("Text").'</options>'."\n".$out;
				$z++;
			}
			$pid=$this->db->f("ParentID");
			if( $c > 500 ) {
				$pid = 0;
			}
			if( $this->rootDirID ) {
				if( $this->db->f( "ID" ) == $this->rootDirID) {
					$pid =0;
				}
			}
		}
		if( !$this->rootDirID ) {
			$out ='<option value="0">/</option>'.$out."\n";
		}
		print $out;
	}

	function printHeaderTableExtraCols(){
		$we_button = new we_button();
		print '                <td width="10">'.getPixel(10,10).'</td><td width="40">
';
		$makefolderState = $this->userCanMakeNewDir() ? 1 : 0;

		print $we_button->create_button("image:btn_new_dir", "javascript:top.drawNewFolder();", true, -1, 22, "", "", !$this->userCanMakeNewDir(),false);
		print '               </td>
';
	}

	function printHeaderTableSpaceRow(){
		print '				<tr>
					<td colspan="11">'.getPixel(5,10).'</td>
				</tr>
';

	}

	function printFramesetJSDoClickFn(){
?>

function showPreview(id) {
	if(top.fspreview) {
		top.fspreview.location.replace(top.queryString(<?php print FS_PREVIEW; ?>,id));
	}
}

function doClick(id,ct){
	top.fspreview.document.body.innerHTML = "";
	if(ct==1){
		if(wasdblclick){
			setDir(id);
			setTimeout('wasdblclick=0;',400);
		}
	}else{
		if(top.currentID == id && (!fsbody.ctrlpressed)){
		<?php
		print $this->userCanRenameFolder ? 'top.RenameFolder(id);' : 'selectFile(id);';
		?>
			
		}else{
<?php if($this->multiple): ?>
			if(fsbody.shiftpressed){
				var oldid = currentID;
				var currendPos = getPositionByID(id);
				var firstSelected = getFirstSelected();

				if(currendPos > firstSelected){
					selectFilesFrom(firstSelected,currendPos);
				}else if(currendPos < firstSelected){
					selectFilesFrom(currendPos,firstSelected);
				}else{
					selectFile(id);
				}
				currentID = oldid;

			}else if(!fsbody.ctrlpressed){
				selectFile(id);
			}else{
				if (isFileSelected(id)) {
					unselectFile(id);
				}else{

<?php endif ?>

					selectFile(id);

<?php if($this->multiple): ?>

				}
			}

<?php endif ?>

		}
	}
	if(fsbody.ctrlpressed){
		fsbody.ctrlpressed = 0;
	}
	if(fsbody.shiftpressed){
		fsbody.shiftpressed = 0;
	}
}

<?php
	}

	function printFramesetJSsetDir(){
?>
function setDir(id){
	showPreview(id);
	top.fspreview.document.body.innerHTML = "";	
	top.fscmd.location.replace(top.queryString(<?php print FS_SETDIR; ?>,id));
	e = getEntry(id);
	fspath.document.body.innerHTML = e.path;	
}


<?php
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
		if(in_workspace(abs($this->dir),get_ws($this->table),$this->table,$this->db)){
			if($this->id==0) $this->path="/";
			print 'top.unselectAllFiles();top.currentPath = "'.$this->path.'";
top.currentID = "'.$this->id.'";
top.fsfooter.document.we_form.fname.value = "'.(($this->id==0) ? "/" : $this->values["Text"]).'";
';
		}
		$_SESSION["we_fs_lastDir"][$this->table] = $this->dir;
		print 'top.currentDir = "'.$this->dir.'";
top.parentID = "'.$this->values["ParentID"].'";
</script>
';
	}


	function printFramesetSelectFileHTML(){
?>

function selectFile(id){
	if(id){
		showPreview(id);
		e = getEntry(id);
		if( top.fsfooter.document.we_form.fname.value != e.text &&
			top.fsfooter.document.we_form.fname.value.indexOf(e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 &&
			top.fsfooter.document.we_form.fname.value.indexOf(","+e.text+",") == -1 ){

			top.fsfooter.document.we_form.fname.value =  top.fsfooter.document.we_form.fname.value ?
																(top.fsfooter.document.we_form.fname.value + "," + e.text) :
																e.text;
		}
		if(top.fsbody.document.getElementById("line_"+id)) top.fsbody.document.getElementById("line_"+id).style.backgroundColor="#DFE9F5";
		currentPath = e.path;
		currentID = id;

		we_editDirID = 0;
	}else{
		top.fsfooter.document.we_form.fname.value = "";
		currentPath = "";
		we_editDirID = 0;
	}
}

<?php
	}

	function printNewFolderHTML(){
		print '<script>
top.clearEntries();
top.makeNewFolder=1;
';
		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

		print 'top.makeNewFolder = 0;
</script>
';
	}
	function printCreateFolderHTML(){
		htmlTop();
		protect();
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");

		print '<script>
top.clearEntries();
';
		$this->FolderText = rawurldecode($this->FolderText);
		$txt = $this->FolderText;
		if($txt==""){
			print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["folder"]["filename_empty"], WE_MESSAGE_ERROR);
		}elseif(strpos($txt,".")!==false){
			print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["folder"]["we_filename_notAllowed"], WE_MESSAGE_ERROR);
		}elseif($_REQUEST['id']==0 && strtolower($txt)=="webedition"){
			print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["folder"]["we_filename_notAllowed"], WE_MESSAGE_ERROR);
		}else{
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_folder.inc.php");
			$folder= new we_folder();
			$folder->we_new();
			$folder->setParentID($this->dir);
			$folder->Table=$this->table;
			$folder->Text=$txt;
			$folder->CreationDate=time();
			$folder->ModDate=time();
			$folder->Filename=$txt;
			$folder->Published=time();
			$folder->Path=$folder->getPath();
			$folder->CreatorID=isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : "";
			$folder->ModifierID=isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : "";
			$this->db->query("SELECT ID FROM ".$this->table." WHERE Path='".$folder->Path."'");
			if($this->db->next_record()){
				$we_responseText = sprintf($GLOBALS["l_we_editor"]["folder"]["response_path_exists"],$folder->Path);
				print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
			}else{
				if(eregi('[^a-z0-9\._\-]',$folder->Filename)){
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["folder"]["we_filename_notValid"],$folder->Path);
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
				}else{
					$folder->we_save();
					print 'var ref;
if(top.opener.top.makeNewEntry) ref = top.opener.top;
else if(top.opener.top.opener) ref = top.opener.top.opener.top;
ref.makeNewEntry("'.$folder->Icon.'",'.$folder->ID.',"'.$folder->ParentID.'","'.$txt.'",1,"'.$folder->ContentType.'","'.$this->table.'");
';
					if($this->canSelectDir){
						print 'top.currentPath = "'.$folder->Path.'";
top.currentID = "'.$folder->ID.'";
top.fsfooter.document.we_form.fname.value = "'.$folder->Text.'";
';
					}
				}

			}
		}


		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

		print 'top.makeNewFolder = 0;
top.selectFile(top.currentID);
</script>
';
		print '</head><body></body></html>';
	}

	function getFrameset(){
		$out = '<frameset rows="67,*,65,20,0" border="0">
	<frame src="'.$this->getFsQueryString(FS_HEADER).'" name="fsheader" noresize scrolling="no">
	<frameset cols="605,*" border="1">
		<frame src="'.$this->getFsQueryString(FS_BODY).'" name="fsbody" noresize scrolling="auto">
		<frame src="'.$this->getFsQueryString(FS_PREVIEW).'" name="fspreview" noresize scrolling="no"'.(($GLOBALS['BROWSER'] != "NN6") ?' style="border-left:1px solid black"' : '').'>
		<!--frame src="" name="fspreview" noresize scrolling="auto"'.(($GLOBALS['BROWSER'] != "NN6") ?' style="border-left:1px solid black"' : '').'-->
	</frameset>
	<frame src="'.$this->getFsQueryString(FS_FOOTER).'"  name="fsfooter" noresize scrolling="no">
	<frame src="'.HTML_DIR.'gray2.html"  name="fspath" noresize scrolling="no">
    <frame src="'.HTML_DIR.'white.html"  name="fscmd" noresize scrolling="no">
</frameset>
<body>
</body>
</html>
';
		return $out;
	}
	function getFramesetJavaScriptDef(){
		$def = we_fileselector::getFramesetJavaScriptDef();
		$def .= 'var makeNewFolder=0;
var we_editDirID="";
var old=0;
';
		return $def;
	}

	function printRenameFolderHTML(){
		if(userIsOwnerCreatorOfParentDir($this->we_editDirID,$this->table) && in_workspace($this->we_editDirID,get_ws($this->table),$this->table,$this->db)){
			print '<script>
top.clearEntries();
top.we_editDirID='.$this->we_editDirID.';
';
			$this->printCmdAddEntriesHTML();
			$this->printCMDWriteAndFillSelectorHTML();

			print 'top.we_editDirID = "";
</script>
';
		}
	}

	function printDoRenameFolderHTML(){
		htmlTop();
		protect();
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");

		print '<script>
top.clearEntries();
';
		$this->FolderText = rawurldecode($this->FolderText);
		$txt = $this->FolderText;
		if($txt==""){
			print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["folder"]["filename_empty"], WE_MESSAGE_ERROR);
		}else{
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_folder.inc.php");
			$folder= new we_folder();
			$folder->initByID($this->we_editDirID,$this->table);
			$folder->Text=$txt;
			$folder->ModDate=time();
			$folder->Filename=$txt;
			$folder->Published=time();
			$folder->Path=$folder->getPath();
			$folder->ModifierID=isset($_SESSION["user"]["ID"]) ? $_SESSION["user"]["ID"] : "";
			$this->db->query("SELECT ID,Text FROM ".mysql_real_escape_string($this->table)." WHERE Path='".mysql_real_escape_string($folder->Path)."' AND ID != '".abs($this->we_editDirID)."'");
			if($this->db->next_record()){
				$we_responseText = sprintf($GLOBALS["l_we_editor"]["folder"]["response_path_exists"],$folder->Path);
				print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
			}else{
				if(eregi('[^a-z0-9\._\-]',$folder->Filename)){
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["folder"]["we_filename_notValid"],$folder->Path);
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
				}else if(in_workspace($this->we_editDirID,get_ws($this->table),$this->table,$this->db)){
					if(f("SELECT Text FROM ".mysql_real_escape_string($this->table)." WHERE ID='".abs($this->we_editDirID)."'","Text",$this->db) != $txt){
						$folder->we_save();
						print 'var ref;
if(top.opener.top.makeNewEntry) ref = top.opener.top;
else if(top.opener.top.opener) ref = top.opener.top.opener.top;
';
						print 'ref.updateEntry('.$folder->ID.',"'.$txt.'","'.$folder->ParentID.'","'.$this->table.'");
';
						if($this->canSelectDir){
							print 'top.currentPath = "'.$folder->Path.'";
top.currentID = "'.$folder->ID.'";
top.fsfooter.document.we_form.fname.value = "'.$folder->Text.'";
';
						}
					}
				}

			}
		}


		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

		print 'top.makeNewFolder = 0;
top.selectFile(top.currentID);
</script>
';
		print '</head><body></body></html>';
	}
	
	function printPreviewHTML() {
		if( $this->id) {
			$query = $this->db->query("SELECT * FROM " . mysql_real_escape_string($this->table) . " WHERE ID='".abs($this->id)."'");
			while ($this->db->next_record()) {
				$result['Text'] = $this->db->f('Text');
				$result['Path'] = $this->db->f('Path');
				$result['ContentType'] = $this->db->f('ContentType');
				$result['Type'] = $this->db->f('Type');
				$result['CreationDate'] = $this->db->f('CreationDate');
				$result['ModDate'] = $this->db->f('ModDate');
				$result['Filename'] = $this->db->f('Filename');
				$result['Extension'] = $this->db->f('Extension');
				$result['MasterTemplateID'] = $this->db->f('MasterTemplateID');
				$result['IncludedTemplates'] = $this->db->f('IncludedTemplates');
				$result['ClassName'] = $this->db->f('ClassName');
				$result['Templates'] = $this->db->f('Templates');
			}
			$path = f("SELECT Text, Path FROM " . mysql_real_escape_string($this->table) . " WHERE ID='".abs($this->id)."'","Path",$this->db);
			$out = '<html>
<head>
' . STYLESHEET . '
' . we_htmlElement::jsElement("", array("src" => JS_DIR . "attachKeyListener.js")) . '
<style type="text/css">
	body {
		margin:0px;
		padding:0px;
		background-color:#FFFFFF;
	}
	td {
		font-size: 10px;
		padding: 3px 6px;
		vertical-align:top;
	}
	td.image {
		vertical-align:middle;
		padding: 0px;
	}
	td.info {
		padding: 0px;
	}
	.headline {
		padding:3px 6px;
		background-color:#BABBBA;
		font-weight:bold;
		border-top:0px solid black;
		border-bottom:0px solid black;
	}
	.odd {
		padding:3px 6px;
		background-color:#FFFFFF;
	}
	.even {
		padding:3px 6px;
		background-color:#F2F2F1;
	}
</style>
<script tyle="text/javascript">
	function setInfoSize() {
		infoSize = document.body.clientHeight;
		if(infoElem=document.getElementById("info")) {
			infoElem.style.height = document.body.clientHeight - (prieviewpic = document.getElementById("previewpic") ? 160 : 0 );
		}
	}
	function openToEdit(tab,id,contentType){
		if(top.opener && top.opener.top.weEditorFrameController) {
			top.opener.top.weEditorFrameController.openDocument(tab,id,contentType);
		} else if(top.opener.top.opener && top.opener.top.opener.top.weEditorFrameController) {
			top.opener.top.opener.top.weEditorFrameController.openDocument(tab,id,contentType);				
		} else if(top.opener.top.opener.top.opener && top.opener.top.opener.top.opener.top.weEditorFrameController) {
			top.opener.top.opener.top.opener.top.weEditorFrameController.openDocument(tab,id,contentType);				
		}
	}
	var weCountWriteBC = 0;
	setTimeout(\'weWriteBreadCrumb("' . $path . '")\',100);
	function weWriteBreadCrumb(BreadCrumb){
		if(top.fspath && top.fspath.document && top.fspath.document.body) top.fspath.document.body.innerHTML = BreadCrumb;
		else if(weCountWriteBC<10) setTimeout(\'weWriteBreadCrumb("' . $path . '")\',100);
		weCountWriteBC++;
	}
</script>
</head>
<body bgcolor="white" class="defaultfont" onresize="setInfoSize()" onload="setTimeout(\'setInfoSize()\',50)">
					';
			if(isset($result['ContentType']) && !empty($result['ContentType'])) {
				if ($this->table == FILE_TABLE && $result['ContentType'] != "folder") {
					$query = $this->db->query("SELECT a.Name, b.Dat FROM " . LINK_TABLE . " a LEFT JOIN " . CONTENT_TABLE . " b on (a.CID = b.ID) WHERE a.DID=".abs($this->id)." AND NOT a.DocumentTable='tblTemplates'");
					while ($this->db->next_record()) {
						$metainfos[$this->db->f('Name')] = $this->db->f('Dat');
					}
				} elseif ($this->table == FILE_TABLE && $result['ContentType'] = "folder") {
					$query = $this->db->query("SELECT ID, Text, IsFolder FROM " . mysql_real_escape_string($this->table) . " WHERE ParentID=".abs($this->id));
					$folderFolders = array();
					$folderFiles = array();
					while ($this->db->next_record()) {
						$this->db->f('IsFolder') ? $folderFolders[$this->db->f('ID')] = $this->db->f('Text') : $folderFiles[$this->db->f('ID')] = $this->db->f('Text');
					}
				}
				
				$fs = file_exists($_SERVER["DOCUMENT_ROOT"].$result['Path']) ? filesize($_SERVER["DOCUMENT_ROOT"].$result['Path']) : 0;
				
				$filesize = $fs<1000 ? $fs.' byte' : ($fs<1024000?round(($fs/1024),2) . ' kb' : round(($fs/(1024*1024)),2) . ' mb');
				$nextrowclass = "odd";
				$previewDefauts  = "<tr><td class='info' width='100%'>";
				$previewDefauts .= "<div style='overflow:auto; height:100%' id='info'><table cellpadding='0' cellspacing='0' width='100%'>";
				
				$previewDefauts .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_we_class']["tab_properties"]."</td></tr>";
				$previewDefauts .= "<tr class='odd'><td title=\"".$result['Path']."\" width='10'>".$GLOBALS['l_fileselector']["name"].": </td><td>";			
				//$previewDefauts .= "<div style='float:left; vertical-align:baseline; margin-right:4px;'><a href='http://".$_SERVER['HTTP_HOST'].$result['Path']."' target='_blank' style='color:black'><img src='/webEdition/images/tree/icons/browser.gif' border='0' vspace='0' hspace='0'></a></div>";			
				//$previewDefauts .= "<div style='margin-right:14px'><a href='http://".$_SERVER['HTTP_HOST'].$result['Path']."' target='_blank' style='color:black'>".$result['Text']."</a></div></td></tr>";			
				$previewDefauts .= "<div style='margin-right:14px'>".$result['Text']."</div></td></tr>";			
				$previewDefauts .= "<tr class='even'><td width='10'>ID: </td><td>";
				$previewDefauts .= "<a href='javascript:openToEdit(\"".$this->table."\",\"".$this->id."\",\"".$result['ContentType']."\")' style='color:black'><div style='float:left; vertical-align:baseline; margin-right:4px;'><img src='/webEdition/images/tree/icons/bearbeiten.gif' border='0' vspace='0' hspace='0'></div></a>";
				$previewDefauts .= "<a href='javascript:openToEdit(\"".$this->table."\",\"".$this->id."\",\"".$result['ContentType']."\")' style='color:black'><div>".$this->id."</div></a></td></tr>";
				if ($result['CreationDate']) {
					$previewDefauts .= "<tr class='odd'><td class='odd'>".$GLOBALS['l_fileselector']["created"].": </td><td>".date($GLOBALS["l_global"]["date_format"],$result['CreationDate'])."</td></tr>";		
					$nextrowclass = "even";		
				} else {
					$nextrowclass = "odd";		
				}
				if ($result['ModDate']) {
					$previewDefauts .=  "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["modified"].": </td><td>".date($GLOBALS["l_global"]["date_format"],$result['ModDate'])."</td></tr>";						
					$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
				} else {
					$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
				}
				$previewDefauts .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["type"].": </td><td>".(isset($GLOBALS['l_contentTypes'][$result['ContentType']])?$GLOBALS['l_contentTypes'][$result['ContentType']]:$result['ContentType'])."</td></tr>";
				
				$out .= "\t<table cellpadding='0' cellspacing='0' height='100%' width='100%'>\n";
				switch ($result['ContentType']) {
					case "image/*":
						if (file_exists($_SERVER["DOCUMENT_ROOT"].$result['Path'])) {
							$imagesize = getimagesize($_SERVER["DOCUMENT_ROOT"].$result['Path']);
							if ($imagesize[0]>150 || $imagesize[1]>150) {
								$extension = substr($result['Extension'],1);
								$thumbpath = '/webEdition/preview/' . $this->id .'.'.$extension;
								$created = filemtime($_SERVER["DOCUMENT_ROOT"].$result['Path']);
								if (!file_exists($_SERVER["DOCUMENT_ROOT"].$thumbpath) || ($created > filemtime($_SERVER["DOCUMENT_ROOT"].$thumbpath))) {
									include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_image_edit.class.php");
									$thumb = we_image_edit::edit_image($_SERVER["DOCUMENT_ROOT"].$result['Path'],$extension,$_SERVER["DOCUMENT_ROOT"].$thumbpath,null,150,200);
								}
							} else {
								$thumbpath = $result['Path'];
							}
						
							$out .= "<tr><td valign='middle' class='image' height='160' align='center' bgcolor='#EDEEED'><a href='http://".$_SERVER['HTTP_HOST'].$result['Path']."' target='_blank' align='center'><img src='$thumbpath' border='0' id='previewpic'></a></td></tr>\n";

							$out .= $previewDefauts;
							
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["width"]." x ".$GLOBALS['l_we_class']["height"].": </td><td>".$imagesize[0]." x ".$imagesize[1]." px </td></tr>";
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["filesize"].": </td><td>".$filesize."</td></tr>";
							
							$out .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_we_class']["metainfo"]."</td></tr>";
							$nextrowclass = "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Title"].": </td><td>".(isset($metainfos['Title']) ? $metainfos['Title'] : '')."</td></tr>";						
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Description"].": </td><td>".(isset($metainfos['Description']) ? $metainfos['Description'] : '')."</td></tr>";
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Keywords"].": </td><td>".(isset($metainfos['Keywords']) ? $metainfos['Keywords'] : '')."</td></tr>";
							
							$out .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_we_class']["attribs"]."</td></tr>";
							$nextrowclass = "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Title"].": </td><td>".(isset($metainfos['Title']) ? $metainfos['Title'] : '')."</td></tr>";
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["name"].": </td><td>".(isset($metainfos['name']) ? $metainfos['name'] : '')."</td></tr>";
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["alt"].": </td><td>".(isset($metainfos['alt']) ? $metainfos['alt'] : '')."</td></tr>";
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["width"]." x ".$GLOBALS['l_we_class']["height"].": </td><td>".(isset($metainfos['width']) ? $metainfos['width'] : '')." x ".(isset($metainfos['height']) ? $metainfos['height'] : '')." px </td></tr>";
						}
						break;
					case "folder":
						$out .= $previewDefauts;
						if (isset($folderFolders) && is_array($folderFolders) && count($folderFolders)) {
							$out .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_fileselector']["folders"]."</td></tr>";
							$nextrowclass = "odd";
							foreach ($folderFolders as $fId => $fxVal) {
								$out .= "<tr class='$nextrowclass'><td>".$fId.": </td><td>".$fxVal."</td></tr>";
								$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";
							}
						}
						if (isset($folderFiles) && is_array($folderFiles) && count($folderFiles)) {
							$out .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_fileselector']["files"]."</td></tr>";
							$nextrowclass = "odd";
							foreach ($folderFiles as $fId => $fxVal) {
								$out .= "<tr class='$nextrowclass'><td>".$fId.": </td><td>".$fxVal."</td></tr>";
								$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";
							}
						}
						break;
					case "text/weTmpl":
						$out .= $previewDefauts;
						if (isset($result['MasterTemplateID']) && !empty($result['MasterTemplateID'])) {
							$mastertemppath = f("SELECT Text, Path FROM " . mysql_real_escape_string($this->table) . " WHERE ID='".abs($result['MasterTemplateID'])."'","Path",$this->db);
							$out .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_we_class']["master_template"]."</td></tr>";						
							$nextrowclass = "odd";					
							$out .= "<tr class='$nextrowclass'><td>ID:</td><td>".$result['MasterTemplateID']."</td></tr>";						
							$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
							$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["path"].":</td><td>".$mastertemppath."</td></tr>";						
						}
						break;
					case "text/webedition":
						$out .= $previewDefauts;
						$out .= "<tr><td colspan='2' class='headline'>".$GLOBALS['l_we_class']["metainfo"]."</td></tr>";
						$nextrowclass = "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Title"].":</td><td>".(isset($metainfos['Title']) ? $metainfos['Title'] : '')."</td></tr>";						
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Charset"].":</td><td>".(isset($metainfos['Charset']) ? $metainfos['Charset'] : '')."</td></tr>";
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Keywords"].":</td><td>".(isset($metainfos['Keywords']) ? $metainfos['Keywords'] : '')."</td></tr>";
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_we_class']["Description"].":</td><td>".(isset($metainfos['Description']) ? $metainfos['Description'] : '')."</td></tr>";
						break;
					case "text/html":
						$out .= $previewDefauts;						
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["filesize"].":</td><td>".$filesize."</td></tr>";
						break;
					case "text/css":
						$out .= $previewDefauts;						
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["filesize"].":</td><td>".$filesize."</td></tr>";
						break;
					case "text/js":
						$out .= $previewDefauts;						
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["filesize"].":</td><td>".$filesize."</td></tr>";
						break;
					case "application/*":
						$out .= $previewDefauts;						
						$nextrowclass = $nextrowclass == "odd" ? "even" : "odd";					
						$out .= "<tr class='$nextrowclass'><td>".$GLOBALS['l_fileselector']["filesize"].":</td><td>".$filesize."</td></tr>";
						break;
					case "object":
						$out .= $previewDefauts;
						break;
					case "objectFile":
						$out .= $previewDefauts;
						break;
					default:
						$out .= $previewDefauts;
				}
				$out .= "</table></div></td></tr>\t</table>\n";
			}
			$out .= "</body>\n</html>";
			echo $out;
		}
	}

	
}
?>