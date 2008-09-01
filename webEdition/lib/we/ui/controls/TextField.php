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
 * Class to display a text input field
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_ui_controls_TextField extends we_ui_abstract_AbstractInputElement
{

	/**
	 * Default class name for text input fields
	 */
	const kTextInputClassNormal = 'we_ui_controls_TextInput';

	/**
	 * class name for focused text input fields
	 */
	const kTextInputClassFocus = 'we_ui_controls_TextInput_Selected';
	
	protected $_height = 22;

	/**
	 * type attribute => overwritten
	 * @see we_ui_abstract_AbstractInputElement
	 *
	 * @var string
	 */
	protected $_type = 'text';

	/**
	 * maxlength attribute
	 *
	 * @var integer
	 */
	protected $_maxlength = '';

	/**
	 * size attribute
	 *
	 * @var integer
	 */
	protected $_size = '';

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
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/yahoo-min.js');
		$this->addJSFile($GLOBALS['__WE_BASE_URL__'] . '/js/libs/yui/dom-min.js');
		
	}
	
	
	/**
	 * Returns the computed onFocus attrib as text to insert into the HTML tag
	 *
	 * @return string
	 */
	protected function _getComputedOnFocusAttrib()
	{
		$onFocus = 'YAHOO.util.Dom.addClass(this, "' . self::kTextInputClassFocus . '");';
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
		$onBlur = 'YAHOO.util.Dom.removeClass(this, "' . self::kTextInputClassFocus . '");';
		if ($this->getOnBlur() !== '') {
			$onBlur .= $this->getOnBlur();
		}
		return ' onBlur="' . htmlspecialchars($onBlur) . '"';
	}

	/**
	 * Renders and returns HTML of text input
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		
		return '<input' . $this->_getNonBooleanAttribs('id,name,value,maxlength,size,type,onChange,title') .
				$this->_getBooleanAttribs('disabled,readonly') . 
				$this->_getComputedStyleAttrib(array(),-4,-5) . 
				$this->_getComputedClassAttrib(self::kTextInputClassNormal) . 
				$this->_getComputedOnFocusAttrib() . 
				$this->_getComputedOnBlurAttrib() . '/>';
	}

	/**
	 * Retrieve maxlength attribute
	 * 
	 * @return integer
	 */
	public function getMaxlength()
	{
		return $this->_maxlength;
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
	 * Retrieve size attribute
	 * 
	 * @return string
	 */
	public function getSize()
	{
		return $this->_size;
	}

	/**
	 * Set maxlength attribute
	 * 
	 * @param integer $maxlength
	 * @return void
	 */
	public function setMaxlength($maxlength)
	{
		$this->_maxlength = $maxlength;
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
	 * Set size attribute
	 * 
	 * @param string $size
	 * @return void
	 */
	public function setSize($size)
	{
		$this->_size = $size;
	}

}
