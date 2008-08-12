<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Model.php,v 1.9 2008/07/25 14:36:25 thomas.kneip Exp $
 */

/**
 * @see we_core_AbstractModel
 */
Zend_Loader::loadClass('we_core_AbstractModel');

/**
 * Base class for app models
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_Model extends we_core_AbstractModel
{

	public $ID = 0;

	public $Text = '';

	public $ParentID = 0;

	public $Path = '';

	public $ContentType = '';
			
	public $IsFolder;

	protected $_appName = '';

	protected $_requiredFields = array();
	
	function __construct($table)
	{
		parent::__construct($table);
	}


	public function filenameNotValid() 
	{
		return eregi('/',$this->Text);
	}


	public function isRequiredField($fieldname)
	{
		return in_array($fieldname, $this->_requiredFields);
	}

	public function hasRequiredFields(&$failed)
	{
		foreach ($this->_requiredFields as $req) {
			if (empty($this->$req)) {
				$failed[] = $req;
			}
		}
		return empty($failed);
	}

	public public function setPath($path='')
	{
		if ($path === '') {
			$path = we_util_Path::id2Path($this->ParentID, $this->_table) . '/' . $this->Text;
		}
		$this->Path = $path;
	}

	public function pathExists($path)
	{
		return we_util_Path::pathExists($path, $this->_table);
	}

	public function isSelf()
	{
		$db = we_io_DB::sharedAdapter();
		
		if ($this->ID) {
			$count = 0;
			$parentid = $this->ParentID;
			while ($parentid != 0) {
				if ($parentid == $this->ID) {
					return true;
				}
				$parentid = $db->fetchOne('SELECT ParentID FROM ' . addslashes($this->_table) . ' WHERE ID = ?', $parentid);
				$count++;
				if ($count == 9999) {
					return false;
				}
			}
			return false;
		} else {
			return false;
		}
	}

	public function isAllowedForUser()
	{
		return true;
	}

	protected function _evalPath($id = 0)
	{
		$db = we_io_DB::sharedAdapter();
		$path = '';
		if ($id == 0) {
			$id = $this->ParentID;
			$path = $this->Text;
		}
		
		$result = $db->fetchAssoc('SELECT Text,ParentID FROM ' . $this->_table . 
			' WHERE ' . $this->_primaryKey . ' = ?', $id);
		$path = '/' . (isset($result[0]['Text']) ? $result[0]['Text'] : '') . $path;
		$pid = isset($result[0]['ParentID']) ? abs($result[0]['ParentID']) : 0;
		while ($pid > 0) {
			$result = $db->fetchAssoc('SELECT Text,ParentID FROM ' . $this->_table . 
			' WHERE ' . $this->_primaryKey . ' = ?', $pid);
			$path = '/' . $result[0]['Text'] . $path;
			$pid = abs($result[0]['ParentID']);
		}
		return $path;
	}

	public function updateChildPaths($oldpath)
	{
		$db = we_io_DB::sharedAdapter();
		if ($this->IsFolder && $oldpath != '' && $oldpath != '/' && $oldpath != $this->Path) {
			$result = $db->fetchAssoc(
				'SELECT ' . $this->_primaryKey . ' FROM ' . 
				$this->_table .'  WHERE Path like ? AND ' . 
				$this->_primaryKey . ' <> ?', 
				array($oldpath . '%', $this->{$this->_primaryKey})
			);
			
			foreach ($result as $row) {
				$updateFields = array('Path'=>$this->_evalPath($row[$this->_primaryKey]));
				$cond = $this->_primaryKey . '='.abs($row[$this->_primaryKey]);
				$db->update($this->_table, $updateFields, $cond);
			}

		}
	}
	
	public function setIsFolder($value)
	{
		$this->IsFolder = $value;
	}

	public function deleteChilds()
	{
		$db = we_io_DB::sharedAdapter();
		$stmt =$db->query('SELECT ' . $this->_primaryKey . ' FROM ' . $this->_table . 
			' WHERE ParentID = ?', $this->{$this->_primaryKey});
		$id = $stmt->fetchColumn(0);
		while ($id) {
			$class = get_class($this);
			$child = new $class($id);
			$child->delete();
			$id = $stmt->fetchColumn(0);
		}
	}

	public function delete()
	{
		
		if (!$this->{$this->_primaryKey}) {
			throw new we_core_ModelException('No Primary Key set. Can\'t delete the model!', we_service_ErrorCodes::kModelNoPrimaryKeySet);
		}
		
		if ($this->IsFolder) {
			$this->deleteChilds();
		}
			
		parent::delete();
	}

	public function setFields($fields) {
		parent::setFields($fields);
	}
}
