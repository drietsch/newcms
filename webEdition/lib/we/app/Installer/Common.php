<?php
/**
 * class for local installation of webEdition applications (formerly known as "tools")
 * the source files need to be present as a zip file at a specified location
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 * @author Alexander Lindenstruth
 */

include_once (dirname(dirname(__FILE__)) . '/../../we/core/autoload.php');

/**
 * @see we_io_DB
 */
Zend_Loader::loadClass('we_io_DB');

include_once('Zend/Db.php');

/**
 * static class for common installer activities, i.e. check routines
 */
class we_app_Installer_Common
{
	
	public static function executeQuery($query = "")
	{
		if(empty($query)) {
			return false;
		}
		$db = we_io_DB::getAdapter();
		try {
			$result = $db->getConnection()->exec($query);
		} catch (PDOException $e) {
			error_log($e->getCode().": ".$e->getMessage()." in file ".$e->getFile());
			return false;
		}
		return true;
		
	}
	
	
	
}