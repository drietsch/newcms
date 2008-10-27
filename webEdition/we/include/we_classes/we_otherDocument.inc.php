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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."we_binaryDocument.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/global.inc.php");

/*  a class for handling flashDocuments. */
class we_otherDocument extends we_binaryDocument
{
	######################################################################################################################################################
	##################################################################### Variables ######################################################################
	######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_otherDocument";

	/* ContentType of the Object  */
	var $ContentType="application/*";

	/* buffer for pdf text creation */
	var $_buffer="";



	######################################################################################################################################################
	##################################################################### FUNCTIONS ######################################################################
	######################################################################################################################################################


	/* Constructor */
	function we_otherDocument(){
		/* Begin: Do we use this? */
		switch($this->Extension){
			case ".pdf":
				$this->Icon = "pdf.gif";
				break;
		}
		/* End: Do we use this? */
		$this->we_binaryDocument();
		array_push($this->EditPageNrs,WE_EDITPAGE_PREVIEW);
	}


	/* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
	function editor() {
		switch($this->EditPageNr){
			case WE_EDITPAGE_PREVIEW:
			return "we_templates/we_editor_other_preview.inc.php";
			default:
			return parent::editor();
		}
	}

	/* gets the HTML for including in HTML-Docs */
	function getHtml($dyn=false){
		global $lngDir,$we_transaction,$l_global;
		$_data = $this->getElement("data");
		if ($this->ID || ($_data && !is_dir($_data) && is_readable($_data))) {
			$this->html = '<p class="defaultfont"><b>Datei</b>: '.$this->Text.'</p>';
		}else{
			$this->html = $GLOBALS["l_global"]["no_file_uploaded"];
		}
		return $this->html;
	}

	function formExtension2(){
		return $this->htmlFormElementTable($this->htmlTextInput("we_".$this->Name."_Extension",5,$this->Extension,"",'onChange="_EditorFrame.setEditorIsHot(true);" style="width:92px"'),$GLOBALS["l_we_class"]["extension"]);
	}

	function we_save($resave=0){
		$this->Icon = we_getIcon($this->ContentType, $this->Extension);
		return we_binaryDocument::we_save($resave);
	}
	function insertAtIndex(){
		$text = "";
		$this->resetElements();
		while(list($k,$v) = $this->nextElement("")){
				$foo = (isset($v["dat"]) && substr($v["dat"],0,2) == "a:") ? unserialize($v["dat"]) : "";
				if(!is_array($foo)){
					if(isset($v["type"]) && $v["type"] == "txt"){
						$text .= " ".(isset($v["dat"]) ? $v["dat"] : "");
					}
				}
		}

		$content = ($this->Extension == ".doc" || $this->Extension == ".xls"  || $this->Extension == ".pps"  || $this->Extension == ".ppt"  || $this->Extension == ".rtf")
				?  $this->i_getDocument() : "";

		/*if($this->Extension == ".pdf" && function_exists("gzuncompress")){
			$content = $this->getPDFText($this->i_getDocument());
		}*/

		for($i=0;$i < 48; $i++){
			$content =  str_replace(chr($i),"",$content);
		}

		$text = trim(strip_tags($text) . $content);

		$maxDB = getMaxAllowedPacket($this->DB_WE) - 1024;
		$maxDB = min(1000000,$maxDB);
		if(strlen($text) > $maxDB){
			$text = substr($text,0,$maxDB);
		}
		$text = addslashes($text);

		$this->DB_WE->query("DELETE FROM " . INDEX_TABLE . " WHERE DID=".abs($this->ID));
		if($this->IsSearchable && $this->Published){
			return $this->DB_WE->query("INSERT INTO " . INDEX_TABLE . " (DID,Text,BText,Workspace,WorkspaceID,Category,Doctype,Title,Description,Path) VALUES('".abs($this->ID)."','".mysql_real_escape_string($text)."','".mysql_real_escape_string($text)."','".mysql_real_escape_string($this->ParentPath)."','".abs($this->ParentID)."','".mysql_real_escape_string($this->Category)."','','".mysql_real_escape_string($this->getElement("Title"))."','".mysql_real_escape_string($this->getElement("Description"))."','".mysql_real_escape_string($this->Path)."')");
		}
		return true;

	}

	function i_descriptionMissing(){
		if($this->IsSearchable){
			$description = $this->getElement("Description");
			return strlen($description) ? false : true;
		}
		return false;
	}


	function nextline() {
			$pos = strpos($this->_buffer, "\r");
			if ($pos === false) {
					return false;
			}
			$line = substr($this->_buffer, 0, $pos);
			$this->_buffer = substr($this->_buffer, $pos + 1);
			if ($line == "stream") {
					$endpos = strpos($this->_buffer, "endstream");
					$stream = substr($this->_buffer, 1, $endpos - 1);
					$stream = gzuncompress($stream);
					$this->_buffer = $stream . substr($this->_buffer, $endpos + 9);
			}
			return $line;
	}

	function txtline() {
			$line = $this->nextline();
			if ($line === false) {
					return false;
			}
			if (preg_match("/[^\\\\]\\((.+)[^\\\\]\\)/", $line, $match)) {
					$line = preg_replace("/\\\\(\d+)/e", "chr(0\\1);", $match[1]);
					return stripslashes($line);
			}
			return $this->txtline();
	}

	function getPDFText($str) {
		$out = "";
		$this->_buffer = $str;
		while (($line = $this->txtline()) !== false) {
			$out .= $line;
		}
		return $out;
	}
}

?>
