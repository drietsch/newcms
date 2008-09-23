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

/*
 * @see Zend_Log
 */
Zend_Loader::loadClass('Zend_Log');

/**
 * abstract class for hook reader classes
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
abstract class we_app_Hook_Reader_Abstract
{

	/**
	 * @var source where the hooks are to be found. This could be an url, an array or a filename, 
	 * 		depending on which reader class is to be used
	 */
	protected $_source = "";

	/**
	 * @var contents read from $this->_source
	 */
	protected $_content = "";

	/**
	 * Constructor
	 */
	public function __construct($source = "")
	{
		if (empty($source) || !$this->_validateSource($source)) {
			return false;
		} else {
			$this->_source = $source;
		}
	}

	/**
	 * validates the specified reader source
	 * @return bool true (source is valid) or false (source is invalid or unaccessible/unreachable)
	 */
	abstract protected function _validate($source);

	abstract protected function _read();

}