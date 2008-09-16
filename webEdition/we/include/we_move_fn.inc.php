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

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/we_temporaryDocument.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/alert.inc.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_exim/weContentProvider.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_versions/weVersions.class.inc.php");

$notprotect = isset($GLOBALS["NOT_PROTECT"]) && $GLOBALS["NOT_PROTECT"] && (!isset($_REQUEST["NOT_PROTECT"]));

if (!$notprotect) {
	protect();
}

function moveTreeEntries($dontMoveClassFolders = false)
{
	$s = "var obj = top.treeData;\n";
	$s .= "var cont = new top.container();\n";
	$s .= "\n";
	$s .= "for(var i=1;i<=obj.len;i++){\n";
	$s .= "	if(obj[i].checked!=1 " . ($dontMoveClassFolders ? " || obj[i].parentid==0" : "") . "){\n";
	$s .= "		if(obj[i].parentid != 0){\n";
	$s .= "			if(!parentChecked(obj[i].parentid)){\n";
	$s .= "				cont.add(obj[i]);\n";
	$s .= "			}\n";
	$s .= "		}else{\n";
	$s .= "			cont.add(obj[i]);\n";
	$s .= "		}\n";
	$s .= "	}\n";
	$s .= "}\n";
	$s .= "top.treeData = cont;\n";
	$s .= "top.drawTree();\n";
	$s .= "\n";
	$s .= "function parentChecked(start){\n";
	$s .= "	var obj = top.treeData;\n";
	$s .= "	for(var i=1;i<=obj.len;i++){\n";
	$s .= "		if(obj[i].id == start){\n";
	$s .= "			if(obj[i].checked==1){\n";
	$s .= "				return true;\n";
	$s .= "			} else if(obj[i].parentid != 0){\n";
	$s .= "				parentChecked(obj[i].parentid);\n";
	$s .= "			}\n";
	$s .= "		}\n";
	$s .= "	}\n";
	$s .= "	return false;\n";
	$s .= "}\n";
	return $s;
}

function checkMoveItem($targetDirectoryID, $id, $table, &$items2move)
{
	$DB_WE = new DB_WE();
	// check if entry is a folder
	$row = getHash("SELECT Path, Text, IsFolder FROM " . addslashes($table) . " WHERE  ID=" . abs($id), $DB_WE);
	if (sizeof($row) == 0 || $row["IsFolder"]) {
		return -1;
	}
	
	$text = $row["Text"];
	$temp = explode("/", $row["Path"]);
	if (sizeof($temp) < 2) {
		$rootdir = "/";
	} else {
		$rootdir = "/" . $temp[1];
	}
	
	// add the item to the item names which could be moved
	array_push($items2move, $text);
	
	$DB_WE->query("SELECT Text,Path FROM " . $table . " WHERE ParentID=" . abs($targetDirectoryID));
	while ($DB_WE->next_record()) {
		// check if there is a item with the same name in the target directory
		if (in_array($DB_WE->f('Text'), $items2move)) {
			return -2;
		}
		
		if (defined("OBJECT_TABLE") && $table == OBJECT_FILES_TABLE) {
			// check if class directory is the same
			if (substr($DB_WE->f('Path'), 0, strlen($rootdir)) != $rootdir) {
				return -3;
			}
		}
	}
	return 1;
}

function moveItem($targetDirectoryID, $id, $table, &$notMovedItems)
{
	
	$DB_WE = new DB_WE();
	
	if (!$id) {
		return false;
	}
	
	$table = addslashes($table);
	
	// get information about the target directory
	if (defined("OBJECT_TABLE") && $table == OBJECT_TABLE && !$targetDirectoryID) {
		return false;
	} elseif ($targetDirectoryID) {
		$row = getHash("SELECT IsFolder,Path,ID FROM " . $table . " WHERE ID=" . abs($targetDirectoryID), $DB_WE);
		if (sizeof($row) == 0 || !$row["IsFolder"]) {
			return false;
		}
		$newPath = $row['Path'];
		$parentID = $row['ID'];
	} else {
		$newPath = "";
		$parentID = 0;
	}
	
	@set_time_limit(30);
	
	// move Templates
	if ($table == TEMPLATES_TABLE) {
		/*
		// get information about the template which has to be moved
		$row = getHash("SELECT Text,Path,IsFolder,Icon FROM ".$table." WHERE ID=".abs($id),$DB_WE);
		$fileName = $row['Text'];
		$oldPath = $row['Path'];
		$isFolder = ($row["IsFolder"] == 1 ? true : false);
		$icon = $row['Icon'];
		$item = array(
			'ID'	=> $id,
			'Text'	=> $fileName,
			'Path'	=> $oldPath,
			'Icon'	=> $icon,
		);

		if(sizeof($row) == 0 || $isFolder) {
			array_push($notMovedItems, $item);
			return false;
		}

		// move template file
		if(!file_exists(TEMPLATE_DIR.$oldPath)) {
			array_push($notMovedItems, $item);
			return false;
		}

		if(!copy(TEMPLATE_DIR.$oldPath, TEMPLATE_DIR.$newPath."/".$fileName)) {
			array_push($notMovedItems, $item);
			return false;
		}

		if(!unlink(TEMPLATE_DIR.$oldPath)) {
			array_push($notMovedItems, $item);
			return false;
		}

		// update table
		$q = "UPDATE ".$table." SET ParentID=".$parentID.", Path='".$newPath."/".$fileName."' WHERE ID=".abs($id);
		$DB_WE->query($q);

		return true;
		*/
		// bugfix 0001643
		include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/we_template.inc.php');
		$_template = new we_template();
		$_template->initByID($id, $_template->Table);
		$_template->ParentID = $targetDirectoryID;
		if (!$_template->save()) {
			array_push(
					$notMovedItems, 
					array(
						
							'ID' => $_template->ID, 
							'Text' => $_template->Text, 
							'Path' => $_template->Path, 
							'Icon' => $_template->Icon
					));
			return false;
		}
		return true;
		// move documents
	} elseif ($table == FILE_TABLE) {
		
		// get information about the document which has to be moved
		$row = getHash(
				"SELECT Text,Path,Published,IsFolder,Icon,ContentType FROM " . $table . " WHERE ID=" . abs($id), 
				$DB_WE);
		$fileName = $row['Text'];
		$oldPath = $row['Path'];
		$isPublished = ($row['Published'] > 0 ? true : false);
		$isFolder = ($row["IsFolder"] == 1 ? true : false);
		$icon = $row['Icon'];
		$item = array(
			'ID' => $id, 'Text' => $fileName, 'Path' => $oldPath, 'Icon' => $icon
		);
		if (sizeof($row) == 0 || $isFolder) {
			array_push($notMovedItems, $item);
			return false;
		}
		
		// move document file
		if (!file_exists($_SERVER["DOCUMENT_ROOT"] . SITE_DIR . $oldPath)) {
			array_push($notMovedItems, $item);
			return false;
		}
		if (!copy(
				$_SERVER["DOCUMENT_ROOT"] . SITE_DIR . $oldPath, 
				$_SERVER["DOCUMENT_ROOT"] . SITE_DIR . $newPath . "/" . $fileName)) {
			array_push($notMovedItems, $item);
			return false;
		}
		if (!unlink($_SERVER["DOCUMENT_ROOT"] . SITE_DIR . $oldPath)) {
			array_push($notMovedItems, $item);
			return false;
		}
		
		// move published document file
		if ($isPublished) {
			if (!file_exists($_SERVER["DOCUMENT_ROOT"] . $oldPath)) {
				array_push($notMovedItems, $item);
				return false;
			}
			if (!copy($_SERVER["DOCUMENT_ROOT"] . $oldPath, $_SERVER["DOCUMENT_ROOT"] . $newPath . "/" . $fileName)) {
				array_push($notMovedItems, $item);
				return false;
			}
			if (!unlink($_SERVER["DOCUMENT_ROOT"] . $oldPath)) {
				array_push($notMovedItems, $item);
				return false;
			}
		}
		
		$version = new weVersions();
		if (in_array($row['ContentType'], $version->contentTypes)) {
			$object = weContentProvider::getInstance($row['ContentType'], $id, $table);
			$version_exists = $version->getLastEntry($id, $table);
			$tempOldParentID = $object->ParentID;
			$tempNewParentID = $parentID;
			$tempOldPath = $object->Path;
			$tempNewPath = "" . $newPath . "/" . $fileName . "";
			$object->Path = $tempNewPath;
			$object->ParentID = $tempNewParentID;
			if (empty($version_exists)) {
				$object->Path = $tempOldPath;
				$object->ParentID = $tempOldParentID;
				$version->saveVersion($object);
				$object->Path = $tempNewPath;
				$object->ParentID = $tempNewParentID;
			}
			$version->saveVersion($object);
		
		}
		
		// update table
		$q = "UPDATE " . $table . " SET ParentID=" . $parentID . ", Path='" . $newPath . "/" . $fileName . "' WHERE ID=" . abs(
				$id);
		$DB_WE->query($q);
		
		return true;
		
	// move Objects
	} elseif (defined("OBJECT_TABLE") && $table == OBJECT_FILES_TABLE) {
		
		// get information about the object which has to be moved
		$row = getHash(
				"SELECT TableID,Path,Text,IsFolder,Icon,ContentType FROM " . $table . " WHERE ID=" . abs($id), 
				$DB_WE);
		$tableID = $row['TableID'];
		$oldPath = $row['Path'];
		$fileName = $row['Text'];
		$isFolder = ($row["IsFolder"] == 1 ? true : false);
		$icon = $row['Icon'];
		$item = array(
			'ID' => $id, 'Text' => $fileName, 'Path' => $oldPath, 'Icon' => $icon
		);
		if (sizeof($row) == 0 || $isFolder) {
			array_push($notMovedItems, $item);
			return false;
		}
		
		$version = new weVersions();
		if (in_array($row['ContentType'], $version->contentTypes)) {
			$object = weContentProvider::getInstance($row['ContentType'], $id, $table);
			$version_exists = $version->getLastEntry($id, $table);
			$tempOldParentID = $object->ParentID;
			$tempNewParentID = $parentID;
			$tempOldPath = $object->Path;
			$tempNewPath = "" . $newPath . "/" . $fileName . "";
			$object->Path = $tempNewPath;
			$object->ParentID = $tempNewParentID;
			if (empty($version_exists)) {
				$object->Path = $tempOldPath;
				$object->ParentID = $tempOldParentID;
				$version->saveVersion($object);
				$object->Path = $tempNewPath;
				$object->ParentID = $tempNewParentID;
			}
			$version->saveVersion($object);
		
		}
		
		// update table
		$q = "UPDATE " . $table . " SET ParentID=" . $parentID . ", Path='" . $newPath . "/" . $fileName . "' WHERE ID=" . abs(
				$id);
		$DB_WE->query($q);
		$q = "UPDATE " . OBJECT_X_TABLE . $tableID . " SET OF_ParentID=" . $parentID . ", OF_Path='" . $newPath . "/" . $fileName . "' WHERE OF_ID=" . abs(
				$id);
		$DB_WE->query($q);
		
		return true;
	
	}
	
	return false;

}

function checkIfRestrictUserIsAllowed($id, $table = FILE_TABLE)
{
	
	$DB_WE = new DB_WE();
	$row = getHash("SELECT CreatorID,RestrictOwners,Owners,OwnersReadOnly FROM $table WHERE ID=$id", $DB_WE);
	
	if (($_SESSION["user"]["ID"] == $row["CreatorID"]) || $_SESSION["perms"]["ADMINISTRATOR"]) { //	Owner or admin
		return true;
	}
	
	if ($row["RestrictOwners"]) { //	check which user - group has permission
		

		$userArray = makeArrayFromCSV($row["Owners"]);
		
		$_allowedGroup = false;
		
		//	check if usergroup is allowed
		foreach ($_SESSION['user']['groups'] as $nr => $_userGroup) {
			if (in_array($_userGroup, $userArray)) {
				$_allowedGroup = true;
				break;
			}
		}
		if (!in_array($_SESSION["user"]["ID"], $userArray) && !$_allowedGroup) { //	user is no allowed user.
			

			return false;
		}
		
		//	user belongs to owners of document, check if he has only read access !!!
		

		if ($row["OwnersReadOnly"]) {
			
			$arr = unserialize($row["OwnersReadOnly"]);
			if (is_array($arr)) {
				
				if (isset($arr[$_SESSION["user"]["ID"]]) && $arr[$_SESSION["user"]["ID"]]) { //	if user is readonly user -> no delete
					return false;
				} else { //	user NOT readonly and in restricted -> delete allowed
					if (in_array($_SESSION["user"]["ID"], $userArray)) {
						return true;
					}
				}
				//	check if group has rights to delete
				foreach ($_SESSION['user']['groups'] as $nr => $_userGroup) { //	user is directly in first group
					if (isset($arr[$_userGroup]) && $arr[$_userGroup]) { //	group not allowed
						return false;
					} else {
						if (in_array($_userGroup, $userArray)) { //	group is NOT readonly and in restricted -> delete allowed
							return true;
						}
					}
				}
			}
		}
	}
	return true;
}

?>
