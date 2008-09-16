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
 * Base TreeAction Controller
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_controller_TreeAction extends Zend_Controller_Action
{

	/**
	 * The default action - show the tree page
	 * @return void
	 */
	public function indexAction()
	{
		$this->view = new Zend_View();
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('tree/index.php');
	}
}