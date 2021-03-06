<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
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
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
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
