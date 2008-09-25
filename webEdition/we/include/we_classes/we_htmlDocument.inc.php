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
 * @package    webEdition_class
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_textContentDocument.inc.php");

class we_htmlDocument extends we_textContentDocument{

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_htmlDocument";
	var $ContentType="text/html";

	function we_htmlDocument(){
		$this->we_textContentDocument();
	}

	function i_saveContentDataInDB(){
		if (is_array($this->elements["data"]) && isset($this->elements["data"]["dat"])) {
			$code = $this->elements["data"]["dat"];
			$metas = $this->getMetas($code);
			if (isset($metas["title"]) && $metas["title"]) {
				$this->setElement("Title", $metas["title"]);
			}
			if (isset($metas["description"]) && $metas["description"]) {
				$this->setElement("Description", $metas["description"]);
			}
			if (isset($metas["keywords"]) && $metas["keywords"]) {
				$this->setElement("Keywords", $metas["keywords"]);
			}
			if (isset($metas["charset"]) && $metas["charset"]) {
				$this->setElement("Charset", $metas["charset"]);
			}
		}
		return we_textContentDocument::i_saveContentDataInDB();
	}
	function makeSameNew(){
		we_textContentDocument::makeSameNew();
		$this->Icon = "prog.gif";

	}
	function i_publInScheduleTable(){
		if(defined("SCHEDULE_TABLE")){
			$this->DB_WE->query("DELETE FROM ".SCHEDULE_TABLE." WHERE DID='".$this->ID."' AND ClassName='".$this->ClassName."'");
			$ok = true;
			$makeSched = false;
			foreach($this->schedArr as $s){
				if($s["task"] == SCHEDULE_FROM && $s["active"]){
					$serializedDoc = we_temporaryDocument::load($this->ID,$this->Table,$this->DB_WE);
					$makeSched = true;
				}else{
					$serializedDoc = "";
				}
				include_once(WE_SCHEDULE_MODULE_DIR."we_schedpro.inc.php");
				$Wann = we_schedpro::getNextTimestamp($s,time());

				if(!$this->DB_WE->query("INSERT INTO ".SCHEDULE_TABLE.
						" (DID,Wann,Was,ClassName,SerializedData,Schedpro,Type,Active)
						VALUES('".$this->ID."','".$Wann."','".$s["task"]."','".$this->ClassName."','".addslashes(serialize($serializedDoc))."','".addslashes(serialize($s))."','".$s["type"]."','".$s["active"]."')")) return false;
			}
			return $makeSched;
		}
		return false;
	}
	
	function getDocumentCode(){
		
		$code = $this->getElement("data");
		
		if( isset($this->elements["Charset"]["dat"]) && $this->elements["Charset"]["dat"] ){
			$code = preg_replace( "'<meta http-equiv=\"Content-Type\" content=\".*>'i", '<meta http-equiv="Content-Type" content="text/html; charset=' . $this->elements["Charset"]["dat"] . '">', $code );
		}
		return $code;
	}
}

?>