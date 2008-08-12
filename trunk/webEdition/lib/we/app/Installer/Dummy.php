<?php
/**
 * dummy class for installation of webEdition applications (formerly known as "tools")
 * will be returned to the caller if no appropriate class for a specified source exista
 * to avoid a php error like "PHP Fatal error:  Call to a member function install() on a non-object"
 * when using code like
 * 		$myInstaller = new we_app_Installer($_SERVER["DOCUMENT_ROOT"]."/tmp/leer/");
 * 		$myInstaller->getInstance()->install();
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
 * @see we_app_Installer
 */
Zend_Loader::loadClass('we_app_Installer');

class we_app_Installer_Dummy extends we_app_Installer
{
	
	
	public function __construct($source = "", $installer = "")
	{
		
	}
	
	public function __call($method = "", $args = "")
	{
		return false;
	}
	
	public function install()
	{
		return false;
	}
	
	public function update()
	{
		return false;
	}
	
	public function uninstall()
	{
		return false;
	}
	
}