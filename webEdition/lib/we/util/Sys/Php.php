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
 * @package    we_util
 * @subpackage we_util_Sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_util_Sys
 */
Zend_Loader::loadClass('we_util_Sys');

/**
 * @see we_util_Sys_Exception
 */
Zend_Loader::loadClass('we_util_Sys_Exception');

/**
 * Class to check php settings
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_util_Sys_Php
{
	
	/**
	 * get php version
	 * @return String phpversion string without any manufacturer-part (i.e. set on ubuntu)
	 */
	public static function version()
	{
        return preg_replace('/[a-z-]/', '', phpversion());
	}
	
	/**
	 * compares specified PHP version with the currently installed webEdition version
	 * @param int $reference target version to be compared to current webEdition version
	 * @param string $operator
	 * @see we_util_Sys::_versionCompare()
	 * @example we_util_Sys_PHP::versionCompare("5.1");
	 * @example we_util_Sys_PHP::versionCompare("5.1", "<");
	 */
	public static function versionCompare($version = "", $operator = "")
	{
		$currentVersion = self::version();
		if($currentVersion === false || empty($version)) return false;
		return parent::_versionCompare($version,$currentVersion,$operator);
	}
	
	/**
	 * checks if a given php extension is loaded
	 * @return boolean
	 */
	public static function extension($ext = "")
	{
		if(empty($ext)) return false;
		return (in_array($ext,@get_loaded_extensions(true)));
	}
	
	/**
	 * checks if a given ini-variable is available and returns its value
	 * @return value of the requested php.ini variable
	 * 			returns (bool)true if value is "1", "On" or "true"
	 * 			returns (bool)false if value is "0", "Off" or "false"
	 */
	public static function ini($var = "")
	{
		if(empty($var)) return false;
		$_value = ini_get($var);
		switch($_value) {
			case "0":
			case "Off":
			case "off":
			case "false":
				return false;
			case "1":
			case "On":
			case "on":
			case "true":
				return true;
			default:
				return $_value;
		}
	}
	
}