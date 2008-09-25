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
 * @category   we
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */ 


/**
 * @see Zend_Exception
 */
Zend_Loader::loadClass('Zend_Exception');

/**
 * class for exceptions
 * 
 * @category   we
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_Exception extends Zend_Exception
{
	/**
	 * write exception into errorlog
	 * 
	 * @return void
	 */
	public function __construct() {
		we_util_Log::errorLog("webEdition exception '".get_class($this)."' in ".$this->getFile().":".$this->getLine()."\nStack trace;\n".$this->getTraceAsString());
	}
}