<?php

class we_ui_Client
{
	
	const kBrowserIE 		= 0;
	const kBrowserGecko 	= 1;
	const kBrowserWebkit 	= 2;
	const kBrowserOther 	= 3;
	
	const kSystemWindows	= 0;
	const kSystemMacOS		= 1;
	const kSystemOther		= 2;
	
	private static $instance;


	protected $_system;
	protected $_browser;
	protected $_version;
	
	function __construct($userAgent='')
	{
		if ($userAgent === '') {
			$userAgent = $_SERVER['HTTP_USER_AGENT'];
		}
				
		if (preg_match('/MSIE ([0-9\.]+)/i',$userAgent, $regs)) {
			$this->_browser = self::kBrowserIE;
			$this->_version = $regs[1];
		} else if (preg_match('/Gecko\/([0-9]+)/i',$userAgent, $regs)) {
			$this->_browser = self::kBrowserGecko;
			$this->_version = $regs[1];
		} else if (preg_match('/AppleWebKit\/([0-9\.]+)/',$userAgent, $regs)) {
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
	
 	public static function getInstance($userAgent='') {
    	if (!self::$instance instanceof self) { 
      		self::$instance = new self($userAgent);
    	}
    	return self::$instance;
	}

	/**
	 * @return unknown
	 */
	public function getBrowser()
	{
		return $this->_browser;
	}

	/**
	 * @return unknown
	 */
	public function getSystem()
	{
		return $this->_system;
	}

	/**
	 * @return unknown
	 */
	public function getVersion()
	{
		return $this->_version;
	}

}

?>
