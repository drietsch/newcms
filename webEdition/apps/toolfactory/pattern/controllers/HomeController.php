
require_once 'Zend/Controller/Action.php';

/**
 * Base Home Controller
 * 
 * @category   app
 * @package    app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class HomeController extends Zend_Controller_Action
{

	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		$homePage = new we_app_HomePage();
		$homePage->setBodyAttributes(array('class'=>'weAppHome'));
		echo $homePage->getHTML();
	}
	
}
