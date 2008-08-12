<?php

/**
 * FramesetController
 * 
 * @author
 * @version 
 */

Zend_Loader::loadClass('we_app_controller_FramesetAction');

class FramesetController extends we_app_controller_FramesetAction
{

	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		$this->view = new toolfactory_views_TopFrameView();
		$this->view->appDir = $this->getFrontController()->getParam('appDir');
		$this->view->appName = $this->getFrontController()->getParam('appName');
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->tab = $this->getRequest()->getParam('tab', 0);
		$this->view->sid = $this->getRequest()->getParam('sid', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('frameset/index.php');
	}

}