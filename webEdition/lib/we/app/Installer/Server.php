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

/**
 * class for remote installation of webEdition applications from update server
 * the source files need to be present as a zip file at a specified location
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
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