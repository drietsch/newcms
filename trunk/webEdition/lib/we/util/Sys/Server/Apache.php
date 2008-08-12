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
Zend_Loader::loadClass('we_util_Sys_Server');

/**
 * utility class for apache web server
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @author     Alexander Lindenstruth
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Sys_Server_Apache extends we_util_Sys_Server
{
	
	/**
	 * checks if a specified module is loaded
	 *
	 * @param string $module name of an apache module
	 * @return bool true/false
	 */
	public static function module($module = "")
	{
		if(empty($module) || !function_exists("apache_get_modules")) {
			return false;
		} else {
			if(in_array($module,apache_get_modules())) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * returns the apache version string, if it is available. 
	 * This depends on settings in httpd.conf ServerTokens, possible return values are:
	 * ServerTokens Full - Apache/1.3.29 (Unix) PHP/4.3.4
	 * ServerTokens Full - Apache/2.0.55 (Win32) DAV/2
	 * ServerTokens OS - Apache/2.0.55 (Win32)
	 * ServerTokens Minor - Apache/2.0
	 * ServerTokens Minimal - Apache/2.0.55
	 * ServerTokens Major - Apache/2
	 * ServerTokens Prod - Apache
	 *
	 * @return string apache version or (bool)false, if there was an error reading the version string. 
	 */
	public static function version()
	{
		if(function_exists("apache_get_version")) {
			return apache_get_version();
		} else {
			return false;
		}
	}
	
	/**
	 * compares specified apache version with the currently installed apache version
	 * @param int $reference target version to be compared to current apache version
	 * @param string $operator
	 * @see we_util_Sys::_versionCompare()
	 * @example we_util_Sys_Webedition::versionCompare("5501");
	 * @example we_util_Sys_Webedition::versionCompare("5501", "<");
	 */
	public static function versionCompare($reference = "", $operator = "")
	{
		$version = self::version();
		if($version === false�|| empty($reference)) return false;
		return parent::_versionCompare($reference,$version,$operator);
	}
}