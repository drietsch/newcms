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
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_abstract_AbstractElement');

/**
 * Class to display Tabs
 * 
 * @category   we
 * @package    we_ui
 * @subpackage we_ui_controls
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_ui_controls_Tabs extends we_ui_abstract_AbstractElement
{

	/**
	 * Default class name for tab container
	 */
	const kTabs_ContainerClass = 'we_ui_controls_Tabs_Container';

	/**
	 * Default class name for normal tab
	 */
	const kTabNormal_Class = 'we_ui_controls_Tab_Normal';

	/**
	 * Default class name for active tab
	 */
	const kTabActive_Class = 'we_ui_controls_Tab_Active';

	/**
	 * Default class name for active tab with bottomline
	 */
	const kTabActiveBottomline_Class = 'we_ui_controls_Tab_Active_Bottomline';

	/**
	 * Default class name for disabled tab
	 */
	const kTabDisabled_Class = 'we_ui_controls_Tab_Disabled';

	/**
	 * Default class name for ImageBorder
	 */
	const kTabImageBorder_Class = 'we_ui_controls_Tab_ImageBorder';

	/**
	 * path of close icon
	 */
	const kTabCloseIconPath = '/webEdition/images/multiTabs/close.gif';

	/**
	 * path of mouseOver close icon
	 */
	const kTabCloseIconMouseOverPath = '/webEdition/images/multiTabs/closeOver.gif';

	/**
	 * id attribute
	 *
	 * @var string
	 */
	protected $_id = 'we_ui_controls_Tabs_Container';

	/**
	 * tabs in tabContainer
	 *
	 * @var array
	 */
	protected $_tabs = array();

	/**
	 * name of the frame where the content is displayed
	 *
	 * @var string
	 */
	protected $_contentFrame = '';

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
	 * Retrieve tabs
	 * 
	 * @return array
	 */
	public function getTabs()
	{
		return $this->_tabs;
	}

	/**
	 * Set tabs
	 * 
	 * @param array $_tabs
	 */
	public function setTabs($_tabs)
	{
		$this->_tabs = $_tabs;
	}

	/**
	 * Retrieve content frame
	 * 
	 * @return string
	 */
	public function getContentFrame()
	{
		return $this->_contentFrame;
	}

	/**
	 * Set content Frame
	 * 
	 * @param string $_contentFrame
	 */
	public function setContentFrame($_contentFrame)
	{
		$this->_contentFrame = $_contentFrame;
	}

	/**
	 * Retrieve tab attributes
	 * 
	 * @param array of tab $_tabArray, string $_att
	 * 
	 * @return string
	 */
	protected function getTabAttribute($_tabArray, $_att)
	{
		switch ($_att) {
			case "id" :
				if (isset($_tabArray["id"]) && $_tabArray["id"] != "") {
					return $_tabArray["id"];
				} else {
					return "";
				}
				break;
			case "active" :
				if (isset($_tabArray["active"])) {
					return $_tabArray["active"];
				}
				break;
			case "text" :
				if (isset($_tabArray["text"])) {
					return $_tabArray["text"];
				} else {
					return '';
				}
				break;
			case "title" :
				if (isset($_tabArray["title"])) {
					return $_tabArray["title"];
				} else {
					return '';
				}
				break;
			case "hidden" :
				if (isset($_tabArray["hidden"])) {
					return $_tabArray["hidden"];
				}
				break;
			case "disabled" :
				if (isset($_tabArray["disabled"])) {
					return $_tabArray["disabled"];
				}
				break;
			case "onClick" :
				if (isset($_tabArray["onClick"])) {
					return $_tabArray["onClick"];
				} else {
					return '';
				}
				break;
			case "bottomline" :
				if (isset($_tabArray["bottomline"])) {
					return $_tabArray["bottomline"];
				}
				break;
			case "close" :
				if (isset($_tabArray["close"])) {
					return $_tabArray["close"];
				}
				break;
			case "icon" :
				if (isset($_tabArray["icon"])) {
					return $_tabArray["icon"];
				}
				break;
			case "onCloseClick" :
				if (isset($_tabArray["onCloseClick"])) {
					return $_tabArray["onCloseClick"];
				} else {
					return '';
				}
				break;
			case "reload" :
				if (isset($_tabArray["reload"])) {
					return $_tabArray["reload"];
				} else {
					return false;
				}
				break;
		}
		
		return "";
	}

	/**
	 * Retrieve tab image border
	 * 
	 * @return string
	 */
	protected function getTabImageBorder()
	{
		return '<img src="/webEdition/images/multiTabs/tabBorder.gif" border="0" ' . $this->_getComputedClassAttrib(self::kTabImageBorder_Class) . ' height="21" />';
	}

	/**
	 * Retrieve tabs HTML
	 * 
	 * @return string
	 */
	public function getTabsHTML()
	{
		$out = '';
		$tabs = $this->getTabs();
		if (is_array($tabs) && !empty($tabs)) {
			foreach ($tabs as $k => $v) {
				if ($this->getTabAttribute($v, 'id') !== "") {
					$id = $this->getTabAttribute($v, 'id');
				}
				$class = self::kTabNormal_Class;
				$onClick = '';
				if ($this->getTabAttribute($v, 'onClick')) {
					$onClick .= htmlentities($this->getTabAttribute($v, 'onClick'));
				}
				$submit = '';
				if ($this->getTabAttribute($v, 'reload')) {
					$submit = $this->getContentFrame() . 'submitForm();';
				}
				$onClick .= 'if ( we_ui_controls_Tabs.allowed_change_edit_page() ){ we_ui_controls_Tabs.setTabClass(\'' . $this->getId() . '\',this); we_ui_controls_Tabs.setTab(\'' . $this->getId() . '\',\'' . $id . '\',\'' . $this->getContentFrame() . '\');' . $submit . '}';
				if ($this->getTabAttribute($v, 'active')) {
					$class = self::kTabActive_Class;
					if ($this->getTabAttribute($v, 'bottomline')) {
						$class = self::kTabActiveBottomline_Class;
					}
				}
				if ($this->getTabAttribute($v, 'disabled')) {
					$class = self::kTabDisabled_Class;
					$onClick = 'return false;';
				}
				$hiddenStyle = '';
				if ($this->getTabAttribute($v, 'hidden')) {
					$hiddenStyle = 'style="display:none;"';
				}
				$out .= '<div ' . $hiddenStyle . ' title="' . $this->getTabAttribute($v, 'title') . '" id="Tabs_' . $id . '" onclick="' . $onClick . '" ' . $this->_getComputedClassAttrib($class) . '>';
				$out .= '<table border="0" height="100%" cellspacing="0" cellpadding="0"><tr><td>';
				$out .= ($this->getTabAttribute($v, 'icon') !== '') ? '<img style="width:16px;height:16px;padding-right:5px;" src="' . $this->getTabAttribute($v, 'icon') . '" border="0" /></td><td>' : '';
				$out .= $this->getTabAttribute($v, 'text');
				$out .= '</td>';
				$out .= ($this->getTabAttribute($v, 'close') !== '') ? '<td><img style="width:16px;height:16px;padding-left:5px;" src="' . self::kTabCloseIconPath . '" border="0" onMouseOut="this.src=\'' . self::kTabCloseIconPath . '\'" onClick="' . htmlentities($this->getTabAttribute($v, 'onCloseClick')) . 'we_ui_controls_Tabs.close(\'' . $this->getId() . '\',\'' . $id . '\');" onMouseOver="this.src=\'' . self::kTabCloseIconMouseOverPath . '\'" /></td>' : '';
				$out .= '</tr></table>';
				$out .= $this->getTabImageBorder();
				$out .= '</div>';
			}
		}
		return $out;
	}

	/**
	 * Renders and returns HTML of Tabs
	 *
	 * @return string
	 */
	protected function _renderHTML()
	{
		if ($this->getHidden()) {
			$this->_style .= 'display:none;';
		}
		
		return '<div' . $this->_getComputedClassAttrib(self::kTabs_ContainerClass) . $this->_getComputedStyleAttrib() . $this->_getNonBooleanAttribs('id') . '>' . $this->getTabsHTML() . '</div><div style="clear:left;"></div>';
	}
}