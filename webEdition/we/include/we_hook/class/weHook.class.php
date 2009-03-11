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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/tools/weToolLookup.class.php');

/**
 * class to handle hooks in webEdition and in applications
 */
class weHook{
	
	protected $_action;
	
	protected $_appName;
	
	protected $_param;
	
		
	function __construct($action, $appName='', $param=array()) {
		
		$this->_action = $action;
		$this->_appName = $appName;
		$this->_param = $param;

	}
	
	
	function executeHook() {
		
		if(!defined('EXECUTE_HOOKS')) {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php");
		}

		if(defined('EXECUTE_HOOKS') && EXECUTE_HOOKS) {
		
			$hookFile = '';
			$action = $this->_action;
			$param = $this->_param;
			$appName = $this->_appName;
			
			if($action!='') {
				$hookFile = $this->getHookFiles($action, $appName);

				if($appName!='') {
					$functionName = 'weCustomHook_'.$appName.'_'.$action;
				}
				else {
					$functionName = 'weCustomHook_'.$action;
				}

				include_once($hookFile);
					
				if(function_exists($functionName)) {
					eval($functionName.'($param);');
				}
			}
		}
	}
	
	/**
	 * get all custom hook files
	 * 
	 * @param string $action 
	 * @param string $appName 
	 * 
	 * return array
	 */
	function getHookFiles($action, $appName) {
		
		$hookFile = '';

		if($appName!='') {
			$filename = 'weCustomHook_'.$appName.'_' . $action . '.inc.php';
			// look in app folder
			$toolHookFile = $_SERVER['DOCUMENT_ROOT'].'/webEdition/apps/'.$appName.'/hook/custom_hooks/'.$filename;
			if(file_exists($toolHookFile) && is_readable($toolHookFile)) {
		  	$hookFile = $toolHookFile;
			}
		}
		else {
			$filename = 'weCustomHook_'. $action . '.inc.php';
			// look in we_hook/custom_hooks folder
	  		$weHookFile = $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_hook/custom_hooks/'.$filename;
	  		if(file_exists($weHookFile) && is_readable($weHookFile)) {
	  			$hookFile = $weHookFile;
	  		}
		}
		
		return $hookFile;
	}
	
	
	function __destruct() {
		
		unset($this);
		
	}

}

?>