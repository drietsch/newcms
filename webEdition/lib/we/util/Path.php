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
 * Utility class for path manipulation and creation
 * 
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Path
{

	/**
	 * Converts a given id to a path
	 *
	 * @param integer $id  id to convert
	 * @param string $dbTable name of table
	 * @param Zend_Db_Adapter $db  Zend db adapter object
	 * @return string
	 */
	static function id2Path($id, $dbTable, $db = NULL)
	{
		if (is_null($db)) {
			$db = we_io_DB::sharedAdapter();
		}
		return $db->fetchOne('SELECT Path FROM ' . addslashes($dbTable) . ' WHERE ID = ?', $id);
	}

	/**
	 * Converts a given path to an id
	 *
	 * @param string $path  path to convert
	 * @param string $dbTable name of table
	 * @param Zend_Db_Adapter $db  Zend db adapter object
	 * @return integer
	 */
	static function path2Id($path, $dbTable, $db = NULL)
	{
		if (is_null($db)) {
			$db = we_io_DB::getAdapter();
		}
		return abs($db->fetchOne('SELECT ID FROM ' . addslashes($dbTable) . ' WHERE Path = ?', $path));
	}

	/**
	 * Checks if a given path exists
	 *
	 * @param string $path  path to convert
	 * @param string $dbTable name of table
	 * @param Zend_Db_Adapter $db  Zend db adapter object
	 * @return boolean
	 */
	static function pathExists($path, $dbTable, $db = NULL)
	{
		$id = we_util_Path::path2Id($path, $dbTable, $db);
		return $id != 0;
	}

}
