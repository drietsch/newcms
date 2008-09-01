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

/**
 * @see we_app_Hook_Reader_Abstract
 */
Zend_Loader::loadClass('we_app_Hook_Reader_Abstract');

include_once ('Zend/Log.php');

/**
 * class for reading hook code from xml file
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_Hook_Reader_Xml extends we_app_Hook_Reader_Abstract
{

	protected function _validate($source)
	{
	
	}

	protected function _read()
	{
	
	}

}