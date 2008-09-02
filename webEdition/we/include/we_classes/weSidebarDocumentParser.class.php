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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/JSON.php");


class weSidebarDocumentParser {
	
	function parseCode($srcCode, $linkPrefix = "") {
				
		// matches[0] -> all js commands including all parameters
		// matches[1] -> all javascript function calls
		// matches[2] -> all parameters as json object
		preg_match_all("/top.weSidebar.(.*[a-zA-Z])\((.*)\);/", $srcCode, $matches);
		
		$json = new Services_JSON();
		
		if($linkPrefix == "/") {
			$linkPrefix = "";
			
		}
		
		foreach($matches[0] as $index => $command) {
			$function = $matches[1][$index];
			$parameters = $json->decode($matches[2][$index]);
			
			$call = "parseFor_" . $function;
			
			if(method_exists($this, $call)) {
				$this->$call($parameters, $linkPrefix);
			
			}
				
			$changedParameters = $json->encode($parameters);

			// remove not needed backslashes, change " to '
			$changedParameters = str_replace(array('"', '\/'), array("'", "/"), $changedParameters);
			
			$changedJSCommand = str_replace($matches[2][$index], $changedParameters, $matches[0][$index]);
			
			$srcCode = str_replace($matches[0][$index], $changedJSCommand, $srcCode);
			
		}
		
		return $srcCode;
		
	}
	
	
	function parseFor_openUrl(&$parameters, $linkPrefix) {
		
		return $linkPrefix . $parameters;
		
	}
	
	
	function parseFor_openDocument(&$parameters, $linkPrefix) {

		// get the id
		if(isset($parameters->id)) {
			$parameters->id = path_to_id($linkPrefix . $parameters->id, FILE_TABLE);
			
		}

		// get the doctype
		if(isset($parameters->dt)) {
			$db = new DB_WE();
			if ($parameters->dt == "/") {
				return 0;
			}
			$parameters->dt = abs(f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType='" . $parameters->dt . "'","ID",$db));
			
		}
		return $parameters;
		
	}
	
	
	function parseFor_openTemplate(&$parameters, $linkPrefix) {

		// get the id
		if(isset($parameters->id)) {
			$parameters->id = path_to_id($linkPrefix . $parameters->id, TEMPLATES_TABLE);
			
		}

		// get the doctype
		if(isset($parameters->dt)) {
			$db = new DB_WE();
			if ($parameters->dt == "/") {
				return 0;
			}
			$parameters->dt = abs(f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType='" . $parameters->dt . "'","ID",$db));
			
		}
		
		return $parameters;
		
	}
	
	
	function parseFor_openObject(&$parameters, $linkPrefix) {

		// get the id
		if(isset($parameters->id)) {
			$parameters->id = path_to_id($linkPrefix . $parameters->id, OBJECT_FILES_TABLE);
			
		}

		// get the doctype
		if(isset($parameters->dt)) {
			$db = new DB_WE();
			if ($parameters->dt == "/") {
				return 0;
			}
			$parameters->dt = abs(f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType='" . $parameters->dt . "'","ID",$db));
			
		}
		
		return $parameters;
		
	}
	
	
	function parseFor_openClass(&$parameters, $linkPrefix) {

		// get the id
		if(isset($parameters->id)) {
			$parameters->id = path_to_id($linkPrefix . $parameters->id, OBJECT_TABLE);
			
		}

		// get the doctype
		if(isset($parameters->dt)) {
			$db = new DB_WE();
			if ($parameters->dt == "/") {
				return 0;
			}
			$parameters->dt = abs(f("SELECT ID FROM " . DOC_TYPES_TABLE . " WHERE DocType='" . $parameters->dt . "'","ID",$db));
			
		}
		
		return $parameters;
		
	}
	
}
	
?>