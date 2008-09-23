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
 * Base EditorAction Controller
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_controller_EditorAction extends Zend_Controller_Action
{

	/**
	 * view
	 */
	public $view;

	/**
	 * model
	 */
	protected $_model;

	/**
	 * The default action - show the home page
	 * @return void
	 */
	public function indexAction()
	{
		$this->_setupModel(true);
		if ($this->getRequest()->getParam('folder') == 1) {
			$this->_model->IsFolder = 1;
			$this->_model->ContentType = 'folder';
		}
		$this->_renderDefaultView('editor/index.php');
	}

	/**
	 * The body action - show the body
	 * @return void
	 */
	public function bodyAction()
	{
		$this->_setupModel();
		$this->_processPostVars();
		$this->_renderDefaultView('editor/body.php');
	}

	/**
	 * The header action - show the header
	 */
	public function headerAction()
	{
		$this->_setupModel();
		$this->_renderDefaultView('editor/header.php');
	}

	/**
	 * The footer action - show the footer
	 * @return void
	 */
	public function footerAction()
	{
		$this->_setupModel();
		$this->_renderDefaultView('editor/footer.php');
	}

	/**
	 * The exit doc question action - show the exit doc question
	 * @return void
	 */
	public function exitdocquestionAction()
	{
		$this->view = new Zend_View();
		$this->view->setScriptPath('views/scripts');
		$this->view->cmdstack = $this->getRequest()->getParam('cmdstack');
		echo $this->view->render('editor/exitDocQuestion.php');
	}

	/**
	 * Render Default View - show the default view
	 * @return void
	 */
	protected function _renderDefaultView($viewscript)
	{
		$this->view = new Zend_View();
		$this->_setupParameter();
		$this->_setupParamString();
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render($viewscript);
	}

	/**
	 * setup the parameter string
	 * @return void
	 */
	protected function _setupParamString()
	{
		$this->view->paramString = ((isset($this->view->tab) && $this->view->tab) ? '/tab/' . $this->view->tab : '') . ((isset($this->view->modelId) && $this->view->modelId) ? '/modelId/' . $this->view->modelId : '');
	
	}

	/**
	 * setup parameter
	 * @return void
	 */
	protected function _setupParameter()
	{
		$this->view->tab = $this->getRequest()->getParam('tab', 0);
		$this->view->sid = $this->getRequest()->getParam('sid', '');
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->model = $this->_model;
	}

	/**
	 * process POST variables
	 * @return void
	 */
	protected function _processPostVars()
	{
		$this->_model->setFields($_POST);
	}

	/**
	 * setup the model
	 * @return void
	 */
	protected function _setupModel($forceNew = false)
	{
		$appName = $this->getFrontController()->getParam('appName');
		$session = new Zend_Session_Namespace($appName);
		
		if ($forceNew === false && isset($session->model)) {
			$this->_model = $session->model;
		} else {
			try {
				$args = array("" . $appName . "_models_Default");
				$modelId = $this->getRequest()->getParam('modelId');
				if ($modelId) {
					$args[] = $modelId;
				}
				$serviceObj = new we_service_Cmd();
				$this->_model = $serviceObj->createModel($args);
			} catch (we_service_Exception $e) {
				we_util_Log::errorLog($e->getMessage());
				return;
			}
			
			unset($session->model);
			$session->model = $this->_model;
		}
	}
}
