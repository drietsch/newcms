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
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * @see we_ui_layout_HTMLPage
 */
Zend_Loader::loadClass('we_ui_layout_HTMLPage');

/**
 * Basic Class for Home Page View of App
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_app_HomePage extends we_ui_layout_HTMLPage
{

	/*
	 * class for the BoxHeader
	 * @var string
	 */
	const kClassBoxHeader = 'we_app_HomePageBoxHeader';

	/*
	 * class for the BoxBody
	 * @var string
	 */
	const kClassBoxBody = 'we_app_HomePageBoxBody';

	/*
	 * class for the BoxFooter
	 * @var string
	 */
	const kClassBoxFooter = 'we_app_HomePageBoxFooter';

	/*
	 * frames
	 */
	protected $_frames;

	/*
	 * title
	 * @var string
	 */
	protected $_title = '';

	/*
	 * height of the box
	 * @var integer
	 */
	protected $_boxHeight = 220;

	/**
	 * Constructor
	 *
	 * @param array $properties
	 * @return void
	 */
	function __construct($properties = null)
	{
		parent::__construct($properties);
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
	}

	/**
	 * add HTML to home page before it will be rendered
	 *
	 * @return void
	 */
	protected function _willRenderHTML()
	{
		parent::_willRenderHTML();
		
		$translate = we_core_Local::addTranslation('apps.xml');
		we_core_Local::addTranslation('default.xml', 'toolfactory');
		
		$appName = Zend_Controller_Front::getInstance()->getParam('appName');
		we_core_Local::addTranslation('default.xml', $appName);
		
		$mainDiv = new we_ui_layout_Div(array('width' => 250, 'height' => $this->_boxHeight, 'top' => 30, 'left' => 40, 'position' => 'absolute'));
		
		$headerDiv = new we_ui_layout_Div(array('width' => 250, 'height' => 20, 'top' => 0, 'left' => 0, 'position' => 'absolute', 'class' => self::kClassBoxHeader));
		
		if ($this->_title === '') {
			$this->_title = $translate->_($appName);
		}
		
		$headerDiv->addHTML(we_util_Strings::shortenPath(htmlspecialchars($this->_title), 30));
		
		$bodyDiv = $this->_getBodyDiv();
		
		$footerDiv = new we_ui_layout_Div(array('width' => 250, 'height' => 18, 'top' => $this->_boxHeight - 18, 'left' => 0, 'position' => 'absolute', 'class' => self::kClassBoxFooter));
		
		$mainDiv->addElement($headerDiv);
		$mainDiv->addElement($bodyDiv);
		$mainDiv->addElement($footerDiv);
		
		$this->addElement($mainDiv);
		
		$this->addHTML($this->_getApplicationImage());
	
	}

	/**
	 * Returns string with HTML of the body div
	 *
	 * @return string
	 */
	protected function _getBodyDiv()
	{
		
		$translate = we_core_Local::addTranslation('apps.xml');
		
		$appName = Zend_Controller_Front::getInstance()->getParam('appName');
		
		$bodyDiv = new we_ui_layout_Div(array('width' => 206, 'height' => $this->_boxHeight - (38 + 22), 'top' => 20, 'left' => 0, 'position' => 'absolute', 'class' => self::kClassBoxBody));
		
		$perm = 'NEW_APP_' . strtoupper($appName);
		
		$newItemButton = new we_ui_controls_Button(array('text' => $translate->_('New Entry'), 'onClick' => 'weCmdController.fire({cmdName: "app_' . $appName . '_new"})', 'type' => 'onClick', 'disabled' => we_core_Permissions::hasPerm($perm) ? false : true, 'width' => 200));
		$bodyDiv->addElement($newItemButton);
		
		$newFolderButton = new we_ui_controls_Button(array('text' => $translate->_('New Folder'), 'onClick' => 'weCmdController.fire({cmdName: "app_' . $appName . '_new_folder"})', 'type' => 'onClick', 'width' => 200, 'disabled' => we_core_Permissions::hasPerm($perm) ? false : true, 'style' => 'margin:10px 0 0 0;'));
		$bodyDiv->addElement($newFolderButton);
		
		return $bodyDiv;
	}

	/**
	 * Returns string with the img-tag of the application image
	 *
	 * @return string
	 */
	protected function _getApplicationImage()
	{
		return '<img style="top:160px;left:286px;position: absolute;" src="' . Zend_Controller_Front::getInstance()->getParam('appDir') . '/resources/images/home.gif' . '"/>';
	}
}

?>
