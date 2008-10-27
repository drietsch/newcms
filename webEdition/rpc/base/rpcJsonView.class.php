<?php

/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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