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
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_abstract_AbstractFormElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractFormElement');

/**
 * Class to display a Label
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_controls_Label extends we_ui_abstract_AbstractFormElement
{

	/**
	 * Default class name for label
	 */
	const kLabelClass = 'we_ui_controls_Label';

	/**
	 * class name for disabled label
	 */
	const kLabelClassDisabled = 'we_ui_controls_Label_disabled';

	/**
	 * for attribute
	 *
	 * @var string
	 */
	protected $_for = '';

	/**
	 * text of label
	 *
	 * @var string
	 */
	protected $_text = '';

	/**
	 * Constructor
	 * 
	 * Sets object properties if set in $properties array
	 * 
	 * @param array $properties associative array containing named object properties
	 * @return void
	 */
	public function __construct($properties = null)
	{
		parent::__construct($properties);
		
		// add needed CSS files
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
		
		// add needed JS Files
		$this->addJSFile(we_ui_abstract_AbstractElement::computeJSURL(__CLASS__));
	
	}

	/**
	 * Retrieve for attribute
	 * 
	 * @return boolean
	 */
	public function getFor()
	{
		return $this->_for;
	}

	/**
	 * Set for attribute
	 * 
	 * @param boolean $_for
	 */
	public function setFor($_for)
	{
		$this->_for = $_for;
	}

	/**
	 * Retrieve text for label
	 * 
	 * @return boolean
	 */
	public function getText()
	{
		return $this->_text;
	}

	/**
	 * Set text for label
	 * 
	 * @param boolean $_text
	 */
	public function setText($_text)
	{
		$this->_text = $_text;
	}

	/**
	 * Renders and returns HTML of label
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		if ($this->getDisabled()) {
			$class = self::kLabelClassDisabled;
		} else {
			$class = self::kLabelClass;
		}
		
		if ($this->getHidden()) {
			$this->_style .= "display:none;";
		}
		
		return '<label' . $this->_getComputedStyleAttrib() . $this->_getComputedClassAttrib($class) . $this->_getNonBooleanAttribs('id,for,title') . '>' . $this->getText() . '</label>';
	}

}

?>