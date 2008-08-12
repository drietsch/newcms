<?php

/**
 * @see we_util_Sys_Dbms_Interface
 */
require_once 'we/util/Sys/Db/Interface.php';

/**
 * @see Zend_Db_Adapter_Abstract
 */
require_once 'Zend/Db/Adapter/Abstract.php';


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