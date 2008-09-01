<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_io
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * Base class for data base
 * 
 * @category   we
 * @package    we_io
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
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
