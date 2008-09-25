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
 * @package    we_net
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_net_Exception
 */
Zend_Loader::loadClass('we_net_Exception');

/**
 * @see we_util_Log
 */
Zend_Loader::loadClass('we_util_Log');

include_once ('Zend/Uri/Http.php');
include_once ('Zend/Http/Client.php');

/**
 * class for local installation of webEdition applications (formerly known as "tools")
 * the source files need to be present as a zip file at a specified location
 * 
 * @category   we
 * @package    we_net
 * @author Alexander Lindenstruth
 * 
 * @uses Zend_Http_Client
 * @uses Zend_Uri
 * @link http://en.wikipedia.org/wiki/HTTP more informations about http
 * 
 * @internal from wikipedia (http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol) 
 * 		about the usage of GET, HEAD and POST:
 * 		"Some methods (e.g. HEAD, GET, OPTIONS, and TRACE) are defined as safe, which means they are 
 * 		intended only for information retrieval and should not change the state of the server (in other 
 * 		words, they should not have side effects). Repetition of the same GET request should therefore 
 * 		be harmless. 
 * 		Repetition of unsafe methods (such as POST, PUT and DELETE) should draw special	attention, 
 * 		typically as a dialog box requesting confirmation of the action. This is because repeated 
 * 		requests can cause side effects, such as unwanted duplication of a transaction."
 * 
 * @example #1
 * 		$http = new we_net_Http("http://www.example.org/");
 * 		$resp = $http->get();
 * @example #2
 * 		$http = new we_net_Http();
 * 		$http->uri = "http://www.example.org/";
 * 		$resp = $http->head();
 * 		$resp = $http->get();
 * 		$resp = $http->post();
 * @example #4
 * 		$http = new we_net_Http();
 * 		$http->uri = "http://www.example.org/";
 * 		$resp1 = $http->get(array("parameter1" => "value1", "parameter2" => "value2"));
 * 		$resp2 = $http->get(); // request without parameters
 * @example #5
 * 		$http = new we_net_Http("http://www.example.org/");
 * 		$resp1 = $http->get(array("parameter1" => "value1", "parameter2" => "value2"));
 * 		$resp2 = $http->get(array("parameter3" => "value3", "parameter4" => "value4"));
 * 
 * 
 * @category   we
 * @package    we_net
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_net_Http
{

	/**
	 * @var Zend_Uri_Http object Uri for this request, with (GET) or without parameters
	 */
	private $_uriObj = null;

	/**
	 * @see Zend_Uri
	 */
	private $_uri = "";

	private $_scheme = ""; // can be either "http" or "https"

	
	/**
	 * @see Zend_Uri_Http
	 */
	private $_fragment = "";

	private $_host = "";

	private $_password = "";

	private $_path = "";

	private $_port = "";

	private $_query = "";

	private $_username = "";

	/**
	 * @var connection parameters for proxy usage
	 */
	private $_proxy = array();

	/**
	 * @var shall we use a proxy?
	 */
	private $_proxyUsage = false;

	/**
	 * @var Zend_Http_Client object
	 */
	private $_client = null;

	/**
	 * @see Zend_Http_Response
	 */
	private $_response = "";

	/**
	 * @var stores the HTTP status code of the preivously performed request
	 * 		http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol#Status_Codes
	 * 		http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
	 */
	private $_status = "";

	private $_statustext = "";

	public function __construct($uri = "")
	{
		if (!empty($uri)) {
			$this->setUri($uri);
		}
	}

	/**
	 * @return int response of the current request
	 */
	public function __toString()
	{
		return $this->getRequest();
	}

	/**
	 * getter method
	 * @return mixed returns a class variable
	 */
	public function __get($attribute)
	{
		if (empty($attribute)) {
			return false;
		}
		$attribute = "_" . $attribute;
		if (isset($this->$attribute)) {
			return $this->$attribute;
		} else {
			return false;
		}
	}

	/**
	 * public setter method for all request parameters
	 */
	public function __set($attribute, $value = "")
	{
		switch ($attribute) {
			case "uri" :
				$this->setUri($value);
				break;
			case "protocol" :
				if ($value == "1.0" || $value == "1.1") {
					$this->_protocol = $value;
				}
				break;
			default :
				break;
		}
	}

	/**
	 * specify the uri for the next request, can also be done via __set()
	 * @param string $uri complete uri with scheme, host, port, path, parameters etc.
	 */
	public function setUri($uri)
	{
		if (empty($uri) || !Zend_Uri_Http::check($uri)) {
			return false;
		} else {
			$this->_uriObj = Zend_Uri_Http::factory($uri);
			if ($this->_uriObj->getScheme() == "http" || $this->_uriObj->getScheme() == "https") {
				$this->_fragment = $this->_uriObj->getFragment();
				$this->_host = $this->_uriObj->getHost();
				$this->_password = $this->_uriObj->getPassword();
				$this->_path = $this->_uriObj->getPath();
				$this->_port = $this->_uriObj->getPort();
				$this->_query = $this->_uriObj->getQuery();
				$this->_scheme = $this->_uriObj->getScheme();
				$this->_uri = $this->_uriObj->getUri();
				$this->_username = $this->_uriObj->getUsername();
				$this->_protocol = "1.1";
			} else {
				$this->_uriObj = null;
				$this->_uri = "";
				$this->_client = null;
			}
			return true;
		}
	}

	/**
	 * specify proxy connection parameters to use for http connections:
	 * automatically enables usage of this proxy
	 * 
	 * @uses Zend_Http_Client_Adapter_Proxy
	 */
	public function setProxy($params = array())
	{
		$this->_proxy = array('adapter' => 'Zend_Http_Client_Adapter_Proxy', 'proxy_host' => (!empty($params["proxy_host"]) ? $params["proxy_host"] : "127.0.0.1"), 'proxy_port' => (!empty($params["proxy_port"]) ? $params["proxy_port"] : "8000"), 'proxy_user' => (!empty($params["proxy_user"]) ? $params["proxy_user"] : ""), 'proxy_pass' => (!empty($params["proxy_pass"]) ? $params["proxy_pass"] : ""));
		$this->enableProxy();
	}

	/**
	 * enable usage of proxy, but you neet to specify the connection parameters
	 * first using $this->setProxy()
	 */
	public function enableProxy()
	{
		$this->_proxyUsage = true;
	}

	/**
	 * disable usage of proxy for the forthcoming connections
	 * the proxy parameters won't be lost
	 */
	public function disableProxy()
	{
		$this->_proxyUsage = false;
	}

	/**
	 * send a http request of method "HEAD"
	 * 
	 * @param array $param request parameters (optional)
	 * @return object Zend_Http_Response object or false
	 * @internal desciption from wikipedia (http://en.wikipedia.org/wiki/Hypertext_Transfer_Protocol):
	 * 		"Asks for the response identical to the one that would correspond to a GET request, 
	 * 		but without the response body. This is useful for retrieving meta-information written 
	 * 		in response headers, without having to transport the entire content."
	 */
	public function head($param = array())
	{
		if (!$this->_doRequest("HEAD", $param)) {
			return false;
		} else {
			return $this->_response;
		}
	}

	/**
	 * send a http request of method "GET"
	 * 
	 * @param array $param request parameters (optional)
	 * @return object Zend_Http_Response object
	 */
	public function get($param = array())
	{
		if (!$this->_doRequest("GET", $param)) {
			throw new we_net_Exception();
		} else {
			return $this->_response;
		}
	}

	/**
	 * send a http request of method "POST"
	 * 
	 * @param array $param request parameters (optional)
	 * @return object Zend_Http_Response object or false
	 */
	public function post($param = array())
	{
		if (!$this->_doRequest("POST", $param)) {
			return false;
		} else {
			return $this->_response;
		}
	}

	/**
	 * send a http request of method "PUT"
	 * 
	 * @param array $param request parameters (optional)
	 * @return object Zend_Http_Response object or false
	 */
	public function put($param = array())
	{
		return false;
		/* not implemented yet
		if(!$this->_doRequest("PUT", $param)) {
			return false;
		} else {
			return $this->_response;
		}
		*/
	}

	/**
	 * performs a request, by default with method "GET"
	 * 
	 * @param string $method http request method, can be "GET", "HEAD", "POST" or "PUT"
	 * @return bool true/false
	 */
	private function _doRequest($method = "GET", $param = array())
	{
		if (is_null($this->_uriObj)) {
			return false;
		}
		
		if (is_null($this->_client) || $this->_client->getUri() != $this->_uri) {
			$this->_response = null;
			$this->_status = "";
			$this->_statustext = "";
			$this->_client = new Zend_Http_Client($this->_uri);
		} else if (!is_null($this->_client)) {
			$this->_client->resetParameters();
		}
		
		if (is_array($param) && !empty($param)) {
			switch ($method) {
				case "GET" :
				case "HEAD" :
					$this->_client->setParameterGet($param);
					break;
				case "POST" :
					$this->_client->setParameterPost($param);
					break;
				default :
					break;
			}
		}
		
		try {
			$this->_response = $this->_client->request($method);
			$this->_status = $this->_response->getStatus();
			$this->_statustext = $this->_response->responseCodeAsText($this->_status);
		} catch (Exception $e) {
			//we_util_Log::errorLog(get_class($this).": could send request to ".$this->_uri);
			throw new we_net_Exception(get_class($this) . ": could send request to " . $this->_uri);
			return false;
		}
		return true;
	}

}