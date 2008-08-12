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
 * @version    $Id: IndexAction.php,v 1.1 2008/07/15 15:03:28 thomas.kneip Exp $
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
class we_app_controller_IndexAction extends Zend_Controller_Action
{
	
	public function indexAction()
	{
		if (strpos($this->getFrontController()->getBaseUrl(), 'index.php') === false) {
			$this->_redirect('index.php/frameset/index');
		} else {
			$this->_redirect('frameset/index');
		}
		
	}
}