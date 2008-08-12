<?php
//echo ini_get("include_path")."<br />";
ini_set("include_path",ini_get("include_path").":".$_SERVER['DOCUMENT_ROOT']);
//echo ini_get("include_path");

/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: Check.php,v 1.1 2008/05/13 13:41:32 alexander.lindenstruth Exp $
 */

include_once 'webEdition/lib/we/core/autoload.php';
include_once 'webEdition/lib/we/util/Sys.php';

/**
 * Utility class for checking system dependencies using the we_util_Sys_* classes
 * 
 * dependencies can be read from a file (i.e. xml) or defined directly via addDependency().
 * Each dependency must habe the follwing attributes:
 * 		class		dependency class according to the we_util_Sys_* class names, i.e. "Db", "Server_Apache" or "Webedition"
 * 		operation	the method to be calles in these classes, i.e. "version" or "module"
 * 		version		version number for this operation (i.e. used for version checks or webEdition tools)
 * 		property	the value for the operation, i.e. version or module name
 * 		operator	if the operation is a comparison, you can specify an operator like "==", "<=" or "lt"
 * The operations called by check() will always return (bool)true or (bool)false.
 * check() returns (bool)true, if all dependencies are met. Otherwise it will return (bool)false.
 * 
 * example:
 * 		class			operation			property		version		operator
 * 		------------------------------------------------------------------------
 * 		Php				versionCompare						5.1			>=
 * 		Webedition		module				customer
 * 		Webedition		tool				navigation
 * 		Webedition		toolVersionCompare	navigation		1.1			>=
 * 		Server_Apache	version								2.0			>=
 * 		Server_Apache	module				mod_rewrite
 *  
 * @category   we
 * @package    we_util
 * @subpackage we_util_sys
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */

class we_util_Sys_Dependencies extends we_util_Sys
{
	
	private $_dependencies = array();
	
	public function __construct()
	{
		
	}
	
	public function addDependency($class="", $values=array(""))
	{
		if(empty($class) || !isset($values["operation"]) || empty($values["operation"])) {
			return false;
		}
		// set default operator for versionCompare operations:
		if($values["operation"] == "versionCompare" && (!isset($values["operator"]) || empty($values["operator"]))) {
			$values["operator"] = ">=";
		}
		// check if required we_util_Sys class exists:
		if(Zend_Loader::isReadable('webEdition/lib/we/util/Sys/'.str_replace("_","/",$class.".php"))) {
			Zend_Loader::loadClass('we_util_Sys_'.$class);
			// check if the required method exists in this class: 
			$reflectionClass = new ReflectionClass('we_util_Sys_'.$class);
			if(!$reflectionClass->hasMethod($values["operation"])) {
				return false;
			} else {
				// identify the required and optional parameters of this method:
				$reflectionMethod = new ReflectionMethod('we_util_Sys_'.$class, $values["operation"]);
				$reflectionParameters = array();
				foreach($reflectionMethod->getParameters() as $parameter) {
					$reflectionParameters[] = $parameter->name;
				}
				// identify all required parameters specified within the dependency definition 
				$parameters = array();
				foreach($values as $k => $v) {
					if(in_array($k,$reflectionParameters)) {
						$parameters[$k] = (string)$v;
					}
				}
				// discard all unneccesary stuff:
				unset($reflectionParameters,$reflectionMethod,$reflectionClass);
				// check if there is not already a 2nd level array for this dependency class:
				if(!isset($this->_dependencies[$class])) {
					$this->_dependencies[$class] = array();
				}
				$this->_dependencies[$class][$values["operation"]] = $parameters;
			}
		}
		
		
	}
	
	public function check()
	{
		print_r($this->_dependencies);
	}
	
	/**
	 * tries to identify the needed operation parameters so that the methods are being called correctly
	 * (example: a webEdition version check does not need a property, a webEdition tool check has no need for an operator)
	 * this is done using the PHP5 reflection API
	 * 
	 * @see http://php.net/manual/en/language.oop5.reflection.php  
	 *
	 */
	private function _getOperationParameters() {
		
	}
}
$dependencies = new we_util_Sys_Dependencies();
$dependencies->addDependency("Php",array("operation" => "versionCompare","version" => "5.1","operator" => ">="));
$dependencies->addDependency("Webedition",array("operation" => "versionCompare","version" => "5111", "operator" => ">="));
$dependencies->addDependency("Webedition",array("operation" => "module","property" => "newsletter"));
$dependencies->addDependency("Webedition",array("operation" => "toolVersionCompare","property" => "navigation","version" => "5111", "operator" => ">="));
$dependencies->check();
