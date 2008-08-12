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
 */

include_once (dirname(dirname(__FILE__)) . '/../we/core/autoload.php');

include_once('Zend/Log.php');

/**
 * class for loading and executing code execution hooks for webEdition applications
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_Hook
{
	
	/**
	 * @var array for storing all application code hooks that have already been read.
	 */
	protected $_hooks = array();
	
	/**
	 * @var array for storing all reader objects that are used by this hook object instance
	 */
	protected $_readers = array();
	
	/**
	 * constructor method for hook parser
	 * @param we_app_Reader_* reference to reader object, i.e. we_app_Reader_Xml
	 */
	public function __construct(&$reader = null)
	{
		error_log("creating hook object");
		if(!is_null($reader)) {
			$this->addReader($reader);
			error_log("adding hook reader object of type ".get_class($reader));
		}
	}
	
	/**
	 * getter method
	 * @example $myHook->preInstallHook->code
	 * @return requested hook properties of object $this->_hooks or false on failure
	 */
	public function __get($property = "")
	{
		if(empty($property) || empty($this->_hooks)) return false;
		if(isset($this->_hooks->$property)) {
			return false;
		} else {
			return $this->_hooks->$property;
		}
	}
	
	/**
	 * adds a reader for fetching hooks (i.e. we_app_Reader_Xml)
	 * @return bool true (success) or false (failure, i.e. no or invalid reader)
	 */
	public function addReader(&$reader = null)
	{
		if(is_null($reader)) {
			return false;
		}
		error_log("adding hook reader object of type ".get_class($reader));
	}
	
	public function run($hook = "")
	{
		
	}
	
	/**
	 * loads all hooks from all registered readers
	 */
	public function loadAll()
	{
		// not implemented yet
	}
	 
}