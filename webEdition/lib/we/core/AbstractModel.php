<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * @see we_core_AbstractObject
 */
Zend_Loader::loadClass('we_core_AbstractObject');

/**
 * Base class for webEdition models
 * 
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_core_AbstractModel extends we_core_AbstractObject
{

	/**
	 * primaryKey attribute
	 *
	 * @var string
	 */
	protected $_primaryKey = "ID";

	/**
	 * table attribute
	 *
	 * @var string
	 */
	protected $_table = "";

	/**
	 * persistentSlots attribute
	 *
	 * @var array
	 */
	public $_persistentSlots = array();

	/**
	 * metadata attribute
	 *
	 * @var array
	 */
	protected $_metadata = array();

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
		if ($table !== '') {
			$this->_table = $table;
			$this->loadPersistents();
		}
	}

	/**
	 * load persistents
	 * 
	 * @return void
	 */
	protected function loadPersistents()
	{
		$db = we_io_DB::sharedAdapter();
		
		$this->_persistentSlots = array();
		
		// fetch all column names
		$this->_metadata = $db->describeTable($this->_table);
		$keys = array_keys($this->_metadata);
		foreach ($keys as $columnName) {
			$this->_persistentSlots[] = $columnName;
			if (!isset($this->$columnName)) {
				// create public properties
				$this->$columnName = "";
			}
		}
	}

	/**
	 * Load entry from database
	 * 
	 * @param integer $id 
	 * @return boolean returns true on success, othewise false
	 */
	public function load($id = 0)
	{
		$db = we_io_DB::sharedAdapter();
		$stm = $db->query('SELECT * FROM ' . $this->_table . ' WHERE ' . $this->_primaryKey . ' = ?', $id);
		$row = $stm->fetch();
		if ($row) {
			foreach ($row as $key => $value) {
				$this->$key = $value;
			}
			return true;
		}
		return false;
	}

	/**
	 * returns primary key condition
	 * 
	 * @return string
	 */
	protected function _getPKCondition()
	{
		return $this->_primaryKey . ' = ' . abs($this->{$this->_primaryKey});
	}

	/**
	 * save entry in database
	 * 
	 * @return void
	 */
	public function save()
	{
		$db = we_io_DB::sharedAdapter();
		
		// check if there is another entry with the same path
		
		$stm = $db->query('SELECT ID FROM ' . $this->_table . ' WHERE Text = ? AND ParentID = ? AND ID != ?', array($this->Text, abs($this->ParentID), abs($this->ID)));
		
		$row = $stm->fetch();
		if ($row) {
			throw new we_core_ModelException('Error saving model. Path already exists!', we_service_ErrorCodes::kPathExists);
		}
		$updateArray = array();
		foreach ($this->_persistentSlots as $key) {
			if ($key !== $this->_primaryKey) {
				$updateArray[$key] = $this->$key;
			}
		}
		
		if (!isset($this->{$this->_primaryKey}) || !$this->{$this->_primaryKey}) {
			try {
				$db->delete($this->_table, $this->_getPKCondition());
				$db->insert($this->_table, $updateArray);
			} catch (Exception $e) {
				throw new we_core_ModelException('Error inserting model to database with db exception: ' . $e->getMessage(), we_service_ErrorCodes::kDBError);
			}
			$this->{$this->_primaryKey} = $db->lastInsertId();
		} else {
			try {
				$db->update($this->_table, $updateArray, $this->_getPKCondition());
			} catch (Exception $e) {
				throw new we_core_ModelException('Error updating model in database with db exception: ' . $e->getMessage(), we_service_ErrorCodes::kDBError);
			}
		}
	
	}

	/**
	 * delete entry from database
	 * 
	 * @return void
	 */
	public function delete()
	{
		$db = we_io_DB::sharedAdapter();
		try {
			$db->delete($this->_table, $this->_getPKCondition());
		} catch (Exception $e) {
			throw new we_core_ModelException('Error updating model in database with db exception: ' . $e->getMessage(), we_service_ErrorCodes::kDBError);
		}
	}

	/**
	 * retrieve table
	 * 
	 * @return string
	 */
	public function getTable()
	{
		return $this->_table;
	}

	/**
	 * load persistent slots
	 * 
	 * @return array
	 */
	public function getPersistentSlots()
	{
		return $this->_persistentSlots;
	}

	/**
	 * set persistent slots
	 * 
	 * @param array $persistentSlots
	 * @return void
	 */
	public function setPersistentSlots($persistentSlots)
	{
		$this->_persistentSlots = $persistentSlots;
	}

	/*
	 * Set data fields with contents of an array
	 * 
	 * @param array $fields
	 * @return void
	 */
	public function setFields($fields)
	{
		$slots = $this->_persistentSlots;
		foreach ($slots as $slot) {
			if (isset($fields[$slot]) && isset($this->$slot)) {
				$this->$slot = $fields[$slot];
			}
		}
	}
}
