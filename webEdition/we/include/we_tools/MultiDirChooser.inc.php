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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");

class MultiDirChooser{

	var $width = "388";
	var $table = FILE_TABLE;
	var $db;
	var $db2;
	var $ids = "";
	var $ws = "";
	var $wsArr= array();
	var $cmd_del = "";
	var $addbut = "";
	var $css = "";
	var $fields = "Icon,Path";
	var $fieldsArr = array("Icon","Path");
	var $nr=0;
	var $lines = 1;
	var $CanDelete = false;
	var $isEditable = true;
	var $extraDelFn = "";
	var $thirdDelPar = "";

	function MultiDirChooser($width,$ids,$cmd_del,$addbut,$ws="",$fields="Icon,Path",$table=FILE_TABLE,$css="defaultfont",$thirdDelPar="",$extraDelFn=""){
		$this->db = new DB_WE();
		$this->db2 = new DB_WE();
		$this->width = $width;
		$this->ids = $ids;
		$this->table = $table;
		$this->ws = $ws;
		$this->wsArr = makeArrayFromCSV($ws);
		$this->cmd_del = $cmd_del;
		$this->addbut = $addbut;
		$this->css = $css;
		$this->fields=$fields;
		$this->fieldsArr=makeArrayFromCSV($fields);
		$this->extraDelFn = $extraDelFn;
		$this->thirdDelPar=$thirdDelPar;
	}


	function printIt(){
		print $this->get();
	}

	function getLine($lineNr){
		$we_button = new we_button();
		switch($lineNr){
			case 0:
				return '<tr>
	<td><img src="'.ICON_DIR.$this->db->f($this->fieldsArr[0]).'" width="16" height="18"></td>
	<td class="'.$this->css.'">'.$this->db->f($this->fieldsArr[1]).'</td>
	<td>'.((($this->isEditable() && $this->cmd_del) || $this->CanDelete) ?
			$we_button->create_button("image:btn_function_trash", "javascript:if(typeof(_EditorFrame)!='undefined'){_EditorFrame.setEditorIsHot(true);}".($this->extraDelFn ? $this->extraDelFn : "").";we_cmd('".$this->cmd_del."','".$this->db->f("ID")."'".(strlen($this->thirdDelPar) ? ",'".$this->thirdDelPar."'" : "").");")  :
			"").'</td>
</tr>
';
		}
	}

	function getRootLine($lineNr){

		$we_button = new we_button();

		switch($lineNr){
			case 0:
				return '<tr>
	<td><img src="'.ICON_DIR.'folder.gif" width="16" height="18"></td>
	<td class="'.$this->css.'">/</td>
	<td>'.((($this->isEditable() && $this->cmd_del) || $this->CanDelete) ?
			$we_button->create_button("image:btn_function_trash", "javascript:if(typeof(_EditorFrame)!='undefined'){_EditorFrame.setEditorIsHot(true);}".($this->extraDelFn ? $this->extraDelFn : "").";we_cmd('".$this->cmd_del."','0');") :
			"").'</td>
</tr>
';
		}
	}

	function isEditable(){
		return $this->isEditable;
		if($this->isEditable == false) return false;
		if($this->ws){
			if(!in_workspace($this->db->f("ID"),$this->ws,$this->table,$this->db2)){
				return false;
			}
		}
		return true;
	}

	function get(){
		$out = '<table border="0" callpadding="0" cellspacing="0" width="'.abs($this->width-20).'">
	<tr><td>'.getPixel(20,2).'</td><td>'.getPixel(abs($this->width-66),2).'</td><td>'.getPixel(26,2).'</td></tr>
';

		$this->nr=0;
		$idArr = makeArrayFromCSV($this->ids);

		if(sizeof($idArr)){
			foreach($idArr as $id){
				$this->db->query("SELECT ID,".$this->fields." FROM ".$this->table." WHERE ID ='$id'");
				if($this->db->next_record()){
					for($i=0;$i<$this->lines;$i++){
						$out .= $this->getLine($i);
					}
				}else if(!$id){
					for($i=0;$i<$this->lines;$i++){
						$out .= $this->getRootLine($i);
					}
				}
				$this->nr++;
			}
		}
		$out .= '	<tr><td>'.getPixel(20,sizeof($idArr) ? 2 : 12).'</td><td>'.getPixel($this->width-66,2).'</td><td>'.getPixel(26,2).'</td></tr>
</table>
';


			return '<table border="0" cellpadding="0" cellspacing="0" width="'.$this->width.'">
<tr><td><div style="background-color:white;" class="multichooser">'.$out.'</div></td></tr>
'.($this->addbut ? ('<tr><td>'.getPixel(2,5).'</td></tr>
<tr><td align="right">'.$this->addbut.'</td></tr>') : '').'</table>'."\n";



	}


}
?>
