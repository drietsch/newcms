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


/**
 * @see we_app_Application
 */
Zend_Loader::loadClass('we_app_Application');

/**
 * @see we_app_Common
 */
Zend_Loader::loadClass('we_app_Common');

/**
 * @see we_app_Installer_Common
 */
Zend_Loader::loadClass('we_app_Installer_Common');

/**
 * @see we_app_Hook
 */
Zend_Loader::loadClass('we_app_Hook');

/**
 * @see we_app_Hook_Reader_Xml
 */
Zend_Loader::loadClass('we_app_Hook_Reader_Xml');

/**
 * @see we_util_File
 */
Zend_Loader::loadClass('we_util_File');


/**
 * class for installing and uninstalling webEdition applications (formerly known as "tools")
 * 
 * @category   we
 * @package    we_app
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
 class we_app_Installer
{
	
	/**
	 * @var instance of the used installer class
	 */
	protected $_instance = null;
	
	/**
	 * @var installation source, either path or application name
	 */
	protected $_source = "";
	
	/**
	 * @var string path to the temporary installation files of the application
	 */
	protected $_tmpDir = "";
	
	/**
	 * @var object reference to we_app_Application object of the used application
	 */
	protected $_app = null;
	
	/**
	 * @var string application name
	 */
	protected $_appname = "";
	
	/**
	 * @var object Zend_Config_Xml object for general application handling configuration 
	 */
	protected $_config = null;
	
	/**
	 * @var object SimpleXML_Element object for application list
	 */
	protected $_toc = null;
	
	/**
	 * @var object SimpleXML_Element object for application file list
	 */
	protected $_files = null;
	
	/**
	 * @var array with an application's config files that need special treatment (i.e. on uninstall)
	 * 		filled by constructor method
	 */
	protected $_configFiles = array();
	
	/**
	 * constructor method for installer class
	 * returns the object instance of an appropriate class for specified application.
	 * -> needed for uninstallation process where the actions to be performed are the same
	 * 
	 * @param string $source application name or source file path
	 * @param string $installer name of the installer (without "we_app_Installer_", optional)
	 */
	public function __construct($source = "", $installer = "")
	{
		if(empty($source)) {
			return false;
		}
		if(!empty($installer)) {
			$installer = strtolower($installer);
			$installer[0] = strtoupper($installer[0]);
		}
		
		// identify all available installer classes:
		$validInstallerClasses = array();
		$classdir = dirname(__FILE__).DIRECTORY_SEPARATOR.'Installer'.DIRECTORY_SEPARATOR;
		$installerList = scandir($classdir);
		foreach($installerList as $installerClass) {
			if(substr($installerClass,0,1) != "." && !is_link($classdir.$installerClass) && !is_dir($classdir.$installerClass) && is_readable($classdir.$installerClass) && substr($installerClass,-4) == ".php") {
				$validInstallerClasses[] = $installerClass;
			}
		}
		
		// check $source for identifying installer class:
		if(is_dir($source) && is_readable($source)) {
			$source = we_util_File::addTrailingSlash(realpath($source));
			$appname = @we_app_Common::getManifestElement($source."conf/manifest.xml","/info/name");
			if(!is_readable($source.'conf/manifest.xml')  ||  !$appname) {
				$this->_instance = null;
			} else {
				// $source is an installation directory
				// -> use we_app_Installer_Local
				include_once($classdir.'Local.php');
				$this->_instance = new we_app_Installer_Local();
				error_log("using class we_app_Installer_Local");
				$this->_instance->_appname = $appname;
			}
			
		} else if(substr($source,0,1) == DIRECTORY_SEPARATOR && substr($source,-1) == DIRECTORY_SEPARATOR) {
			// $source seems to be an invalid path that is not readable
			error_log("source seems to be an invalid path. aborting installation.");
				
		} else if(we_app_Common::isInstalled($source)) {
			// there is already an application with this name installed
			// -> search for installer in the application's manifest.xml
			$usedInstaller = strtolower(@we_app_Common::getAppTOCElement($source,"installer"));
			$appname = @we_app_Common::getManifestElement($source,"/info/name");
			$usedInstaller[0] = strtoupper($usedInstaller[0]);
			if(is_readable($classdir.$usedInstaller.'.php')) {
				include_once($classdir.$usedInstaller.'.php');
				$classname = 'we_app_Installer_'.$usedInstaller;
				$this->_instance = new $classname();
				error_log("using application class $classname");
				$this->_instance->_appname = $appname;
			} else {
				$this->_instance = null;
			}
			
			
		} else if(!empty($installer) && in_array($installer,$validInstallerClasses)) {
			// -> use we_app_Installer_$installer
			if(is_readable($classdir.$installer.'.php')) {
				include_once($classdir.$installer.'.php');
				$classname = 'we_app_Installer_'.$installer;
				$this->_instance = new $classname();
				error_log("using custom class $classname");
			} else {
				$this->_instance = null;
			}
			
		} else {
			// treat as an application name try to install from Server
			// -> use we_app_Installer_Server
			include_once($classdir.'Server.php');
			error_log("using Server class we_app_Installer_Server");
			$this->_instance = new we_app_Installer_Server();
			
			// installation from server currently deactivated (not implemented yet)
			$this->_instance = null;
		}
		
		if(is_null($this->_instance)) {
			include_once($classdir.'Dummy.php');
			$this->_instance = new we_app_Installer_Dummy();
			error_log("no appropriate installer class found or invalid source $source.");
		} else {
			if(empty($this->_instance->_appname)) {
				$this->_instance->_appname = $source;
			}
			$this->_instance->_source = $source;
			$this->_instance->_config = &we_app_Common::readConfig();
			$this->_instance->_toc = &we_app_Common::readAppTOC();
			$this->_instance->_tmpDir = we_util_File::addTrailingSlash($_SERVER["DOCUMENT_ROOT"].$this->_instance->_config->tmp_installer);
			$applicationPath = we_app_Common::getConfigElement("applicationpath").$this->_instance->_appname."/";
			$this->_instance->_configFiles = array(
				$applicationPath."conf/toc.xml",
				$applicationPath."conf/manifest.xml",
				$applicationPath."conf/installhooks.xml",
			);
		}
		
	}
	
	/**
	 * returns the capitalized name of the installer without the "we_app_Installer_" prefix
	 */
	public function __toString()
	{
		if(get_class($this) == "we_app_Installer") {
			return "";
		} else if(stristr(get_class($this),"we_app_Installer_")){
			return str_replace("we_app_Installer_","",get_class($this));
		} else {
			return false;
		}
	}
	
	/**
	 * get the created instance of the used installer class (created in constructor method)
	 * @return object instance of we_app_Installer_*
	 */
	public function getInstance()
	{
		if(is_null($this->_instance)) {
			return false;
		} else {
			return $this->_instance;
		}
	}
	
	/**
	 * install an application either from a local directory or from the update server
	 * - check first if there is already an application installed with the same name
	 */
	public function install()
	{
		if(empty($this->_source)) return false;
		if(we_app_Common::isInstalled($this->_source)) {
			error_log($this->_source." seems to be installed already. Aborting installation.");
			return false;
		}
		error_log(get_class()." - starting installation of application \"".$this->_appname."\"");
		
		if(!$this->_preInstall()) return false;
		if(!$this->_executeHook("preInstall")) return false;
		
		// beginn common installation process:
		/*
		 * common installation activities:
		 * - move all files to their predefine locations
		 * - execute all sql queries
		 * - remove installation files
		 * - inserts application entry into application toc
		 */
		if(!$this->_installFiles()) return false;
		if(!$this->_executeQueries("install")) return false;
		if(!we_app_Common::rebuildAppTOC($this->_appname)) return false;
		if(!$this->_removeInstallationFiles()) return false;
		
		if(!$this->_postInstall()) return false;
		if(!$this->_executeHook("postInstall")) return false;
		return true;
	}
	
	public function update()
	{
		error_log("update() not implemented yet.");
		if(true) return false;
		
		if(!$this->_preUpdate()) return false;
		if(!$this->_executeHook("preUpdate")) return false;
		
		// beginn common update process:
		
		/*
		 * common installation activities:
		 * - do some checks
		 * - move all files to their predefine locations
		 * - execute all sql queries
		 */
		
		if(!$this->_postUpdate()) return false;
		if(!$this->_executeHook("postUpdate")) return false;
	}
	
	/**
	 * removes an application permanently
	 * preUninstall:
	 * - nothing
	 * uninstall:
	 * - deletes all application files using $this->_uninstallFiles() via conf/toc.xml
	 * - removes application data (from database) using $this->_uninstallData()
	 * - removes the manifest file
	 * - removes the file toc
	 * postinstall:
	 * - removes the application's toc.xml entry
	 */
	public function uninstall()
	{
		
		error_log("uninstall() under construction");
		if(empty($this->_source) || !we_app_Common::isInstalled($this->_source)) {
			error_log($this->_source." seems not to be installed. Aborting deinstallation.");
			return false;
		}
		error_log("starting deinstallation of application \"".$this->_appname."\"");
		
		$filename = we_app_Common::getConfigElement("applicationpath").$this->_appname.'/conf/toc.xml';
		if(!is_readable(we_app_Common::getConfigElement("applicationpath").$this->_appname.'/conf/toc.xml')) {
			return false;
		} else {
			$this->_files = simplexml_load_file($filename);
		}
		if(!$this->_preUninstall()) return false;
		if(!$this->_executeHook("preUninstall")) return false;
		
		// beginn common installation process:
		/* 
		 * common uninstallation activities:
		 * - do some checks
		 * - delete all files in toc.xml
		 * - delete all empty directories in the application's main directory (currently in apps)
		 * - but leave database untouched
		 * - remove entry from toc.xml
		 */
		//if(!$this->_executeQueries("uninstall")) return false;
		if(!$this->_uninstallFiles()) return false;
		
		if(!$this->_postUninstall()) return false;
		if(!$this->_executeHook("postUninstall")) return false;
		if(!$this->_removeAppConfig()) return false;
		if(!we_app_Common::rebuildAppTOC($this->_appname)) return false;
		
	}
	
	protected function _executeHook($hook = "")
	{
		if(empty($hook)) {
			return false;
		}
		error_log("---- hook START ".$hook." ----");
		error_log("executing installer hook ".$hook);
		$filename = ""; // path to the downloaded installerhooks.xml file of the application
		$myHook = new we_app_Hook();
		//$myHookReader = new we_app_Hook_Reader_Array($array);
		//$myHookReader = new we_app_Hook_Reader_File($filename);
		//$myHookReader = new we_app_Hook_Reader_Url($url);
		$myHookReader = new we_app_Hook_Reader_Xml($filename);
		$myHook->addReader($myHookReader);
		$myHook->run();
		error_log("----- hook END ".$hook." -----");
		// or:
		//$myHookReader = new we_app_Hook_Reader_Xml($source);
		//$myHook = new we_app_Hook($myHookReader);
		//$myHook->run();
		return true;
	}
	
	/**
	 * prepares the installation files, moves them to the temporary installation directory
	 * and extracts the archive (if it is one)
	 * @param string $source path to the source file or directory
	 */
	protected function _prepareInstallationFiles($source = "")
	{
		if(empty($source)) {
			return false;
		}
		error_log("preparing installation files.");
		// checking readability of installation archive and writablility of the temp directory
		we_util_File::createLocalFolderByPath($_SERVER["DOCUMENT_ROOT"].$this->_config->tmp_installer);
		//$this->_tmpDir = we_util_File::addTrailingSlash($_SERVER["DOCUMENT_ROOT"].$this->_config->tmp_installer);
		// check if there is already a directory with the same name:
		if(is_dir($this->_tmpDir)) {
			error_log("removing existing directory.");
			//$this->_removeInstallationFiles();
		}
		if(is_writable($this->_tmpDir) && is_writable($source)) {
			error_log("ready to move the installation files to tmp");
			$fileinfo = pathinfo($source);
			//echo $tmpDir.$fileinfo["basename"];
			if(is_dir($source)) {
				//return we_util_File::moveDir($source,$this->_tmpDir);
				error_log($this->_tmpDir);
				//$this->_tmpDir = we_util_File::addTrailingSlash($this->_tmpDir);
				$this->_tmpDir .= we_util_File::addTrailingSlash(substr(strrchr(we_util_File::removeTrailingSlash($source),"/"),1));
				//error_log("temporary installation directory: ".$this->_tmpDir);
				if(!we_util_File::moveDir($source,$this->_tmpDir)) {
					error_log("ERROR moving installation files to temporary directory.");
					return false;
				}
				return true;
			} else if(is_file($source)) {
				return we_util_File::moveFile($source,$this->_tmpDir.$fileinfo["basename"]);
			} else if($fileinfo["extension"] == "zip") {
				if(!we_util_File::hasZip()) {
					error_log("zip support for local installation needed.");
					return false;
				}
				return we_util_File::extract($this->_tmpDir.$fileinfo["basename"]);
			} else {
				error_log("unsupported installation medium.");
				return false;
			}
		} else {
			error_log("could not find installation archive ".$source);
			return false;
		}
		error_log("everything seems to be ok.");
		return true;
	}
	
	/**
	 * performs some checks if all needed files and informations are present:
	 * - is there already a tool installed with the same name? 
	 * - is there a manifest file? (checks only its existence)
	 * - is there a toc file? (checks only its existence)
	 * - are all files of the toc file present in the temporary installation directory?
	 */
	protected function _validateInstallationFiles()
	{
		if(empty($this->_tmpDir)) {
			return false;
		}
		error_log("validating installation files.");
		if(!is_readable($this->_tmpDir."conf/manifest.xml")) {
			error_log("no manifest file found in installation files");
			return false;
		} else {
			//$this->_appname = we_app_Common::getManifestElement($this->_tmpDir."/conf/manifest.xml","/info/name");
			if(empty($this->_appname)) {
				error_log("could not read application name from manifest. aborting installation.");
				$this->_appname = "";
				return false;
			} else {
				if(we_app_Common::isInstalled($this->_appname)) {
					error_log("application is $appname already installed.");
					return false;
				}
			}
		}
		if(!is_readable($this->_tmpDir."conf/toc.xml")) {
			error_log("no toc file found in installation files");
			return false;
		}
		if(!$this->_files = @simplexml_load_file($this->_tmpDir."conf/toc.xml")) {
			error_log("could not read toc file, perhaps a syntax error.");
		}
		error_log(print_r($this->_files,true));
		// check if all <file> entries are present:
		$filesNotFound = "0";
		foreach($this->_files->file as $entry) {
			if(is_readable($this->_tmpDir.$entry->source)) {
				error_log($entry->source." found.");
			} else {
				error_log("ERROR: ".(string)$entry->source." found.");
				$filesNotFound++;
			}
		}
		// check if all <sql> entries are present:
		foreach($this->_files->sql as $entry) {
			if(is_readable($this->_tmpDir.$entry->source)) {
				error_log($entry->source." found.");
			} else {
				error_log("ERROR: ".(string)$entry->source." NOT found.");
				$filesNotFound++;
			}
		}
		if($filesNotFound >= "1") {
			error_log("some of the files from toc.xml could not be found.");
			return false;
		}
		error_log("installation directory seems to be complete.");
		return true;
	}
	
	/**
	 * moves all files to their destination according to toc.xml
	 */
	protected function _installFiles()
	{
		error_log("installing application files.");
		$filesNotInstallable = array();
		foreach($this->_files->file as $entry) {
			if(!isset($entry->destination) || empty($entry->destination)) {
				$filesNotInstallable[] = $entry->source;
				error_log("no destination directory specified for file ".$entry->source);
			} else {
				$srcinfo = pathinfo($entry->source);
				$destDir = we_util_File::addTrailingSlash($_SERVER["DOCUMENT_ROOT"].$entry->destination.$srcinfo["dirname"]);
				$destFile = $srcinfo["basename"];
				we_util_File::checkAndMakeFolder($destDir,true);
				if(we_util_File::checkWritePermissions($destDir)) {
					error_log("copying file ".$this->_tmpDir.$entry->source." to ".$destDir.$destFile);
					if(we_util_File::copyFile($this->_tmpDir.$entry->source,$destDir.$destFile)) {
						error_log("successfully moved file ".$destDir.$destFile." to ".$entry->source);
					} else {
						error_log("FAILED moving file ".$destDir.$destFile." to ".$entry->source);
						$filesNotInstallable[] = (string)$entry->source;
					}
				}
			}
		}
		if(!empty($filesNotInstallable)) {
			error_log("the following files could not be installed: ".print_r($filesNotInstallable,true));
		} else {
			error_log("all files were installed successfully.");
		}
		
		error_log("installing sql files.");
		$filesNotInstallable = array();
		foreach($this->_files->sql as $entry) {
			$entry->destination = we_app_Common::getConfigElement("applicationpath");
			
			if(!isset($entry->destination) || empty($entry->destination)) {
				$filesNotInstallable[] = $entry->source;
				error_log("no destination directory specified for file ".$entry->source);
			} else {
				$srcinfo = pathinfo($entry->source);
				$destDir = we_util_File::addTrailingSlash($entry->destination.$srcinfo["dirname"]);
				$destFile = $srcinfo["basename"];
				we_util_File::checkAndMakeFolder($destDir,true);
				if(we_util_File::checkWritePermissions($destDir)) {
					error_log("copying file ".$this->_tmpDir.$entry->source." to ".$destDir.$destFile);
					if(we_util_File::copyFile($this->_tmpDir.$entry->source,$destDir.$destFile)) {
						error_log("successfully moved file ".$destDir.$destFile." to ".$entry->source);
					} else {
						error_log("FAILED moving file ".$destDir.$destFile." to ".$entry->source);
						$filesNotInstallable[] = (string)$entry->source;
					}
				}
			}
		}
		if(!empty($filesNotInstallable)) {
			error_log("the following files could not be installed: ".print_r($filesNotInstallable,true));
		} else {
			error_log("all files were installed successfully.");
		}
		
		return true;
	}
	
	protected function _removeInstallationFiles()
	{
		error_log(we_util_File::removeTrailingSlash($this->_tmpDir));
		if(!@we_util_File::rmdirr(we_util_File::addTrailingSlash($this->_tmpDir))) {
			error_log("could not remove installation files from ".we_util_File::addTrailingSlash($this->_tmpDir));
			return false;
		} else {
			error_log("installation files removed successfully.");
			return true;
		}
	}
	
	/**
	 * executes all queries according to tox.xml
	 * @param string $operation current operation as noted in toc.xml
	 * 		possible values: install, update, uninstall
	 */
	protected function _executeQueries($operation = "")
	{
		// executes all queries from toc.xml defined for specified operation
		error_log("executing sql queries for operation \"$operation\"");

		$failedQueries = array();
		$validOperations = array("install","update","uninstall");
		if(!in_array($operation,$validOperations) || is_null($this->_files)) {
			return false;
		}
		switch($operation) {
			case "install":
				$srcdir = $this->_tmpDir;
				break;
			case "uninstall":
				$srcdir = we_app_Common::getConfigElement("applicationpath").$this->_appname."/";
				break;
			case "update":
				$srcdir = $this->_tmpDir;
				break;
			default:
				break;
		}
		foreach($this->_files->sql as $entry) {
			error_log("----- ".$entry->operation." => ".$entry->source);
			if($entry->operation != $operation && !empty($operation)) {
				// nothing to do, this is not a query for this operation.
				error_log("this query is for another operation, skipping."); 
			} else if(is_readable($srcdir.$entry->source)) {
				error_log($entry->source." found.");
				if(!$query = we_util_File::load($srcdir.$entry->source)) {
					error_log("ERROR: failed reading file ".$entry->source.".");
					$failedQueries[] = (string)$entry->source;
				} else {
					error_log("executing query ".$entry->source); 
					if(!we_app_Installer_Common::executeQuery($query)) {
						$failedQueries[] = (string)$entry->source;
					} else {
						error_log("... success.");
					}
				}
			} else {
				error_log("ERROR: ".$srcdir.$entry->source." NOT found.");
				$failedQueries[] = (string)$entry->source;
			}
		}
		
		if(!empty($failedQueries)) {
			error_log("the following queries could not be executed: ".print_r($failedQueries,true));
		} else {
			error_log("all queries were executed successfully.");
		}
		return true;
	}
	
	/**
	 * deletes an application's configuration files:
	 * - conf/installhooks.xml
	 * - conf/manifest.xml
	 * - conf/toc.xml
	 */
	protected function _removeAppConfig()
	{
		$filesNotRemovable = array();
		$path = we_app_Common::getConfigElement("applicationpath").$this->_appname."/";
		foreach($this->_configFiles as $file) {
			if(!@unlink($file)) {
				error_log("ERROR: could not delete ".$file);
				$filesNotRemovable[] = $file;
			}
		}
		
		if(!empty($filesNotRemovable)) {
			error_log("the following config files could not be removed: ".print_r($filesNotRemovable,true));
		} else {
			we_util_File::rmdirr(we_app_Common::getConfigElement("applicationpath").$this->_appname.'/conf/',true);
			error_log("all config files were removed successfully.");
		}
		return true;
	}
	
	/**
	 * moves all files to their destination according to toc.xml
	 */
	protected function _uninstallFiles()
	{
		error_log("removing application files.");
		$filesNotRemovable = array();
		$weApplicationPath = we_app_Common::getConfigElement("applicationpath");
		$applicationPath = $weApplicationPath.$this->_appname."/";
		// the following files are needed in later steps during installation
		// so we leave them untouched for no:
		foreach($this->_files->file as $entry) {
			/*
			 * example toc entry:
			 * 	<file>
			 * 		<source>home.inc.php</source>
			 * 		<destination>/webEdition/apps/leer/</destination>
			 * 	</file>
			 */
			$path = $_SERVER["DOCUMENT_ROOT"].$entry->destination.$entry->source;
			error_log("trying to remove $path");
			if(in_array($path,$this->_configFiles)) {
				error_log("skipping $entry->source because we may need it later");
				continue;
			}
			if(is_dir($path)) {
				error_log("INFO: found directory ".$path.". Skipping.");
				continue;
			}
			if(is_link($path)) {
				error_log("INFO: found symlink ".$path.". Skipping.");
				$filesNotRemovable[] = (string)$entry->source;
				continue;
			}
			if(!is_file($path) || is_link($path) || !is_writable($path)) {
				error_log("ERROR: could not find/access ".$path);
				$filesNotRemovable[] = (string)$entry->source;
				continue;
			}
			if(!@unlink($path)) {
				error_log("ERROR: could not delete ".$path);
				$filesNotRemovable[] = (string)$entry->source;
				continue;
			}
			error_log("removed $path successfully.");

		}
		
		// purge empty subdirectories in he application's main directory:
		if(!we_util_File::rmdirr($applicationPath,true)) {
			error_log("ERROR: could not remove empty subdirectories of ".$applicationPath);
		}
		
		// delete all sql files:
		foreach($this->_files->sql as $entry) {
			if(is_writable($applicationPath.$entry->source)) {
				if(!@unlink($applicationPath.$entry->source)) {
					error_log("ERROR: could not delete sql file $entry->source");
					$applicationPath[] = $entry->source;
				} else {
					error_log("sql file $entry->source successfully deleted.");
				}
			}
		}
		// delete the directories of all sql files if they are empty:
		foreach($this->_files->sql as $entry) {
			$pathinfo = pathinfo($applicationPath.$entry->source);
			if(is_readable($pathinfo["dirname"]) && !we_util_File::rmdirr($pathinfo["dirname"],true)) {
				error_log("ERROR: could not remove empty subdirectories of ".$pathinfo["dirname"]);
			}
		}
		if(!empty($filesNotRemovable)) {
			error_log("the following files could not be removed: ".print_r($filesNotRemovable,true));
		} else {
			error_log("all files were removed successfully.");
		}
		return true;
	}
	
	/**
	 * things to do before starting an installation
	 */
	protected function _preInstall()
	{
		return true;
	}
	
	/**
	 * things to do after a successfull installation
	 */
	protected function _postInstall()
	{
		return true;
	}
	
	/**
	 * things to do before starting an update
	 */
	protected function _preUpdate()
	{
		return false;
	}
	
	/**
	 * things to do after a successful update
	 */
	protected function _postUpdate()
	{
		return false;
	}
	
	/**
	 * preparations before uninstalling an application
	 */
	protected function _preUninstall()
	{
		return true;
	}
	
	/**
	 * things to do after a having successfully uninstalled an application (clean up)
	 */
	protected function _postUninstall()
	{
		return true;
	}
}