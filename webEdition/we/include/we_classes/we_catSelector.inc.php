<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_multiSelector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

define("FS_SETDIR",5);
define("FS_CREATEFOLDER",8);
define("FS_DORENAMEENTRY",10);
define("FS_CREATECAT",7);
define("FS_DORENAMECAT",9);
define("FS_DEL",11);
define("FS_PROPERTIES",12);
define("FS_CHANGE_CAT",13);

class we_catSelector extends we_multiSelector{

	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon";

	var $editCatState = true;
	var $we_editCatID="";
	var $EntryText = "";
	var $noChoose = "";

	function we_catSelector($id,
								$table=FILE_TABLE,
								$JSIDName="",
								$JSTextName="",
								$JSCommand="",
								$order="",
								$sessionID="",
								$we_editCatID="",
								$EntryText="",
								$rootDirID=0,
								$noChoose=""){

		$this->we_multiSelector($id,
								$table,
								$JSIDName,
								$JSTextName,
								$JSCommand,
								$order,
								$sessionID,
								$rootDirID);


		$this->editCatState = $this->userCanEditCat();
		$this->we_editCatID	= $we_editCatID;
		$this->EntryText	= $EntryText;
		$this->rootDirID	= $rootDirID;
		$this->noChoose 	= $noChoose;
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
			case FS_CREATEFOLDER:
				$this->printCreateEntryHTML(1);
				break;
			case FS_DORENAMEENTRY:
				$this->printDoRenameEntryHTML();
				break;
			case FS_CREATECAT:
				$this->printCreateEntryHTML(0);
				break;
			case FS_DORENAMECAT:
				$this->printDoRenameEntryHTML();
				break;
			case FS_DEL:
				$this->printDoDelEntryHTML();
				break;
			case FS_PROPERTIES:
				$this->printPropertiesHTML();
				break;
			case FS_CHANGE_CAT:
				$this->printchangeCatHTML();
				break;
			case FS_FRAMESET:
			default:
				$this->printFramesetHTML();
		}
	}

	function getFsQueryString($what){
		return $_SERVER["PHP_SELF"]."?what=$what&table=".$this->table."&id=".$this->id."&order=".$this->order."&noChoose=".$this->noChoose;
	}

	function printHeaderTable(){

		$we_button = new we_button();
		$editCatState = $this->userCanEditCat() ? 1 : 0;
		$changeCatState = $this->userCanChangeCat() ? 1 : 0;
       	print '<script language="JavaScript" type="text/javascript">editCatState='.$editCatState.';</script>';

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
						'. $we_button->create_button("root_dir", "javascript:top.setRootDir();", true, -1, 22, "", "", $this->dir == abs($this->rootDirID), false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="40">
						'. $we_button->create_button("image:btn_fs_back", "javascript:top.goBackDir();", true, -1, 22, "", "", $this->dir == abs($this->rootDirID), false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="40">
						'. $we_button->create_button("image:btn_new_dir", "javascript:if(editCatState==1){top.drawNewFolder();}", true, -1, 22, "", "", !$editCatState, false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="38">
						'. $we_button->create_button("image:btn_add_cat", "javascript:if(editCatState==1){top.drawNewCat();}", true, -1, 22, "", "", !$editCatState, false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
					<td width="27">
						'. $we_button->create_button("image:btn_function_trash", "javascript:if(changeCatState==1){top.deleteEntry();}", true, 27, 22, "", "", !$changeCatState, false) . '
					</td>
					<td width="10">'.getPixel(10,29).'</td>
				</tr>
 ';
 		$this->printHeaderTableSpaceRow();

		print '			</table>
';
	}

	function printHeaderTableSpaceRow(){
		print '				<tr>
					<td colspan="15">'.getPixel(5,10).'</td>
				</tr>
';

	}

	function userCanEditCat(){
		return we_hasPerm("EDIT_KATEGORIE");
	}

	function userCanChangeCat(){
		if(!$this->userCanEditCat()) return false;
		if($this->id == 0) return false;
		return true;
	}

	function printHeaderJSDef(){
		print 'var editCatState = '.($this->userCanEditCat() ? 1 : 0).';
';
		print 'var changeCatState = '.($this->userCanChangeCat() ? 1 : 0).';
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

function disableNewBut(){
	btn_new_dir_enabled = switch_button_state("btn_new_dir", "new_directory_enabled", "disabled", "image");
	btn_add_cat_enabled = switch_button_state("btn_add_cat", "newCategorie_enabled", "disabled", "image");
	editCatState = 0;
}
function enableNewBut(){
	btn_new_dir_enabled = switch_button_state("btn_new_dir", "new_directory_enabled", "enabled", "image");
	btn_add_cat_enabled = switch_button_state("btn_add_cat", "newCategorie_enabled", "enabled", "image");
	editCatState = 1;
}
function disableDelBut(){
	btn_function_trash_enabled = switch_button_state("btn_function_trash", "btn_function_trash_enabled", "disabled", "image");
	changeCatState = 0;
}
function enableDelBut(){
';
if(we_hasPerm("EDIT_KATEGORIE")){
	print '
	btn_function_trash_enabled = switch_button_state("btn_function_trash", "btn_function_trash_enabled", "enabled", "image");
	changeCatState = 1;
';
}
print '
}
';
	}

	function getExitClose(){
		$out = '	function exit_close(){
';
		if(!$this->noChoose){
			$out .= '		if(hot){
			opener.setScrollTo();opener.top.we_cmd("reload_editpage");
		}
';

		}
$out .= '		self.close();
	}
';
		return $out;
	}

	function printFramesetJSFunctioWriteBody(){
		global $BROWSER;
		$htmltop = ereg_replace("[[:cntrl:]]","",trim(str_replace("'","\\'",getHtmlTop())));
		$htmltop = str_replace('script', "scr' + 'ipt", $htmltop);
?>

function writeBody(d){
	d.open();
	//d.writeln('<?php print $htmltop; ?>'); Geht nicht im IE
	d.writeln('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>webEdition (c) living-e AG</title><meta http-equiv="expires" content="0"><meta http-equiv="pragma" content="no-cache"><meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"><meta http-equiv="imagetoolbar" content="no"><meta name="generator" content="webEdition Version 4.9.0.0">');
	d.writeln('<?php print STYLESHEET_SCRIPT; ?>');
	d.writeln('</head>');
	d.writeln('<scr'+'ipt>');
	d.writeln('var ctrlpressed=false');
	d.writeln('var shiftpressed=false');
	d.writeln('var inputklick=false');
	d.writeln('var wasdblclick=false');
	d.writeln('var tout=null');
	d.writeln('document.onclick = weonclick;');
	d.writeln('function weonclick(e){');
	if(makeNewFolder || makeNewCat || we_editCatID){
	d.writeln('if(!inputklick){');
<?php if ($GLOBALS['BROWSER'] == "IE" && substr($GLOBALS["WE_LANGUAGE"],-5) !== "UTF-8") { ?>
	d.writeln('document.we_form.we_EntryText.value=escape(document.we_form.we_EntryText_tmp.value);document.we_form.submit();');

<?php } else { ?>
	d.writeln('document.we_form.we_EntryText.value=document.we_form.we_EntryText_tmp.value;document.we_form.submit();');

<?php } ?>
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
	d.writeln('if((self.shiftpressed==false) && (self.ctrlpressed==false)){top.unselectAllFiles();}');
	}
	d.writeln('}');
	d.writeln('</scr'+'ipt>');
	d.writeln('<body bgcolor="white" LINK="#000000" ALINK="#000000" VLINK="#000000" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0"'+((makeNewFolder || makeNewCat || we_editCatID) ? ' onload="document.we_form.we_EntryText_tmp.focus();document.we_form.we_EntryText_tmp.select();"' : '')+'>');
<?php if ($GLOBALS['BROWSER'] == "IE" && substr($GLOBALS["WE_LANGUAGE"],-5) !== "UTF-8") { ?>
	d.writeln('<form name="we_form" target="fscmd" action="<?php print $_SERVER["PHP_SELF"]; ?>" onsubmit="document.we_form.we_EntryText.value=escape(document.we_form.we_EntryText_tmp.value);return true;">');

<?php } else { ?>
	d.writeln('<form name="we_form" target="fscmd" action="<?php print $_SERVER["PHP_SELF"]; ?>" onsubmit="document.we_form.we_EntryText.value=document.we_form.we_EntryText_tmp.value;return true;">');

<?php } ?>
	if(top.we_editCatID){
		d.writeln('<input type="hidden" name="what" value="<?php print FS_DORENAMEENTRY; ?>">');
		d.writeln('<input type="hidden" name="we_editCatID" value="'+top.we_editCatID+'">');
	}else{
		if(makeNewFolder){
			d.writeln('<input type="hidden" name="what" value="<?php print FS_CREATEFOLDER; ?>">');
		}else{
			d.writeln('<input type="hidden" name="what" value="<?php print FS_CREATECAT; ?>">');
		}
	}
	d.writeln('<input type="hidden" name="order" value="'+top.order+'">');
	d.writeln('<input type="hidden" name="rootDirID" value="<?php print $this->rootDirID; ?>">');
	d.writeln('<input type="hidden" name="table" value="<?php print $this->table; ?>">');
	d.writeln('<input type="hidden" name="id" value="'+top.currentDir+'">');
	d.writeln('<table border="0" cellpadding="0" cellspacing="0" width="100%">');
	if(makeNewFolder){
		d.writeln('<tr style="background-color:#DFE9F5;">');
		d.writeln('<td align="center"><img src="<?php print ICON_DIR?>folder.gif" width="16" height="18" border="0"></td>');
		d.writeln('<td><input type="hidden" name="we_EntryText" value="<?php print $GLOBALS["l_fileselector"]["new_folder_name"]; ?>"><input onMouseDown="self.inputklick=true" name="we_EntryText_tmp" type="text" value="<?php print $GLOBALS["l_fileselector"]["new_folder_name"]?>" class="wetextinput" onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%"></td>');
		d.writeln('</tr>');
	}else if(makeNewCat){
		d.writeln('<tr style="background-color:#DFE9F5;">');
		d.writeln('<td align="center"><img src="<?php print ICON_DIR?>cat.gif" width="16" height="18" border="0"></td>');
		d.writeln('<td><input type="hidden" name="we_EntryText" value="<?php print $GLOBALS["l_fileselector"]["new_cat_name"]; ?>"><input onMouseDown="self.inputklick=true" name="we_EntryText_tmp" type="text" value="<?php print $GLOBALS["l_fileselector"]["new_cat_name"]?>" class="wetextinput" onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%"></td>');
		d.writeln('</tr>');
	}
	for(i=0;i < entries.length; i++){
		var onclick = ' onClick="weonclick(<?php echo ($BROWSER=="IE"?"this":"event")?>);tout=setTimeout(\'if(top.wasdblclick==0){top.doClick('+entries[i].ID+',0);}else{top.wasdblclick=0;}\',300);return true;"';
		var ondblclick = ' onDblClick="top.wasdblclick=1;clearTimeout(tout);top.doClick('+entries[i].ID+',1);return true;"';
		d.writeln('<tr id="line_'+entries[i].ID+'" style="cursor:pointer;'+((we_editCatID != entries[i].ID) ? '-moz-user-select: none;' : '' )+'"'+((we_editCatID || makeNewFolder || makeNewCat) ? '' : onclick)+ (entries[i].isFolder ? ondblclick : '') + ' unselectable="on">');
		d.writeln('<td class="selector" width="25" align="center">');
		if(we_editCatID == entries[i].ID){
			d.writeln('<img src="<?php print ICON_DIR; ?>'+entries[i].icon+'" width="16" height="18" border="0">');
			d.writeln('</td>');
			d.writeln('<td class="selector">');
			d.writeln('<input type="hidden" name="we_EntryText" value="'+entries[i].text+'"><input onMouseDown="self.inputklick=true" name="we_EntryText_tmp" type="text" value="'+entries[i].text+'" class="wetextinput" onblur="this.className=\'wetextinput\';" onfocus="this.className=\'wetextinputselected\'" style="width:100%">');
		}else{
			d.writeln('<img src="<?php print ICON_DIR; ?>'+entries[i].icon+'" width="16" height="18" border="0">');
			d.writeln('</td>');
			d.writeln('<td class="selector"' + (we_editCatID ? '' : ' unselectable="on"') + ' title="'+entries[i].text+'">');
			d.writeln(cutText(entries[i].text,80));
		}
		d.writeln('</td>');
		d.writeln('</tr><tr><td colspan="2"><?php print getPixel(2,1); ?></td></tr>');
	}
	d.writeln('<tr>');
	d.writeln('<td width="25"><?php print getPixel(25,2)?></td>');
	d.writeln('<td><?php print getPixel(150,2)?></td>');
	d.writeln('</tr>');
	d.writeln('</table></form>');
	d.writeln('</body>');
	d.close();
}

<?php

	}

	function printFramesetJSFunctionQueryString(){
?>

function queryString(what,id,o,we_editCatID){
	if(!o) o=top.order;
	if(!we_editCatID) we_editCatID="";
	return '<?php print $_SERVER["PHP_SELF"]; ?>?what='+what+'&rootDirID=<?php print $this->rootDirID; ?>&table=<?php print $this->table; ?>&id='+id+(o ? ("&order="+o) : "")+(we_editCatID ? ("&we_editCatID="+we_editCatID) : "");
}

<?php

	}

	function printFramesetJSFunctions(){
		parent::printFramesetJSFunctions();
?>

function drawNewFolder(){
	unselectAllFiles();
	top.makeNewFolder=true;
	top.writeBody(top.fsbody.document);
	top.makeNewFolder=false;
}
function drawNewCat(){
	unselectAllFiles();
	top.makeNewCat=true;
	top.writeBody(top.fsbody.document);
	top.makeNewCat=false;
}
function deleteEntry(){
	if(confirm('<?php print $GLOBALS["l_fileselector"]["deleteQuestion"]?>')){
		var todel = "";
		for	(var i=0;i < entries.length; i++){
			if(isFileSelected(entries[i].ID)){
				todel += entries[i].ID + ",";
			}
		}
		if (todel) {
			todel = "," + todel;
		}
		top.fscmd.location.replace(top.queryString(<?php print FS_DEL; ?>,top.currentID)+"&todel="+escape(todel));
		if(top.fsvalues) top.fsvalues.location.replace(top.queryString(<?php print FS_PROPERTIES; ?>,0));
		top.fsheader.disableDelBut();
	}

}
function RenameEntry(id){
	top.we_editCatID=id;
	top.writeBody(top.fsbody.document);
	selectFile(id);
	top.we_editCatID=0;
}

<?php

	}

	function getFramesetJavaScriptDef(){
		$def = we_fileselector::getFramesetJavaScriptDef();
		$def .= 'var makeNewFolder=0;
var hot=0; // this is hot for category edit!!
var makeNewCat=0;
var we_editCatID="";
var old=0;
';
		return $def;
	}

	function printCreateEntryHTML($what=0){
		htmlTop();
		print '<script>
top.clearEntries();
';
		$this->EntryText = rawurldecode($this->EntryText);
		$txt = $this->EntryText;
		if($txt==""){
			if($what==1){
				print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["folder"]["filename_empty"], WE_MESSAGE_ERROR);
			}else{
				print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["category"]["filename_empty"], WE_MESSAGE_ERROR);
			}
		}else if(ereg(",",$txt)){
			print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["category"]["name_komma"], WE_MESSAGE_ERROR);
		}else{
			$txt = trim($txt);
			$parentPath = (!abs($this->dir)) ? "" : f("SELECT Path FROM ".$this->table." WHERE ID=".abs($this->dir),"Path",$this->db);
			$Path = $parentPath."/".$txt;

			$this->db->query("SELECT ID FROM ".$this->table." WHERE Path='".addslashes($Path)."'");
			if($this->db->next_record()){
				if($what==1){
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["folder"]["response_path_exists"],$Path);
				}else{
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["category"]["response_path_exists"],$Path);
				}
				print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
			}else{
				if(eregi('[\\\'"<>/]',$txt)){

					$we_responseText = sprintf($GLOBALS["l_we_editor"]["category"]["we_filename_notValid"],$Path);
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
		         }else{
					$this->db->query("INSERT INTO ".$this->table."
								(Category,ParentID,Text,Path,IsFolder,Icon)
								VALUES('".addslashes($txt)."',
									".abs($this->dir).",
									'".addslashes($txt)."',
									'".addslashes($Path)."',".$what.",'".(($what==1) ? 'folder.gif' : 'cat.gif')."')");
    				$folderID = f("SELECT MAX(LAST_INSERT_ID()) as LastID FROM ".$this->table,"LastID",$this->db);
					print 'top.currentPath = "'.$Path.'";
top.currentID = "'.$folderID.'";
top.hot = 1; // this is hot for category edit!!

if(top.currentID){
	top.fsheader.enableDelBut();
	top.showPref(top.currentID);
}
';
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

  	function printHeaderHeadlines(){
		print '			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td width="35%" class="selector" style="padding-left:10px;"><b><a href="#" onclick="javascript:top.orderIt(\'IsFolder DESC, Text\');">'.$GLOBALS["l_fileselector"]["catname"].'</a></b></td>
					<td width="65%" class="selector" style="padding-left:10px;"><b>'.$GLOBALS["l_button"]["properties"]["value"].'</b></td>
				</tr>
				<tr>
					<td width="35%"></td>
					<td width="65%"></td>
				</tr>
			</table>
';

  	}

	function printDoRenameEntryHTML(){
		htmlTop();
protect();
		$foo = getHash("SELECT IsFolder,Text FROM ".$this->table." WHERE ID=".$this->we_editCatID,$this->db);
		$IsDir = $foo["IsFolder"];
		$oldname = $foo["Text"];
		$what = f("SELECT IsFolder FROM " . CATEGORY_TABLE . " WHERE ID='".$this->we_editCatID."'","IsFolder",$this->db);
		print '<script>
top.clearEntries();
';
		$this->EntryText = rawurldecode($this->EntryText);
		$txt = $this->EntryText;
		if($txt==""){
			if($what==1){
				print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["folder"]["filename_empty"], WE_MESSAGE_ERROR);
			}else{
				print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["category"]["filename_empty"], WE_MESSAGE_ERROR);
			}
		}else if(ereg(",",$txt)){
			print we_message_reporting::getShowMessageCall($GLOBALS["l_we_editor"]["category"]["name_komma"], WE_MESSAGE_ERROR);
		}else{
			$parentPath = (!abs($this->dir)) ? "" : f("SELECT Path FROM ".$this->table." WHERE ID=".abs($this->dir),"Path",$this->db);
			$Path = $parentPath."/".$txt;
			$this->db->query("SELECT ID,Text FROM ".$this->table." WHERE Path='".$Path."' AND ID != '".$this->we_editCatID."'");
			if($this->db->next_record()){
				if($what==1){
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["folder"]["response_path_exists"],$Path);
				}else{
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["category"]["response_path_exists"],$Path);
				}
				print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
			}else{
				if(eregi('[\'"<>/]',$txt)){
					$we_responseText = sprintf($GLOBALS["l_we_editor"]["category"]["we_filename_notValid"],$Path);
					print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR);
		         }else{
		         	if(f("SELECT Text FROM ".$this->table." WHERE ID='".$this->we_editCatID."'","Text",$this->db) != $txt){
						$this->db->query("UPDATE ".$this->table."
								SET Category='".addslashes($txt)."',
								ParentID=".abs($this->dir).",
								Text='".addslashes($txt)."',
								Path='".addslashes($Path)."'
								WHERE ID='".$this->we_editCatID."'");
						if($IsDir){
							$this->renameChildrenPath($this->we_editCatID);
						}
						print 'top.currentPath = "'.$Path.'";
top.hot = 1; // this is hot for category edit!!
top.currentID = "'.$this->we_editCatID.'";
if(top.currentID){
	top.fsheader.enableDelBut();
	top.showPref(top.currentID);
}
';
					}
				}

			}
		}


		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

print 'top.fsfooter.document.we_form.fname.value = "";
top.selectFile('.$this->we_editCatID.');top.makeNewFolder = 0;
</script>
';
//	}
		print '</head><body></body></html>';
	}

	function printFramesetJSDoClickFn(){
?>

function doClick(id,ct){
	if(ct==1){
		if(wasdblclick){
			setDir(id);
			setTimeout('wasdblclick=0;',400);
		}else if(top.currentID == id){

<?php if(we_hasPerm("EDIT_KATEGORIE")): ?>
			top.RenameEntry(id);
<?php endif ?>

		}
	}else{
		if(top.currentID == id && (!fsbody.ctrlpressed)){

<?php if(we_hasPerm("EDIT_KATEGORIE")): ?>
			top.RenameEntry(id);
<?php endif ?>

		}else{
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
				hidePref(id);
			}else if(!fsbody.ctrlpressed){
				showPref(id);
				selectFile(id);
			}else{
				hidePref(id);
				if (isFileSelected(id)) {
					unselectFile(id);
				}else{
					selectFile(id);
				}
			}
		}
	}
	if(fsbody.ctrlpressed){
		fsbody.ctrlpressed = 0;
	}
	if(fsbody.shiftpressed){
		fsbody.shiftpressed = 0;
	}
}

function showPref(id) {
	if(self.fsvalues) self.fsvalues.location = '<?php print $this->getFsQueryString(FS_PROPERTIES); ?>&catid='+id;
}

function hidePref() {
	if(self.fsvalues) self.fsvalues.location = '<?php print $this->getFsQueryString(FS_PROPERTIES); ?>';
}

<?php
	}

	function printCmdHTML(){
		print '<script>
top.clearEntries();
';
		$this->printCmdAddEntriesHTML();
		$this->printCMDWriteAndFillSelectorHTML();

if(abs($this->dir)==0){
	print 'top.fsheader.disableRootDirButs();
top.fsheader.disableDelBut();
';
}else{
	print 'top.fsheader.enableRootDirButs();
top.fsheader.enableDelBut();
';
}
print 'top.currentPath = "'.$this->path.'";
top.parentID = "'.$this->values["ParentID"].'";
</script>
';
	}

	function printFramesetSelectFileHTML(){
?>

function unselectFile(id){
	e = getEntry(id);
	top.fsbody.document.getElementById("line_"+id).style.backgroundColor="white";

	var foo = top.fsfooter.document.we_form.fname.value.split(/,/);

	for (var i=0; i < foo.length; i++) {
		if (foo[i] == e.text) {
			foo[i] = "";
			break;
		}
	}
	var str = "";
	for (var i=0; i < foo.length; i++) {
		if(foo[i]){
			str += foo[i]+",";
		}
	}
	str = str.replace(/(.*),$/,"$1");
	top.fsfooter.document.we_form.fname.value = str;
}

function selectFilesFrom(from,to){
	unselectAllFiles();
	for	(var i=from;i <= to; i++){
		selectFile(entries[i].ID);
	}
}

function getFirstSelected(){
	for	(var i=0;i < entries.length; i++){
		if(top.fsbody.document.getElementById("line_"+entries[i].ID).style.backgroundColor!="white"){
			return i;
		}
	}
	return -1;
}

function getPositionByID(id){
	for	(var i=0;i < entries.length; i++){
		if(entries[i].ID == id){
			return i;
		}
	}
	return -1;
}
function isFileSelected(id){
	return (top.fsbody.document.getElementById("line_"+id).style.backgroundColor && (top.fsbody.document.getElementById("line_"+id).style.backgroundColor!="white"));
}

function unselectAllFiles(){
	for	(var i=0;i < entries.length; i++){
		top.fsbody.document.getElementById("line_"+entries[i].ID).style.backgroundColor="white";
	}
	top.fsfooter.document.we_form.fname.value = "";
	top.fsheader.disableDelBut()
}

function selectFile(id){
	if(id){
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
		if(id) top.fsheader.enableDelBut();
		we_editCatID = 0;
	}else{
		top.fsfooter.document.we_form.fname.value = "";
		currentPath = "";
		we_editCatID = 0;
	}
}


<?php
	}

	function printFramesetJSsetDir(){
?>
function setDir(id){
	e = getEntry(id);
	if(id==0) e.text="";
	currentID = id;
	currentDir = id;
	currentPath = e.path;
	top.fsfooter.document.we_form.fname.value = e.text;
	if(id) top.fsheader.enableDelBut();
	top.fscmd.location.replace(top.queryString(<?php print FS_CMD; ?>,id));
}


<?php
	}

	function renameChildrenPath($id){
		$db = new DB_WE();
		$db2 = new DB_WE();
		$db->query("SELECT ID,IsFolder,Text FROM ".CATEGORY_TABLE." WHERE ParentID='$id'");
		while($db->next_record()){
			$newPath = f("SELECT Path FROM ".CATEGORY_TABLE. " WHERE ID='$id'","Path",$db2)."/".$db->f("Text");
			$db2->query("UPDATE ".CATEGORY_TABLE." SET Path='$newPath' WHERE ID='".$db->f("ID")."'");
			if($db->f("IsFolder")){
				$this->renameChildrenPath($db->f("ID"));
			}
		}
	}

	function CatInUse($id,$IsDir){
		$db = new DB_WE();
		if($IsDir){
			return $this->DirInUse($id);
		}else{
			$ret = f("SELECT ID FROM " . FILE_TABLE . " WHERE Category like '%,".$id.",%' OR temp_category like '%,".$id.",%'","ID",$db);
			if($ret) return true;
			if(defined("OBJECT_TABLE")){
				$ret = f("SELECT ID FROM " . OBJECT_FILES_TABLE . " WHERE Category like '%,".$id.",%'","ID",$db);
				if($ret) return true;
			}
		}
		return false;
	}

	function DirInUse($id){
		$db=new DB_WE();
		if($this->CatInUse($id,0)) return true;

		$db->query("SELECT ID,IsFolder FROM ".$this->table." WHERE ParentID='$id'");
		while($db->next_record()){
			if($this->CatInUse($db->f("ID"),$db->f("IsFolder"))) return true;
		}
		return false;
	}

	function printDoDelEntryHTML(){
		htmlTop();
		protect();



		if (isset($_REQUEST["todel"])) {


			$finalDelete = array();
			$catsToDel = makeArrayFromCSV($_REQUEST["todel"]);
			$catlistNotDeleted = "";
			$changeToParent=false;
			foreach ($catsToDel as $id) {
				$IsDir = f("SELECT IsFolder FROM ".$this->table." WHERE ID=".$this->id,"IsFolder",$this->db);
				if ($this->CatInUse($id,$IsDir)) {
					$catlistNotDeleted .= id_to_path($id, CATEGORY_TABLE)."\\n";
				} else {
					array_push($finalDelete,array("id"=>$id,"IsDir"=>$IsDir));
				}
			}
			if (sizeof($finalDelete)) {
				foreach ($finalDelete as $foo) {
					if ($foo["IsDir"]) {
						$this->delDir($foo["id"]);
					} else {
						$this->delEntry($foo["id"]);
					}
					if($this->dir == $foo["id"]){
						$changeToParent=true;
					}
				}
			}
			if($catlistNotDeleted){

				print we_htmlElement::jsElement(
					we_message_reporting::getShowMessageCall($GLOBALS["l_fileselector"]["cat_in_use"] . '\n\n' . $catlistNotDeleted, WE_MESSAGE_ERROR)
				);
			}
			if($changeToParent){
				$this->dir = $this->values["ParentID"];
			}
			$this->id = $this->dir;
			if($this->id){
				$foo = getHash("SELECT Path,Text FROM " . CATEGORY_TABLE . " WHERE ID='".$this->id."'",$this->db);
				$Path = $foo["Path"];
				$Text = $foo["Text"];
			}else{
				$Path = "";
				$Text = "";
			}

			print '<script>
top.clearEntries();
';
			$this->printCmdAddEntriesHTML();
			$this->printCMDWriteAndFillSelectorHTML();

			print 'top.makeNewFolder = 0;
top.currentPath = "'.$Path.'";
top.currentID = "'.$this->id.'";
top.selectFile('.$this->id.');
if(top.currentID && top.fsfooter.document.we_form.fname.value != "")
	top.fsheader.enableDelBut();
</script>
';

		}
		print '</head><body></body></html>';

		return;

		$IsDir = f("SELECT IsFolder FROM ".$this->table." WHERE ID=".$this->id,"IsFolder",$this->db);
		if($this->CatInUse($this->id,$IsDir)){

			print we_htmlElement::jsElement(
					we_message_reporting::getShowMessageCall($GLOBALS["l_fileselector"]["cat_in_use"] . '\n\n' . $catlistNotDeleted, WE_MESSAGE_ERROR)
				);
		}else{
			print '<script>
top.clearEntries();
';
			if($IsDir){
				$this->delDir($this->id);
			}else{
				$this->delEntry($this->id);
			}
			if($this->dir && ($this->dir==$this->id)){
				$this->dir = $this->values["ParentDir"];
			}
			$this->id = $this->dir;

			if($this->id){
				$foo = getHash("SELECT Path,Text FROM " . CATEGORY_TABLE . " WHERE ID='".$this->id."'",$this->db);
				$Path = $foo["Path"];
				$Text = $foo["Text"];
			}else{
				$Path = "";
				$Text = "";
			}
			$this->printCmdAddEntriesHTML();
			$this->printCMDWriteAndFillSelectorHTML();

		print 'top.makeNewFolder = 0;
top.currentPath = "'.$Path.'";
top.currentID = "'.$this->id.'";
top.fsfooter.document.we_form.fname.value = "'.$Text.'";
if(top.currentID && top.fsfooter.document.we_form.fname.value != "")
	top.fsheader.enableDelBut();
</script>
';
		}

		print '</head><body></body></html>';
	}

	function delDir($id){
		$db = new DB_WE();
		$db->query("SELECT * FROM ".$this->table." WHERE ParentID='$id'");
		while($db->next_record()){
			if($db->f("IsFolder")){
				$this->delDir($db->f("ID"));
			}
			$this->delEntry($db->f("ID"));
		}
		$this->delEntry($id);
	}

	function delEntry($id){
		$this->db->query("DELETE FROM ".$this->table." WHERE ID='$id'");
	}

	function printFooterTable() {
		$we_button = new we_button();
		if($this->values["Text"] == "/" ) $this->values["Text"]="";
		$csp = $this->noChoose ? 4 : 5;

		if(!$this->noChoose){

			$okBut = $we_button->create_button("ok", "javascript:press_ok_button();");
		} else {
			$okBut = "";
		}
		print '
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="5"><img src="'.IMAGE_DIR.'umr_h_small.gif" width="100%" height="2" border="0"></td>
				</tr>
				<tr>
					<td colspan="5">'.getPixel(5,5).'</td>
				</tr>';
		$cancelbut = $we_button->create_button("close", "javascript:top.exit_close();");
		if($okBut){
			$buttons =$we_button->position_yes_no_cancel(	$okBut,
												null,
												$cancelbut);
		}else{
			$buttons = $cancelbut;
		}

		print '
				<tr>
					<td></td>
					<td class="defaultfont">
						<b>'.$GLOBALS["l_fileselector"]["catname"].'</b>
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

	function getFrameset(){
		$isMainChooser = isset($_REQUEST["we_cmd"]) && $_REQUEST["we_cmd"][0] == "openCatselector" && !($_REQUEST["we_cmd"][3] || $_REQUEST["we_cmd"][5]);
		return '<frameset rows="67,*,65,0" border="0">
	<frame src="'.$this->getFsQueryString(FS_HEADER).'" name="fsheader" noresize scrolling="no">
' .($isMainChooser ? '
	<frameset cols="35%,65%" border="0">
' : '') . '
    	<frame src="'.$this->getFsQueryString(FS_BODY).'" name="fsbody" scrolling="auto">
' .($isMainChooser ? '
    	<frame src="'.$this->getFsQueryString(FS_PROPERTIES).'" name="fsvalues"  scrolling="auto">
    </frameset>
' : '') .'
    <frame src="'.$this->getFsQueryString(FS_FOOTER).'"  name="fsfooter" noresize scrolling="no">
    <frame src="'.HTML_DIR.'white.html"  name="fscmd" noresize scrolling="no">
</frameset>
<body>
</body>
</html>
';
	}

	function printChangeCatHTML() {
		if (isset($_POST["catid"])) {
			$db = new DB_WE();
			$result = getHash("SELECT Category,Catfields,ParentID,Path FROM " . CATEGORY_TABLE . " WHERE ID='".abs($_POST["catid"])."'",$db);
			$fields =  isset($result["Catfields"]) ? $result["Catfields"] : "";
			if ($fields) {
				$fields = unserialize($fields);
			} else {
				$fields = array(
					"default" => array("Title"=>"","Description"=>"")
				);
			}
			$fields[$_SESSION["we_catVariant"]]["Title"] = $_REQUEST["catTitle"];
			$fields[$_SESSION["we_catVariant"]]["Description"] = $_REQUEST["catDescription"];
			$path = $result['Path'];
			$parentid = ($_REQUEST["FolderID"]!=""?$_REQUEST["FolderID"]:$result['ParentID']);
			$category = (isset($_REQUEST['Category'])?$_REQUEST['Category']:$result['Category']);

			$targetPath = id_to_path($parentid, CATEGORY_TABLE);

			$js = "";
			if(preg_match("|^".preg_quote($path, "|")."|", $targetPath) || preg_match("|^".preg_quote($path, "|")."/|", $targetPath)) {
				// Verschieben nicht m�glich
				$parentid = $result['ParentID'];

				if($parentid == 0) {
					$parentPath = "/";
					$path = "/".$category;
				} else {
					$tmp = explode("/", $path);
					array_pop($tmp);
					$parentPath =implode("/", $tmp);
					$path = $parentPath."/".$category;
				}
				$js = "top.frames['fsvalues'].document.we_form.elements['FolderID'].value = '$parentid';top.frames['fsvalues'].document.we_form.elements['FolderIDPath'].value = '$parentPath';";
			} else {
				if($parentid == 0) {
					$path = "/".$category;
				} else {
					$path = $targetPath."/".$category;
				}
			}
			$updateok = $db->query("UPDATE " . CATEGORY_TABLE . " SET Category='".addslashes($category)."', Text='".addslashes($category)."', Path='".$path."', ParentID='".$parentid."', Catfields='".addslashes(serialize($fields))."' WHERE ID='".abs($_POST["catid"])."'");
			if($updateok) {
				$this->renameChildrenPath(abs($_POST["catid"]));
			}
			htmlTop();
			protect();
			print '<script>'.$js.'top.setDir(top.frames[\'fsheader\'].document.we_form.elements[\'lookin\'].value);' .
				($updateok
					? we_message_reporting::getShowMessageCall( sprintf($GLOBALS["l_we_editor"]["category"]["response_save_ok"],$category), WE_MESSAGE_NOTICE)
					: we_message_reporting::getShowMessageCall( sprintf($GLOBALS["l_we_editor"]["category"]["response_save_notok"],$category), WE_MESSAGE_ERROR ) )
				. '</script>';

			print '</head><body></body></html>';
		}
	}

	function printPropertiesHTML(){

		$showPrefs = (isset($_REQUEST["catid"]) && $_REQUEST["catid"] );

		$path = "";

		$title = "";
		$variant = isset($_SESSION["we_catVariant"]) ? $_SESSION["we_catVariant"] : "default";
		$_SESSION["we_catVariant"] = $variant;
		$description="";
		if ($showPrefs) {
			$result = getHash("SELECT ID,Category,Catfields,Path,ParentID FROM " . CATEGORY_TABLE . " WHERE id='".abs($_REQUEST["catid"])."'", new DB_WE());
			if(isset($result["Catfields"]) && $result["Catfields"]) {
				$fields = unserialize($result["Catfields"]);
			} else {
				$fields = array(
					"default" => array("Title"=>"","Description"=>"")
				);
			}
			if($result["ParentID"] != 0) {
				$result2 = getHash("SELECT Path FROM " . CATEGORY_TABLE . " WHERE id='".abs($result["ParentID"])."'", new DB_WE());
				$path = isset($result2["Path"]) ? $result2["Path"] : '/';
			} else {
				$path = "/";
			}
			$parentId = isset($result["ParentID"]) ? $result["ParentID"] : '0';
			$category = isset($result["Category"]) ? $result["Category"] : '';
			$catID = isset($result["ID"]) ? abs($result["ID"]) : 0;
			$title = $fields[$_SESSION["we_catVariant"]]["Title"];
			$description = $fields[$_SESSION["we_catVariant"]]["Description"];
			unset($result);
			$we_button = new we_Button();

			$dir_hidden = hidden('FolderID', $parentId);
			$dir_input = htmlTextInput('FolderIDPath', 24, $path, '', "style='width: 240px;'");

			$dir_chooser = $we_button->create_button('select', "javascript:we_cmd('openSelector', document.we_form.elements['FolderID'].value, '" . CATEGORY_TABLE . "', 'document.we_form.elements[\\'FolderID\\'].value', 'document.we_form.elements[\\'FolderIDPath\\'].value', '', '', '', '1', '', 'false', 1)");

			$table = new we_htmlTable(array("border" => "0", "cellpadding" => "0", "cellspacing" => "0"),4, 3);

			$table->setCol(0, 0, array("style" => "width:100px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), '<b>'.$GLOBALS["l_we_class"]["category"].'</b>');
			$table->setCol(0, 1, array("colspan" => 2, "style" => "width:350px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), htmlTextInput("Category",50,$category,"",' id="category"',"text",360));

			$table->setCol(1, 0, array("style" => "width:100px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), "<b>ID</b>");
			$table->setCol(1, 1, array("colspan" => 2, "style" => "width:350px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), $catID);

			$table->setCol(2, 0, array("style" => "width:100px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), '<b>'.$GLOBALS["l_we_class"]["dir"].'</b>');
			$table->setCol(2, 1, array("style" => "width:240px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), $dir_hidden . $dir_input);
			$table->setCol(2, 2, array("style" => "width:110px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont", "align" => "right"), $dir_chooser);

			$table->setCol(3, 0, array("style" => "width:100px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), "<b>".$GLOBALS["l_global"]["title"]."</b>");
			$table->setCol(3, 1, array("colspan" => 2, "style" => "width:350px; padding: 0px 0px 10px 0px;", "class"=>"defaultfont"), htmlTextInput("catTitle",50,$title,"",'',"text",360));

			$ta = htmlFormElementTable(we_forms::weTextarea("catDescription",$description,array("bgcolor"=>"white","inlineedit"=>"true","wysiwyg"=>"true","width"=>"450", "height"=>"130"), true, 'autobr',true,"",true,true,true,false,""),
			"<b>".$GLOBALS["l_global"]["description"] ."</b>", "left", "defaultfont", "", "", "", "", "", 0);
			$saveBut = $we_button->create_button("save", "javascript:weWysiwygSetHiddenText();we_checkName();");


		}



		htmlTop();
		protect();
		print '
<script type="text/javascript" src="' . JS_DIR . 'we_textarea.js"></script>
<script src="' . JS_DIR . 'windows.js" language="JavaScript" type="text/javascript"></script>
<script type="text/javascript">
function we_cmd(){
	var args = "";
	var url = "/webEdition/we_cmd.php?"; for(var i = 0; i < arguments.length; i++){ url += "we_cmd["+i+"]="+escape(arguments[i]); if(i < (arguments.length - 1)){ url += "&"; }}

	switch (arguments[0]){
		case "openSelector":
			new jsWindow(url,"we_selector",-1,-1,'.WINDOW_SELECTOR_WIDTH.','.WINDOW_SELECTOR_HEIGHT.',true,true,true,true);
			break;
		default:
			for(var i = 0; i < arguments.length; i++){
				args += \'arguments[\'+i+\']\' + ((i < (arguments.length-1)) ? \',\' : \'\');
			}
			eval(\'parent.we_cmd(\'+args+\')\');
	}
}
function we_checkName() {
	var regExp = /\'|"|>|<|\\|///;
	if(regExp.test(document.getElementById("category").value)) {
';
	$we_responseText = sprintf($GLOBALS["l_we_editor"]["category"]["we_filename_notValid"], $path);
	print we_message_reporting::getShowMessageCall($we_responseText, WE_MESSAGE_ERROR) . '
	} else {
		document.we_form.submit();
	}
}
</script>
';
		print STYLESHEET.'</head><body class="defaultfont" style="margin:0;padding: 15px 0 0 10px;background-image:url(/webEdition/images/backgrounds/aquaBackgroundLineLeft.gif);">
' . ($showPrefs ? '
	<form onsubmit="weWysiwygSetHiddenText();"; action="'.$_SERVER["PHP_SELF"].'" name="we_form" method="post" target="fscmd"><input type="hidden" name="what" value="'.FS_CHANGE_CAT.'"><input type="hidden" name="catid" value="'.$_REQUEST["catid"].'">
		'.$table->getHtmlCode()."<br />".$ta."<br />".$saveBut.'
	</div>		' : '' ) .'
</body></html>';
	}


}

?>