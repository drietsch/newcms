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

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/modules/weModelBase.php');

class weNavigationRule extends weModelBase
{

	var $table = NAVIGATION_RULE_TABLE;

	var $Table = NAVIGATION_RULE_TABLE;

	var $ContentType = 'weNavigationRule';

	var $ClassName = 'weNavigationRule';

	var $db;

	var $ID;

	var $NavigationName;

	var $NavigationID;

	var $SelectionType;

	var $FolderID;

	var $DoctypeID;

	var $ClassID;

	var $Categories;

	var $WorkspaceID;

	var $Href;

	var $SelfCurrent;

	var $persistent_slots = array(
		
			'ID', 
			'NavigationName', 
			'NavigationID', 
			'SelectionType', 
			'FolderID', 
			'DoctypeID', 
			'ClassID', 
			'Categories', 
			'WorkspaceID'
	);

	function weNavigationRule()
	{
		$this->db = new DB_WE();
	}

	function initByID($ruleId)
	{
		
		parent::load(abs($ruleId));
	}

	function getWeNavigationRule($navigationName, $navigationId, $selectionType, $folderId, $doctype, $classId, $categories, $workspaceId, $href = '', $selfCurrent = true)
	{
		
		$_navigation = new weNavigationRule();
		$_navigation->NavigationName = $navigationName;
		$_navigation->NavigationID = $navigationId;
		$_navigation->SelectionType = $selectionType;
		$_navigation->FolderID = $folderId;
		$_navigation->DoctypeID = $doctype;
		$_navigation->ClassID = $classId;
		$_navigation->Categories = $categories;
		$_navigation->WorkspaceID = $workspaceId;
		
		$_navigation->Href = $href;
		$_navigation->SelfCurrent = $selfCurrent;
		
		return $_navigation;
	}

	function we_load($id)
	{
		$this->load($id);
	}

	function we_save()
	{
		parent::save($this->ID ? false : true);
	}

}
?>