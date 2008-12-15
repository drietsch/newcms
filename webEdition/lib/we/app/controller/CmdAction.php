<?php
/**
 * webEdition SDK
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
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/*
 * @see Zend_Controller_Action
 */
Zend_Loader::loadClass('Zend_Controller_Action');

/**
 * Base CmdAction Controller
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_app_controller_CmdAction extends Zend_Controller_Action
{

	/**
	 * The default action - show the home page
	 * @return void
	 */
	public function indexAction()
	{
		echo 'Don\'t call index action directly';
	}

	/**
	 * The menu action - show the menu
	 * @return void
	 */
	public function menuAction()
	{
		$appName = $this->getFrontController()->getParam('appName');
		$this->view = new Zend_View();
		$this->view->cmdName = $this->getRequest()->getParam('name', 'app_' . $appName . '_new');
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('cmd/menu.php');
	}
}