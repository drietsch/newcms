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


/**
 * base class for rpc commands
 *
 * @package we_rpc 
 * @abstract 
  */
class rpcCmd {
	
	
	var $CmdShell;

	var $ExtraViews = array();

	var $Permissions = array();
	
	var $Status = RPC_STATUS_OK;
	
	var $Parameters = array();
	
	function rpcCmd($shell){
		
		if ((get_magic_quotes_gpc() == 1)) {
			if (!empty($_REQUEST)) {
				rpcCmd::stripSlashes($_REQUEST);
			}
		}
		
		$this->startSession();
		
		$this->checkSession();
		
		$this->checkParameters();
		
		if (sizeof($this->Permissions)) {
			
			foreach ($this->Permissions as $perm) {
				if (!we_hasPerm($perm)) {
					$this->Status = RPC_STATUS_NO_PERMISSION;
				}
			}
			
		}
		
		$this->CmdShell = $shell;
	
	}
	
	
	function stripSlashes(&$arr){
		foreach ($arr as $n=>$v) {
			if (is_array($v)) {
				rpcCmd::stripSlashes($arr[$n]);
			} else {
				$arr[$n] = stripslashes($v);
			}
		}
	}

	function execute() {
		
		return new rpcResponse();
	}

	function checkSession() {

		if(!isset($_SESSION['user']['ID'])) {
			
			$this->Status = RPC_STATUS_NO_SESSION;
			return false;
			
		}
		
		if(empty($_SESSION['user']['ID'])) {
		 	$this->Status = RPC_STATUS_NO_SESSION;
			return false;
			
		}
		 
		return true;
		
	}

	function startSession() {
		
		if (isset($_REQUEST["weSessionId"])) {
			session_id($_REQUEST["weSessionId"]);
		}
		@session_start();
	}
	
	function checkParameters() {

		$_count = sizeof($this->Parameters);
				
		for($i=0;$i<$_count;$i++){
			
			if(!isset($_REQUEST[$this->Parameters[$i]])) {
				$this->Status = RPC_STATUS_REQUEST_MALFORMED;
				return false;
			}
			
		}
		return true;
		
	}
	

}

?>