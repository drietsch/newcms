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
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * class for service exception
 * 
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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
