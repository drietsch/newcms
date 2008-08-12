<?php
/**
 * class for common liveUpdate functions
 * 
 * @category   we
 * @package    we_net
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 * @author Alexander Lindenstruth
 */

include_once (dirname(dirname(__FILE__)) . '/../we/core/autoload.php');

/**
 * @see we_net_Http
 */
Zend_Loader::loadClass('we_net_Http');

/**
 * @see we_net_LiveUpdate_Session
 */
Zend_Loader::loadClass('we_net_LiveUpdate_Session');

/**
 * class for liveUpdate actions
 * @category   we
 * @package    we_net
 * @author Alexander Lindenstruth
 * 
 * @uses we_net_Http
 * 
 */
class we_net_LiveUpdate
{
	
	/**
	 * @var uri and path to the update server:
	 */
	private $_host = "";
	private $_path = "";
	private $_uri = "";
	
	private $_session = null;
	
	private $_request = null;
	
	public function __construct()
	{
		$this->_readConfig();
		if(empty($this->_uri)) {
			return false;
		}
		$this->_session = new we_net_LiveUpdate_Session();
		$this->_session->start();
		$this->_request = new we_net_Http($this->_uri);
		
	}
	
	
	private function _readConfig()
	{
		$this->_host = "http://update.ali.intra";
		$this->_path = "/webEdition/liveUpdate.php";
		$this->_uri = $this->_host.$this->_path;
	}
	
	public function checkConnection()
	{
		
		$this->_response = null;
		$this->_response = $this->_request->get();
		error_log(print_r($this->_response,true));
		if($this->_request->status == "200") {
			return true;
		} else {
			error_log("Connection check returned http status code \"".$this->_request->status." - ".$this->_request->statustext."\"");
			return false;
		}
	}
	
	/**
	 * sends a common http request to the update server
	 * @return string response from the update server
	 */
	public function sendRequest($params = array())
	{
		if(!is_array($params)) {
			error_log("WARNING: the parameter array seems not to be a valid array so it won't be used for this request!");
			$params = array();
		}
		$this->_response = null;
		try {
			$this->_response = $this->_request->get($params);
			error_log(print_r($this->_response,true));
			return $this->_response->getBody();
		} catch(we_net_Exception $e) {
			error_log("shit");
		}
	}
	
	/**
	 * destroy the update server session
	 */
	public function close()
	{
		$this->_session->destroy();
	}
	
}