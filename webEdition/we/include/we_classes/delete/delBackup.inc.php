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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/taskFragment.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_htmlElement.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weFile.class.php");

class delBackup extends taskFragment{

	var $db;

	function delBackup($name,$taskPerFragment,$pause=0){
		$this->db = new DB_WE();
		$this->taskFragment($name,$taskPerFragment,$pause);
	}

	function init(){
		if(isset($_SESSION["backup_delete"]) && $_SESSION["backup_delete"]){

			if(defined("ISP_VERSION") && ISP_VERSION){
				$where=array();
				foreach($GLOBALS["_isp_hide_files"] as $hiden) $where[]=" Path NOT LIKE '$hiden%'";
				$this->db->query("SELECT Icon,Path, CHAR_LENGTH(Path) as Plen FROM ".FILE_TABLE." WHERE ".implode(" AND",$where)." ORDER BY IsFolder, Plen DESC;");
				while($this->db->next_record()) $this->alldata[]=$_SERVER["DOCUMENT_ROOT"].$this->db->f("Path").",".$this->db->f("Icon");
			}
			else{
				$this->db->query("SELECT Icon,Path, CHAR_LENGTH(Path) as Plen FROM ".FILE_TABLE." ORDER BY IsFolder, Plen DESC;");
				while($this->db->next_record()) {
					$this->alldata[]=$_SERVER["DOCUMENT_ROOT"].$this->db->f("Path").",".$this->db->f("Icon");
					$this->alldata[]=$_SERVER["DOCUMENT_ROOT"]. SITE_DIR .$this->db->f("Path").",".$this->db->f("Icon");
				}
				$this->db->query("SELECT Icon,Path, CHAR_LENGTH(Path) as Plen FROM ".TEMPLATES_TABLE." ORDER BY IsFolder, Plen DESC;");
				while($this->db->next_record()){
					$this->alldata[]=TEMPLATE_DIR . "/".preg_replace('/\.tmpl$/i','.php',$this->db->f("Path")).",".$this->db->f("Icon");
				}
			}
			if(!count($this->alldata)){
				print we_htmlElement::jsElement(
					we_message_reporting::getShowMessageCall($GLOBALS["l_backup"]["nothing_to_delete"], WE_MESSAGE_WARNING)
				);
				$this->finish();
			}
		}

	}

	function doTask(){
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");
		$item=makeArrayFromCSV($this->data);
		if(!weFile::delete($item[0])){
				if(file_exists($item[0])) array_push($_SESSION["delete_files_nok"],array("icon"=>(isset($item[1]) ? $item[1] : ""),"path"=>$item[0]));
		}
		$percent = round((100/count($this->alldata))*(1+$this->currentTask));
		$text=str_replace($_SERVER["DOCUMENT_ROOT"],"",clearPath($item[0]));
		if(strlen($text)>75){
			$text = addslashes(substr($text,0,65) . '...' . substr($text,-10));
		}
		print we_htmlElement::jsElement('
			parent.delmain.setProgressText("pb1","'.sprintf($GLOBALS["l_backup"]["delete_entry"],$text).'");
			parent.delmain.setProgress('.$percent.');
		');

	}

	function finish(){
		if(isset($_SESSION["delete_files_nok"]) && is_array($_SESSION["delete_files_nok"]) && count($_SESSION["delete_files_nok"])){
			print we_htmlElement::jsElement("",array("src"=>JS_DIR."windows.js"));
			print we_htmlElement::jsElement('
					new jsWindow("'.WEBEDITION_DIR.'delInfo.php","we_delinfo",-1,-1,600,550,true,true,true);
			');

		}
		unset($_SESSION["backup_delete"]);
		print we_htmlElement::jsElement('top.close();');
	}

	function printHeader(){
		protect();
		print "<html><head><title></title></head>";
	}
}


?>