<?php

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
