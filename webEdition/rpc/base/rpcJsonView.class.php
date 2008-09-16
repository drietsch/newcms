<?php

/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpcJsonView {
	
	var $CmdShell;
	
	function setCmdShell($cmdshell) {
		$this->CmdShell = $cmdshell;
	}
	
	
	/**
	 * @param rpcResponse $response
	 * @return string
	 */
	function getResponse( $response ) {
		
		if ( $response->Success ) {
			$status = "response";

		} else {
			$status = "error";
		}
		
		// DONT TOUCH THIS -  this is also  used forDreamweaver extension !!!!
		return 
		'var weResponse = {
			"type":"' . $status . '",
			"data":"' . addslashes($response->getData("data")) . '"
		};'
		;
	}
}

?>