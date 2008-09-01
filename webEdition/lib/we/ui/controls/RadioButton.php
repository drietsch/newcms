<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * @see we_ui_abstract_AbstractInputElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractInputElement');

/**
 * Class to display a RadioButton
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_controls_RadioButton extends we_ui_abstract_AbstractInputElement
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
	 * type attribute => overwritten
	 * @see we_ui_abstract_AbstractInputElement
	 *
	 * @var string
	 */
	protected $_type = 'radio';

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
	 * Renders and returns HTML of Radiobutton
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		$labelHTML = '';
		if ($this->getLabel() !== "") {
			$label = new we_ui_controls_Label(array('text' => '' . $this->getLabel() . '', 'for' => '' . $this->getId() . '', 'id' => 'label_' . $this->getId() . '', 'disabled' => $this->getDisabled(), 'title' => $this->getTitle()));
			$labelHTML = $label->getHTML();
		}
		
		if ($this->getHidden()) {
			$this->_style .= "display:none;";
		}
		$tableId = 'table_' . $this->getId();
		
		return '<table id="' . $tableId . '" ' . $this->_getComputedStyleAttrib() . '><tr><td><input' . $this->_getNonBooleanAttribs('id,name,value,type,title') . $this->_getBooleanAttribs('disabled,checked') . '/></td><td style="padding-top:4px;">' . $labelHTML . '</td></tr></table>';
	}

}