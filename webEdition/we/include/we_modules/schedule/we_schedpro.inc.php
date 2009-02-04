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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");

if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_forms.inc.php");
}

class we_schedpro{
	var $task = 1;
	var $type = 0;
	var $months = array();
	var $days = array();
	var $weekdays = array();
	var $time = 0;
	var $nr = 0;
	var $CategoryIDs = "";
	var $DoctypeID = 0;
	var $ParentID = 0;
	var $active = 1;
	var $doctypeAll = 0;

	function we_schedpro($s = "",$nr=0){
		if(is_array($s)){
			$this->task        = isset($s["task"]) ? $s["task"] : 1;
			$this->type        = isset($s["type"]) ? $s["type"] : 0;
			$this->months      = isset($s["months"]) ?$s["months"] : array();
			$this->days        = isset($s["days"]) ? $s["days"] : array();
			$this->weekdays    = isset($s["weekdays"]) ? $s["weekdays"] : array();
			$this->time        = isset($s["time"]) ? $s["time"] : time();
			$this->CategoryIDs = isset($s["CategoryIDs"]) ? $s["CategoryIDs"] : "";
			$this->DoctypeID   = isset($s["DoctypeID"]) ? $s["DoctypeID"] : 0;
			$this->ParentID    = isset($s["ParentID"]) ? $s["ParentID"] : 0;
			$this->active      = isset($s["active"]) ? $s["active"] : 1;
			$this->doctypeAll  = isset($s["doctypeAll"]) ? $s["doctypeAll"] : 0;;
		}else{
			$this->task = 1;
			$this->type = 0;
			$this->months = array();
			$this->days = array();
			$this->weekdays = array();
			$this->time = time();
			$this->CategoryIDs = "";
			$this->DoctypeID = 0;
			$this->ParentID = 0;
			$this->active = 1;
			$this->doctypeAll = 0;
		}
		$this->nr = $nr;
	}


	function getMonthsHTML(){
		$months = '<table cellpadding="0" cellspacing="0" border="0"><tr>
';

		for($i=1;$i<=12;$i++){
			$months .= '<td>' . we_forms::checkbox("1", $this->months[$i-1], "check_we_schedule_month".$i."_".$this->nr, $GLOBALS["l_monthShort"][$i-1], false, "defaultfont", "this.form.elements['we_schedule_month".$i."_".$this->nr."'].value=this.checked?1:0;_EditorFrame.setEditorIsHot(true)") .
			  '<input type="hidden" name="we_schedule_month'.$i.'_'.$this->nr.'" value="'.$this->months[$i-1].'"></td>';
		}

		$months .= '</tr></table>
';
		return $months;
	}

	function getDaysHTML(){
		$days = '<table cellpadding="0" cellspacing="0" border="0"><tr>';

		for($i=1;$i<=36;$i++){
			if($i<= 31){
				$days .= '<td>' . we_forms::checkbox("1", $this->days[$i-1], "check_we_schedule_day".$i."_".$this->nr, sprintf('%02d',$i), false, "defaultfont", "this.form.elements['we_schedule_day".$i."_".$this->nr."'].value=this.checked?1:0;_EditorFrame.setEditorIsHot(true)")

					. '<input type="hidden" name="we_schedule_day'.$i.'_'.$this->nr.'" value="'.$this->days[$i-1].'"></td><td class="defaultfont">&nbsp;</td>';
			}else{
				$days .= '<td colspan="3">';
			}
			switch($i){
				case 14:
				case 28:
					$days .= '</tr><tr>'."\n";
					break;
			}
		}

		$days .= '</tr></table>
';
		return $days;
	}

	function getWeekdaysHTML(){
		$wd = '<table cellpadding="0" cellspacing="0" border="0"><tr>
';

		for($i=1;$i<=7;$i++){
			$wd .= '<td>' .	we_forms::checkbox("1", $this->weekdays[$i-1], "check_we_schedule_wday'.$i.'_'.$this->nr.'", $GLOBALS["l_dayShort"][$i-1], false, "defaultfont", "this.form.elements['we_schedule_wday" . $i . "_" . $this->nr . "'].value=this.checked?1:0;_EditorFrame.setEditorIsHot(true)")
     			.  '<input type="hidden" name="we_schedule_wday'.$i.'_'.$this->nr.'" value="'.$this->weekdays[$i-1].'"></td><td class="defaultfont">&nbsp;</td>';
		}

		$wd .= '</tr></table>
';
		return $wd;
	}

	function getSpacerRowHTML(){
		return '	<tr valign="top">
		<td>'.getPixel(80,10).'</td>
		<td>'.getPixel(565,10).'</td>
		<td>'.getPixel(26,10).'</td>
	</tr>
';
	}

	function getHTML($isobj=false){

		$we_button = new we_button();

		$taskpopup = '<select class="weSelect" name="we_schedule_task_'.$this->nr.'" size="1" onchange="_EditorFrame.setEditorIsHot(true);if(self.we_hasExtraRow_'.$this->nr.' || this.options[this.selectedIndex].value=='.SCHEDULE_DOCTYPE.' || this.options[this.selectedIndex].value=='.SCHEDULE_CATEGORY.' || this.options[this.selectedIndex].value=='.SCHEDULE_DIR.'){ setScrollTo();we_cmd(\'reload_editpage\');}">
<option value="'.SCHEDULE_FROM.'"'.(($this->task == SCHEDULE_FROM) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["task"][SCHEDULE_FROM].'</option>
<option value="'.SCHEDULE_TO.'"'.(($this->task == SCHEDULE_TO) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["task"][SCHEDULE_TO].'</option>
';
		if((we_hasPerm("DELETE_DOCUMENT") && (!$isobj)) || (we_hasPerm("DELETE_OBJECTFILE") && $isobj)){
			$taskpopup .= '<option value="'.SCHEDULE_DELETE.'"'.(($this->task == SCHEDULE_DELETE) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["task"][SCHEDULE_DELETE].'</option>
';
		}
		if(!$isobj){
			$taskpopup .= '<option value="'.SCHEDULE_DOCTYPE.'"'.(($this->task == SCHEDULE_DOCTYPE) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["task"][SCHEDULE_DOCTYPE].'</option>
';
		}
			$taskpopup .= '<option value="'.SCHEDULE_CATEGORY.'"'.(($this->task == SCHEDULE_CATEGORY) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["task"][SCHEDULE_CATEGORY].'</option>
';
		if((we_hasPerm("MOVE_DOCUMENT") && (!$isobj)) || (we_hasPerm("MOVE_OBJECTFILE") && $isobj)){
			$taskpopup .= '
<option value="'.SCHEDULE_DIR.'"'.(($this->task == SCHEDULE_DIR) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["task"][SCHEDULE_DIR].'</option>
';
		}
		$taskpopup .= '</select>
';
		$extracont = "";
		$extraheadl="";


		if($this->task==SCHEDULE_DOCTYPE){
			$db = new DB_WE();
			$q=getDoctypeQuery($db);
			$db->query("SELECT ID,DocType FROM " . DOC_TYPES_TABLE . " $q");
			$doctypepop = '<select class="weSelect" name="we_schedule_doctype_'.$this->nr.'" size="1" onchange="_EditorFrame.setEditorIsHot(true)">
';
			while($db->next_record()){
				$doctypepop .= '<option value="'.$db->f("ID").'"'.(($this->DoctypeID == $db->f("ID")) ? ' selected="selected"' : '').'>'.$db->f("DocType").'</option>
';
			}
			$doctypepop .= '</select>';
			$checknname = md5(uniqid(rand(),1));
			$extracont = '<table border="0" cellpadding="0" cellspacing="0"><tr><td>'.$doctypepop.'</td><td class="defaultfont">&nbsp;&nbsp;</td><td>' . we_forms::checkbox("1", $this->doctypeAll, $checknname, $GLOBALS["l_schedpro"]["doctypeAll"], false, "defaultfont", "this.form.elements['we_schedule_doctypeAll_".$this->nr."'].value=this.checked?1:0;")
																																						 .  '<input type="hidden" name="we_schedule_doctypeAll_'.$this->nr.'" value="'.$this->doctypeAll.'"></td></tr></table>';
			$extraheadl = $GLOBALS["l_schedpro"]["doctype"];

		}else if($this->task==SCHEDULE_CATEGORY){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");
			$delallbut = $we_button->create_button("delete_all", "javascript:we_cmd('delete_all_schedcats',".$this->nr.")");
			$addbut    = $we_button->create_button("add","javascript:we_cmd('openCatselector','','".CATEGORY_TABLE."','','','opener.setScrollTo();opener.top.we_cmd(\\'add_schedcat\\',top.currentID,".$this->nr.");')");
			$cats = new MultiDirChooser(450,$this->CategoryIDs,"delete_schedcat",$we_button->create_button_table(array($delallbut, $addbut)),"","Icon,Path",CATEGORY_TABLE,"defaultfont",$this->nr);
			$cats->extraDelFn = 'setScrollTo();';
			if(!we_hasPerm("EDIT_KATEGORIE")){
				$cats->isEditable=false;
			}
			$extracont = $cats->get();
			$extraheadl = $GLOBALS["l_schedpro"]["categories"];
		}else if($this->task==SCHEDULE_DIR){

			$textname = 'path_we_schedule_parentid_'.$this->nr;
			$idname = 'we_schedule_parentid_'.$this->nr;
			$myid = $this->ParentID;
			$path = id_to_path($this->ParentID, $GLOBALS['we_doc']->Table);

			if($GLOBALS['we_doc']->ClassName == "we_objectFile"){
				if($path == "/"){ //	impossible for documents
					$path = $GLOBALS["we_doc"]->RootDirPath;
				}
				$_rootDirID = $GLOBALS["we_doc"]->rootDirID;

			} else {
				$_rootDirID = 0;
			}

			$button = $we_button->create_button("select", "javascript:we_cmd('openDirselector',document.we_form.elements['$idname'].value,'".$GLOBALS['we_doc']->Table."','document.we_form.elements[\\'$idname\\'].value','document.we_form.elements[\\'$textname\\'].value','top.opener._EditorFrame.setEditorIsHot(true);','".session_id()."','" . $_rootDirID . "')");
			
			$yuiSuggest =& weSuggest::getInstance();
			$yuiSuggest->setAcId("WsDir");
			$yuiSuggest->setContentType("folder");
			$yuiSuggest->setInput($textname,$path);
			$yuiSuggest->setMaxResults(20);
			$yuiSuggest->setMayBeEmpty(0);
			$yuiSuggest->setResult($idname,$myid);
			$yuiSuggest->setSelector("Dirselector");
			$yuiSuggest->setTable(FILE_TABLE);
			$yuiSuggest->setWidth(320);
			$yuiSuggest->setSelectButton($button);
			
			
			$extracont = $yuiSuggest->getYuiFiles().$yuiSuggest->getHTML().$yuiSuggest->getYuiCode();
			$extraheadl = $GLOBALS["l_schedpro"]["dirctory"];
		}

		$typepopup = '<select class="weSelect" name="we_schedule_type_'.$this->nr.'" size="1" onchange="_EditorFrame.setEditorIsHot(true);setScrollTo();we_cmd(\'reload_editpage\')">
<option value="'.SCHEDULE_TYPE_ONCE.'"'.(($this->type == SCHEDULE_TYPE_ONCE) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_ONCE].'</option>
<option value="'.SCHEDULE_TYPE_HOUR.'"'.(($this->type == SCHEDULE_TYPE_HOUR) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_HOUR].'</option>
<option value="'.SCHEDULE_TYPE_DAY.'"'.(($this->type == SCHEDULE_TYPE_DAY) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_DAY].'</option>
<option value="'.SCHEDULE_TYPE_WEEK.'"'.(($this->type == SCHEDULE_TYPE_WEEK) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_WEEK].'</option>
<option value="'.SCHEDULE_TYPE_MONTH.'"'.(($this->type == SCHEDULE_TYPE_MONTH) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_MONTH].'</option>
<option value="'.SCHEDULE_TYPE_YEAR.'"'.(($this->type == SCHEDULE_TYPE_YEAR) ? ' selected' : '').'>'.$GLOBALS["l_schedpro"]["type"][SCHEDULE_TYPE_YEAR].'</option>
</select>
';


		$checknname = md5(uniqid(rand(),1));
		$table = '<table cellpadding="0" cellspacing="0" border="0">
	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["task"]["headline"].':</td>
		<td class="defaultfont"><table border="0" cellpadding="0" cellspacing="0"><tr><td>'.$taskpopup.'</td><td class="defaultfont">&nbsp;&nbsp;</td><td>' . we_forms::checkbox("1", $this->active, $checknname, $GLOBALS["l_schedpro"]["active"], false, "defaultfont", "this.form.elements['we_schedule_active_".$this->nr."'].value=this.checked?1:0;_EditorFrame.setEditorIsHot(true);")
																																							. '<input type="hidden" name="we_schedule_active_'.$this->nr.'" value="'.$this->active.'"></td></tr></table></td>
		<td>' . $we_button->create_button("image:btn_function_trash", "javascript:_EditorFrame.setEditorIsHot(true);we_cmd('del_schedule','".$this->nr."')") . '</td>
	</tr>
'.$this->getSpacerRowHTML();
		if($extracont){
			$table .= '	<tr valign="top">
		<td class="defaultgray">'.$extraheadl.':</td>
		<td class="defaultfont">'.$extracont.'</td>
		<td></td>
	</tr>
'.$this->getSpacerRowHTML();
		}

		$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["type"]["headline"].':</td>
		<td class="defaultfont">'.$typepopup.'</td>
		<td></td>
	</tr>
'.
$this->getSpacerRowHTML();


		switch($this->type){
			case SCHEDULE_TYPE_ONCE:
				$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["datetime"].':</td>
		<td class="defaultfont">'.getDateInput2("we_schedule_time%s_".$this->nr,$this->time,true).'</td>
		<td></td>
	</tr>
';
				break;
			case SCHEDULE_TYPE_HOUR:
				$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["minutes"].':</td>
		<td class="defaultfont">'.getDateInput2("we_schedule_time%s_".$this->nr,$this->time,true,"i").'</td>
		<td></td>
	</tr>
';
				break;
			case SCHEDULE_TYPE_DAY:
				$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["time"].':</td>
		<td class="defaultfont">'.getDateInput2("we_schedule_time%s_".$this->nr,$this->time,true,"h:i").'</td>
		<td></td>
	</tr>
';
				break;
			case SCHEDULE_TYPE_WEEK:
				$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["time"].':</td>
		<td class="defaultfont">'.getDateInput2("we_schedule_time%s_".$this->nr,$this->time,true,"h:i").'</td>
		<td></td>
	</tr>
'.
$this->getSpacerRowHTML().
'	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["weekdays"].':</td>
		<td class="defaultfont">'.$this->getWeekdaysHTML().'</td>
		<td></td>
	</tr>
';
				break;
			case SCHEDULE_TYPE_MONTH:
				$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["time"].':</td>
		<td class="defaultfont">'.getDateInput2("we_schedule_time%s_".$this->nr,$this->time,true,"h:i").'</td>
		<td></td>
	</tr>
'.
$this->getSpacerRowHTML().
'	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["days"].':</td>
		<td class="defaultfont">'.$this->getDaysHTML().'</td>
		<td></td>
	</tr>
';
				break;
			case SCHEDULE_TYPE_YEAR:
				$table .= '	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["time"].':</td>
		<td class="defaultfont">'.getDateInput2("we_schedule_time%s_".$this->nr,$this->time,true,"h:i").'</td>
		<td></td>
	</tr>
'.
$this->getSpacerRowHTML().
'	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["months"].':</td>
		<td class="defaultfont">'.$this->getMonthsHTML().'</td>
		<td></td>
	</tr>
'.
$this->getSpacerRowHTML().
'	<tr valign="top">
		<td class="defaultgray">'.$GLOBALS["l_schedpro"]["days"].':</td>
		<td class="defaultfont">'.$this->getDaysHTML().'</td>
		<td></td>
	</tr>
';
				break;
		}
		$table .= '</table>'."\n";
		return '<script language="JavaScript" type="text/javascript">var we_hasExtraRow_'.$this->nr.'='.($extracont ? 'true' : 'false').'</script>'.$table;
	}

	function processSchedule($id,$schedFile,$now,$DB_WE){
		usort ($schedFile["value"], "weCmpSchedLast");
		if($schedFile["ClassName"] == "we_objectFile"){
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/".$schedFile["ClassName"].".inc.php");
		}else{
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/".$schedFile["ClassName"].".inc.php");
		}
		$doc_save = isset($GLOBALS["we_doc"]) ? $GLOBALS["we_doc"] : NULL;
		eval('$GLOBALS["we_doc"] = new '.$schedFile["ClassName"].'();');
		$GLOBALS["we_doc"]->InitByID($id,$schedFile["table"],LOAD_SCHEDULE_DB);
		$deleted = false;
		$changeTmpDoc=false;
		$_SESSION["Versions"]['fromScheduler'] = true;
		
		foreach($schedFile["value"] as $s){
			
			if($s["task"] == SCHEDULE_DELETE){
				$GLOBALS["NOT_PROTECT"]=true;
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_delete_fn.inc.php");
				deleteEntry($id,$schedFile["table"]);
				$deleted = true;
				$changeTmpDoc = false;
				break;
			}

			$_scheduleEditedDoc = false;	//	shall the in webEdition edited doc be changed.
			if(isset($GLOBALS["we_doc"]) && $schedFile["table"] == $GLOBALS["we_doc"]->Table){	//	in webEdition bearbeitetes Dokument wird gescheduled
				$_scheduleEditedDoc = true;
			}

			switch($s["task"]){
				case SCHEDULE_FROM:
					$GLOBALS["we_doc"]->Published = $now;
					if($_scheduleEditedDoc){
						$GLOBALS["we_doc"]->Published = $now;
					}
					break;
				case SCHEDULE_TO:
					$GLOBALS["we_doc"]->Published = 0;
					if($_scheduleEditedDoc){
						$GLOBALS["we_doc"]->Published = 0;
					}
					break;
				case SCHEDULE_DOCTYPE:
					if($GLOBALS["we_doc"]->Published){
						$publSave = $GLOBALS["we_doc"]->Published;
						$GLOBALS["we_doc"]->we_unpublish();
						$GLOBALS["we_doc"]->DocType = $s["DoctypeID"];
						if($s["doctypeAll"]){
							$GLOBALS["we_doc"]->changeDoctype($s["DoctypeID"],true);
						}
						$changeTmpDoc = true;
						$GLOBALS["we_doc"]->Published = $publSave;
					}
					break;
				case SCHEDULE_CATEGORY:
					if($GLOBALS["we_doc"]->Published){
						$GLOBALS["we_doc"]->Category = $s["CategoryIDs"];
						$changeTmpDoc = true;
					}
					break;
				case SCHEDULE_DIR:
					if($GLOBALS["we_doc"]->Published){
						$GLOBALS["we_doc"]->setParentID($s["ParentID"]);
						$GLOBALS["we_doc"]->Path = $GLOBALS["we_doc"]->getPath();
						$changeTmpDoc = true;
					}
					break;
			}

			if($s["type"] != SCHEDULE_TYPE_ONCE){
				$nextWann = we_schedpro::getNextTimestamp($s,$now);
				if($nextWann){
					$DB_WE->query("UPDATE ".SCHEDULE_TABLE." SET Wann='".$nextWann."' WHERE DID='".abs($id)."' AND ClassName!='we_objectFile' AND Type='".$s["type"]."' AND Was='".$s["task"]."'");
				}
			}
			
		}

		if($changeTmpDoc){
			$GLOBALS["we_doc"]->we_save();
		}
		if(!$deleted){
			if($GLOBALS["we_doc"]->Published){
				$GLOBALS["we_doc"]->we_publish();
			}else{
				$GLOBALS["we_doc"]->we_unpublish();
			}
		}
				
		$GLOBALS["we_doc"] = $doc_save;
		
		$_SESSION["Versions"]['fromScheduler'] = false;
			
		$DB_WE->query("UPDATE ".SCHEDULE_TABLE." SET Active=0 WHERE Wann<='".$now."' AND Schedpro != '' AND Active=1 AND TYPE='".SCHEDULE_TYPE_ONCE."'");
	}

	function trigger_schedule(){
		$scheddyFile = array();
		$scheddyObject = array();
		$DB_WE = NEW DB_WE();
		$now = time();

		$DB_WE->query("SELECT * FROM ".SCHEDULE_TABLE." WHERE Wann<='".$now."' AND Schedpro != '' AND Active=1");
		while($DB_WE->next_record()){
			$s = unserialize($DB_WE->f("Schedpro"));
			if(is_array($s)){
				if($DB_WE->f("ClassName") == "we_objectFile"){
					if(!(isset($scheddyObject[$DB_WE->f("DID")]) && is_array($scheddyObject[$DB_WE->f("DID")]))){
						$scheddyObject[$DB_WE->f("DID")] = array();
						$scheddyObject[$DB_WE->f("DID")]["value"] = array();
						$scheddyObject[$DB_WE->f("DID")]["ClassName"] = $DB_WE->f("ClassName");
						$scheddyObject[$DB_WE->f("DID")]["table"] = OBJECT_FILES_TABLE;
					}
					$s["lasttime"] = we_schedpro::getPrevTimestamp($s,$now);
					array_push($scheddyObject[$DB_WE->f("DID")]["value"],$s);
				}else{
					if(!(isset($scheddyFile[$DB_WE->f("DID")]) && is_array($scheddyFile[$DB_WE->f("DID")] ))){
						$scheddyFile[$DB_WE->f("DID")] = array();
						$scheddyFile[$DB_WE->f("DID")]["value"] = array();
						$scheddyFile[$DB_WE->f("DID")]["ClassName"] = $DB_WE->f("ClassName");
						$scheddyFile[$DB_WE->f("DID")]["table"] = FILE_TABLE;
					}
					$s["lasttime"] = we_schedpro::getPrevTimestamp($s,$now);
					array_push($scheddyFile[$DB_WE->f("DID")]["value"],$s);
				}
			}
		}
		
		foreach($scheddyFile as $id=>$s){
			we_schedpro::processSchedule($id,$s,$now,$DB_WE);
		}
		foreach($scheddyObject as $id=>$s){
			we_schedpro::processSchedule($id,$s,$now,$DB_WE);
		}


	}

	function check_and_convert_to_sched_pro() {
		$DB_WE = NEW DB_WE();

		$scheddy = array();

		$DB_WE->query("SELECT * FROM ".SCHEDULE_TABLE." WHERE Schedpro IS NULL OR Schedpro=''");
		while($DB_WE->next_record()){
			$s = array();

			$s["did"] = $DB_WE->f("DID");
			$s["task"] = $DB_WE->f("Was");
			$s["type"] = 0;
			$s["months"] = array();
			$s["days"] = array();
			$s["weekdays"] = array();
			$s["time"] = $DB_WE->f("Wann");
			$s["CategoryIDs"] = "";
			$s["DoctypeID"] = 0;
			$s["ParentID"] = 0;
			$s["active"] = 1;
			$s["doctypeAll"] = 0;

			array_push($scheddy,$s);

		}

		foreach($scheddy as $s){
			$DB_WE->query("UPDATE " . SCHEDULE_TABLE . " SET Schedpro='" . addslashes(serialize($s)) . "', Active=1, SerializedData='s:0:\"\";' WHERE DID=" . abs($s["did"])  ." AND Was=".abs($s["task"])." AND Wann=".abs($s["time"]));
		}
	}

	function getNextTimestamp($s,$now=0){
		if(!$now){
			$now = time();
		}
		switch($s["type"]){
			case SCHEDULE_TYPE_ONCE:
				return $s["time"];
				break;
			case SCHEDULE_TYPE_HOUR:
				$nextTime = mktime(date("G",$now), date("i",$s["time"]),0 , date("m",$now), date("j",$now), date("Y",$now));
				if($nextTime > $now){
					return $nextTime;
				}else{
					return $nextTime+3600;  // +1 h
				}
				break;
			case SCHEDULE_TYPE_DAY:
				$nextTime = mktime(date("G",$s["time"]), date("i",$s["time"]),0 , date("m",$now), date("j",$now), date("Y",$now));
				if($nextTime > $now){
					return $nextTime;
				}else{
					return $nextTime+86400; // + 1 Tag
				}
				break;
			case SCHEDULE_TYPE_WEEK:
				$wdayNow = date("w",$now);
				$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$now)), date("j",$now), date("Y",$now)); // zeit fuer heutigen tag
				if($s["weekdays"][$wdayNow] && ($timeSched > $now)){ // wenn am heutigen Tag was geschehen soll, checken ob Ereignis noch offen, wenn ja dann speichern
					return $timeSched;
				}else{
					$nextday = 0;
					$found = false;
					// naechst moeglicher Wochentag suchen
					for($wd=$wdayNow+1;$wd <=6; $wd++){
						$nextday ++;
						if($s["weekdays"][$wd]){
							$found = true;
							break;
						}
					}
					if(!$found){
						for($wd=0;$wd <=$wdayNow; $wd++){
							$nextday ++;
							if($s["weekdays"][$wd]){
								$found = true;
								break;
							}
						}
					}
					if($found){
						$nextdaystamp = $now + ($nextday * 86400);
						$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$nextdaystamp)), date("j",$nextdaystamp), date("Y",$nextdaystamp));
						return $timeSched;
					}
				}
				break;
			case SCHEDULE_TYPE_MONTH:
				$dayNow = date("j",$now);
				$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$now)), date("j",$now), date("Y",$now)) ; // zeit fuer heutigen tag
				if($s["days"][$dayNow-1] && ($timeSched > $now)){ // wenn am heutigen Tag was geschehen soll, checken ob Ereignis noch offen, wenn ja dann speichern
					return $timeSched;
				}else{

					$tomorrow = $now + 86400;
					$dayTomorrow = date("j",$tomorrow);

					$trys = 0;
					while($s["days"][$dayTomorrow-1] == 0 && $trys <= 365){
						$tomorrow += 86400;
						$dayTomorrow = date("j",$tomorrow);
						$trys++;
					}
					if($trys <= 365){
						$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$tomorrow)), date("j",$tomorrow), date("Y",$tomorrow));
						return $timeSched;
					}
				}
				break;
			case SCHEDULE_TYPE_YEAR:
				$dayNow = date("j",$now);
				$monthNow = abs(date("m",$now));
				$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$now)), date("j",$now), date("Y",$now)); // zeit fuer heutigen tag
				if($s["days"][$dayNow-1] && $s["months"][$monthNow-1] && ($timeSched > $now)){ // wenn am heutigen Tag was geschehen soll, checken ob Ereignis noch offen, wenn ja dann speichern
					return $timeSched;
				}else{

					$tomorrow = $now + 86400;
					$dayTomorrow = date("j",$tomorrow);
					$monthTomorrow = abs(date("m",$tomorrow));

					$trys = 0;
					while(($s["days"][$dayTomorrow-1] == 0 || $s["months"][$monthTomorrow-1] == 0) && $trys <= 365){
						$tomorrow += 86400;
						$dayTomorrow = date("j",$tomorrow);
						$monthTomorrow = abs(date("m",$tomorrow));
						$trys++;
					}
					if($trys <= 365){
						$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$tomorrow)), date("j",$tomorrow), date("Y",$tomorrow));
						return $timeSched;
					}
				}
				break;
		}
		return 0;
	}

	function getPrevTimestamp($s,$now=0){
		if(!$now){
			$now = time();
		}
		switch($s["type"]){
			case SCHEDULE_TYPE_ONCE:
				return $s["time"];
				break;
			case SCHEDULE_TYPE_HOUR:
				$nextTime = mktime(date("G",$now), date("i",$s["time"]),0 , date("m",$now), date("j",$now), date("Y",$now));
				if($nextTime < $now){
					return $nextTime;
				}else{
					return $nextTime-3600;  // +1 h
				}
				break;
			case SCHEDULE_TYPE_DAY:
				$nextTime = mktime(date("G",$s["time"]), date("i",$s["time"]),0 , date("m",$now), date("j",$now), date("Y",$now));
				if($nextTime < $now){
					return $nextTime;
				}else{
					return $nextTime-86400; // + 1 Tag
				}
				break;
			case SCHEDULE_TYPE_WEEK:
				$wdayNow = date("w",$now);
				$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$now)), date("j",$now), date("Y",$now)); // zeit fuer heutigen tag
				if($s["weekdays"][$wdayNow] && ($timeSched < $now)){ // wenn am heutigen Tag was geschehen soll, checken ob Ereignis noch offen, wenn ja dann speichern
					return $timeSched;
				}else{
					$lastday = 0;
					$found = false;
					// naechst moeglicher Wochentag suchen
					for($wd=$wdayNow-1;$wd >= 0; $wd--){
						$lastday ++;
						if($s["weekdays"][$wd]){
							$found = true;
							break;
						}
					}
					if(!$found){
						for($wd=6;$wd >=$wdayNow; $wd--){
							$lastday ++;
							if($s["weekdays"][$wd]){
								$found = true;
								break;
							}
						}
					}
					if($found){
						$lasttimestamp = $now - ($lastday * 86400);
						$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$lasttimestamp)), date("j",$lasttimestamp), date("Y",$lasttimestamp));
						return $timeSched;
					}
				}
				break;
			case SCHEDULE_TYPE_MONTH:
				$dayNow = date("j",$now);
				$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$now)), date("j",$now), date("Y",$now)) ; // zeit fuer heutigen tag
				if($s["days"][$dayNow-1] && ($timeSched < $now)){ // wenn am heutigen Tag was geschehen soll, checken ob Ereignis noch offen, wenn ja dann speichern
					return $timeSched;
				}else{

					$yesterday = $now - 86400;
					$dayYesterday = date("j",$yesterday);

					$trys = 0;
					while($s["days"][$dayYesterday-1] == 0 && $trys <= 365){
						$yesterday -= 86400;
						$dayYesterday = date("j",$yesterday);
						$trys++;
					}
					if($trys <= 365){
						$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$yesterday)), date("j",$yesterday), date("Y",$yesterday));
						return $timeSched;
					}
				}
				break;
			case SCHEDULE_TYPE_YEAR:
				$dayNow = date("j",$now);
				$monthNow = abs(date("m",$now));
				$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$now)), date("j",$now), date("Y",$now)); // zeit fuer heutigen tag
				if($s["days"][$dayNow-1] && $s["months"][$monthNow-1] && ($timeSched < $now)){ // wenn am heutigen Tag was geschehen soll, checken ob Ereignis noch offen, wenn ja dann speichern
					return $timeSched;
				}else{

					$yesterday = $now - 86400;
					$dayYesterday = date("j",$yesterday);
					$monthYesterday = abs(date("m",$yesterday));

					$trys = 0;
					while(($s["days"][$dayYesterday-1] == 0 || $s["months"][$monthYesterday-1] == 0) && $trys <= 365){
						$yesterday -= 86400;
						$dayYesterday = date("j",$yesterday);
						$monthYesterday = abs(date("m",$yesterday));
						$trys++;
					}
					if($trys <= 365){
						$timeSched = mktime(date("G",$s["time"]),date("i",$s["time"]),0,abs(date("m",$yesterday)), date("j",$yesterday), date("Y",$yesterday));
						return $timeSched;
					}
				}
				break;
		}
		return 0;
	}


}

function weCmpSchedLast ($a, $b) {
    if ($a["lasttime"] == $b["lasttime"]) return 0;
    return ($a["lasttime"] < $b["lasttime"]) ? -1 : 1;
}


?>