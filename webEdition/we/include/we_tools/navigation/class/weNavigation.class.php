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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/modules/weModelBase.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationRuleControl.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationRule.class.php');
include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigationCache.class.php');

/**
 * General Definition of WebEdition Navigation
 *
 */
class weNavigation extends weModelBase
{

	//properties
	var $ID = 0;

	var $Text = '';

	var $Display = '';

	var $Name = '';

	var $ParentID = 0;

	var $TitleField = '';

	var $IconID = '';

	var $IsFolder = 0;

	var $Path = '/';

	var $Selection = 'static';

	var $SelectionType = 'docLink';

	var $FolderID = 0;

	var $DocTypeID = 0;

	var $ClassID = 0;

	var $Categories = array();

	var $CategoryIDs = '';

	var $Sort = array();

	var $ShowCount = 5;

	var $LinkID = 0;

	var $Ordn = 0;

	var $Depended = 0;

	var $WorkspaceID = -1;

	var $CatParameter = 'catid';

	var $Parameter = '';

	var $LinkSelection = 'intern';

	var $Url = 'http://';

	var $UrlID = 0;

	var $Charset = '';

	var $defaultPreviewCode = '';

	var $previewCode = '';

	var $ClassName = 'weNavigation';

	var $ContentType = 'weNavigation';

	var $Attributes = array();

	var $FolderSelection = 'docLink';

	var $FolderParameter = '';

	var $FolderWsID = -1;

	var $FolderUrl = 'http://';

	var $Table = NAVIGATION_TABLE;

	var $LimitAccess = 0;

	var $AllCustomers = 1;

	var $ApplyFilter = 0;

	var $Customers = array();

	var $CustomerFilter = array();

	var $BlackList = array();

	var $WhiteList = array();

	var $UseDocumentFilter = true;

	var $serializedFields = array(
		'Sort', 'Attributes', 'CustomerFilter'
	);

	/**
	 * Default Constructor
	 * Can load or create new navigation depends of parameter
	 */
	
	function weNavigation($navigationID = 0)
	{
		
		weModelBase::weModelBase(NAVIGATION_TABLE);
		
		if ($_ws = get_ws(NAVIGATION_TABLE)) {
			$_wsa = makeArrayFromCSV($_ws);
			$this->ParentID = $_wsa[0];
		}
		
		if ($navigationID) {
			$this->ID = $navigationID;
			$this->load($navigationID);
		}
		
		include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/conf/we_navigationSettings.inc.php');
		$this->defaultPreviewCode = str_replace('@###PARENTID###@', $this->ID, $this->defaultPreviewCode);
		$this->previewCode = $this->defaultPreviewCode;
	}

	function load($id = '0')
	{
		if (parent::load($id)) {
			$this->CategoryIDs = $this->Categories;
			
			$this->Categories = makeArrayFromCSV($this->Categories);
			$this->Categories = $this->convertToPaths($this->Categories, CATEGORY_TABLE);
			
			$this->Sort = $this->Sort ? @unserialize($this->Sort) : '';
			
			if ($this->IsFolder == 0) {
				$this->Charset = $this->findCharset($this->ParentID);
			}
			$this->Attributes = @unserialize($this->Attributes);
			if (!is_array($this->Attributes)) {
				$this->Attributes = array();
			}
			
			if (defined('CUSTOMER_TABLE')) {
				if (!is_array($this->Customers)) {
					$this->Customers = makeArrayFromCSV($this->Customers);
				}
				if (!is_array($this->BlackList)) {
					$this->BlackList = makeArrayFromCSV($this->BlackList);
				}
				if (!is_array($this->WhiteList)) {
					$this->WhiteList = makeArrayFromCSV($this->WhiteList);
				}
				
				$this->CustomerFilter = @unserialize($this->CustomerFilter);
				if (!is_array($this->CustomerFilter)) {
					$this->CustomerFilter = array();
				}
			}
		
		}
		$this->ContentType = 'weNavigation';
	}

	function _getFilterOfDocument()
	{
		$_id = 0;
		$_table = "";
		if ($this->IsFolder) {
			if ($this->FolderSelection == "objLink") {
				$_table = OBJECT_FILES_TABLE;
				$_id = $this->LinkID;
			} else 
				if ($this->FolderSelection == "docLink") {
					$_table = FILE_TABLE;
					$_id = $this->LinkID;
				}
		} else {
			if ($this->SelectionType == "objLink") {
				$_table = OBJECT_FILES_TABLE;
				$_id = $this->LinkID;
			} else 
				if ($this->SelectionType == "docLink") {
					$_table = FILE_TABLE;
					$_id = $this->LinkID;
				}
		}
		
		$this->LimitAccess = 0;
		
		if ($_id && $_table) {
			$_docFilter = weDocumentCustomerFilter::getFilterByIdAndTable($_id, $_table);
			if ($_docFilter) {
				weNavigationCustomerFilter::translateModeToNavModel($_docFilter->getMode(), $this);
				$this->Customers = $_docFilter->getSpecificCustomers();
				$this->CustomerFilter = $_docFilter->getFilter();
				$this->BlackList = $_docFilter->getBlackList();
				$this->WhiteList = $_docFilter->getWhiteList();
			}
		}
	
	}

	function save($order = true)
	{
		$configFile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/conf/we_conf_navigation.inc.php";
		if (!file_exists($configFile) || !is_file($configFile)) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/class/weNavigationSettingControl.class.php");
			weNavigationSettingControl::saveSettings(true);
		}
		include ($configFile);
		
		if (defined('CUSTOMER_TABLE') && $this->UseDocumentFilter) {
			$this->_getFilterOfDocument();
		}
		
		$this->Text = $this->encodeSpecChars($this->Text);
		$this->Icon = ($this->IsFolder == 1 ? 'folder.gif' : 'link.gif');
		
		$_paths = $this->Categories;
		$this->Categories = makeCSVFromArray(weConvertToIds($this->Categories, CATEGORY_TABLE), true);
		
		$_preSort = $this->Sort;
		if (is_array($this->Sort)) {
			$this->Sort = serialize($this->Sort);
		}
		$this->setPath();
		
		if ($order) {
			$_ord_count = f(
					'SELECT COUNT(ID) as OrdCount FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $this->ParentID . ';', 
					'OrdCount', 
					$this->db);
			if ($this->ID == 0) {
				$this->Ordn = $_ord_count;
			} else {
				if ($this->Ordn > ($_ord_count - 1)) {
					$this->Ordn = $_ord_count;
				}
				$_oldPid = f(
						'SELECT ParentID FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $this->ID, 
						'ParentID', 
						$this->db);
			}
		}
		
		if ($this->IsFolder == 0) {
			$_charset = $this->Charset;
			$this->Charset = '';
		}
		$_preAttrib = $this->Attributes;
		if (is_array($this->Attributes)) {
			$this->Attributes = serialize($this->Attributes);
		}
		
		if (defined('CUSTOMER_TABLE') && $this->LimitAccess) {
			$_cus_paths = $this->Customers;
			$_bl_paths = $this->BlackList;
			$_wl_paths = $this->WhiteList;
			$this->WhiteList = makeCSVFromArray($this->WhiteList, true);
			$this->BlackList = makeCSVFromArray($this->BlackList, true);
			$this->Customers = makeCSVFromArray($this->Customers, true);
			$this->CustomerFilter = serialize($this->CustomerFilter);
		} else {
			$_cus_paths = array();
			$_bl_paths = array();
			$_wl_paths = array();
			$this->Customers = '';
			$this->WhiteList = '';
			$this->BlackList = '';
			$this->CustomerFilter = '';
		}
		
		// Clear the Cache if the option is set
		$ClearCache = false;
		if ($this->isnew && $GLOBALS['weNavigationCacheDeleteAfterAdd']) {
			$ClearCache = true;
		} else 
			if (!$this->isnew && $GLOBALS['weNavigationCacheDeleteAfterEdit']) {
				$ClearCache = true;
			}
		
		parent::save();
		
		// Clear the Cache if the option is set
		if ($ClearCache) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
			$cacheDir = weCacheHelper::getCacheDir();
			weCacheHelper::clearCache($cacheDir);
		}
		
		if ($order && isset($_oldPid) && $_oldPid != $this->ParentID) {
			// the entry has been moved
			$this->reorder($_oldPid);
			$this->reorder($this->ParentID);
		}
		$this->Categories = $_paths;
		$this->Sort = $_preSort;
		include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/conf/we_navigationSettings.inc.php');
		$this->defaultPreviewCode = str_replace('@###PARENTID###@', $this->ID, $this->defaultPreviewCode);
		$this->previewCode = $this->defaultPreviewCode;
		
		if ($this->IsFolder == 0) {
			$this->Charset = $_charset;
		}
		
		$this->Attributes = $_preAttrib;
		
		if (defined('CUSTOMER_TABLE')) {
			$this->Customers = $_cus_paths;
			$this->WhiteList = $_wl_paths;
			$this->BlackList = $_bl_paths;
			$this->CustomerFilter = unserialize($this->CustomerFilter);
		}
		$this->Name = $this->Text;
		if ($this->IsFolder) {
			weNavigationCache::cacheNavigationTree($this->ID);
		} else {
			weNavigationCache::cacheNavigationTree($this->ParentID);
		}
	
	}

	function convertToPaths($ids, $table)
	{
		if (!is_array($ids))
			return array();
		$ids = array_unique($ids);
		$paths = array();
		foreach ($ids as $id) {
			$paths[] = id_to_path($id, $table);
		}
		return $paths;
	
	}

	function delete()
	{
		$configFile = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/conf/we_conf_navigation.inc.php";
		if (!file_exists($configFile) || !is_file($configFile)) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/navigation/class/weNavigationSettingControl.class.php");
			weNavigationSettingControl::saveSettings(true);
		}
		include ($configFile);
		
		if (!$this->ID)
			return false;
		if ($this->IsFolder)
			$this->deleteChilds();
		parent::delete();
		
		// Clear the Cache if the option is set
		if ($GLOBALS['weNavigationCacheDeleteAfterDelete']) {
			include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/cache/weCacheHelper.class.php");
			$cacheDir = weCacheHelper::getCacheDir();
			weCacheHelper::clearCache($cacheDir);
		}
		
		weNavigationCache::cacheNavigationTree($this->ParentID);
		
		return true;
	}

	function deleteChilds()
	{
		$this->db->query('SELECT ID FROM ' . NAVIGATION_TABLE . ' WHERE ParentID="' . $this->ID . '"');
		while ($this->db->next_record()) {
			$child = new weNavigation($this->db->f("ID"));
			$child->delete();
		}
	}

	function clearSessionVars()
	{
		if (isset($_SESSION['navigation_session'])) {
			unset($_SESSION['navigation_session']);
		}
	}

	function filenameNotValid($text)
	{
		$_tmp = str_replace("]", "", str_replace("[", "", $text));
		//return eregi('[^a-z0-9\(\)\._\@\ \-]',$_tmp);
		if (stristr($text, "/") !== false) {
			return true;
		}
		return false;
		//return eregi('[^a-z0-9äöü\._\@\ \-]',$text);
	}

	function alnumNotValid($text)
	{
		if (ctype_alnum($text)) {
			return false;
		} else {
			return true;
		}
	}

	function setPath()
	{
		$ppath = f('SELECT Path FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $this->ParentID . ';', 'Path', $this->db);
		$this->Path = $ppath . "/" . $this->Text;
	}

	function pathExists($path)
	{
		$path = addslashes($path);
		$this->db->query('SELECT * FROM ' . $this->table . ' WHERE Path = \'' . $path . '\' AND ID <> \'' . $this->ID . '\';');
		if ($this->db->next_record())
			return true;
		else
			return false;
	}

	function isSelf()
	{
		if ($this->ID) {
			$_count = 0;
			$_parentid = $this->ParentID;
			while ($_parentid != 0) {
				if ($_parentid == $this->ID)
					return true;
				$_parentid = f(
						'SELECT ParentID FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $_parentid, 
						'ParentID', 
						$this->db);
				$_count++;
				if ($_count == 9999) {
					return false;
				}
			}
			return false;
		} else {
			return false;
		}
	}

	function isAllowedForUser()
	{
		return true;
		if (!defined("BIG_USER_MODULE"))
			return true;
		if (we_hasPerm('ADMINISTRATOR'))
			return true;
	}

	function evalPath($id = 0)
	{
		$db_tmp = new DB_WE();
		$path = '';
		if ($id == 0) {
			$id = $this->ParentID;
			$path = $this->Text;
		}
		
		$foo = getHash("SELECT Text,ParentID FROM " . NAVIGATION_TABLE . " WHERE ID='" . $id . "';", $db_tmp);
		$path = '/' . (isset($foo['Text']) ? $foo['Text'] : '') . $path;
		
		$pid = isset($foo['ParentID']) ? $foo['ParentID'] : '';
		while ($pid > 0) {
			$db_tmp->query("SELECT Text,ParentID FROM " . NAVIGATION_TABLE . " WHERE ID='$pid'");
			while ($db_tmp->next_record()) {
				$path = '/' . $db_tmp->f('Text') . $path;
				$pid = $db_tmp->f('ParentID');
			}
		}
		return $path;
	}

	function saveField($name, $serialize = false)
	{
		if ($serialize)
			$field = serialize($this->$name);
		else
			$field = $this->$name;
		
		$this->db->query(
				'UPDATE ' . $this->table . ' SET ' . $name . '="' . addslashes($field) . '" WHERE ID=\'' . $this->ID . '\';');
		return $this->db->affected_rows();
	}

	function getDynamicEntries()
	{
		if ($this->Selection == 'dynamic') {
			include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weDynList.class.php');
			
			if ($this->SelectionType == 'doctype') {
				return weDynList::getDocuments(
						$this->DocTypeID, 
						$this->FolderID, 
						$this->Categories, 
						$this->Sort, 
						$this->ShowCount, 
						$this->TitleField);
			} else 
				if ($this->SelectionType == 'category') {
					return weDynList::getCatgories($this->FolderID, $this->ShowCount);
				} else {
					
					return $this->ClassID > 0 ? weDynList::getObjects(
							$this->ClassID, 
							$this->FolderID, 
							$this->Categories, 
							$this->Sort, 
							$this->ShowCount, 
							$this->TitleField) : array();
				}
		}
	}

	function getChilds()
	{
		$_items = array();
		
		$this->db->query(
				'SELECT ID,Path,Text,Ordn FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $this->ID . ' ORDER BY Ordn;');
		
		while ($this->db->next_record()) {
			$_items[] = array(
				
					'id' => $this->db->f('ID'), 
					'path' => $this->db->f('Path'), 
					'text' => $this->db->f('Text'), 
					'ordn' => $this->db->f('Ordn')
			);
		}
		
		return $_items;
	}

	function getDynamicChilds()
	{
		$_items = array();
		
		$this->db->query(
				'SELECT ID,Ordn FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $this->ID . ' AND IsFolder=0 AND Depended=1 ORDER BY Ordn;');
		
		while ($this->db->next_record()) {
			$_items[] = array(
				'id' => $this->db->f('ID'), 'ordn' => $this->db->f('Ordn')
			);
		}
		
		return $_items;
	}

	function populateGroup($_items)
	{
		
		$_info = $this->getDynamicEntries();
		
		$_new_items = array();
		
		foreach ($_info as $_k => $_item) {
			
			$_navigation = new weNavigation();
			
			$_navigation->ParentID = $this->ID;
			$_navigation->Selection = 'static';
			
			$_navigation->SelectionType = $this->SelectionType == 'doctype' ? 'docLink' : ($this->SelectionType == 'category' ? 'catLink' : 'objLink');
			$_navigation->LinkID = $_item['id'];
			$_navigation->Ordn = isset($_items[$_k]) ? $_items[$_k]['ordn'] : $_k;
			$_navigation->Depended = 1;
			$_navigation->Text = !empty($_item['field']) ? $_item['field'] : $_item['text'];
			$_navigation->IconID = $this->IconID;
			
			$_navigation->Url = $this->Url;
			$_navigation->UrlID = $this->UrlID;
			$_navigation->CatParameter = $this->CatParameter;
			$_navigation->LinkSelection = $this->LinkSelection;
			$_navigation->Parameter = $this->Parameter;
			$_navigation->WorkspaceID = $this->WorkspaceID;
			
			$_navigation->save(false);
			
			$_new_items[] = array(
				'id' => $_navigation->ID, 'text' => $_navigation->Text
			);
		}
		
		// delete old items??
		

		return $_new_items;
	
	}

	function depopulateGroup()
	{
		
		$_items = $this->getDynamicChilds();
		foreach ($_items as $_id) {
			$_navigation = new weNavigation($_id['id']);
			if ($_navigation->delete())
				;
		}
		return $_items;
	
	}

	function hasDynChilds()
	{
		if ($this->ID) {
			$_dep = f(
					'SELECT COUNT(ID) as Navi FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $this->ID . ' AND Depended=1;', 
					'Navi', 
					$this->db);
			return $_dep ? true : false;
		}
		return false;
	}

	function getDynamicPreview(&$storage, $rules = false)
	{
		$_items = array();
		
		$_count = count($storage['items']);
		for ($i = 0; $i < $_count; $i++) {
			
			$item = $storage['items'][$i];
			
			if ($item['ParentID'] == $this->ID) {
				
				$_nav = new weNavigation();
				$_nav->initByRawData($item);
				if ($_nav->IsFolder || $_nav->Selection != 'dynamic') {
					$_items[] = array(
						
							'id' => $_nav->ID, 
							//'text'=>str_replace('&amp;','&',$_nav->Text),
							'name' => $_nav->Text, 
							'text' => (isset($_nav->Display) && !empty($_nav->Display)) ? $_nav->Display : $_nav->Text, 
							'display' => (isset($_nav->Display) && !empty($_nav->Display)) ? $_nav->Display : "", 
							'docid' => $_nav->LinkID, 
							'table' => $_nav->IsFolder ? ($_nav->FolderSelection == "objLink" ? OBJECT_FILES_TABLE : FILE_TABLE) : (($_nav->SelectionType == 'classname' || $_nav->SelectionType == 'objLink' ? OBJECT_FILES_TABLE : FILE_TABLE)), 
							'href' => $_nav->getHref($storage['ids']), 
							'type' => $_nav->IsFolder ? 'folder' : 'item', 
							'parentid' => $_nav->ParentID, 
							'workspaceid' => $_nav->WorkspaceID, 
							'icon' => isset($storage['ids'][$_nav->IconID]) ? $storage['ids'][$_nav->IconID] : id_to_path(
									$_nav->IconID), 
							'attributes' => $_nav->Attributes, 
							'customers' => weNavigationItems::getCustomerData($_nav), 
							'limitaccess' => $_nav->LimitAccess, 
							'depended' => $_nav->Depended
					);
				}
				
				if ($_nav->IsFolder == 0 && $_nav->Selection == 'dynamic') {
					
					$_dyn_items = $_nav->getDynamicEntries();
					foreach ($_dyn_items as $_dyn) {
						
						$_href = $_nav->getHref($storage['ids'], $_dyn['id']);
						$_items[] = array(
							
								'id' => $_nav->ID . '_' . $_dyn['id'], 
								//'text'=>str_replace('&amp;','&',!empty($_dyn['field']) ? $_dyn['field'] : $_dyn['text']),
								'name' => !empty($_dyn['field']) ? $_dyn['field'] : $_dyn['text'], 
								'text' => !empty($_dyn['field']) ? $_dyn['field'] : $_dyn['text'], 
								'display' => !empty($_dyn['display']) ? $_dyn['display'] : "", 
								'docid' => $_dyn['id'], 
								'table' => (($_nav->SelectionType == 'classname' || $_nav->SelectionType == 'objLink') ? OBJECT_FILES_TABLE : FILE_TABLE), 
								'href' => $_href, 
								'type' => 'item', 
								'parentid' => $_nav->ParentID, 
								'workspaceid' => $_nav->WorkspaceID, 
								'icon' => isset($storage['ids'][$_nav->IconID]) ? $storage['ids'][$_nav->IconID] : id_to_path(
										$_nav->IconID), 
								'attributes' => $_nav->Attributes, 
								'customers' => weNavigationItems::getCustomerData($_nav), 
								'limitaccess' => $_nav->LimitAccess, 
								'depended' => 2
						);
						
						if ($rules) {
							$_items[(sizeof($_items) - 1)]['currentRule'] = weNavigationRule::getWeNavigationRule(
									'defined_' . (!empty($_dyn['field']) ? $_dyn['field'] : $_dyn['text']), 
									$_nav->ID, 
									$_nav->SelectionType, 
									$_nav->FolderID, 
									$_nav->DocTypeID, 
									$_nav->ClassID, 
									$_nav->CategoryIDs, 
									$_nav->WorkspaceID, 
									$_href, 
									false);
						}
					}
				}
				
				if ($_nav->IsFolder) {
					$_items = array_merge($_items, $_nav->getDynamicPreview($storage, $rules));
				}
			
			}
		
		}
		
		if (!empty($_new_items)) {
			$_items = array_merge($_items, array_reverse($_new_items, true));
		
		}
		
		return $_items;
	}

	function reorder($pid)
	{
		$_count = 0;
		$_db = new DB_WE();
		$_db->query('SELECT ID FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $pid . ' ORDER BY Ordn;');
		while ($_db->next_record()) {
			$this->db->query('UPDATE ' . NAVIGATION_TABLE . ' SET Ordn=' . $_count . ' WHERE ID=' . $_db->f('ID') . ';');
			$_count++;
		}
	}

	function reorderUp()
	{
		if ($this->ID) {
			if ($this->Ordn > 0) {
				$_db = new DB_WE();
				$_parentid = f(
						'SELECT ParentID FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $this->ID . ';', 
						'ParentID', 
						$_db);
				$_db->query(
						'UPDATE ' . NAVIGATION_TABLE . ' SET Ordn=' . $this->Ordn . ' WHERE ParentID=' . $_parentid . ' AND Ordn=' . ($this->Ordn - 1) . ';');
				$this->Ordn--;
				$this->saveField('Ordn');
				$this->reorder($this->ParentID);
				return true;
			}
		}
		return false;
	}

	function reorderDown()
	{
		if ($this->ID) {
			$_parentid = f(
					'SELECT ParentID FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $this->ID . ';', 
					'ParentID', 
					$this->db);
			$_num = f(
					'SELECT COUNT(ID) as OrdCount FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $_parentid . ';', 
					'OrdCount', 
					$this->db);
			if ($this->Ordn < ($_num - 1)) {
				$_db = new DB_WE();
				$_db->query(
						'UPDATE ' . NAVIGATION_TABLE . ' SET Ordn=' . $this->Ordn . ' WHERE ParentID=' . $this->ParentID . ' AND Ordn=' . ($this->Ordn + 1) . ';');
				$this->Ordn++;
				$this->saveField('Ordn');
				$this->reorder($this->ParentID);
				return true;
			}
		}
		return false;
	
	}

	function getHref(&$storage, $id = 0)
	{
		
		if ($this->IsFolder) {
			
			$_path = '';
			eval('$_param = "' . addslashes(eregi_replace("\\$", '$this->', $this->FolderParameter)) . '";');
			if ($this->FolderSelection == 'urlLink') {
				$_path = $this->FolderUrl;
			} else {
				if ($this->FolderSelection == 'objLink') {
					$_param = 'we_objectID=' . $this->LinkID . (!empty($_param) ? '&' : '') . $_param;
					$_id = weDynList::getFirstDynDocument($this->FolderWsID);
				} else {
					$_id = $this->LinkID;
				}
				$_path = isset($storage[$_id]) ? $storage[$_id] : id_to_path($_id, FILE_TABLE);
			}
		} else {
			
			if ($id) {
				$_id = $id;
			} else {
				$_id = $this->LinkID;
			}
			
			$_path = '';
			eval('$_param = "' . addslashes(eregi_replace("\\$", '$this->', $this->Parameter)) . '";');
			
			if ($this->SelectionType == 'urlLink') {
				$_path = $this->Url;
			} else 
				if ($this->SelectionType == 'category' || $this->SelectionType == 'catLink') {
					$_path = $this->LinkSelection == 'extern' ? $this->Url : ($_path = isset($storage[$_id]) ? $storage[$_id] : id_to_path(
							$this->UrlID, 
							FILE_TABLE));
					if (!empty($this->CatParameter)) {
						$_param = $this->CatParameter . '=' . $_id . (!empty($_param) ? '&' : '') . $_param;
					}
				} else {
					if ($this->SelectionType == 'classname' || $this->SelectionType == 'objLink') {
						$_param = 'we_objectID=' . $_id . (!empty($_param) ? '&' : '') . $_param;
						$_id = weDynList::getFirstDynDocument($this->WorkspaceID);
					}
					
					$_path = isset($storage[$_id]) ? $storage[$_id] : id_to_path($_id, FILE_TABLE);
				
				}
		}
		
		if (!is_array($this->Attributes)) {
			$this->Attributes = @unserialize($this->Attributes);
		}
		
		$_path = $_path . ($_param != '' ? ((strpos($_path, '?') === false ? '?' : '&amp;') . $_param) : '') . ((isset(
				$this->Attributes['anchor']) && !empty($this->Attributes['anchor'])) ? ('#' . $this->Attributes['anchor']) : '');
		
		$_path = str_replace('&amp;', '&', $_path);
		$_path = str_replace('&', '&amp;', $_path);
		
		return $_path;
	
	}

	function setOrdn($num)
	{
		$_db = new DB_WE();
		if ($this->ID) {
			$_db->query(
					'SELECT ID FROM ' . NAVIGATION_TABLE . ' WHERE ParentID=' . $this->ParentID . ' AND Ordn>=' . $num . ' ORDER BY Ordn;');
			while ($_db->next_record()) {
				$this->db->query(
						'UPDATE ' . NAVIGATION_TABLE . ' SET Ordn=' . ($_db->f('Ordn') + 1) . ' WHERE ID=' . $_db->f(
								'ID') . ';');
			}
			$this->Ordn = $num;
			$this->saveField('Ordn');
		}
		$this->reorder($this->ParentID);
	}

	function findCharset($pid)
	{
		$_charset = '';
		$_count = 0;
		if ($pid == '') {
			$pid = 0;
		}
		$_db = new DB_WE();
		while (empty($_charset)) {
			$_hash = getHash('SELECT ParentID,Charset FROM ' . NAVIGATION_TABLE . ' WHERE ID=' . $pid, $_db);
			if (isset($_hash['ParentID'])) {
				if (isset($_hash['Charset']) && !empty($_hash['Charset'])) {
					$_charset = $_hash['Charset'];
					break;
				}
				$pid = $_hash['ParentID'];
				//prevent deadlocks
				if ($_count > 10000) {
					break;
				}
				$_count++;
			} else {
				break;
			}
		}
		
		return $_charset;
	}

	function we_load($id)
	{
		parent::load($id);
		$this->ContentType = 'weNavigation';
	}

	function we_save()
	{
		$this->save();
	}

	function setAttribute($name, $value)
	{
		$this->Attributes[$name] = $value;
	}

	function getAttribute($name)
	{
		return isset($this->Attributes[$name]) ? $this->Attributes[$name] : null;
	}

	function initByRawData($data)
	{
		foreach ($data as $key => $value) {
			if (!is_numeric($key)) {
				$this->$key = in_array($key, $this->serializedFields) ? @unserialize($value) : $value;
			}
		}
	
	}

	function encodeSpecChars($string)
	{
		$open = "!@###";
		$close = "!###@";
		$amp = "!!##@";
		
		$string = ereg_replace("<br(\/)?>", $open . "br\\1" . $close, $string);
		$string = ereg_replace("<(\/)?b>", $open . "\\1b" . $close, $string);
		$string = ereg_replace("<(\/)?i>", $open . "\\1i" . $close, $string);
		$string = ereg_replace("&([^;]+);", $amp . "\\1;", $string);
		
		$string = htmlspecialchars($string);
		
		$string = str_replace($open, "<", $string);
		$string = str_replace($close, ">", $string);
		$string = str_replace($amp, "&", $string);
		
		return $string;
	
	}

	function getNavCondition($id, $table)
	{
		$_linkType = ($table == OBJECT_FILES_TABLE) ? 'objLink' : 'docLink';
		return ' ((IsFolder=1 AND FolderSelection="' . $_linkType . '") OR (IsFolder=0 AND SelectionType="' . $_linkType . '")) AND LinkID=' . abs(
				$id) . ' ';
	}
}

?>