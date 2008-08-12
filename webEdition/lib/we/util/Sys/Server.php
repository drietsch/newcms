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
 * @version    $Id: $
 */

Zend_Loader::loadClass('we_util_Sys');
Zend_Loader::loadClass('we_util_Sys_Exception');

/**
 * utility class for various web servers
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @author     Alexander Lindenstruth
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Sys_Server extends we_util_Sys
{

	/**
	 * tries to identify the web server and return its product name.
	 * The product name return to the caller is the name used for these classes.
	 *
	 * @return string product name or false, if the server product is unknown.
	 */
	public static function product()
	{
		if (self::isApache()) {
			return "Apache";
		} else if (self::isIIS()) {
			return "IIS";
		} else {
			return false;
		}
	}

	/**
	 * checks if this is an apache web server
	 *
	 * @param string $version optional parameter to check for a specific apache version.
	 * this method checks the part of the version string that comes after "Apache/"
	 * i.e. "Apache/1.3" in "Apache/1.3.29 (Unix) PHP/4.3.4"
	 * This depends on settings in httpd.conf ServerTokens, possible return values are:
	 * ServerTokens Full - Apache/1.3.29 (Unix) PHP/4.3.4
	 * ServerTokens Full - Apache/2.0.55 (Win32) DAV/2
	 * ServerTokens OS - Apache/2.0.55 (Win32)
	 * ServerTokens Minor - Apache/2.0
	 * ServerTokens Minimal - Apache/2.0.55
	 * ServerTokens Major - Apache/2
	 * ServerTokens Prod - Apache
	 * 
	 * @return bool true/false
	 */
	public static function isApache($version = "")
	{
		if (function_exists("apache_get_version")) {
			if (empty($version)) {
				return true;
			} else {
				$apacheVersion = apache_get_version();
				if ($apacheVersion === false) {
					return false;
				} else if (stristr($version, "Apache/" . $apacheVersion)) {
					return true;
				} else {
					return false;
				}
			}
		} else {
			return false;
		}
	}

	/**
	 * checks if this is a Microsoft IIS
	 *
	 * @return bool true/false
	 */
	public static function isIIS()
	{
		if (defined("IIS_RUNNING") && IIS_RUNNING === true) {
			return true;
		} else {
			return false;
		}
	
	}

	/**
	 * Retrieve Hostname for current request
	 *
	 * @return string
	 */
	public static function getHost()
	{
		// in case the port is attached => remove it
		$parts = explode(':', $_SERVER['HTTP_HOST']);
		return $parts[0];
	}

	/**
	 * Retrieve Protocol for current request
	 *
	 * @return string
	 */
	public static function getProtocol()
	{
		return (empty($_SERVER['HTTPS'])) ? 'http' : 'https';
	}

	/**
	 * Retrieve Port for current request
	 *
	 * @return integer
	 */
	public static function getPort()
	{
		return $_SERVER['SERVER_PORT'];
	}

	/**
	 * Retrieve complete URI for host and appends an url if set
	 *
	 * @param string $url  url to append. If empty a uri only with hostname is returned
	 * @return string
	 */
	public static function getHostUri($url = '')
	{
		$host = self::getHost();
		$proto = self::getProtocol();
		$port = self::getPort();
		$uri = $proto . '://' . $host;
		if ((('http' == $proto) && (80 != $port)) || (('https' == $proto) && (443 != $port))) {
			$uri .= ':' . $port;
		}
		if ($url !== '') {
			return $uri . '/' . ltrim($url, '/');
		} else {
			return $uri;
		}
	}

	/**
	 * identify docroot, either via $_SERVER["DOCUMENT_ROOT"] or path reproduction
	 * 
	 * @return string complete path of the servers docroot without a trailing slash
	 * @author Alexander Lindenstruth
	 */
	public static function getDocroot()
	{
		if (isset($_SERVER["DOCUMENT" . "_ROOT"]) && !empty($_SERVER["DOCUMENT" . "_ROOT"])) {
			return $_SERVER["DOCUMENT" . "_ROOT"];
		} else {
			// mostly on Microsoft IIS servers (Windows) without DOCUMENT_ROOT:
			return realpath(dirname(__FILE__) . "/.." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR);
		}
	}

}