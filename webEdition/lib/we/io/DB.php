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
 * @package    we_io
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * Base class for data base
 * 
 * @category   we
 * @package    we_io
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_io_DB
{

	/**
	 * dbInstance attribute
	 *
	 * @var NULL
	 */
	private static $dbInstance = NULL;

	/**
	 * create new adapter
	 *
	 * @return object
	 */
	static function newAdapter()
	{
		$db = Zend_Db::factory('Pdo_Mysql', array('host' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'dbname' => DB_DATABASE));
		return $db;
	}

	/**
	 * shared adapter
	 *
	 * @return object
	 */
	static function sharedAdapter()
	{
		if (self::$dbInstance === NULL) {
			self::$dbInstance = self::newAdapter();
		}
		return self::$dbInstance;
	}

	/**
	 * checks if table exists in $tab
	 *
	 * @param string $tab
	 * @return boolean
	 */
	static function tableExists($tab)
	{
		$_db = we_io_DB::sharedAdapter();
		if ($_db->fetchAll("SHOW TABLES LIKE '$tab';"))
			return true;
		else
			return false;
	}
}
