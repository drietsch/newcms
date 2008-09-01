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

include_once ('Zend/Config/Xml.php');

/**
 * class for administrating webEdition applications (formerly known as "tools")
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_app_Common
{

	/*
	 * some class variables:
	 */
	/**
	 * @var configuration for application management
	 * 		read from webEdition/lib/we/app/defaults/config.xml
	 */
	private static $_config = null;

	/**
	 * @var default application manifest
	 * 		read from webEdition/lib/we/app/defaults/manifest.xml
	 */
	private static $_defaultManifest = null;

	/**
	 * @var application toc
	 * 		read from webEdition/apps/toc.xml
	 */
	private static $toc = null;

	/**
	 * returns an array with the name of all installed applications
	 */
	public static function getAllApplications()
	{
		$retval = array();
		$apps = self::readAppTOC();
		foreach ($apps as $application) {
			$retval[] = $application->name;
		}
		return $retval;
	}

	/**
	 * returns an array with all currently activated applications
	 */
	public static function getActiveApplications()
	{
		$retval = array();
		$apps = self::readAppTOC();
		foreach ($apps as $application) {
			if ($application["active"] == "true") {
				$retval[] = $application->name;
			}
		}
		return $retval;
	}

	/**
	 * checks version number of an application for special variables and returns it to the caller
	 * 		WE_VERSION 		version of the currently used webEdition installation
	 * @param string version number
	 * @param bool nodots eliminates all dots
	 * @return string version number
	 */
	public static function getVersion($version = "", $nodots = false)
	{
		switch ($version) {
			case "WE_VERSION" :
				$retval = WE_VERSION;
				break;
			default :
				$retval = $version;
				break;
		}
		if ($nodots) {
			return str_replace(".", "", $retval);
		} else {
			return $retval;
		}
	
	}

	/**
	 * reads the application toc file from webEdition/apps/toc.xml
	 * @param bool $overwrite switch to read the toc file independently of self::$toc
	 */
	public static function readAppTOC($overwrite = false)
	{
		if (!is_null(self::$toc) && $overwrite === false) {
			//error_log("toc already read, returning class variable");
			return self::$toc;
		}
		//error_log("loading toc from file.");
		self::readConfig();
		if (isset(self::$_config->applicationpath) && !empty(self::$_config->applicationpath)) {
			$filename = self::$_config->applicationpath . "/toc.xml";
		} else {
			$filename = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/toc.xml";
		}
		if (!is_readable($filename)) {
			return false;
		}
		try {
			self::$toc = @simplexml_load_file($filename);
		} catch (Exception $e) {
			//error_log("Could not read application toc file from ".$filename.". Please check your installation.");
			return null;
		}
		return self::$toc;
	}

	/**
	 * rebuilds the application toc file from webEdition/apps/toc.xml
	 * searches in all subdirectories of webEdition/apps/ for conf/manifest.xml
	 * and builds a new webEdition/apps/toc.xml
	 */
	public static function rebuildAppTOC()
	{
		/*
		 * identify all installed tools according to these rules:
		 * - entry has to be a directory
		 * - there has to be a file called "manifest.xml" in a subdirectory called "conf"
		 */
		$dir = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/";
		$skiplist = array(".", "..", "cache", "first_steps_wizard", "CVS", ".svn");
		$applist = array();
		foreach (scandir($_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/") as $entry) {
			if (is_dir($dir . $entry) && !in_array($entry, $skiplist)) {
				if (is_readable($dir . $entry . "/conf/manifest.xml")) {
					$applist[] = $entry;
					//error_log("application ".$entry." found.");
				}
			}
		}
		
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->formatOutput = true;
		$root = $doc->createElement('toc');
		
		//$newtoc = new SimpleXMLElement('<toc></toc>');
		foreach ($applist as $app) {
			//error_log("creating toc entry for ".$app);
			$entry = self::createAppTOCEntry($app, false);
			if (is_object($entry)) {
				//error_log(print_r($entry,true));
				$domnode = dom_import_simplexml($entry);
				$domnode = $doc->importNode($domnode, true);
				$domnode = $root->appendChild($domnode);
			}
		}
		
		// We insert the new element as root (child of the document)
		$doc->appendChild($root);
		
		file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/toc.xml", $doc->saveXML());
	}

	/**
	 * this method creates a new application toc entry with all needed elements.
	 * 
	 * @param string $appname name of the application for which the application toc entry has to be created
	 * 		the attribute "active" will be set to "true" by default
	 * @param bool $checkInstallation flag for a check if the specified application is installed
	 * @return object SimpleXMLElement with application data or false (on failure)
	 */
	public static function createAppTOCEntry($appname, $checkInstallation = true)
	{
		if (empty($appname)) {
			return false;
		}
		if ($checkInstallation && !self::isInstalled($appname)) {
			return false;
		}
		$appmanifest = self::getManifestXml($appname);
		$date = @self::getAppTOCElement($appname, "date");
		if (!$date)
			$date = time();
		$installer = @self::getAppTOCElement($appname, "installer");
		if (!$installer)
			$installer = "local";
		$active = @self::getAppTOCAttribute($appname, "active", "");
		if (!$active)
			$active = "true";
		
		$entry = new SimpleXMLElement("<application></application>");
		$entry->addAttribute("active", $active);
		$entry->addChild("name", $appname);
		$entry->addChild("installer", $installer);
		$entry->addChild("implementation", $appmanifest->info->implementation);
		$entry->addChild("date", $date);
		$entry->addChild("deactivatable", $appmanifest->info->deactivatable);
		$entry->addChild("deinstallable", $appmanifest->info->deinstallable);
		$entry->addChild("updatable", $appmanifest->info->updatable);
		
		$title = $entry->addChild("title");
		foreach ($appmanifest->xpath('//title') as $item) {
			foreach ($item as $lang => $text) {
				$title->addChild($lang, $text);
			}
		}
		$description = $entry->addChild("description");
		foreach ($appmanifest->xpath('//description') as $item) {
			foreach ($item as $lang => $text) {
				$description->addChild($lang, $text);
			}
		}
		return $entry;
	}

	/**
	 * saves the parameter $toc to the toc file
	 * used for changing single values
	 * 
	 * @param object SimpleXMLElement object of the complete toc.xml file
	 * @return bool true/false
	 */
	public static function saveAppTOC($toc = null)
	{
		//error_log(print_r($toc,true));
		if (is_null($toc)) {
			error_log("invalid data");
			return false;
		}
		$output = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" . "<toc>\n";
		foreach ($toc as $node) {
			//error_log($node->asXML());
			$output .= "\t" . $node->asXML() . "\n";
		}
		$output .= "</toc>\n";
		//error_log($output);
		// need to do it this way because the SimpleXML Object would not produce a complete and valid xml file 
		file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/toc.xml", $output);
	
	}

	/**
	 * loads the general configuration file from webEdition/lib/we/app/defaults/config.xml
	 * it contains general confiruration settings for handling webEdition applications
	 */
	public static function readConfig()
	{
		if (!is_null(self::$_config)) {
			//error_log("config already read, returning class variable");
			return self::$_config;
		}
		//error_log("loading config from file.");
		$filename = $_SERVER["DOCUMENT_ROOT"] . '/webEdition/lib/we/app/defaults/config.xml';
		if (!is_readable($filename)) {
			//error_log("Could not find the configuration file from ".$filename.". Please check your installation.");
			return false;
		}
		try {
			self::$_config = new Zend_Config_Xml($filename, null, true);
			// add $_SERVER["DOCUMENT_ROOT"] to <applicationpath> value
			if (isset(self::$_config->applicationpath) && !empty(self::$_config->applicationpath)) {
				if (substr(self::$_config->applicationpath, 0, 1) != "/") {
					$newpath = $_SERVER["DOCUMENT_ROOT"] . "/" . self::$_config->applicationpath;
				} else {
					$newpath = $_SERVER["DOCUMENT_ROOT"] . self::$_config->applicationpath;
				}
				if (substr($newpath, -1) != "/") {
					$newpath .= "/";
				}
				self::$_config->applicationpath = $newpath;
			}
		} catch (Exception $e) {
			//error_log("Could not read the configuration file from ".$filename.". Please check your installation.");
			return null;
		}
		return self::$_config;
	}

	/**
	 * checks if there is already an application with the name $name installed on this system
	 */
	public static function isInstalled($appname = "")
	{
		if (empty($appname)) {
			return false;
		}
		//error_log("checking if $appname is installed.");
		$config = self::readConfig();
		$apps = self::readAppTOC(true);
		//error_log(print_r($apps,true));
		$path = $config->applicationpath . $appname . "/";
		if (is_dir($path)) {
			//error_log("directory $path found.");
			if (is_readable($path . "conf/manifest.xml")) {
				foreach ($apps as $app) {
					if ($app->name == $appname) {
						return true;
					}
				}
			}
		}
		error_log(get_class() . " - application " . $appname . " does not seem to be installed.");
		return false;
	}

	/**
	 * checks if the application with the name $name is currently active
	 */
	public static function isActive($appname = "")
	{
		$tocentry = self::getAppTOCEntry($appname);
		
		$status = "";
		if ($tocentry->name == $appname) {
			$status = @$tocentry["active"];
		}
		if ($status == "true") {
			return true;
		} else if ($status == "false") {
			return false;
		} else {
			return -1;
		}
	}

	/**
	 * fetches the value of a specified application's toc entry element
	 * @param string $appname name of the application
	 * @param string $element name of the requested element
	 * @return string value of the requested element
	 */
	public static function getAppTOCElement($appname = "", $element = "")
	{
		if (empty($appname) || empty($element)) {
			return false;
		}
		$entry = self::getAppTOCEntry($appname);
		if ($entry === false) {
			return false;
		} else if (isset($entry->$element)) {
			return $entry->$element;
		}
		return false;
	}

	/**
	 * fetches the attribute's value of a specified application's toc entry element
	 * @param string $appname name of the application
	 * @param string $attribute name of the requested attribute
	 * @param string $element name of the requested element
	 * 			leave it empty to request an attribute of the <application> element
	 * @return string value of the requested attribute
	 * 
	 */
	public static function getAppTOCAttribute($appname = "", $attribute = "", $element = "")
	{
		if (empty($appname) || empty($attribute)) {
			return false;
		}
		$entry = self::getAppTOCEntry($appname);
		if ($entry === false) {
			error_log("here");
			return false;
		} else if (empty($element) && isset($entry[$attribute])) {
			return $entry[$attribute];
		} else if (isset($entry->$element[$attribute])) {
			return $entry->$element[$attribute];
		}
		return false;
	}

	/**
	 * reads the manifest file via SimpleXML from a specified path (absolute path)
	 * @param string $filename path and filename to the manifest.xml file
	 * @return object SimpleXML object of manifest file contents
	 */
	public static function getManifestXml($source = "")
	{
		if (empty($source)) {
			//error_log("source empty");
			return false;
		}
		if (is_readable($source)) {
			//error_log("readable source file");
			// seems to be a file ...
			$filename = $source;
		} else {
			// seems to be an app name:
			$filename = $_SERVER["DOCUMENT_ROOT"] . "/webEdition/apps/" . $source . "/conf/manifest.xml";
		}
		if (!is_readable($filename)) {
			//error_log("file $filename not readable");
			return false;
		}
		if (!$xml = @simplexml_load_file($filename)) {
			//error_log("could not read xml file");
			return false;
		}
		return $xml;
	}

	/**
	 * reads an element from a specified manifest file (application name)
	 * @param string $appname name of the application
	 * @param string $query xpath query
	 * @return object SimpleXMLElement
	 * @example we_app_Common::getManifestElement('application','/info/name');
	 * @see http://de.php.net/manual/de/function.simplexml-element-xpath.php
	 */
	public static function getManifestElement($source = "", $query = "")
	{
		if (empty($source)) {
			return false;
		}
		// check if $source is a path:
		if (is_readable($source)) {
			$filename = $source;
		} else if (self::isInstalled($source)) {
			// seems to be an appname
			$filename = self::$_config->applicationpath . $source . "/conf/manifest.xml";
		} else {
			return false;
		}
		self::readConfig();
		$manifest = self::getManifestXml($filename, $query);
		// add "/manifest" to relative xpath queries:
		if (substr($query, 0, 1) == "/") {
			$query = "/manifest" . $query;
		}
		$result = @$manifest->xpath($query);
		if (!$result) {
			return false;
		} else {
			return (string)$result[0];
		}
	
	}

	/**
	 * changes the value of a specified  element from an application's manifest file (via application name)
	 * @param string $appname name of the application
	 * @param string $query xpath query
	 * @example we_app_Common::setManifestElement('application','/info/name','false');
	 */
	public static function setManifestElement($appname = "", $query = "", $value = "")
	{
		if (empty($appname) || !self::isInstalled($appname) || empty($query)) {
			return false;
		}
		self::readConfig();
		
	//return self::getManifestElementFromFile(self::$_config->applicationpath.$appname."/conf/manifest.xml",$query);
	}

	public static function getManifestAttribute($appname = "", $attribute = "")
	{
		if (empty($appname) || !self::isInstalled($appname) || empty($query)) {
			return false;
		}
		self::readConfig();
		
	//return self::getManifestElementFromFile(self::$_config->applicationpath.$appname."/conf/manifest.xml",$query);
	}

	public static function setManifestAttribute($appname = "", $attribute = "", $value = "")
	{
		if (empty($appname) || !self::isInstalled($appname) || empty($query)) {
			return false;
		}
		self::readConfig();
		
	//return self::getManifestElementFromFile(self::$_config->applicationpath.$appname."/conf/manifest.xml",$query);
	}

	/**
	 * adds an entry for a specified application into toc.
	 * 
	 */
	public static function addAppToTOC($appname)
	{
		if (empty($appname) || self::isInstalled($appname)) {
			return false;
		}
		$title = self::getManifestElement($appname, "/info/title");
		$description = self::getManifestElement($appname, "/info/description");
		
		//error_log(print_r(self::$toc,true));
		$entry = self::$toc->addChild("application");
		$entry->addAttribute("active", "true");
		$entry->addChild("name", $appname);
		$entry->addChild("installer", "local");
		$entry->addChild("implementation", "tool");
		$entry->addChild("date", time());
		$entry->addChild("deactivatable", (string)(self::getManifestElement($appname, "/info/deactivatable")));
		$entry->addChild("deinstallable", (string)(self::getManifestElement($appname, "/info/deinstallable")));
		$entry->addChild("updatable", (string)(self::getManifestElement($appname, "/info/updatable")));
		if (!empty($title)) {
			foreach ($title as $entry) {
				$element = $entry->addChild("title", $entry);
				$element->addAttribute($entry["lang"]);
			}
		} else {
			$element = $entry->addChild("title", "Ohne Titel");
			$element->addAttribute("lang", "de");
			$element = $entry->addChild("title", "untitled application");
			$element->addAttribute("lang", "en");
		}
		if (!empty($description)) {
			foreach ($description as $entry) {
				$element = $entry->addChild("description", $entry);
				$element->addAttribute("lang", $entry["lang"]);
				$element = $entry->addChild("description", $entry);
				$element->addAttribute("lang", $entry["lang"]);
			}
		} else {
			$element = $entry->addChild("description", "keine Beschreibung vorhanden");
			$element->addAttribute("lang", "de");
			$element = $entry->addChild("description", "no description available");
			$element->addAttribute("lang", "en");
		}
		//		if(!self::$toc->asXML) {
		//			echo "invalid xml";
		//		} else {
		//			echo self::$toc->asXML;
		//		}
		// saving currently done via DOM because SimpleXMLElement->asXML produces invalid XML code
		$doc = new DOMDocument('1.0', 'UTF-8');
		$doc->formatOutput = true;
		$domnode = dom_import_simplexml(self::$toc);
		$domnode = $doc->importNode($domnode, true);
		$domnode = $doc->appendChild($domnode);
		
	//error_log($doc->saveXML());		
	}

	/**
	 * get default value for an application's property from webEdition/lib/we/app/defaults/manifest.xml
	 * The default values are used if an application does not have a manifest file.
	 */
	public static function getDefaultManifest()
	{
		if (!is_null(self::$_defaultManifest)) {
			return self::$_defaultManifest;
		}
		$filename = $_SERVER["DOCUMENT_ROOT"] . '/webEdition/lib/we/app/defaults/manifest.xml';
		if (!is_readable($filename)) {
			error_log("Could not find the default manifest file from " . $filename . ". Please check your installation.");
			return false;
		}
		try {
			self::$_defaultManifest = new Zend_Config_Xml($filename, null, true);
		} catch (Exception $e) {
			self::$_defaultManifest = null;
			error_log("Could not read the default manifest file from " . $filename . ". Please check your installation.");
			return false;
		}
		return self::$_defaultManifest;
	}

	/**
	 * Reads the application's manifest file via Zend_Config and merges it with the default manifest.
	 * this internal method merges the two SimpleXML objects for default properties and the application's manifest.
	 * @internal the "old" values are these from the default manifest. The "new" values come from the application's manifest and overwrite the default properties.
	 * @url http://framework.zend.com/issues/browse/ZF-998
	 * @param string $application name of the application
	 * @return object Zend_Config object containing the merge result
	 */
	public static function getManifest($application)
	{
		if (empty($application) || !self::isInstalled($application)) {
			return false;
		}
		self::getDefaultManifest();
		$filename = $_SERVER["DOCUMENT_ROOT"] . '/webEdition/apps/' . $application . '/conf/manifest.xml';
		if (!is_readable($filename)) {
			error_log('Could not find the application\'s manifest file from application "' . $application . '". Using default values for this application.');
			return false;
		}
		try {
			$manifest = new Zend_Config_Xml($filename, null, true);
		} catch (Exception $e) {
			$manifest = null;
			error_log('Could not load the application\'s manifest file from application "' . $application . '". Using default values for this application.');
			return false;
		}
		
		// merge default manifest into application manifest:
		

		// set default category "miscellaneous" if no category is specified in the application's manifest.xml
		// check if the "categories" section exists in manifest:
		if (isset($manifest->info->categories)) {
			//error_log("categories section for ".$this->_name." found.");
			if (isset($manifest->info->categories->category)) {
				//error_log("at least one category for ".$this->_name." found.");
				// removing default category before config merge:
				unset(self::$_defaultManifest->info->categories);
			} else {
				//error_log("no category for ".$this->_name." found.");
				// leaving default category in place for merge
				// moving empty categories entity out of the way for the merge of the default category
				unset($manifest->info->categories);
			}
		} else {
			//error_log("no categories section for ".$this->_name." found.");
		// nothing to do here, leaving default category in place for merge
		}
		if (is_null($manifest)) {
			$manifest = &self::$_defaultManifest;
		} else {
			$manifest = self::$_defaultManifest->merge($manifest);
		}
		self::$_defaultManifest->setReadOnly();
		return $manifest;
	}

	/**
	 * fetches informations for a specified application from the application toc
	 * @param string $appname application name for the requested toc entry
	 * @return object SimpleXMLElement object of the requested application toc entry
	 */
	public static function getAppTOCEntry($appname = "")
	{
		if (empty($appname) || !self::isInstalled($appname)) {
			return false;
		}
		$toc = self::readAppTOC();
		foreach ($toc as $entry) {
			if ($entry->name == $appname) {
				return $entry;
			}
		}
		return false;
	}

	/**
	 * activate a previoulsy deactivated application
	 * - set attribute in manifest.xml
	 * - set attribute of the application's toc.xml entry
	 */
	public static function activate($appname = "")
	{
		if (empty($appname) || !self::isInstalled($appname)) {
			return false;
		}
		
		// 1. check first if the application is deactivatable
		$deactivatable = self::getManifestElement($appname, "/info/deactivatable");
		if ($deactivatable != "true") {
			return false;
		}
		
		// 2. check if it is already activated
		if (self::isActive($appname) !== false) {
			return false;
		}
		
		// 3. activate it
		$toc = self::readAppTOC();
		foreach ($toc as $entry) {
			if ($entry->name == $appname) {
				$entry["active"] = "true";
			}
		}
		self::saveAppTOC($toc);
	
	}

	/**
	 * deactivate an application
	 * - set attribute in manifest.xml
	 * - set attribute of the application's toc.xml entry
	 */
	public static function deactivate($appname = "")
	{
		if (empty($appname) || !self::isInstalled($appname)) {
			return false;
		}
		
		// 1. check first if the application is deactivatable
		$deactivatable = self::getManifestElement($appname, "/info/deactivatable");
		if ($deactivatable != "true") {
			return false;
		}
		
		// 2. check if it is already deactivated
		if (self::isActive($appname) !== true) {
			return false;
		}
		
		// 3. deactivate it
		$toc = self::readAppTOC();
		foreach ($toc as $entry) {
			if ($entry->name == $appname) {
				$entry["active"] = "false";
			}
		}
		self::saveAppTOC($toc);
	
	}

	/**
	 * returns a specified config value or false
	 */
	public static function getConfigElement($element = "")
	{
		self::readConfig();
		if (empty($element) || !isset(self::$_config->$element)) {
			return false;
		} else {
			return self::$_config->$element;
		}
	}

}