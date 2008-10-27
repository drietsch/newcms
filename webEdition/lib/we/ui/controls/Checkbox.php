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
 * @see we_ui_abstract_AbstractInputElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractInputElement');

/**
 * Class to display a checkbox
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_controls_Checkbox extends we_ui_abstract_AbstractInputElement
{

	/**
	 * checked attribute
	 *
	 * @var boolean
	 */
	protected $_checked = false;

	/**
	 * label text
	 *
	 * @var string
	 */
	protected $_label = '';

	/**
	 * onClick attribute
	 *
	 * @var string
	 */
	protected $_onClick = '';

	/**
	 * type attribute => overwritten
	 * @see we_ui_abstract_AbstractInputElement
	 *
	 * @var string
	 */
	protected $_type = 'checkbox';

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
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL('we_ui_controls_Label'));
		
		// add needed JS Files
		$this->addJSFile(we_ui_abstract_AbstractElement::computeJSURL(__CLASS__));
		$this->addJSFile(we_ui_abstract_AbstractElement::computeJSURL('we_ui_controls_Label'));
	
	}

	/**
	 * Retrieve label text
	 * 
	 * @return string
	 */
	public function getLabel()
	{
		return $this->_label;
	}

	/**
	 * Set label text
	 * 
	 * @param string $_label
	 */
	public function setLabel($_label)
	{
		$this->_label = $_label;
	}

	/**
	 * Retrieve onClick attribute
	 * 
	 * @return string
	 */
	public function getOnClick()
	{
		return $this->_onClick;
	}

	/**
	 * Set onClick attribute
	 * 
	 * @param string $_onClick
	 */
	public function setOnClick($_onClick)
	{
		$this->_onClick = $_onClick;
	}

	/**
	 * Retrieve checked attribute
	 * 
	 * @return boolean
	 */
	public function getChecked()
	{
		return $this->_checked;
	}

	/**
	 * Set checked attribute
	 * 
	 * @param boolean $_checked
	 */
	public function setChecked($_checked)
	{
		$this->_checked = $_checked;
	}

	/**
	 * Renders and returns HTML of Checkbox
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		$labelHTML = '';
		$tableId = 'table_' . $this->getId();
		$checkBoxName = "_" . $this->getName();
		$checkBoxId = "_" . $this->getId();
		
		if ($this->getLabel() !== '') {
			$label = new we_ui_controls_Label(array('text' => '' . $this->getLabel() . '', 'for' => '' . $checkBoxId . '', 'id' => 'label_' . $this->getId() . '', 'disabled' => $this->getDisabled(), 'title' => $this->getTitle()));
			$labelHTML = $label->getHTML();
		}
		
		if ($this->getHidden()) {
			$this->_style .= 'display:none;';
		}
		
		$this->_onClick .= ';this.form.elements[\'' . $this->getName() . '\'].value=this.checked ? 1 : 0;';
		
		return '<table id="' . $tableId . '" ' . $this->_getComputedStyleAttrib() . '><tr><td><input type="hidden" id="' . $this->getId() . '" name="' . $this->getName() . '" value="' . ($this->getChecked() ? 1 : 0) . '" /><input id="' . $checkBoxId . '" name="' . $checkBoxName . '" ' . $this->_getNonBooleanAttribs('type,title,onClick') . $this->_getBooleanAttribs('disabled,checked') . '/></td><td style="padding-top:2px;">' . $labelHTML . '</td></tr></table>';
	}

}