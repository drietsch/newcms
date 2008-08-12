<?php
/**
 * class for remote installation of webEdition applications from update server
 * the source files need to be present as a zip file at a specified location
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 * @author Alexander Lindenstruth
 */

include_once (dirname(dirname(__FILE__)) . '/../../we/core/autoload.php');

/**
 * @see we_app_Application
 */
Zend_Loader::loadClass('we_app_Application');

/**
 * @see we_app_Common
 */
Zend_Loader::loadClass('we_app_Common');

/**
 * @see we_app_Installer
 */
Zend_Loader::loadClass('we_app_Installer');

class we_app_Installer_Server extends we_app_Installer
{
	
	public function preInstall()
	{
		// fetch files from update server via http
	}
	
	public function postInstall()
	{
		
	}
	
	public function preUninstall()
	{
		
	}
	
	public function postUninstall()
	{
		
	}
	
}