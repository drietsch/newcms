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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_document.inc.php");
if(!isset($GLOBALS["WE_IS_DYN"])){
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_linklist.inc.php");

/*  a class for handling text-documents */
class we_textDocument extends we_document
{
	######################################################################################################################################################
	##################################################################### Variables ######################################################################
	######################################################################################################################################################

	/* Name of the class => important for reconstructing the class from outside the class */
	var $ClassName="we_textDocument";

	/* Icon which is shown at the tree-menue  */
	var $Icon="link.gif";

	/* defines which Tabs should be shown in editor  */
	var $EditPageNrs = array(WE_EDITPAGE_PROPERTIES,WE_EDITPAGE_INFO,WE_EDITPAGE_CONTENT,WE_EDITPAGE_VALIDATION);

	######################################################################################################################################################
	##################################################################### FUNCTIONS ######################################################################
	######################################################################################################################################################


	/* Constructor */
	function we_textDocument(){
		$this->we_document();
		array_push($this->EditPageNrs, WE_EDITPAGE_VERSIONS);
	}

	################################################



	/* must be called from the editor-script. Returns a filename which has to be included from the global-Script */
	function editor($baseHref=true){
		$port = (defined("HTTP_PORT")) ? (":".HTTP_PORT) : "";
		$prot = getServerProtocol();
		$GLOBALS["we_baseHref"] = $baseHref ? $prot."://".SERVER_NAME.$port.$this->Path : "";

		switch($this->EditPageNr){
			case WE_EDITPAGE_PROPERTIES:
				return "we_templates/we_editor_properties.inc.php";
			case WE_EDITPAGE_INFO:
				return "we_templates/we_editor_info.inc.php";
			case WE_EDITPAGE_CONTENT:
				$GLOBALS["we_editmode"] = true;
				return "we_templates/we_srcTmpl.inc.php";
			case WE_EDITPAGE_PREVIEW:
				if($GLOBALS["we_EDITOR"]){
					$GLOBALS["we_file_to_delete_after_include"] = TMP_DIR."/".md5(uniqid(rand())).$this->Extension;
					saveFile($GLOBALS["we_file_to_delete_after_include"],$this->i_getDocument());
					return $GLOBALS["we_file_to_delete_after_include"];
				}else{
					$GLOBALS["we_editmode"] = false;
					return "we_templates/we_srcTmpl.inc.php";
					break;
				}
            case WE_EDITPAGE_VALIDATION:
                return "we_templates/validateDocument.inc.php";
                break;
            case WE_EDITPAGE_VERSIONS:
				return "we_versions/we_editor_versions.inc.php";
			break;
			default:
				$this->EditPageNr = WE_EDITPAGE_PROPERTIES;
				$_SESSION["EditPageNr"] = WE_EDITPAGE_PROPERTIES;
				return "we_templates/we_editor_properties.inc.php";
		}
		return $this->TemplatePath;
	}


	function we_new(){
		we_document::we_new();
		$this->Filename=$this->i_getDefaultFilename();

	}

	function isValidEditPage($editPageNr) {

		if ($editPageNr == WE_EDITPAGE_VALIDATION) {
			if ($this->ContentType != "text/css") {
				return false;
			} else {
				return true;
			}
		}

		if (is_array($this->EditPageNrs)) {
			return in_array($editPageNr, $this->EditPageNrs);

		}
		return false;
	}

}
?>
