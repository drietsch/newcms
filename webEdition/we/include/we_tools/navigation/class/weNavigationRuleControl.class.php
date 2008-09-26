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

class weNavigationRuleControl
{

	var $NavigationRule;

	function weNavigationRuleControl()
	{
		
		$this->NavigationRule = new weNavigationRule();
	}

	function processCommands()
	{
		
		$js = '';
		$html = '';
		
		if (isset($_REQUEST['cmd'])) {
			
			switch ($_REQUEST['cmd']) {
				
				case "save_navigation_rule" :
					
					$isNew = $this->NavigationRule->isnew; // navigationID = 0
					

					$save = true;
					
					$this->NavigationRule->NavigationName = trim($this->NavigationRule->NavigationName);
					
					// 1st check if name is allowed
					if (!eregi(
							'^[������a-z0-9_-]+$', 
							$this->NavigationRule->NavigationName)) {
						$js = we_message_reporting::getShowMessageCall(
								$GLOBALS['l_navigation']['rules']['invalid_name'], 
								WE_MESSAGE_ERROR);
						$save = false;
					}
					
					// 2ns check if another element has same name
					$db = new DB_WE();
					
					$query = '
						SELECT *
						FROM ' . NAVIGATION_RULE_TABLE . '
						WHERE NavigationName = "' . $this->NavigationRule->NavigationName . '"
							AND ID != ' . $this->NavigationRule->ID;
					
					$db->query($query);
					if ($db->num_rows()) {
						$js = we_message_reporting::getShowMessageCall(
								sprintf(
										$GLOBALS['l_navigation']['rules']['name_exists'], 
										$this->NavigationRule->NavigationName), 
								WE_MESSAGE_ERROR);
						$save = false;
					}
					
					if ($save && $this->NavigationRule->save()) {
						
						$js = "
						doc = top.frames['content'];";
						
						if ($isNew) {
							$js .= "
						doc.weSelect.addOption('navigationRules', " . $this->NavigationRule->ID . ", '" . $this->NavigationRule->NavigationName . "');";
						} else {
							$js .= "
						doc.weSelect.updateOption('navigationRules', " . $this->NavigationRule->ID . ", '" . $this->NavigationRule->NavigationName . "');";
						}
						
						$js .= "
						doc.weSelect.selectOption('navigationRules', " . $this->NavigationRule->ID . ");
						doc.weInput.setValue('ID', " . $this->NavigationRule->ID . ");
						";
						$js .= we_message_reporting::getShowMessageCall(
								sprintf(
										$GLOBALS['l_navigation']['rules']['saved_successful'], 
										$this->NavigationRule->NavigationName), 
								WE_MESSAGE_NOTICE);
					}
					break;
				
				case "delete_navigation_rule" :
					if ($this->NavigationRule->delete()) {
						
						$js = "
						doc = top.frames['content'];
						doc.weSelect.removeOption('navigationRules', " . $this->NavigationRule->ID . ", '" . $this->NavigationRule->NavigationName . "');
						doc.weInput.setValue('ID', " . 0 . ");
						";
					} else {
					
					}
					break;
				
				case "edit_navigation_rule" :
					
					$this->NavigationRule = new weNavigationRule();
					$this->NavigationRule->initByID($_REQUEST['ID']);
					
					$FolderIDPath = '';
					if ($this->NavigationRule->FolderID) {
						$FolderIDPath = id_to_path($this->NavigationRule->FolderID, FILE_TABLE);
					}
					
					$ClassIDPath = '';
					if (defined('OBJECT_TABLE') && $this->NavigationRule->ClassID) {
						$ClassIDPath = id_to_path($this->NavigationRule->ClassID, OBJECT_TABLE);
					}
					
					$NavigationIDPath = '';
					if ($this->NavigationRule->NavigationID) {
						$NavigationIDPath = id_to_path($this->NavigationRule->NavigationID, NAVIGATION_TABLE);
					}
					
					// workspaces:
					$_workspaceList = 'optionList.push({"text":"' . $GLOBALS['l_navigation']['no_entry'] . '","value":"0"});';
					$_selectWorkspace = '';
					if (defined('OBJECT_TABLE') && $this->NavigationRule->ClassID) {
						
						$_workspaces = $this->getWorkspacesByClassID($this->NavigationRule->ClassID);
						
						foreach ($_workspaces as $key => $value) {
							$_workspaceList .= 'optionList.push({"text":"' . $value . '","value":"' . $key . '"});';
						}
						$_selectWorkspace = 'doc.weSelect.selectOption("WorkspaceID", "' . $this->NavigationRule->WorkspaceID . '" );';
					}
					
					// categories
					$catJs = '';
					if ($this->NavigationRule->Categories) {
						
						$catIds = makeArrayFromCSV($this->NavigationRule->Categories);
						
						foreach ($catIds as $catId) {
							if ($path = id_to_path($catId, CATEGORY_TABLE)) {
								$catJs .= 'doc.categories_edit.addItem();doc.categories_edit.setItem(0,(doc.categories_edit.itemCount-1),"' . $path . '");
							';
							}
						}
					}
					
					$js = "
						doc = top.frames['content'];
						doc.clearNavigationForm();
						
						doc.weInput.setValue('ID', " . $this->NavigationRule->ID . ");
						doc.weInput.setValue('NavigationName', '" . $this->NavigationRule->NavigationName . "');
						
						doc.weInput.setValue('NavigationID', '" . $this->NavigationRule->NavigationID . "');
						doc.weInput.setValue('NavigationIDPath', '" . $NavigationIDPath . "');
						
						doc.weInput.setValue('FolderID', '" . $this->NavigationRule->FolderID . "');
						doc.weInput.setValue('FolderIDPath', '" . $FolderIDPath . "');
						
						
						doc.weSelect.selectOption('SelectionType', '" . $this->NavigationRule->SelectionType . "');
						doc.switchType('" . $this->NavigationRule->SelectionType . "');
						
						doc.weInput.setValue('DoctypeID', '" . $this->NavigationRule->DoctypeID . "');
						
						doc.weInput.setValue('ClassID', '" . $this->NavigationRule->ClassID . "');
						doc.weInput.setValue('ClassIDPath', '" . $ClassIDPath . "');
						
						doc.removeAllCats();
						$catJs
						doc.categories_edit.showVariant(0);
						doc.weInput.setValue('CategoriesCount', doc.categories_edit.itemCount);
					
						
						var optionList = new Array();
						$_workspaceList
						doc.weSelect.setOptions('WorkspaceID', optionList);
						$_selectWorkspace
						";
					break;
				
				case "get_workspaces" :
					
					if (defined('OBJECT_TABLE') && $_REQUEST['ClassID']) {
						
						$_workspaces = $this->getWorkspacesByClassID($_REQUEST['ClassID']);
						
						$optionList = 'optionList.push({"text":"' . $GLOBALS['l_navigation']['no_entry'] . '","value":"0"});';
						
						foreach ($_workspaces as $key => $value) {
							$optionList .= 'optionList.push({"text":"' . $value . '","value":"' . $key . '"});';
						}
						
						$js = "
							doc = top.frames['content'];
							var optionList = new Array();
							$optionList
							doc.weSelect.setOptions('WorkspaceID', optionList);
						";
					}
					
					break;
			}
			
			print htmlTop();
			print we_htmlElement::jsElement($js);
			print "</head>
			<body>
				$html
			</body>
			</html>";
			exit();
		}
	}

	function getWorkspacesByClassID($classId)
	{
		
		$_workspaces = array();
		
		if ($classId) {
			$_workspaces = weDynList::getWorkspacesForClass($classId);
			asort($_workspaces);
		}
		return $_workspaces;
	}

	function processVariables()
	{
		
		if (isset($_REQUEST['CategoriesControl']) && isset($_REQUEST['CategoriesCount'])) {
			
			$_categories = array();
			
			for ($i = 0; $i < $_REQUEST['CategoriesCount']; $i++) {
				if (isset(
						$_REQUEST[$_REQUEST['CategoriesControl'] . '_variant0_' . $_REQUEST['CategoriesControl'] . '_item' . $i])) {
					
					$_categories[] = $_REQUEST[$_REQUEST['CategoriesControl'] . '_variant0_' . $_REQUEST['CategoriesControl'] . '_item' . $i];
				}
			}
			
			$categoryIds = array();
			
			for ($i = 0; $i < sizeof($_categories); $i++) {
				
				if ($path = path_to_id($_categories[$i], CATEGORY_TABLE)) {
					
					$categoryIds[] = path_to_id($_categories[$i], CATEGORY_TABLE);
				}
			}
			$categoryIds = array_unique($categoryIds);
			
			$_catString = '';
			
			if (sizeof($categoryIds)) {
				
				$_catString = ',';
				
				foreach ($categoryIds as $catId) {
					$_catString .= "$catId,";
				}
			}
			
			$this->NavigationRule->Categories = $_catString;
		}
		
		if (is_array($this->NavigationRule->persistent_slots)) {
			foreach ($this->NavigationRule->persistent_slots as $val) {
				if (isset($_REQUEST[$val])) {
					$this->NavigationRule->$val = $_REQUEST[$val];
				}
			}
		}
		
		if ($this->NavigationRule->ID == 0) {
			$this->NavigationRule->isnew = true;
		} else {
			$this->NavigationRule->isnew = false;
		}
	}

	function getAllNavigationRules()
	{
		
		$db = new DB_WE();
		
		$query = '
			SELECT *
			FROM ' . NAVIGATION_RULE_TABLE;
		
		$db->query($query);
		
		$navigationRules = array();
		
		while ($db->next_record()) {
			
			$_navigationRule = new weNavigationRule();
			foreach ($_navigationRule->persistent_slots as $val) {
				
				$_navigationRule->$val = $db->f($val);
			}
			$navigationRules[] = $_navigationRule;
		}
		return $navigationRules;
	}
}

?>