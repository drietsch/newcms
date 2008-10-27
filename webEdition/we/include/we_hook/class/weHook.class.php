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
	
	protected $_hookObj;
	
	protected $_action;
	
	protected $_appName;
	
		
	function __construct($obj, $action, $appName='') {
		
		$this->_hookObj = $obj;
		$this->_action = $action;
		$this->_appName = $appName;

	}
	
	
	function executeHook() {
		
		if(!defined('EXECUTE_HOOKS')) {
			include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/conf/we_conf_global.inc.php");
		}

		if(defined('EXECUTE_HOOKS') && EXECUTE_HOOKS) {
		
			$hookFiles = array();
			$action = $this->_action;
			$obj = $this->_hookObj;
			$appName = $this->_appName;
			
			if($action!='') {
				$hookFiles = $this->getHookFiles($action, $appName);
		
				if(!empty($hookFiles)) {
					foreach($hookFiles as $key=>$val) {
						if($key!='') {
							$functionName = 'weCustomHook_'.$key.'_'.$action;
						}
						else {
							$functionName = 'weCustomHook_'.$action;
						}

						include_once($val);
							
						if(function_exists($functionName)) {
							eval($functionName.'($obj, $appName);');
						}

					}
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
		
		$hookFiles = array();
		
		if($appName!='') {
			$filename = 'weCustomHook_'.$appName.'_' . $action . '.inc.php';
		}
		else {
			$filename = 'weCustomHook_'. $action . '.inc.php';
		}
		
		// look in app folders
		$_apps = weToolLookup::getAllTools(true);
		if(!empty($_apps)) {
			foreach($_apps as $_tool){
				$toolname = isset($_tool['classname']) ? $_tool['classname'] : '';
				if($toolname!='') {
					$toolHookFile = $_SERVER['DOCUMENT_ROOT'].'/webEdition/apps/'.$toolname.'/hook/custom_hooks/'.$filename;
					if(file_exists($toolHookFile) && is_readable($toolHookFile)) {
						$hookFiles[$toolname] = $toolHookFile;
					}
				}
			}
		}	
		// look in we_hook/custom_hooks folder
		$weHookFile = $_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_hook/custom_hooks/'.$filename;
		if(file_exists($weHookFile) && is_readable($weHookFile)) {
			$hookFiles[] = $weHookFile;
		}
		
		return $hookFiles;
	}
	
	function __destruct() {
		
		unset($this);
		
	}

}

?>