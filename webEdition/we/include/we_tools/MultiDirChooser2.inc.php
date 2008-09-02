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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

class MultiDirChooser2 extends MultiDirChooser{

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
	var $rowPrefix = "";
	var $catField = "";

	function MultiDirChooser2($width="",$ids="",$cmd_del="",$addbut="",$ws="",$fields="Icon,Path",$table=FILE_TABLE,$css="defaultfont",$thirdDelPar="",$extraDelFn="") {

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

	function getLine($lineNr){
		$out = "";
		$we_button = new we_button();
		$_catFieldJS = "";
		if ($this->catField) {
			$_ids = str_replace(",".$this->db->f("ID").",",",",$this->ids);
		}
		$_catFieldJS .= "deleteCategory('".$this->rowPrefix."',".$this->db->f("ID")."); ";
		switch($lineNr){
			case 0:
				$out .= '<tr id="'.$this->rowPrefix.'Cat'.$this->db->f("ID").'">
	<td><img src="'.ICON_DIR.$this->db->f($this->fieldsArr[0]).'" width="16" height="18"></td>
	<td class="'.$this->css.'">'.$this->db->f($this->fieldsArr[1]).'</td>
	<td>'.((($this->isEditable() && $this->cmd_del) || $this->CanDelete) ?
			$we_button->create_button("image:btn_function_trash", "javascript:if(typeof(_EditorFrame)!='undefined'){_EditorFrame.setEditorIsHot(true);}".($this->extraDelFn ? $this->extraDelFn : "")."; ".$_catFieldJS,true,26)  :
			"").'</td>
</tr>
';
		}
		return $out;
	}

	function getRootLine($lineNr){

		$we_button = new we_button();
		$out = "";
		switch($lineNr){
			case 0:
				$out .= '<tr>
	<td><img src="'.ICON_DIR.'folder.gif" width="16" height="18"></td>
	<td class="'.$this->css.'">/</td>
	<td>'.((($this->isEditable() && $this->cmd_del) || $this->CanDelete) ?
			$we_button->create_button("image:btn_function_trash", "javascript:if(typeof(_EditorFrame)!='undefined'){_EditorFrame.setEditorIsHot(true);}".($this->extraDelFn ? $this->extraDelFn : "").";we_cmd('".$this->cmd_del."','0');",true,26) :
			"").'</td>
</tr>
';
		}
		return $out;
	}
	
	function getTableRows(){
		$out = '	<tr><td width="20">'.getPixel(20,2).'</td><td>'.getPixel(50,2).'</td><td width="26">'.getPixel(26,2).'</td></tr>';
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
		$out .= '	<tr><td width="20">'.getPixel(20,sizeof($idArr) ? 2 : 12).'</td><td>'.getPixel(50,2).'</td><td width="26">'.getPixel(26,2).'</td></tr>';
		return $out;
	}
	
	function get(){
		
		$out = '<table border="0" callpadding="0" height="18" cellspacing="0" width="'.abs($this->width-10).'" id="'.$this->rowPrefix.'CatTable">
';
		$out .= $this->getTableRows();
		
		$out .= '</table>
';

		return '<table border="0" cellpadding="0" cellspacing="0" width="'.$this->width.'">
<tr><td><div style="background-color:white;" class="multichooser">'.$out.'</div></td></tr>
'.($this->addbut ? ('<tr><td>'.getPixel(2,5).'</td></tr>
<tr><td align="right">'.$this->addbut.'</td></tr>') : '').'</table>'."\n";



	}	
	function setRowPrefix($val) {
		$this->rowPrefix = $val;
		return true;
	}
	function setCatField($val) {
		$this->catField = $val;
		return true;
	}


}
?>
