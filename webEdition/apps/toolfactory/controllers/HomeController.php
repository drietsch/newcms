<?php


require_once 'Zend/Controller/Action.php';

/**
 * Base Home Controller
 * 
 * @category   app
 * @package    app_controller
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class HomeController extends Zend_Controller_Action
{

	/**
	 * The default action - show the home page
	 */
	public function indexAction()
	{
		$homePage = new toolfactory_app_HomePage();
		$homePage->setBodyAttributes(array('class'=>'weAppHome'));
		echo $homePage->getHTML();
	}
	
}
