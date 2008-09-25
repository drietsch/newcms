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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

switch($_REQUEST["we_cmd"][1]) {
	case "image/*":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_imageDocument.inc.php");
		$we_doc=new we_imageDocument();
		$we_doc->we_initSessDat($_SESSION["we_data"][$_REQUEST["we_cmd"][2]]);
		$contenttype = $we_doc->getElement("type");
		break;
	case "application/x-shockwave-flash":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_flashDocument.inc.php");
		$we_doc=new we_flashDocument();
		$we_doc->we_initSessDat($_SESSION["we_data"][$_REQUEST["we_cmd"][2]]);
		$contenttype = $_REQUEST["we_cmd"][1];
		break;
	case "video/quicktime":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_quicktimeDocument.inc.php");
		$we_doc=new we_quicktimeDocument();
		$we_doc->we_initSessDat($_SESSION["we_data"][$_REQUEST["we_cmd"][2]]);
		$contenttype = $_REQUEST["we_cmd"][1];
		break;
	case "application/*":
		include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_classes/we_otherDocument.inc.php");
		$we_doc=new we_otherDocument();
		$we_doc->we_initSessDat($_SESSION["we_data"][$_REQUEST["we_cmd"][2]]);
		switch($we_doc->Extension) {
			case ".zip":
				$contenttype = "application/zip";
				break;
			case ".doc":
				$contenttype = "application/msword";
				break;
			case ".xls":
				$contenttype = "application/vnd.ms-excel";
				break;
			case ".ppt":
				$contenttype = "application/vnd.ms-powerpoint";
				break;
			case ".pdf":
				$contenttype = "application/pdf";
				break;
			case ".sit":
				$contenttype = "application/x-stuffit";
				break;
			case ".hqx":
				$contenttype = "application/mac-binhex40";
				break;
			default:
				$contenttype = "application/octet-stream";
		}
		break;
}
header("Content-disposition: filename=".$we_doc->Text);
header("Content-Type: $contenttype");
header("Pragma: no-cache");
header("Expires: 0");

$dataPath = $we_doc->getElement("data");
if(isset($_REQUEST["we_cmd"][3]) && $_REQUEST["we_cmd"][3]){ // create thumbnail
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/we_thumbnail.class.php");
	if(we_image_edit::gd_version()){
		$thumbObj = new we_thumbnail();
		$thumbObj->initByThumbID($_REQUEST["we_cmd"][3],$we_doc->ID,$we_doc->Filename,$we_doc->Path,$we_doc->Extension,$we_doc->getElement("origwidth"),$we_doc->getElement("origheight"),$we_doc->getDocument());
		$thumbObj->getThumb($out);
		unset($thumbObj);
		print $out;exit();
	}
}

readfile($dataPath);
exit();

?>