<?php
class we_net_LiveUpdate_Session
{
	
	/**
	 * @var liveUpdate session-id
	 */
	private $_id = "";
	
	/**
	 * @var ip address of the live update client
	 */
	private $_clientIP = "";
	
	/**
	 * @var timestamp when the live update session has been started
	 */
	private $_time = "";
	
	/**
	 * @var user or customer identification for customer related services
	 */
	private $_uid = "";
	
	public function __construct()
	{
		
	}
	
	/**
	 * @return string liveUpdate session id
	 */
	public function __toString()
	{
		return $this->getID();
	}
	
	/**
	 * setter method for setting a session parameter for the liveUpdate session
	 * this parameter will be saved in the session context of the update server
	 */
	public function __set($var = "", $value = "") {
		
	}
	
	/**
	 * getter metod for reading session parameters from the update server's session context
	 */
	public function __get($var = "")
	{
		if(empty($var)) {
			return false;
		}
	}
	
	/**
	 * start a liveUpdate session on the update server by sending a http request
	 */
	public function start()
	{
		
	}
	
	/**
	 * destroy the current liveUpdate session by sending a http request
	 */
	public function destroy()
	{
		
	}
	
	/**
	 * checks if the update server session has already been started
	 */
	public function isRunning()
	{
		if(!empty($this->_id)) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * validates the session id by sending a http request to the server
	 * and checking if the session is already / still running
	 */
	public function validate()
	{
		return false;
	}
	
	/**
	 * @return string liveUpdate session id
	 */
	public function getID()
	{
		return $this->_id;
	}
	
	/**
	 * tries to send a http request to the update server to
	 * read an update session parameter from the update server's session array
	 */
	private function _readParameterFromServer($var = "", $value ="")
	{
		if(empty($var) || empty($value)) {
			return false;
		}
	}
	
	/**
	 * tries to send a http request to the update server to
	 * save an update session parameter in the update server's session array
	 */
	private function _writeParameterToServer($var = "")
	{
		if(empty($var)) {
			return false;
		}
	}
	
}