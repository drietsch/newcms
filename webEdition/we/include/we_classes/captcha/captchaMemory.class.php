<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class CaptchaMemory {
	
	
	/**
	 * Save the Captcha Code to the Memory
	 *
	 * @param string $file
	 * @param string $captcha
	 * @return void
	 */
	function save($captcha, $file) {
		$items = array();
		$items = CaptchaMemory::readData($file);
		
		// delete old items
		if(sizeof($items) > 0) {
			foreach($items as $code => $item) {
				if(		time() > $item['time']
					||	($_SERVER['REMOTE_ADDR'] == $item['ip']
						&&	$_SERVER['HTTP_USER_AGENT'] == $item['agent'])) {
					unset($items[$code]);
				}
			}
		}
		
		$items[$captcha] = array(
			'time'	=> time()+30*60,
			'ip'	=> $_SERVER['REMOTE_ADDR'],
			'agent'	=> $_SERVER['HTTP_USER_AGENT'],
		);
		CaptchaMemory::writeData($file, $items);			
	} /* end: save */
	
	
	/**
	 * checks if the Captcha Code is a valid Code
	 *
	 * @param string $file
	 * @param string $captcha
	 * @return boolean
	 */
	function isValid($captcha, $file) {
		
		$returnValue = false;
		
		$items = array();
		$items = CaptchaMemory::readData($file);
		
		// check if code is valid
		if(		isset($items[$captcha])
			&&	is_array($items[$captcha]) 
			&&	time() < $items[$captcha]['time']
			&&	$_SERVER['REMOTE_ADDR'] == $items[$captcha]['ip']
			&&	$_SERVER['HTTP_USER_AGENT'] == $items[$captcha]['agent']) {
			unset($items[$captcha]);
			$returnValue = true;
		}
		
		// delete old items
		if(sizeof($items) > 0) {
			foreach($items as $code => $item) {
				if(		time() > $item['time']
					||	($_SERVER['REMOTE_ADDR'] == $item['ip']
						&&	$_SERVER['HTTP_USER_AGENT'] == $item['agent'])) {
					unset($items[$code]);
				}
			}
		}
		
		CaptchaMemory::writeData($file, $items);
		
        return $returnValue;
	} /* end: isValid */
	
	
	/**
	 * read the data file
	 *
	 * @param string $file
	 * @return void
	 */
	function readData($file) {
		if(file_exists($file.".php")) {
			include($file.".php");
			if(isset($data)) {
				return unserialize($data);
			}
		}
		return array();
	} /* end: readData */
	
	
	/**
	 * write the data file
	 *
	 * @param string $file
	 * @return void
	 */
	function writeData($file, $data) {
		if(sizeof($data) < 1) {
			if(file_exists($file.".php")) {
				unlink($file.".php");
			}
		} else {
			$serialized = serialize($data);
			$fh = fopen($file.".php", 'w+');
	    	fputs($fh, "<?php\n\$data='".$serialized."';\n?>");
	    	fclose($fh);
		}
	} /* end: writeData */
	
} /* end: Class */

?>