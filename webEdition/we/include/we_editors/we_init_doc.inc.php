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

// exit if script called directly
if (str_replace(dirname($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME'])=="/we_inc_doc.inc.php") {
	exit();
}

if (0 && isset($we_ID) && isset($we_Table) && isset($GLOBALS["weDocumentCache_".$we_ID."_".$we_Table])) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_webEditionDocument.inc.php");
	$we_doc = new we_webEditionDocument();
	$we_doc->we_initSessDat($GLOBALS["weDocumentCache_" . $we_ID . "_" . $we_Table]);

} else {

	if( (!isset($we_ContentType)) && ((!isset($we_dt)) || (!is_array($we_dt)) || (!$we_dt[0]["ClassName"])) && isset($we_ID) && $we_ID && isset($we_Table) && $we_Table){
		$we_ContentType = f("SELECT ContentType FROM $we_Table WHERE ID=$we_ID","ContentType",$DB_WE);
	}
	if(isset($we_ContentType)){
		switch($we_ContentType){
			case "application/x-shockwave-flash":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_flashDocument.inc.php");
				$we_doc = new we_flashDocument();
			 	break;
			case "video/quicktime":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_quicktimeDocument.inc.php");
				$we_doc = new we_quicktimeDocument();
			 	break;
			case "image/*":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
				$we_doc = new we_imageDocument();
			 	break;
			case "folder":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_folder.inc.php");
				$we_doc = new we_folder();
			 	break;
			case "text/weTmpl":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_template.inc.php");
				$we_doc = new we_template();
			 	break;
			case "text/webedition":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_webEditionDocument.inc.php");
				$we_doc = new we_webEditionDocument();
			 	break;
			case "text/html":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_htmlDocument.inc.php");
				$we_doc = new we_htmlDocument();
			 	break;
			case "text/xml":
			case "text/js":
			case "text/css":
			case "text/plain":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_textDocument.inc.php");
				$we_doc = new we_textDocument();
			 	break;
			case "application/*":
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_otherDocument.inc.php");
				$we_doc = new we_otherDocument();
				break;
			default:
				$moduleDir = we_getModuleNameByContentType($we_ContentType);
				if($moduleDir != ""){
					$moduleDir .= "/";
				}

				if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_modules/" . $moduleDir . "we_".$we_ContentType.".inc.php")){
					include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_modules/" . $moduleDir . "we_".$we_ContentType.".inc.php");
					eval('$we_doc = new we_'.$we_ContentType.'();');
				}else{
					exit("Can NOT initialize document");
				}

		}
	}else{
		if(isset($we_dt[0]["ClassName"]) && $we_dt[0]["ClassName"]){
			if(file_exists($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/".$we_dt[0]["ClassName"].".inc.php")){
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/".$we_dt[0]["ClassName"].".inc.php");
			}else{	//	Here only object-Files??
				include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_modules/object/".$we_dt[0]["ClassName"].".inc.php");
			}
			eval('$we_doc =new '.$we_dt[0]["ClassName"].'();');
		}else{
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_webEditionDocument.inc.php");
			$we_doc = new we_webEditionDocument();
		}
	}
	if(isset($we_ID)){
		$we_doc->initByID($we_ID,$we_Table,( (isset($GLOBALS["FROM_WE_SHOW_DOC"]) && $GLOBALS["FROM_WE_SHOW_DOC"]) || (isset($GLOBALS["WE_RESAVE"]) && $GLOBALS["WE_RESAVE"]) ) ? LOAD_MAID_DB : LOAD_TEMP_DB);

	}else if(isset($we_dt)){
		$we_doc->we_initSessDat($we_dt);
		//	in some templates we must disable some EDIT_PAGES and disable some buttons
		$we_doc->executeDocumentControlElements();

	}else{
		$we_doc->ContentType=$we_ContentType;
		$we_doc->Table= (isset($we_Table) && $we_Table) ? $we_Table : FILE_TABLE;
		$we_doc->we_new();

	}
}

$GLOBALS["we_doc"] = clone($we_doc);

//if document opens get initial object for versioning if no versions exist
if(isset($_REQUEST['we_cmd'][0]) && ($_REQUEST['we_cmd'][0]=='load_edit_footer' || $_REQUEST['we_cmd'][0]=='switch_edit_page')) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
	$version = new weVersions();
	$version->setInitialDocObject($GLOBALS["we_doc"]);
}

?>