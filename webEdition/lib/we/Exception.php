<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 * @category   we
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
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
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
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