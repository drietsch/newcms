<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

/**
 * @see we_app_HomePage
 */
Zend_Loader::loadClass('we_app_HomePage');

/**
 * Class for Home Page View of toolfactory
 * 
 * @category   toolfactory
 * @package    toolfactory_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class toolfactory_app_HomePage extends we_app_HomePage
{
	/**
	 * Returns string with HTML of the body div
	 *
	 * @return string
	 */
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
		$perm = 'NEW_APP_'.strtoupper($appName);
		$newItemButton = new we_ui_controls_Button(array(
			'text'=>$translate->_('New Entry'), 
			'onClick'=>'weCmdController.fire({cmdName: "app_'.$appName.'_new"})', 
			'type'=>'onClick', 
			'disabled' => we_core_Permissions::hasPerm($perm) ? false : true,
			'width'=>200
		));
		$bodyDiv->addElement($newItemButton);
		
		
		return $bodyDiv;
	}
	
}

?>
