<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_abstract_AbstractFormElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractFormElement');

/**
 * Class which creates a form
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_layout
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_layout_Form extends we_ui_abstract_AbstractFormElement
{

	/*
	 * method attribute of the form
	 *
	 * @var string
	 */
	protected $_method = 'post';

	/*
	 * onsubmit attribute of the form
	 *
	 * @var string
	 */
	protected $_onSubmit = '';

	/*
	 * action attribute of the form
	 *
	 * @var string
	 */
	protected $_action = '';

	protected $_enctype = '';

	/*
	 * string to hold the HTML of the form
	 *
	 * @var string
	 */
	protected $_formHTML = '';

	/**
	 * adds an element to the form.
	 *
	 * @param we_ui_abstract_AbstractElement $elem
	 * @return void
	 */
	public function addElement($elem)
	{
		$this->addCSSFiles($elem->getCSSFiles());
		$this->addJSFiles($elem->getJSFiles());
		$this->_formHTML .= $elem->getHTML();
	}

	/**
	 * adds HTML to the form.
	 *
	 * @param string $html
	 * @return void
	 */
	public function addHTML($html)
	{
		$this->_formHTML .= $html;
	}

	/**
	 * Renders and returns the HTML
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		$attribs = $this->_enctype == "" ? 'id,name,method,onSubmit,action' : 'id,name,method,onSubmit,action,enctype';
		return '<form' . $this->_getNonBooleanAttribs($attribs) . '>' . $this->_formHTML . '</form>';
	}

	/**
	 * Retrieve the action attribute
	 * 
	 * @return string
	 */
	public function getAction()
	{
		return $this->_action;
	}

	/**
	 * Retrieve the method attribute
	 * 
	 * @return string
	 */
	public function getMethod()
	{
		return $this->_method;
	}

	/**
	 * Retrieve the onsubmit attribute
	 * 
	 * @return string
	 */
	public function getOnSubmit()
	{
		return $this->_onSubmit;
	}

	/**
	 * Sets the action attribute
	 * 
	 * @param string $action
	 * @return void
	 */
	public function setAction($action)
	{
		$this->_action = $action;
	}

	/**
	 * Sets the method attribute
	 * 
	 * @param string $method
	 * @return void
	 */
	public function setMethod($method)
	{
		$this->_method = $method;
	}

	/**
	 * Sets the onsubmit attribute
	 * 
	 * @param string $onSubmit
	 * @return void
	 */
	public function setOnSubmit($onSubmit)
	{
		$this->_onSubmit = $onSubmit;
	}

	public function setEnctype($val)
	{
		$this->_enctype = $val;
	}
	
	/**
	 * Returns the HTML for a hidden field
	 * 
	 * @param string $name
	 * @param string $value
	 * @param string $attribs
	 * @return void
	 */
	static function hidden($name, $value, $attribs = null)
	{
		$attributs = "";
		if (isset($attribs) && is_array($attribs)) {
			foreach ($attribs as $key => $val) {
				$attributs .= $key . '="' . htmlspecialchars($val) . '" ';
			}
		}
		return '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" ' . $attributs . ' />';
	}

}
