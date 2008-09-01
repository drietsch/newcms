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
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * Class to get informations about the system environment
 * 
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Sys
{
	/**
	 * protected method for comparing two specified version numbers with each other
	 *
	 * @param string $version version number compared with the reference version number
	 * @param string $reference reference version number to compare with
	 * @param string operator
	 * 			possible values for $rel: <, lt, <=, le, >, gt, >=, ge, ==, =, eq, !=, <>, ne  
	 * @return if no operator is used: -1 (if older), 0 (if equal) or 1 (if newer)
	 * @return bool with operator
	 * @link http://php.net/manual/en/function.version-compare.php documentation of version_compare()
	 * @example we_util_Sys::_versionCompare("1.0", "1,1"); // will return -1
	 * @example we_util_Sys::_versionCompare("1.1", "1,1"); // will return 0
	 * @example we_util_Sys::_versionCompare("1.1", "1,0"); // will return 1
	 * @example we_util_Sys::_versionCompare("1.0", "1,1", "<"); // will return (bool)true
	 * @example we_util_Sys::_versionCompare("1.0", "1,1", ">"); // will return (bool)false
	 */
	protected  static function _versionCompare($version="", $reference = "", $operator = "")
	{
		/*
		 * will soon replace the code of following methods:
		 * - we_util_Sys_Webedition::versionCompare()
		 * - we_util_Sys_Webedition::toolVersionCompare()
		 * - we_util_Sys_Php::versionCompare()
		 * - we_util_Sys_Db_Mysql::versionCompare()
		 * they'll call this method here insead of implementing the functionality themselves.
		 */
		if(empty($version) ||!empty($reference)) return false;
		if(!empty($operator)) {
			return version_compare($version,$reference,$operator);
		} else {
			return version_compare($version,$reference);
		}
	}
	
}

// example usage of sys classes:
/*
we_util_Sys_Server::product(); // gibt den Namen des Webserver-Produktes zurueck
we_util_Sys_Server::isApache();
we_util_Sys_Server::isApache("2");
we_util_Sys_Server::isIIS(); // checks if IIS_RUNNING is defined and (bool)true

we_util_Sys_Server_Apache::version(); // Version des Webservers, uses apache_get_version()
we_util_Sys_Server_Apache::module(); // vgl.: we_util_Sys_Php::extension(), uses apache_get_modules()

we_util_Sys_Server_IIS::function(); // IIS class not implemented (yet)

if(we_util_Sys_Webedition::version("customer")) {}
if(we_util_Sys_Webedition::module("customer")) {}
if(we_util_Sys_Webedition::moduleLicense("customer")) {}
if(we_util_Sys_Webedition::tool("customer")) {}
if(we_util_Sys_Webedition::toolLicense("customer")) {}

if(we_util_Sys_Php::version("customer")) {}
if(we_util_Sys_Php::ini("customer")) {}
if(we_util_Sys_Php::extension("customer")) {}

// db checks use webEdition config in webEdition/we/include/conf/we_conf.inc.php
if(we_util_Sys_Db::available()) {} // check if server is up and running and the webedition config is correct
if(we_util_Sys_Db_Mysql::permission("alter")) {} // Benutzer-Berechtigungen: �berpr�ft, ob der MySQL-Benutzer aus der we_conf.inc.php ein best. Recht besitzt 
if(we_util_Sys_Db_Mysql::status("Open_tables")) {} // MySQL Laufzeit-Informationen von "SHOW STATUS LIKE ...;"
if(we_util_Sys_Db_Mysql::variable("have_innodb")) {} // MySQL Servervariablen und -einstellungen von "SHOW VARIABLES LIKE ...;"
if(we_util_Sys_Db_Mysql::plugin("innodb")) {} // �berpr�ft, ob ein MySQL plugin verf�gbar ist (SHOW PLUGIN)
if(we_util_Sys_Db_Mysql::table("tblvoting")) {} // �berr�ft, ob eine Tabelle in der webEdition Datenbank existiert (SHOW TABLES)

*/