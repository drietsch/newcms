/*
 * @see we_app_controller_FramesetAction
 */
Zend_Loader::loadClass('we_app_controller_FramesetAction');

/**
 * Base Frameset Controller
 * 
 * @category   app
 * @package    app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class FramesetController extends we_app_controller_FramesetAction
{

	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		$this->view = new <?php print $TOOLNAME;?>_views_TopFrameView();
		$this->view->appDir = $this->getFrontController()->getParam('appDir');
		$this->view->appName = $this->getFrontController()->getParam('appName');
		$this->view->modelId = $this->getRequest()->getParam('modelId', 0);
		$this->view->tab = $this->getRequest()->getParam('tab', 0);
		$this->view->sid = $this->getRequest()->getParam('sid', 0);
		$this->view->setScriptPath('views/scripts');
		echo $this->view->render('frameset/index.php');
	}

	
	
}
