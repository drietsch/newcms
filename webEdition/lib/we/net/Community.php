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

include_once ('Zend/Config/Xml.php');
/**
 * @see we_util_Log
 */
Zend_Loader::loadClass('we_util_Log');

/**
 * @see we_net_Http
 */
Zend_Loader::loadClass('we_net_Http');

/**
 * Was diese Klasse können muss:
 * - Testen, ob ein community Account existiert
 * - Einen Community Account anmelden
 * 
 * Alles andere läuft über die webEdition community Website
 * 
 * folgende Daten müssen in webEdition gespeichert werden:
 * - Username
 * - Passwort
 * 
 * Die Daten werden in einer XML-Datei gespeichert:
 * webEdition/we/include/conf/we_community.xml.php
 * 
 * Diese Datei hat eine PHP-Endung und beginnt mit <?php exit; ?>
 * um beim Direktaufruf keine Informationen preiszugeben.
 * 
 * 
 * @category   we
 * @package    we_net
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_net_Community
{

	/**
	 * @var e-mail address as unique identification for the webEdition community account:
	 */
	private $_uid = '';

	/**
	 * @var password for the webEdition community account
	 */
	private $_password = '';

	/**
	 * @var Zend_Config_Xml object storing informations about the webEdition community registration server
	 */
	private $_server = null;

	/**
	 * @var server URI including protocol and path
	 */
	private $_serverURI = '';

	/**
	 * @var configuration file with community account data (xml)
	 */
	private $_configFile = '';

	/**
	 * @var allowed encryption methods for password: md5, sha1, crypt, shuffle, none (default: md5)
	 */
	private $_encryption = "md5";

	/**
	 * @var we_net_Http connection object for http connections to the webEdition community registration server
	 */
	private $_http = null;

	/**
	 * 
	 */
	public function __construct()
	{
		$this->_configFile = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/conf/we_community.xml.php';
		$this->_readServerConfig();
		if (!empty($this->_serverURI)) {
			if (!$this->_http = new we_net_Http()) {
				$this->_http = null;
			}
		}
		
	//$this->_getAccount();
	}

	public function __get($var)
	{
		switch ($var) {
			case "password" :
				return $this->_password;
				break;
			case "uid" :
			case "email" :
				return $this->_uid;
				break;
			default :
				return false;
				break;
		}
	}

	/**
	 * public setter method only for these class variables:
	 * - uid (email)
	 * - password (cleartext, will be encrypted for storage and validation later)
	 * 
	 * @param string $var variable name
	 * @param string $value value of the variable
	 */
	public function __set($var, $value)
	{
		switch ($var) {
			case "password" :
				$this->_password = $value;
				break;
			case "uid" :
			case "email" :
				$this->_uid = $value;
				break;
			default :
				return false;
				break;
		}
		return true;
	}

	/**
	 * sends a request to the update server to check if the account data is correct.
	 * @return bool true/false
	 */
	public function isValid()
	{
		if (empty($this->_password) || empty($this->_uid)) {
			return false;
		}
		$responseText = "";
		$this->_http->uri = $this->_serverURI . 'validateRegistration';
		try {
			$response = $this->_http->post(array("username" => $this->_uid, "password" => $this->_password));
			if ($response) {
				$responseText = $response->getBody();
			}
		} catch (we_net_Exception $e) {
			return "fehlermeldung";
		}
		if ($responseText == "true") {
			return true;
		}
		
		return false;
	}

	/**
	 * sends entered user data to the server for creating a new webEdition community account.
	 * Writes the data to the class variables and uid (email) and encrypted password to the config file
	 * if the data is correct and the account has been created successfully.
	 * Note: the password has to be entered twice for verification purposes. The update server will do the checking.
	 * 
	 * @internal possible responses from the server could be:
	 * 			- server malfunction (registration temporarily down)
	 * 			- data incomplete (values x, y and z are missing)
	 * 			- data not valid (i.e. invalid email address)
	 * 			- ...
	 * @param $data array associative array with account data
	 * @return bool true/false
	 */
	public function subscribe()
	{
		/*
		 * - perform $this->isValid()
		 * - if true: perform $this->_updateAccount();
		 * - if false: return false;
		 */
	}

	/**
	 * checks entered account data (uid/email and password) by asking the update server using 
	 * $this->isValid() and - if successful - writes them to the configuration file using 
	 * $this->S_aveAccountToWE()
	 * 
	 * @return bool true/false
	 */
	public function authenticate()
	{
	
	}

	/** 
	 * removes the current subscription from the webEdition configuration file. In order to
	 * remove the "real" subscription on the registration server one needs to do that
	 * within the web application on the server itself. 
	 */
	public function deauthenticate()
	{
		/*
		 * perform $this->_removeAccount();
		 */
	}

	/**
	 * reads informations about the webEdition community registration server from the webEdition 
	 * configuration file to the class variable $_server as a Zend_Config_Xml object
	 */
	private function _readServerConfig()
	{
		if (!$data = file_get_contents($this->_configFile)) {
			we_util_Log::log("could not read config file.", 3);
			return false;
		}
		$data = str_replace("<?php exit; ?>\n", "", $data);
		if (!$xml = @simplexml_load_string($data)) {
			we_util_Log::log("could not parse config file", 3);
			return false;
		}
		if (isset($xml->server)) {
			$this->_server = $xml->server;
		}
		if (isset($xml->account->uid)) {
			$this->_uid = (string)$xml->account->uid;
		}
		if (isset($xml->account->password)) {
			$this->_password = (string)$xml->account->password;
		}
		
		if (isset($this->_server->port)) {
			switch ($this->_server->port) {
				case "443" :
					$protocol = "https://";
					break;
				case "21" :
					$protocol = "ftp://";
					break;
				default :
					$protocol = "http://";
					break;
			}
		}
		if (isset($this->_server->host)) {
			$this->_serverURI = $protocol . $this->_server->host;
		}
		if (isset($this->_server->path)) {
			$this->_serverURI .= $this->_server->path;
		}
		
		return true;
	}

	/**
	 * reads account informations from the webEdition configuration file (uid and password)
	 * @return bool true/false
	 */
	private function _getAccount()
	{
		return $this->_readServerConfig();
	}

	/**
	 * updates account informations in the webEdition configuration file
	 * @return bool true/false
	 */
	private function _updateAccount()
	{
		if (empty($this->_uid) ||  empty($this->_password)) {
			return false;
		}
		$filename = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/conf/we_community.inc.php';
		$output = '<?php' . "\n" . '$communityAccount = array("uid" => "' . $this->_uid . '","password" => "' . $this->_encryptPassword($this->_password) . '");' . "\n" . '?>';
		
		if (!file_put_contents($filename, $output)) {
			we_util_Log::log("ERROR: could not write community configuration to file " . $filename, 3);
			return false;
		} else {
			return true;
		}
	}

	/**
	 * removes account informations from the webEdition configuration file
	 * @return bool true/false
	 */
	private function _removeAccount()
	{
		$filename = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/conf/we_community.inc.php';
		$output = '<?php' . "\n" . '$communityAccount = array("uid" => "","password" => "");' . "\n" . '?>';
		
		if (!file_put_contents($filename, $output)) {
			we_util_Log::log("ERROR: could not write empty community configuration to file " . $filename, 3);
			return false;
		} else {
			return true;
		}
	}

	/**
	 * encrypts a given string or creates a hash value from it 
	 * @param string $str string to be encrypted
	 * @return string encrypted string
	 */
	private function _encrypt($str)
	{
		if (empty($str)) {
			return false;
		}
		switch ($this->_encryption) {
			case "md5" :
				return md5($str);
			case "sha1" :
				return sha1($str);
			case "crypt" :
				return crypt($str);
			case "shuffle" :
				return str_shuffle($str);
			case "none" :
				return $str;
			default :
				return md5($str);
		}
	}

}