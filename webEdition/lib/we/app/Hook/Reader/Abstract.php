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
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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