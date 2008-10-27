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
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/weSelectorQuery.class.inc.php");


class rpcSelectorGetFilesOfDirCmd extends rpcCmd {
	
	function execute() {

		$resp = new rpcResponse();

		$queryClass = new weSelectorQuery();
		eval('$table = ' . $_REQUEST["table"] . ';');
		
		// if a value is already inserted in a selector, we get an i, not a parentID
		if (isset($_REQUEST["id"])) {
			$id = $_REQUEST["id"];
			
			// detect belonging parentid
			$queryClass = new weSelectorQuery();
			if ($res = $queryClass->getItemById($id, $table) ) {
				$id = $res[0]["ParentID"];
				
			} else {
				$id = 0;
				
			}
			
		} else {
			$id = isset($_REQUEST["parentId"]) ? $_REQUEST["parentId"] : 0;
			
		}
		
		$types = array();
		if ($_REQUEST["types"]) {
			$types = explode(",", $_REQUEST["types"]);
			
		}
		$queryClass->queryFolderContents($id, $table, $types, null);
		$entries = $queryClass->getResult();
		
		$first = true;
		
		$data = "_files = new Object();";
			// 1st step, select this folder if folders are selectable
			if (in_array("folder", $types)) {
				$data .= '_files["id_' . $id . '"] = {"type":"folder","text":".","id":"' . $id . '"};';
			}
			// one folder, or up to root
			// parent Folder for navigation up
			if ($parentFolder = $queryClass->getItemById($id, $table) ) {
				$data .= '_files["id_' . $parentFolder[0]["ParentID"] . '"] = {"type":"folder","text":"..","id":"' . $parentFolder[0]["ParentID"] . '"};';
			} else {
				$data .= '_files["id_0"] = {"type":"folder","text":"..","id":"0"};';
			}
			
			
			foreach ($entries as $entry) {
				$data .= '_files["id_' . $entry["ID"] . '"] = {"type":"' . (isset($entry["ContentType"]) ? $entry["ContentType"] : "") . '","text":"' . $entry["Text"] . '","id":"' . $entry["ID"] . '"};';
				
			}
		$resp->addData("data", $data);
		return $resp;
	}
}
?>