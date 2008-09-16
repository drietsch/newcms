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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_tools/MultiDirAndTemplateChooser.inc.php");

class MultiDirTemplateAndDefaultChooser extends MultiDirAndTemplateChooser{
	
	var $lines = 3;
	var $defaultName="";
	var $defaultArr = array();
	
	function MultiDirTemplateAndDefaultChooser($width,$ids,$cmd_del,$addbut,$ws="",$tmplcsv="",$tmplSelectName="",$mustTemplateIDs="",$tmplWs="",$defaultName="",$defaultCSV="",$fields="Icon,Path",$table=FILE_TABLE,$css="defaultfont"){
		$this->defaultName = $defaultName;
		$this->defaultArr = makeArrayFromCSV($defaultCSV);
  		$this->MultiDirAndTemplateChooser($width,$ids,$cmd_del,$addbut,$ws,$tmplcsv,$tmplSelectName,$mustTemplateIDs,$tmplWs,$fields,$table,$css);
  	}
	
	function getRootLine($lineNr){
		
		$we_button = new we_button();
		
		switch($lineNr){
			case 0:
				return MultiDirAndTemplateChooser::getRootLine($lineNr);
			default:
				return $this->getLine($lineNr);
		}
	}
	function getLine($lineNr){

		$we_button = new we_button();
		
		$editable = $this->isEditable();
		switch($lineNr){
			case 0:
				return MultiDirAndTemplateChooser::getLine(0);
			case 1:
				$idArr = makeArrayFromCSV($this->ids);
				$checkbox = we_forms::checkbox($idArr[$this->nr], (in_array($idArr[$this->nr], $this->defaultArr) ? true : false), $this->defaultName."_".$this->nr, $GLOBALS['l_we_class']['standard_workspace']);
				return '<tr><td></td><td>'.$checkbox.'</td><td>'.getPixel(50,1).'</td></tr>';
			case 2:
				return MultiDirAndTemplateChooser::getLine(1);
		}
	}
	

}
?>