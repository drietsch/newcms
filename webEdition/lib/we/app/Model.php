<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_app_Model extends we_core_AbstractModel
{

	/**
	 * id attribute
	 *
	 * @var integer
	 */
	public $ID = 0;

	/**
	 * Text attribute
	 *
	 * @var string
	 */
	public $Text = '';

	/**
	 * ParentID attribute
	 *
	 * @var integer
	 */
	public $ParentID = 0;

	/**
	 * Path attribute
	 *
	 * @var string
	 */
	public $Path = '';

	/**
	 * ContentType attribute
	 *
	 * @var string
	 */
	public $ContentType = '';

	/**
	 * IsFolder attribute
	 *
	 * @var boolean
	 */
	public $IsFolder;

	/**
	 * _appName attribute
	 *
	 * @var string
	 */
	protected $_appName = '';

	/**
	 * _requiredFields attribute
	 *
	 * @var array
	 */
	protected $_requiredFields = array();

	/**
	 * Constructor
	 * 
	 * Set table and load persistents
	 * 
	 * @param string $table
	 * @return void
	 */
	function __construct($table)
	{
		parent::__construct($table);
	}

	/**
	 * validates the Text
	 * 
	 * @return boolean
	 */
	public function textNotValid()
	{
		return eregi('/', $this->Text);
	}

	/**
	 * check if field is required
	 * 
	 * @param string $fieldname
	 * @return boolean
	 */
	public function isRequiredField($fieldname)
	{
		return in_array($fieldname, $this->_requiredFields);
	}

	/**
	 * check if required fields are available
	 * 
	 * @param string (reference) $failed
	 * @return boolean
	 */
	public function hasRequiredFields(&$failed)
	{
		foreach ($this->_requiredFields as $req) {
			if (empty($this->$req)) {
				$failed[] = $req;
			}
		}
		return empty($failed);
	}

	/**
	 * set path
	 * 
	 * @param string $path
	 * @return void
	 */
	public public function setPath($path = '')
	{
		if ($path === '') {
			$path = we_util_Path::id2Path($this->ParentID, $this->_table) . '/' . $this->Text;
		}
		$this->Path = $path;
	}

	/**
	 * check if path exists
	 * 
	 * @param string $path
	 * @return boolean
	 */
	public function pathExists($path)
	{
		return we_util_Path::pathExists($path, $this->_table);
	}

	/**
	 * check if ParentId is equal to Id
	 * 
	 * @return boolean
	 */
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

	/**
	 * check permissions of user
	 * 
	 * @return boolean
	 */
	public function isAllowedForUser()
	{
		return true;
	}

	/**
	 * returns the path of given id
	 * 
	 * @param integer $id
	 * @return string
	 */
	protected function _evalPath($id = 0)
	{
		$db = we_io_DB::sharedAdapter();
		$path = '';
		if ($id == 0) {
			$id = $this->ParentID;
			$path = $this->Text;
		}
		
		$result = $db->fetchAssoc('SELECT Text,ParentID FROM ' . $this->_table . ' WHERE ' . $this->_primaryKey . ' = ?', $id);
		$path = '/' . (isset($result[0]['Text']) ? $result[0]['Text'] : '') . $path;
		$pid = isset($result[0]['ParentID']) ? abs($result[0]['ParentID']) : 0;
		while ($pid > 0) {
			$result = $db->fetchAssoc('SELECT Text,ParentID FROM ' . $this->_table . ' WHERE ' . $this->_primaryKey . ' = ?', $pid);
			$path = '/' . $result[0]['Text'] . $path;
			$pid = abs($result[0]['ParentID']);
		}
		return $path;
	}

	/**
	 * update the child paths
	 * 
	 * @param string $oldpath
	 * @return void
	 */
	public function updateChildPaths($oldpath)
	{
		$db = we_io_DB::sharedAdapter();
		if ($this->IsFolder && $oldpath != '' && $oldpath != '/' && $oldpath != $this->Path) {
			$result = $db->fetchAssoc('SELECT ' . $this->_primaryKey . ' FROM ' . $this->_table . '  WHERE Path like ? AND ' . $this->_primaryKey . ' <> ?', array($oldpath . '%', $this->{$this->_primaryKey}));
			
			foreach ($result as $row) {
				$updateFields = array('Path' => $this->_evalPath($row[$this->_primaryKey]));
				$cond = $this->_primaryKey . '=' . abs($row[$this->_primaryKey]);
				$db->update($this->_table, $updateFields, $cond);
			}
		
		}
	}

	/**
	 * set IsFolder
	 * 
	 * @param boolean $value
	 * @return void
	 */
	public function setIsFolder($value)
	{
		$this->IsFolder = $value;
	}

	/**
	 * delete childs
	 * 
	 * @return void
	 */
	public function deleteChilds()
	{
		$db = we_io_DB::sharedAdapter();
		$stmt = $db->query('SELECT ' . $this->_primaryKey . ' FROM ' . $this->_table . ' WHERE ParentID = ?', $this->{$this->_primaryKey});
		$id = $stmt->fetchColumn(0);
		while ($id) {
			$class = get_class($this);
			$child = new $class($id);
			$child->delete();
			$id = $stmt->fetchColumn(0);
		}
	}

	/**
	 * deletes entry
	 * 
	 * @return void
	 */
	public function delete()
	{
		$translate = we_core_Local::addTranslation('apps.xml');
		$message = $translate->_('This entry cannot be deleted. Probably there is no appropriate data record in the data base or the data base does not exist. In this case you must implement the data retention.');

		if (!$this->{$this->_primaryKey}) {
			throw new we_core_ModelException($message, we_service_ErrorCodes::kModelNoPrimaryKeySet);
		}
		
		if ($this->IsFolder) {
			$this->deleteChilds();
		}
		
		parent::delete();
	}

	/**
	 * set Fields
	 * 
	 * @param array $fields
	 * @return void
	 */
	public function setFields($fields)
	{
		parent::setFields($fields);
	}
}
