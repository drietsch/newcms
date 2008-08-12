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
 * @version    $Id: FramesetAction.php,v 1.1 2008/07/15 15:03:28 thomas.kneip Exp $
 */

/*
 * @see Zend_Controller_Action
 */
Zend_Loader::loadClass('Zend_Controller_Action');

/**
 * Base Action Controller
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_controller_FramesetAction extends Zend_Controller_Action
{

	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		$this->view = new we_app_TopFrameView();
		$this->view->appDir = $this->getFrontController()->getParam('appDir');
		$this->view->appName = $this->getFrontController()->getParam('appName');
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->tab = $this->getRequest()->getParam('tab', 0);
		$this->view->sid = $this->getRequest()->getParam('sid', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('frameset/index.php');
	}
	
	public function resizeAction()
	{
		$this->view = new Zend_View();		
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->tab = $this->getRequest()->getParam('tab', 0);
		$this->view->sid = $this->getRequest()->getParam('sid', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('frameset/resize.php');
	}
	
	public function leftAction()
	{
		$this->view = new Zend_View();
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('frameset/left.php');
	}
	
	public function rightAction()
	{
		$this->view = new Zend_View();
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->tab = $this->getRequest()->getParam('tab', 0);
		$this->view->sid = $this->getRequest()->getParam('sid', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('frameset/right.php');
	}
	
}