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
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * Utility class for path manipulation and creation
 * 
 * @category   we
 * @package    we_util
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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
			$db = we_io_DB::sharedAdapter();
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
		if (is_null($db)) {
			$db = we_io_DB::sharedAdapter();
		}
		
		$id = we_util_Path::path2Id($path, $dbTable, $db);
		return $id != 0;
	}

}
