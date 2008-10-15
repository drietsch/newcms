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
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/we_editor.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/fileselector.inc.php");

if(!defined("FS_DEL")) define("FS_DEL",11);

class we_delSelector extends we_multiSelector{

	var $fields = "ID,ParentID,Text,Path,IsFolder,Icon";
	

	function we_delSelector($id,
								$table=FILE_TABLE){
		
		$this->we_multiSelector($id,
								$table);

								
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
			case FS_DEL:
				$this->printDoDelEntryHTML();
				break;
			case FS_FRAMESET:
			default:
				$this->printFramesetHTML();
		}
	}


	function printFooterJS(){
		$we_button = new we_button();
		print '
		
' . $we_button->create_state_changer(false) . '
function disableDelBut(){
	delete_enabled = switch_button_state("delete", "delete_enabled", "disabled");
}
function enableDelBut(){
	delete_enabled = switch_button_state("delete", "delete_enabled", "enabled");
}
';
	}

	function printFramesetJSFunctions(){
		parent::printFramesetJSFunctions();
?>

function deleteEntry(){
	if(confirm('<?php print $GLOBALS["l_fileselector"]["deleteQuestion"]?>')){
		var todel = "";
		var docIsOpen = false;
		for	(var i=0;i < entries.length; i++){
			if(isFileSelected(entries[i].ID)){
				todel += entries[i].ID + ",";
				<?php
				if(isset($_SESSION['seemForOpenDelSelector']['ID'])) {
				?>
					if(entries[i].ID=="<?php print $_SESSION['seemForOpenDelSelector']['ID']; ?>") {
						docIsOpen = true;
					}
				<?php
					unset($_SESSION['seemForOpenDelSelector']['ID']);
				}
				?>
			}
		}
		if (todel) {
			todel = "," + todel;
		}
		
		top.fscmd.location.replace(top.queryString(<?php print FS_DEL; ?>,top.currentID)+"&todel="+escape(todel));
		top.fsfooter.disableDelBut();

		if(docIsOpen) {
			//top.opener.top.weEditorFrameController.openDocument("", "", "cockpit", "open_cockpit", "", "", "", "", "");
			top.opener.top.we_cmd('close_all_documents');
			top.opener.top.we_cmd('start_multi_editor');
		}
		
		
	}

}

<?php

	}






	function printFramesetJSDoClickFn(){
?>

function doClick(id,ct){
	if(ct==1){
		if(wasdblclick){
			setDir(id);
			setTimeout('wasdblclick=0;',400);
		}
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
			
		}else if(!fsbody.ctrlpressed){
			selectFile(id);
		}else{
			if (isFileSelected(id)) {
				unselectFile(id);
			}else{
				selectFile(id);
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
top.fsfooter.disableDelBut();
';
}else{
	print 'top.fsheader.enableRootDirButs();
top.fsfooter.enableDelBut();
';
}
print 'top.currentPath = "'.$this->path.'";
top.parentID = "'.$this->values["ParentID"].'";
</script>
';
	}

	function printFramesetSelectFileHTML(){
?>	


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
		if(id) top.fsfooter.enableDelBut();
		we_editDelID = 0;
	}else{
		top.fsfooter.document.we_form.fname.value = "";
		currentPath = "";
		we_editDelID = 0;
	}
}


<?php
	}

	function printFramesetUnselectAllFilesHTML(){
?>	

function unselectAllFiles(){
	for	(var i=0;i < entries.length; i++){
		top.fsbody.document.getElementById("line_"+entries[i].ID).style.backgroundColor="white";
	}
	top.fsfooter.document.we_form.fname.value = "";
	top.fsfooter.disableDelBut();
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
	if(id) top.fsfooter.enableDelBut();
	top.fscmd.location.replace(top.queryString(<?php print FS_CMD; ?>,id));
}


<?php
	}
	
	function renameChildrenPath($id){
		$db = new DB_WE();
		$db2 = new DB_WE();
		$db->query("SELECT ID,IsFolder,Text FROM ".mysql_real_escape_string($this->table)." WHERE ParentID='".abs($id)."'");
		while($db->next_record()){
			$newPath = f("SELECT Path FROM ".mysql_real_escape_string($this->table). " WHERE ID='".abs($id)."'","Path",$db2)."/".$db->f("Text");
			$db2->query("UPDATE ".mysql_real_escape_string($this->table)." SET Path='".mysql_real_escape_string($newPath)."' WHERE ID='".abs($db->f("ID"))."'");
			if($db->f("IsFolder")){
				$this->renameChildrenPath($db->f("ID"));
			}
		}
	}
	
	
	
	function printDoDelEntryHTML(){
		htmlTop();		
		protect();
		
		
		
		if (isset($_REQUEST["todel"])) {
			$_SESSION["todel"] = $_REQUEST["todel"];
			print '<script src="'.JS_DIR.'windows.js" language="JavaScript" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript">
	top.opener.top.we_cmd("del_frag", "' . $_REQUEST["todel"] . '");
	top.close();
</script>';
		}	
		print '</head><body></body></html>';
		
	}
	
	function printFooterTable() {
		$we_button = new we_button();
		if($this->values["Text"] == "/" ) $this->values["Text"]="";
		$okBut = $we_button->create_button("delete", "javascript:if(document.we_form.fname.value==''){top.exit_close();}else{top.deleteEntry();}", true,100,22,"","",true,false);
		
		print '
			<table border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr>
					<td colspan="5"><img src="'.IMAGE_DIR.'umr_h_small.gif" width="100%" height="2" border="0"></td>
				</tr>
				<tr>
					<td colspan="5">'.getPixel(5,5).'</td>
				</tr>';
		$cancelbut = $we_button->create_button("cancel", "javascript:top.exit_close();");
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
						<b>'.$GLOBALS["l_fileselector"]["filename"].'</b>
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

	
	function query(){
		
		global $_isp_hide_files;	//	ISP_VERSION
		
		//	Changes for ISP_VERSION
		//	dont look for files in array . $_isp_hide_files
		
		$wsQuery = getWsQueryForSelector($this->table, false);
		
		$_query = "	SELECT ".$this->fields."
					FROM ".mysql_real_escape_string($this->table)."
					WHERE ParentID='".abs($this->dir)."'".makeOwnersSql().
					$wsQuery .
					((defined('ISP_VERSION') && ISP_VERSION && is_array($_isp_hide_files) && sizeof($_isp_hide_files) > 0) ? "AND Path NOT IN ('" . implode("','", $_isp_hide_files) . "')" : '').
					($this->order ? (' ORDER BY '.$this->order) : '');
		
		$this->db->query($_query);

	}
}
?>