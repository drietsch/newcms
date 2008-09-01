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
 */

/**
 * @see we_util_Sys_Dbms_Interface
 */
require_once 'we/util/Sys/Db/Interface.php';

/**
 * @see Zend_Db_Adapter_Abstract
 */
require_once 'Zend/Db/Adapter/Abstract.php';

/**
 * 
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_util_Sys_Db_Mysql extends we_util_Sys_Db implements we_util_Sys_Db_Interface
{
	
	protected function _connect()
	{
		return false;
	}
	
	protected function _disconnect()
	{
		return false;
	}
	
	public function status()
	{
		
	}
	
	public function variable()
	{
		
	}
	
	public function plugin()
	{
		
	}
	
}