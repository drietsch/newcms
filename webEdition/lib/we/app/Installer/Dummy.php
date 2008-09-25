<?php
/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */


/**
 * @see we_app_Installer
 */
Zend_Loader::loadClass('we_app_Installer');

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
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

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