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
 * Class to display a Select
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_controls_Select extends we_ui_abstract_AbstractFormElement
{

	/**
	 * Default class name for Select
	 */
	const kSelectClass = 'we_ui_controls_Select';

	/**
	 * class name for disabled Select
	 */
	const kSelectClassDisabled = 'we_ui_controls_Select_disabled';

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
	 * options of select
	 *
	 * @var array
	 */
	protected $_options = array();
	
	/**
	 * option groups of select
	 *
	 * @var array
	 */
	protected $_optgroups = array();

	/**
	 * selected value of select
	 *
	 * @var string
	 */
	protected $_selectedValue = '';

	/**
	 * multiple attribute
	 *
	 * @var boolean
	 */
	protected $_multiple = '';
	
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
	 * Retrieve onChange attribute
	 * 
	 * @return string
	 */
	public function getOnChange()
	{
		return $this->_onChange;
	}

	/**
	 * Set onChange attribute
	 * 
	 * @param string $_onChange
	 */
	public function setOnChange($_onChange)
	{
		$this->_onChange = $_onChange;
	}

	/**
	 * Retrieve size attribute
	 * 
	 * @return integer
	 */
	public function getSize()
	{
		return $this->_size;
	}

	/**
	 * Set size attribute
	 * 
	 * @param integer $_size
	 */
	public function setSize($_size)
	{
		$this->_size = $_size;
	}

	/**
	 * Retrieve multiple attribute
	 * 
	 * @return boolean
	 */
	public function getMultiple()
	{
		return $this->_multiple;
	}

	/**
	 * Set multiple attribute
	 * 
	 * @param boolean $_multiple
	 */
	public function setMultiple($_multiple)
	{
		$this->_multiple = $_multiple;
	}

	/**
	 * Retrieve selected value
	 * 
	 * @return string
	 */
	public function getSelectedValue()
	{
		return $this->_selectedValue;
	}

	/**
	 * Set selected value
	 * 
	 * @param string $_selectedValue
	 */
	public function setSelectedValue($_selectedValue)
	{
		$this->_selectedValue = $_selectedValue;
	}

	/**
	 * Retrieve options of select
	 * 
	 * @return array
	 */
	public function getOptions()
	{
		return $this->_options;
	}

	/**
	 * Set options of select
	 * 
	 * @param array $_options
	 */
	public function setOptions($_options)
	{
		$this->_options = $_options;
	}
	
	/**
	 * Retrieve option groups of select
	 * 
	 * @return array
	 */
	public function getOptGroups()
	{
		return $this->_optgroups;
	}

	/**
	 * Set option groups of select
	 * 
	 * @param array $_optgroups
	 */
	public function setOptGroups($_optgroups)
	{
		$this->_optgroups = $_optgroups;
	}

	/**
	 * The function returns number of options
	 *
	 * @return int
	 */
	function getOptionNum()
	{
		return count($this->getOptions());
	}

	/**
	 * The function add new option to a select box
	 *
	 * @param string $value									
	 * @param string	$text									
	 *
	 * @return void
	 */
	function addOption($value, $text)
	{
		$this->_options[$value] = $text;
	}

	/**
	 * The function adds one or more options to a select box
	 *
	 * @param array $options
	 *
	 * @return void
	 */
	function addOptions($options)
	{
		
		if (!empty($options)) {
			$count = count($options);
			foreach ($options as $key => $val) {
				$this->addOption($key, $val);
			}
		}
	}

	/**
	 * Renders and returns HTML of options
	 * 
	 * @return string
	 */
	public function getOptionsHTML()
	{
		
		$out = '';
		$options = $this->getOptions();
		if (!empty($options)) {
			foreach ($options as $key => $val) {
				$selected = '';
				if ($this->getSelectedValue() == $key) {
					$selected = 'selected="selected"';
				}
				$out .= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
			}
		}
		$optgroups = $this->getOptGroups();
		if (!empty($optgroups)) {
			foreach ($optgroups as $k => $v) {
				$label = isset($v['label']) ? $v['label'] : "";
				$out .= '<optgroup label="' . $label . '">';
				if (isset($v['options']) && !empty($v['options'])) {
					foreach ($v['options'] as $key => $val) {
						$selected = '';
						if ($this->getSelectedValue() == $key) {
							$selected = 'selected="selected"';
						}
						$out .= '<option value="' . $key . '" ' . $selected . '>' . $val . '</option>';
					}
				}
				$out .= '</optgroup>';
			}
		}
		
		return $out;
	}

	/**
	 * Renders and returns HTML of select
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		if ($this->getDisabled()) {
			$class = self::kSelectClassDisabled;
		} else {
			$class = self::kSelectClass;
		}
		
		if ($this->getHidden()) {
			$this->_style .= "display:none;";
		}
		
		return '<select' . $this->_getComputedStyleAttrib() . $this->_getComputedClassAttrib($class) . $this->_getNonBooleanAttribs('id,size,name,onChange') . $this->_getBooleanAttribs('disabled,multiple') . '>' . $this->getOptionsHTML() . '</select>';
	}

}