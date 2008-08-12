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
 * @version    $Id: Label.php,v 1.1 2008/05/14 13:41:29 thomas.kneip Exp $
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
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
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
	 * Sets object propeties if set in $properties array
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