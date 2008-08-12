<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    
 */

include_once('webEdition/lib/we/core/autoload.php');
Zend_Loader::loadClass('we_util_Sys');
Zend_Loader::loadClass('we_util_Sys_Exception');
/**
 * Class to check php settings
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
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