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
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

require_once 'Zend/Config/Xml.php';

/**
 * @see we_app_Common
 */
Zend_Loader::loadClass('we_app_Common');

/**
 * @see we_app_Installer
 */
Zend_Loader::loadClass('we_app_Installer');

/**
 * class for webEdition applications (formerly known as "tools")
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 * @internal   all default properties of an applications are to be read from webEdition/lib/we/app/defaults/manifest.xml
 */
class we_app_Application
{

	/**
	 * @var bool name of this tool
	 */
	private $_name = "";

	/**
	 * @var Zend_Config_Xml object for general application handling configuration 
	 */
	private $_config = null;

	/**
	 * @var Zend_Config_Xml object for manifest data
	 */
	private $_manifest = null;

	/**
	 * @var Zend_Config_Xml object for default manifest data
	 */
	private $_defaults = null;

	public function __construct($name = "")
	{
		$this->_config = &we_app_Common::readConfig();
		if (empty($name)) {
			return false;
		} else if (!we_app_Common::isInstalled($name)) {
			error_log("no installed application with name " . $name . " found.");
			$this->_manifest = null;
			return false;
		} else {
			$this->_name = $name;
			$this->_getMergedManifest();
		}
	}

	/**
	 * getter method for fetching the application's properties from the manifest file
	 */
	public function __get($property = "")
	{
		if (empty($this->_name) || empty($property) || is_null($this->_manifest)) {
			error_log("no such property");
			return false;
		}
		if (!isset($this->_manifest->$property)) {
			error_log("requested property " . $property . " is not specified in the manifest of " . $this->_name);
			return false;
		} else {
			return $this->_manifest->$property;
		}
	}

	/**
	 * returns the application's name, if it is installed
	 */
	public function __toString()
	{
		if (is_null($this->_manifest) || empty($this->_name)) {
			return false;
		} else {
			return $this->_name;
		}
	}

	/**
	 * returns an array with all categories the application is assigned to
	 */
	public function getCategories()
	{
		if (is_null($this->_manifest) || empty($this->_name)) {
			return false;
		}
		return $this->_manifest->info->categories->toArray("category");
	}

	/**
	 * @see we_app_Installer_Local::uninstall()
	 */
	public function uninstall()
	{
		if (is_null($this->_manifest) || empty($this->_name)) {
			return false;
		}
		$installer = new we_app_Installer_Local($this->_name);
		if (!$installer->uninstall()) {
			return false;
		}
		return true;
	
	}

	/**
	 * @see we_app_Common
	 */
	private function _getDefaultManifest()
	{
		$this->_defaults = we_app_Common::getDefaultManifest();
		if ($this->_defaults == false) {
			$this->_defaults = null;
			return false;
		}
	}

	/**
	 * @see we_app_Common
	 */
	private function _getAppManifest()
	{
		if (empty($this->_name)) {
			return false;
		}
		$this->_manifest = we_app_Common::getManifest($this->_name);
		if ($this->_manifest == false) {
			$this->_manifest = null;
			return false;
		}
	}

	/**
	 * Reads the application's manifest file and merges it with the default manifest.
	 * this internal method merges the two SimpleXML objects for default properties and the application's manifest.
	 * The result will be stored in $this->_manifest
	 * @internal the "old" values are these from the default manifest. The "new" values come from the application's manifest and overwrite the default properties.
	 * @url http://framework.zend.com/issues/browse/ZF-998
	 */
	private function _getMergedManifest()
	{
		if (empty($this->_name)) {
			return false;
		}
		$this->_defaults = $this->_getDefaultManifest();
		if (is_null($this->_defaults)) {
			return false;
		}
		$this->_manifest = $this->_getAppManifest();
		if (is_null($this->_manifest)) {
			return false;
		}
	}

	/**
	 * checks if this application is activated:
	 */
	private function _isActive()
	{
		if (is_null($this->_manifest) || empty($this->_name)) {
			return false;
		} else {
			return true;
		}
	}

}