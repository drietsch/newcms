<?php

class we_service_Exception extends Exception
{

	protected $_type = "error";
	
	/**
	 * Sets the error Type. Possible values are: error|warning|notice
	 * 
	 * @return string
	 */
	final public function getType()
	{
		return $this->_type;
	}

	/**
	 * Gets the error Type. Possible values are: error|warning|notice
	 * 
	 * @param string $type
	 */
	final public function setType($type)
	{
		$this->_type = $type;
	}

	
	
}
