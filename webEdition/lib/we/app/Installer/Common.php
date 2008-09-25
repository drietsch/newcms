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
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_io_DB
 */
Zend_Loader::loadClass('we_io_DB');

include_once('Zend/Db.php');

/**
 * class for local installation of webEdition applications (formerly known as "tools")
 * the source files need to be present as a zip file at a specified location
 * static class for common installer activities, i.e. check routines
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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