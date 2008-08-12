<?php

class we_io_DB
{

	private static $dbInstance = NULL;

	static function newAdapter()
	{
		$db = Zend_Db::factory('Pdo_Mysql', array('host' => DB_HOST, 'username' => DB_USER, 'password' => DB_PASSWORD, 'dbname' => DB_DATABASE));
		return $db;
	}

	static function sharedAdapter()
	{	
		if (self::$dbInstance === NULL) {
			self::$dbInstance = self::newAdapter();
		}
		return self::$dbInstance;
	}
	
	static function tableExists($tab) 
	{
			$_db = we_io_DB::sharedAdapter();
			if($_db->fetchAll("SHOW TABLES LIKE '$tab';")) return true; else return false;
	}
}
