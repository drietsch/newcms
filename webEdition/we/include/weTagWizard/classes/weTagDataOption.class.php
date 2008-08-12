<?php

class weTagDataOption {
	
	/**
	 * @var string
	 */
	var $Name;
	/**
	 * value of this option, if differs from $Name
	 * @var string
	 */
	var $Value;
	/**
	 * all allowed attributes, when selecting this option
	 * @var array
	 */
	var $AllowedAttributes;
	/**
	 * required attributes, when selecting this option
	 * @var array
	 */
	var $RequiredAttributes;
	/**
	 * @var string
	 */
	var $Module;
	/**
	 * @param string $name
	 * @param mixed $value
	 * @param array $allowedAttributes
	 * @param array $requiredAttributes
	 */
	function weTagDataOption($name, $value=false, $module='', $allowedAttributes=array(), $requiredAttributes=array()) {
		
		$this->Name = $name;
		
		if ($value === false) {
			$this->Value = $name;
		} else {
			$this->Value = $value;
		}
		
		// clean allowed and required attributes in case not all modules are installed
		$this->AllowedAttributes = $allowedAttributes;
		$this->RequiredAttributes = $requiredAttributes;
		$this->Module = $module;
	}
	
	/**
	 * @return array
	 */
	function getAssoziation() {
		return array("$this->Value" => "$this->Name");
	}
	
	/**
	 * @return string
	 */
	function getName() {
		return $this->Name;
	}
	
	/**
	 * @return array
	 */
	function getAllowedAttributes($tagAttributes=array()) {
		
		$arr = array();
		foreach ($this->AllowedAttributes as $attribute) {
			if (in_array($attribute, $tagAttributes)) {
				$arr[] = $attribute;
			}
		}
		return $arr;
	}
	
	/**
	 * @return array
	 */
	function getRequiredAttributes($tagAttributes=array()) {
		
		$arr = array();
		foreach ($this->RequiredAttributes as $attribute) {
			if (in_array($attribute, $tagAttributes)) {
				$arr[] = $attribute;
			}
		}
		return $arr;
	}
	
	/**
	 * checks if this attribute should be used, checks if needed modules are installed
	 * @return boolean
	 */
	function useOption() {
		
		if ($this->Module == '' || in_array($this->Module, $GLOBALS['_we_active_modules'])) {
			return true;
		}
		return false;
	}
}
?>