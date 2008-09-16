<?php

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * class for handling client information
 * 
 * @category   we
 * @package    we_ui
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_Client
{

	/**
	 * constant for IE Browser
	 */
	const kBrowserIE = 0;

	/**
	 * constant for Gecko Browser
	 */
	const kBrowserGecko = 1;

	/**
	 * constant for Webkit
	 */
	const kBrowserWebkit = 2;

	/**
	 * constant for other Browsers
	 */
	const kBrowserOther = 3;

	/**
	 * constant for Windows System
	 */
	const kSystemWindows = 0;

	/**
	 * constant for MacOs System
	 */
	const kSystemMacOS = 1;

	/**
	 * constant for other Systems
	 */
	const kSystemOther = 2;

	/**
	 * instance
	 */
	private static $instance;

	/**
	 * _system attribute
	 * 
	 * @var string
	 */
	protected $_system;

	/**
	 * _browser attribute
	 * 
	 * @var string
	 */
	protected $_browser;

	/**
	 * _version attribute
	 * 
	 * @var string
	 */
	protected $_version;

	/**
	 * Constructor
	 * 
	 * Set user agent properties
	 * 
	 * @param string $userAgent
	 * @return void
	 */
	function __construct($userAgent = '')
	{
		if ($userAgent === '') {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
		}
		
		if (preg_match('/MSIE ([0-9\.]+)/i', $userAgent, $regs)) {
			$this->_browser = self::kBrowserIE;
			$this->_version = $regs[1];
		} else if (preg_match('/Gecko\/([0-9]+)/i', $userAgent, $regs)) {
			$this->_browser = self::kBrowserGecko;
			$this->_version = $regs[1];
		} else if (preg_match('/AppleWebKit\/([0-9\.]+)/', $userAgent, $regs)) {
			$this->_browser = self::kBrowserWebkit;
			$this->_version = $regs[1];
		} else {
			$this->_browser = self::kBrowserOther;
			$this->_version = 0;
		}
		
		if (preg_match('/(Mac_PowerPC)|(Macintosh)/', $userAgent)) {
			$this->_system = self::kSystemMacOS;
		} else if (preg_match('/(Windows)|(WinNT)|(Win98)|(Win95)/', $userAgent)) {
			$this->_system = self::kSystemWindows;
		} else {
			$this->_system = self::kSystemOther;
		}
	}

	/**
	 * returns instance
	 * 
	 * @param string $userAgent
	 * @return instance
	 */
	public static function getInstance($userAgent = '')
	{
		if (!self::$instance instanceof self) {
			self::$instance = new self($userAgent);
		}
		return self::$instance;
	}

	/**
	 * retrieve browser
	 * 
	 * @return string
	 */
	public function getBrowser()
	{
		return $this->_browser;
	}

	/**
	 * retrieve system
	 * 
	 * @return string
	 */
	public function getSystem()
	{
		return $this->_system;
	}

	/**
	 * retrieve version
	 * 
	 * @return version
	 */
	public function getVersion()
	{
		return $this->_version;
	}

}

?>
