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

/**
 * @see we_util_Sys_Exception
 */
Zend_Loader::loadClass('we_util_Sys');
Zend_Loader::loadClass('we_util_Sys_Exception');

/**
 * Class to check webEdition settings and installation properties
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @author     Alexander Lindenstruth
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Sys_Webedition extends we_util_Sys
{
	
	/**
	 * tries to identify the version of the currently installed webEdition
	 * @return version string without dots (i.e. "5501") or false, if the version could not be identified.
	 */
	public static function version()
	{
		if(!defined("WE_VERSION")) {
			try {
				include_once $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_version.php";
			} catch (Exception $e) {
				/**
				 * @see we_util_Sys_Exception
				 */
	            throw new we_util_sys_Exception('Could not identify webEdition version because we_version.inc.php '
	                                                . 'is not available.');
			}
			
			if(!defined("WE_VERSION")) return false;
		}
		return WE_VERSION;
	}
	
	/**
	 * compares specified webEdition version with the currently installed webEdition version
	 * @param int $reference target version to be compared to current webEdition version
	 * @param string $operator
	 * @see we_util_Sys::_versionCompare()
	 * @example we_util_Sys_Webedition::versionCompare("5501");
	 * @example we_util_Sys_Webedition::versionCompare("5501", "<");
	 */
	public static function versionCompare($version = "", $operator = "")
	{
		$currentVersion = self::version();
		if($currentVersion === false || empty($version)) return false;
		return parent::_versionCompare($version,$currentVersion,$operator);
	}
	
	/**
	 * checks if a requested module is installed and / or active
	 * @param string module name
	 * @return int
	 * 		-1	module not installed or an error occured on fetching module installation informations from webEdition
	 * 		0	module installed but inactive (only available for integrated modules)
	 * 		1	module installed and active
	 */
	public static function module($property = "")
	{
		if(empty($property)) return -1;
		
		// all modules available for webEdition:
		try {
			include_once $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_available_modules.inc.php";
		} catch (Exception $e) {
			/**
			 * @see we_util_Sys_Exception
			 */
			throw new we_util_sys_Exception('could not read module information from we_available_modules.inc.php.');
			return -1;
		}
		if(!in_array($property,$_we_available_modules)) {
			return -1;
		}
		
		// modules previously available only with costs (always active):
		// busers, customer, shop, object, messaging, workflow, newsletter
		try {
			include_once $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_installed_modules.inc.php";
		} catch (Exception $e) {
			/**
			 * @see we_util_Sys_Exception
			 */
			throw new we_util_sys_Exception('could not read module information from we_installed_modules.inc.php.');
			return -1;
		}
		if (in_array($property,$_we_installed_modules) || in_array($module,$_pro_modules)) {
			return 1;
		}
		
		// integrated modules (free of charge, can be deactivated in webEdition preferences):
		// users, schedule, editor, banner, export, voting, spellchecker, glossary
		try {
			include_once $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_active_integrated_modules.inc.php";
		} catch (Exception $e) {
			throw new we_util_sys_Exception('could not read module information from we_active_integrated_modules.inc.php.');
			return -1;
		}
		
		if (in_array($property,$_we_active_integrated_modules)) {
			return 1;
		} else {
			return 0;
		}
		
	}
	
	/**
	 * builds a list of all installed modules (active and inactive) and returns it to the caller
	 *
	 * @return array a list of all installed webEdition modules or (bool)false, if an error occured
	 */
	public static function modulesInstalled()
	{
		// not implemented yet
		return array();
	}
	
	/**
	 * builds a list of all activated modules (including free and formerly non-free modules) and returns it to the caller
	 *
	 * @return array a list of all active webEdition modules or (bool)false, if an error occured
	 */
	public static function modulesActive()
	{
		// not implemented yet
		return array();
	}
	
	/**
	 * builds a list of all available modules and returns it to the caller
	 *
	 * @return array a list of all available webEdition modules or (bool)false, if an error occured
	 */
	public static function modulesAvailable()
	{
		try {
			include_once $_SERVER['DOCUMENT_ROOT']."/webEdition/we/include/we_available_modules.inc.php";
		} catch (Exception $e) {
			/**
			 * @see we_util_Sys_Exception
			 */
			throw new we_util_sys_Exception('could not read module information from we_available_modules.inc.php.');
			return false;
		}
		return $_we_available_modules;
	}
	
	/**
	 * checks if a requested tool is installed
	 * this implementation is preliminary and WILL be changed once the we_tool-implementation is completed
	 * @param string tool name
	 * @return false (not installed) or true (installed)
	 */
	public static function tool($property = "")
	{
		if(empty($property)) return false;
		$tooldir = $_SERVER['DOCUMENT_ROOT']."/webEdition/apps/".$property;
		try {
			if(is_dir($tooldir) && is_readable($tooldir)) {
				return true;
			}
		} catch (Exception $e) {
			throw new we_util_sys_Exception('The tool installation path does not exist.');
			return false;
		}
	}
	
	/**
	 * get the version of the requested tool (if it is installed)
	 * @param string tool name
	 * @return string version
	 */
	public static function toolVersion($property = "")
	{
		// not imlpemented yet
		return "1.0";
	}
	
	/**
	 * compares specified tool version with the currently installed version of this tool
	 * @param string tool name
	 * @param int $reference target version to be compared to currently installed tool version
	 * @param string $operator
	 * @see we_util_Sys::_versionCompare()
	 * @example we_util_Sys_Webedition::toolVersionCompare("5.1");
	 * @example we_util_Sys_Webedition::toolVersionCompare("5.1", "<");
	 */
	public static function toolVersionCompare($property = "", $reference = "", $operator = "")
	{
		if(empty($property) || empty($reference)) {
			return false;
		} else {
			$version = self::toolVersion($property);
		}
		if($version === false) {
			return false;
		} else {
			return parent::_versionCompare($reference,$version,$operator);
		}
	}
	
	public static function toolsInstalled()
	{
		// not implemented yet
		return array();
	}
}