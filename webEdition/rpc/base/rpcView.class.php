<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * Base class for views.
 * 
 */

class rpcView {

	var $CmdShell;
	
	function getResponse($response){
		
	}
	
	function setCmdShell($cmdshell) {
		$this->CmdShell = $cmdshell;
	}
}
?>