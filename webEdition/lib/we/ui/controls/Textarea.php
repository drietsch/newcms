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
 * Class to display a Textarea
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_controls_Textarea extends we_ui_abstract_AbstractInputElement
{

	/**
	 * Default class name for Textarea
	 */
	const kTextareaClassNormal = 'we_ui_controls_Textarea';

	/**
	 * class name for focused Textarea
	 */
	const kTextareaClassFocus = 'we_ui_controls_Textarea_Selected';

	/**
	 * cols attribute
	 *
	 * @var integer
	 */
	protected $_cols = '';

	/**
	 * rows attribute
	 *
	 * @var integer
	 */
	protected $_rows = '';

	/**
	 * text content of the textarea
	 *
	 * @var string
	 */
	protected $_text = '';

	/**
	 * onChange attribute
	 *
	 * @var string
	 */
	protected $_onChange = '';

	/**
	 * onBlur attribute
	 *
	 * @var string
	 */
	protected $_onBlur = '';

	/**
	 * onFocus attribute
	 *
	 * @var string
	 */
	protected $_onFocus = '';

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
	 * Returns the computed onFocus attrib as text to insert into the HTML tag
	 *
	 * @return string
	 */
	protected function _getComputedOnFocusAttrib()
	{
		$class = self::kTextareaClassFocus;
		if ($this->getClass() !== '') {
			$class .= ' ' . $this->getClass();
		}
		$onFocus = 'this.className="' . $class . '";';
		if ($this->getOnFocus() !== '') {
			$onFocus .= $this->getOnFocus();
		}
		return ' onFocus="' . htmlspecialchars($onFocus) . '"';
	}

	/**
	 * Returns the computed onBlur attrib as text to insert into the HTML tag
	 *
	 * @return string
	 */
	protected function _getComputedOnBlurAttrib()
	{
		$class = self::kTextareaClassNormal;
		if ($this->getClass() !== '') {
			$class .= ' ' . $this->getClass();
		}
		$onBlur = 'this.className="' . $class . '";';
		if ($this->getOnBlur() !== '') {
			$onBlur .= $this->getOnBlur();
		}
		return ' onBlur="' . htmlspecialchars($onBlur) . '"';
	}

	/**
	 * Renders and returns HTML of Textarea
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		return '<textarea' . $this->_getNonBooleanAttribs('id,name,rows,cols,onChange') . $this->_getBooleanAttribs('disabled,readonly') . $this->_getComputedStyleAttrib() . $this->_getComputedClassAttrib(self::kTextareaClassNormal) . $this->_getComputedOnFocusAttrib() . $this->_getComputedOnBlurAttrib() . '>' . $this->getText() . '</textarea>';
	}

	/**
	 * Retrieve onBlur attribute
	 * 
	 * @return string
	 */
	public function getOnBlur()
	{
		return $this->_onBlur;
	}

	/**
	 * Retrieve onFocus attribute
	 * 
	 * @return string
	 */
	public function getOnFocus()
	{
		return $this->_onFocus;
	}

	/**
	 * Retrieve onChange attribute
	 * 
	 * @return string
	 */
	public function getOnChange()
	{
		return $this->_onChange;
	}

	/**
	 * Retrieve cols attribute
	 * 
	 * @return integer
	 */
	public function getCols()
	{
		return $this->_cols;
	}

	/**
	 * Retrieve rows attribute
	 * 
	 * @return integer
	 */
	public function getRows()
	{
		return $this->_rows;
	}

	/**
	 * Retrieve text
	 * 
	 * @return string
	 */
	public function getText()
	{
		return $this->_text;
	}

	/**
	 * Set onBlur attribute
	 * 
	 * @param string $onBlur
	 * @return void
	 */
	public function setOnBlur($onBlur)
	{
		$this->_onBlur = $onBlur;
	}

	/**
	 * Set onFocus attribute
	 * 
	 * @param string $onFocus
	 * @return void
	 */
	public function setOnFocus($onFocus)
	{
		$this->_onFocus = $onFocus;
	}

	/**
	 * Set onChange attribute
	 * 
	 * @param string $onChange
	 * @return void
	 */
	public function setOnChange($onChange)
	{
		$this->_onChange = $onChange;
	}

	/**
	 * Set cols attribute
	 * 
	 * @param integer $cols
	 * @return void
	 */
	public function setCols($cols)
	{
		$this->_cols = $cols;
	}

	/**
	 * Set rows attribute
	 * 
	 * @param integer $rows
	 * @return void
	 */
	public function setRows($rows)
	{
		$this->_rows = $rows;
	}

	/**
	 * Set text attribute
	 * 
	 * @param string $text
	 * @return void
	 */
	public function setText($text)
	{
		$this->_text = $text;
	}

}
