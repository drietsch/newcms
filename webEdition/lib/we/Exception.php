<?php

include_once (dirname(dirname(__FILE__)) . '/we/core/autoload.php');
require_once 'Zend/Exception.php';
/**
 * @see we_util_Log
 */
Zend_Loader::loadClass('we_util_Log');

class we_Exception extends Zend_Exception
{
	public function __construct() {
		we_util_Log::errorLog("webEdition exception '".get_class($this)."' in ".$this->getFile().":".$this->getLine()."\nStack trace;\n".$this->getTraceAsString());
	}
}