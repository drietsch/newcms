<?php

/**
 * HomeController
 * 
 * @author
 * @version 
 */

require_once 'Zend/Controller/Action.php';

class HomeController extends Zend_Controller_Action
{

	
	public function indexAction()
	{
		$homePage = new toolfactory_app_HomePage();
		$homePage->setBodyAttributes(array('class'=>'weAppHome'));
		echo $homePage->getHTML();
	}
	
}
