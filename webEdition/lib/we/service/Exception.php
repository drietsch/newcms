<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * class for service exception
 * 
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_service_Exception extends Exception
{

	/**
	 * type attribute
	 *
	 * @var string
	 */
	protected $_type = "error";

	/**
	 * Sets the error Type. Possible values are: error|warning|notice
	 * 
	 * @return string
	 */
	final public function getType()
	{
		return $this->_type;
	}

	/**
	 * Gets the error Type. Possible values are: error|warning|notice
	 * 
	 * @param string $type
	 */
	final public function setType($type)
	{
		$this->_type = $type;
	}

}
