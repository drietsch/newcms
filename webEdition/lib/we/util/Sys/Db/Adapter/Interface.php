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
 * 
 * 
 * @category   we
 * @package    we_util
 * @subpackage we_util_Sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
interface we_util_Sys_Db_Interface
{
    /**
     * Performs an connection attempt
     *
     * @throws we_util_Sys_Dbms_Exception If connection cannot be performed
     * @return bool
     */
    public function isAvailable();
    
	public function permission();
	
	public function table();
    
}
