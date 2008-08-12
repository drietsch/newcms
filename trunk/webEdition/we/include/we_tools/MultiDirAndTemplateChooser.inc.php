<?php

// +----------------------------------------------------------------------+
// | webEdition                                                           |
// +----------------------------------------------------------------------+
// | PHP version 4.1.0 or greater                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000 - 2007 living-e AG                                |
// +----------------------------------------------------------------------+
//


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirChooser.inc.php");

class MultiDirAndTemplateChooser extends MultiDirChooser{
	
	var $lines = 2;
	var $tmplcsv = "";
	var $tmplSelectName = "";
	var $mustTemplateIDs = "";
	var $tmplArr = "";
	var $tmplVals=array();
	var $tmplWs="";
	var $mustTemplateIDsArr;
	var $mustPaths;
	var $create = 0;
	
	function MultiDirAndTemplateChooser($width,$ids,$cmd_del,$addbut,$ws="",$tmplcsv="",$tmplSelectName="",$mustTemplateIDs="",$tmplWs="",$fields="Icon,Path",$table=FILE_TABLE,$css="defaultfont"){
		$this->MultiDirChooser($width,$ids,$cmd_del,$addbut,$ws,$fields,$table,$css);
		$this->tmplcsv = $tmplcsv;
		$this->tmplSelectName = $tmplSelectName;
		$this->mustTemplateIDs = $mustTemplateIDs;
		$this->mustTemplateIDsArr = makeArrayFromCSV($this->mustTemplateIDs);
		$this->tmplArr = makeArrayFromCSV($this->tmplcsv);
  		$this->tmplValsArr = getPathsFromTable(TEMPLATES_TABLE,$this->db,FILE_ONLY,get_ws(TEMPLATES_TABLE),"Path");
		$this->tmplWs = $tmplWs;
		$this->mustPaths = makeArrayFromCSV(id_to_path($this->mustTemplateIDsArr,TEMPLATES_TABLE,$this->db));
		foreach($this->mustTemplateIDsArr as $i=>$id){
			if(!in_array($id,array_keys($this->tmplValsArr))){
		        $this->tmplValsArr[$id] = isset($this->mustPaths[$i]) ? $this->mustPaths[$i] : "";
			}
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
			$we_button->create_button("image:btn_function_trash", "javascript:_EditorFrame.setEditorIsHot(true);".($this->extraDelFn ? $this->extraDelFn : "").";we_cmd('".$this->cmd_del."','0');") : 
			"").'</td>
</tr>
';
			case 1:
				return $this->getLine($lineNr);
		}
	}
	function getLine($lineNr){

		$we_button = new we_button();
		
		$editable = $this->isEditable();
		switch($lineNr){
			case 0:
				return MultiDirChooser::getLine($lineNr);
			case 1:
				if($this->create){
					$but = $we_button->create_button("image:btn_add_template", "javascript:we_cmd('create_tmpfromClass','0','".$this->nr."','".$GLOBALS["we_transaction"]."')");
				}else{
					
					
					$but = $we_button->create_button("image:btn_function_view", "javascript:we_cmd('preview_objectFile','0','".(isset($this->tmplArr[$this->nr]) ? $this->tmplArr[$this->nr] : "")."','".$GLOBALS["we_transaction"]."')");
				}
				$path = id_to_path(isset($this->tmplArr[$this->nr]) ? $this->tmplArr[$this->nr] : "",TEMPLATES_TABLE,$this->db2);
				if($this->isEditable()){
					$tmplSelect = htmlSelect($this->tmplSelectName."_".$this->nr,$this->tmplValsArr,1,isset($this->tmplArr[$this->nr]) ? $this->tmplArr[$this->nr] : "", false, "onchange='if(_EditorFrame) {_EditorFrame.setEditorIsHot(true);}'");
					return '<tr><td></td><td><span class="small"><b>'.$GLOBALS["l_we_class"]["template"].':</b></span><br>'.$tmplSelect.'</td><td valign="bottom">'.$but.'</td></tr>'."\n";
				}else{
					return '<tr><td></td><td class="'.$this->css.'"><span class="small"><b>'.$GLOBALS["l_we_class"]["template"].':</b></span><br>'.$path.'<input type="hidden" name="'.$this->tmplSelectName."_".$this->nr.'" value="'.(isset($this->tmplArr[$this->nr]) ? $this->tmplArr[$this->nr] : "") .'"></td><td valign="bottom">'.$but.'</td></tr>'."\n";
				}
		}
	}
	

}
?>