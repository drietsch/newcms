<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 * @version    $Id: HomePage.php,v 1.10 2008/07/25 14:36:25 thomas.kneip Exp $
 */

/**
 * @see we_ui_abstract_AbstractElement
 */
Zend_Loader::loadClass('we_ui_layout_HTMLPage');

/**
 * Basic Class for Home Page View of App
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_HomePage extends we_ui_layout_HTMLPage
{

	const kClassBoxHeader = 'we_app_HomePageBoxHeader';
	const kClassBoxBody = 'we_app_HomePageBoxBody';
	const kClassBoxFooter = 'we_app_HomePageBoxFooter';
	
	protected $_frames;
	
	protected $_title = '';  
	
	protected $_boxHeight = 220;

	
	function __construct($properties = null)
	{
		parent::__construct($properties);
		$this->addCSSFile(we_ui_layout_Themes::computeCSSURL(__CLASS__));
	}
	
	protected function _willRenderHTML()
	{
		parent::_willRenderHTML();
		
		$translate = we_core_Local::addTranslation('apps.xml');
		we_core_Local::addTranslation('default.xml', 'toolfactory');
		
		$appName = Zend_Controller_Front::getInstance()->getParam('appName');
		we_core_Local::addTranslation('default.xml', $appName);
				
		$mainDiv = new we_ui_layout_Div(array(
			'width'=>250,
			'height'=>$this->_boxHeight,
			'top' => 30,
			'left' => 40,
			'position' => 'absolute'
		));
		
		$headerDiv = new we_ui_layout_Div(array(
			'width'=>250,
			'height'=>20,
			'top'=>0,
			'left'=>0,
			'position' => 'absolute',
			'class' => self::kClassBoxHeader
		));
		
		if ($this->_title === '') {
			$this->_title = $translate->_($appName);
		}


		$headerDiv->addHTML(we_util_Strings::shortenPath(htmlspecialchars($this->_title), 30));
		
		$bodyDiv = $this->_getBodyDiv();
		
		
		$footerDiv = new we_ui_layout_Div(array(
			'width'=>250,
			'height'=>18,
			'top'=>$this->_boxHeight-18,
			'left'=>0,
			'position'=>'absolute',
			'class' => self::kClassBoxFooter
		));
		
		$mainDiv->addElement($headerDiv);
		$mainDiv->addElement($bodyDiv);
		$mainDiv->addElement($footerDiv);
		
		$this->addElement($mainDiv);
		
		$this->addHTML($this->_getApplicationImage());		
		
	}
	
	protected function _getBodyDiv() {
		
		$translate = we_core_Local::addTranslation('apps.xml');
		
		$appName = Zend_Controller_Front::getInstance()->getParam('appName');
		
		$bodyDiv = new we_ui_layout_Div(array(
			'width'=>206,
			'height'=>$this->_boxHeight-(38+22),
			'top'=>20,
			'left'=>0,
			'position'=>'absolute',
			'class' => self::kClassBoxBody
		));
		
		$newItemButton = new we_ui_controls_Button(array(
			'text'=>$translate->_('New Entry'), 
			'onClick'=>'weCmdController.fire({cmdName: "app_'.$appName.'_new"})', 
			'type'=>'onClick', 
			'width'=>200
		));
		$bodyDiv->addElement($newItemButton);
		
		$newFolderButton = new we_ui_controls_Button(array(
			'text'=>$translate->_('New Folder'), 
			'onClick'=>'weCmdController.fire({cmdName: "app_'.$appName.'_new_folder"})',
			'type'=>'onClick', 
			'width'=>200,
			'style'=>'margin:10px 0 0 0;'
		));
		$bodyDiv->addElement($newFolderButton);
		
		return $bodyDiv;
	}
	
	protected function _getApplicationImage() {
		return '<img style="top:160px;left:286px;position: absolute;" src="' . 
			Zend_Controller_Front::getInstance()->getParam('appDir') . 
			'/resources/images/home.gif' . '"/>';
	}
}

?>
