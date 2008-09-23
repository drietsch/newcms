<?php
/**
 * webEdition SDK
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_app
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/*
 * @see Zend_Controller_Action
 */
Zend_Loader::loadClass('Zend_Controller_Action');

/**
 * Base HeaderAction Controller
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_controller_HeaderAction extends Zend_Controller_Action
{

	/**
	 * The default action - show the home page
	 * @return void
	 */
	public function indexAction()
	{
		$this->view = new Zend_View();
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('header/index.php');
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