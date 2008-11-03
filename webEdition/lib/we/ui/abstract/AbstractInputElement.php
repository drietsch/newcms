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
 * @subpackage we_ui_abstract
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_abstract_AbstractFormElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractFormElement');

/**
 * Base class for input elements
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_abstract
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
abstract class we_ui_abstract_AbstractInputElement extends we_ui_abstract_AbstractFormElement
{

	/**
	 * value attribute
	 *
	 * @var string
	 */
	protected $_value = '';

	/**
	 * type attribute
	 *
	 * @var string
	 */
	protected $_type = '';

	/**
	 * readonly attribute
	 *
	 * @var string
	 */
	protected $_readonly = false;

	/**
	 * Retrieve readonly attribute
	 *
	 * @return boolean
	 */
	public function getReadonly()
	{
		return $this->_readonly;
	}

	/**
	 * Retrieve type attribute
	 *
	 * @return string
	 */
	public function getType()
	{
		return $this->_type;
	}

	/**
	 * Retrieve value attribute
	 *
	 * @return string
	 */
	public function getValue()
	{
		return $this->_value;
	}

	/**
	 * Set readonly attribute
	 * 
	 * @param boolean $readonly
	 * @return void
	 */
	public function setReadonly($readonly)
	{
		$this->_readonly = $readonly;
	}

	/**
	 * Set type attribute
	 * 
	 * @param string $type
	 * @return void
	 */
	public function setType($type)
	{
		$this->_type = $type;
	}

	/**
	 * Set value attribute
	 * 
	 * @param string $value
	 * @return void
	 */
	public function setValue($value)
	{
		$this->_value = $value;
	}
}
