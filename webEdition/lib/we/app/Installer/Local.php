<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

include_once (dirname(dirname(__FILE__)) . '/../../we/core/autoload.php');

/**
 * @see we_app_Installer
 */
Zend_Loader::loadClass('we_app_Installer');

/**
 * class for installing and uninstalling webEdition applications (formerly known as "tools")
 * 
 * @category   we
 * @package    we_app
 * @subpackage we_app_Installer
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_Installer_Local extends we_app_Installer
{
	
	protected function _preInstall()
	{
		if(!$this->_prepareInstallationFiles($this->_source)) return false;
		if(!$this->_validateInstallationFiles($this->_source)) return false;
		return true;
	}
	
	/**
	 * does the following actions:
	 * - remove installation files
	 * - inserts application entry into application toc
	 */
	protected function _postInstall()
	{
		if(!we_app_Common::rebuildAppTOC($this->_appname)) return false;
		//if(!we_app_Common::addAppToTOC($this->_appname)) return false;
		if(!$this->_removeInstallationFiles()) return false;
		return true;
	}
	
	/**
	 * no update possible for local installations
	 */
	public function update()
	{
		return false;
	}
	
}