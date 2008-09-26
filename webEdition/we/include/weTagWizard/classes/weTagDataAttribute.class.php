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

class weTagDataAttribute
{

	/**
	 * @var string
	 */
	var $Id;

	/**
	 * @var string
	 */
	var $Name;

	/**
	 * @var boolean
	 */
	var $Required;

	/**
	 * @var string
	 */
	var $Module;

	/**
	 * @var string
	 */
	var $Value;

	/**
	 * @param string $name
	 * @param boolean $required
	 * @param string $module
	 */
	function weTagDataAttribute($id, $name, $required, $module = '')
	{
		
		$this->Id = $id;
		$this->Name = $name;
		$this->Required = $required;
		$this->Module = $module;
		// set value occasionally
		$this->Value = (isset($_REQUEST['attributes']) && isset($_REQUEST['attributes'][$name])) ? $_REQUEST['attributes'][$name] : false;
	}

	/**
	 * @return string
	 */
	function getLabelCodeForTagWizard()
	{
		
		return we_htmlElement::htmlLabel(
				array(
					
						'id' => 'label_' . $this->getIdName(), 
						'class' => 'defaultfont', 
						'for' => $this->getIdName()
				), 
				$this->Name . ($this->Required ? '*' : ''));
	}

	/**
	 * @return string
	 */
	function getName()
	{
		return $this->Name;
	}

	/**
	 * @return string
	 */
	function getIdName()
	{
		return 'id' . $this->Id . '_' . $this->Name;
	}

	/**
	 * @return boolean
	 */
	function IsRequired()
	{
		return $this->Required;
	}

	/**
	 * checks if this attribute should be used, checks if needed modules are installed
	 * @return boolean
	 */
	function useAttribute()
	{
		if ($this->Module == '' || in_array($this->Module, $GLOBALS['_we_active_modules'])) {
			return true;
		}
		return false;
	}

	/**
	 * checks if this option should be used, checks if needed modules are installed
	 * @return boolean
	 */
	function getUseOptions($options)
	{
		
		$useOptions = array();
		foreach ($options as $option) {
			if ($option->useOption()) {
				$useOptions[] = $option;
			}
		}
		return $useOptions;
	}
}
?>