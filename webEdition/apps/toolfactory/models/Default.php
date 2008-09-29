<?php
/**
 * webEdition CMS
 *
 * This source is part of webEdition CMS. webEdition CMS is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the textfile
 * webEdition/licenses/webEditionCMS/License.txt
 *
 * @category   webEdition
 * @package    webEdition_toolfactory
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weFile.class.php');
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_hook/class/weHook.class.php");

/**
 * Base class for app models
 * 
 * @category   app
 * @package    app_models
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class toolfactory_models_Default extends we_app_Model
{

	/**
	 * id attribute
	 *
	 * @var integer
	 */
	public $ContentType = "toolfactory/item";

	/**
	 * _appName attribute
	 *
	 * @var string
	 */
	protected $_appName = 'toolfactory';

	/**
	 * _requiredFields attribute
	 *
	 * @var array
	 */
	public $_requiredFields = array('Text','classname');
	
	/**
	 * realname attribute
	 *
	 * @var string
	 */
	public $realname = '';

	/**
	 * classname attribute
	 *
	 * @var string
	 */
	public $classname = '';

	/**
	 * maintable attribute
	 *
	 * @var string
	 */
	public $maintable = '';

	/**
	 * datasource attribute
	 *
	 * @var string
	 */
	public $datasource = 'custom:';
	
	/**
	 * makeTable attribute
	 *
	 * @var boolean
	 */
	public $makeTable = false;

	/**
	 * makeTags attribute
	 *
	 * @var boolean
	 */
	public $makeTags = true;

	/**
	 * makeServices attribute
	 *
	 * @var boolean
	 */
	public $makeServices = true;

	/**
	 * makePerms attribute
	 *
	 * @var boolean
	 */
	public $makePerms = true;

	/**
	 * makeBackup attribute
	 *
	 * @var boolean
	 */
	public $makeBackup = true;

	/**
	 * tags attribute
	 *
	 * @var array
	 */
	public $tags = array();

	/**
	 * services attribute
	 *
	 * @var array
	 */
	public $services = array();

	/**
	 * languages attribute
	 *
	 * @var array
	 */
	public $languages = array();

	/**
	 * permissions attribute
	 *
	 * @var array
	 */
	public $permissions = array();

	/**
	 * backupTables attribute
	 *
	 * @var array
	 */
	public $backupTables = array();

	/**
	 * Constructor
	 * 
	 * @param string $toolfactoryID
	 * @return void
	 */
	function __construct($toolfactoryID = 0)
	{
		parent::__construct('');
		if ($toolfactoryID) {
			$this->{$this->_primaryKey} = $toolfactoryID;
			$this->load($toolfactoryID);
		}
		
		$this->setPersistentSlots(array('ID', 'Text', 'classname', 'maintable', 'datasource', 'makeTable', 'makeTags', 'makeServices', 'makePerms', 'makeBackup'));
	}
	
	/**
	 * set Fields
	 * 
	 * @param array $fields
	 * @return void
	 */
	public function setFields($fields) {
		parent::setFields($fields);
	}
		
	/**
	 * converts real appname to intern appname
	 * 
	 * @param string $realname
	 * @return string
	 */
	function realNameToIntern($realname) {
		
		$name = preg_replace('/[^a-z0-9]/','',strtolower($realname));
		
		return $name;
	}
		
	/**
	 * Load entry from database
	 * 
	 * @param integer $loadId 
	 */
	function load($loadId)
	{

		$id = $this->realNameToIntern($loadId);
		
		$_props = weToolLookup::getToolProperties($id);
		
		if(empty($_props)) {
			$_props = weToolLookup::getToolProperties($loadId);
			$id = $loadId;
		}

		foreach ($_props as $_key => $_prop) {
			$this->$_key = $_prop;
		}
		
		$name = isset($_props['text']) ? $_props['text'] : $_props['name'];
		
		$charset = we_core_Local::getComputedUICharset();

		if($charset=='UTF-8') {
			$name = utf8_encode($name);
		}
		
		$this->Text = $name;
		
		$this->ID = $this->Text;
				
		$this->tags = weToolLookup::getAllToolTags($id);
		
		$this->services = weToolLookup::getAllToolServices($id);
		
		$this->languages = weToolLookup::getAllToolLanguages($id);
		
		$this->backupTables = weToolLookup::getBackupTables($id);
		
		$appDir = Zend_Controller_Front::getInstance()->getParam('appDir');
		
		$permFile = $_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__'] . '/' . $_props['name'] . '/conf/permission.conf.php';

		if (file_exists($permFile)) {
			include ($permFile);
			$this->permissions = $perm_defaults[$perm_group_name];
		}
	
	}
	
	/**
	 * replace TOOLNAME and CLASSNAME in created files
	 * @param string $name
	 * @param string $TOOLNAME
	 * @param string $CLASSNAME
	 * @return string
	 */
	function getNewFileName($name,$TOOLNAME,$CLASSNAME) {
		
		$_newname = str_replace("TOOLNAME",$TOOLNAME,$name);	
		$_newname = str_replace("CLASSNAME",$CLASSNAME,$_newname);
		
		return $_newname;
	}
	
	/**
	 * save entry in database and create application files
	 * 
	 * @return boolean
	 */
	function save() {

		$charset = we_core_Local::getComputedUICharset();
		$TOOLREALNAME = htmlentities($this->realname);
		if($charset=='UTF-8') {
			$this->realname = utf8_encode($this->realname);
		}
		$TOOLNAMELANG = htmlspecialchars($this->realname, ENT_NOQUOTES);
		$TOOLNAME = $this->classname;
		$CLASSNAME = $this->classname;
		$TABLENAME = $this->maintable;
		$TABLECONSTANT = !empty($this->maintable) ? strtoupper($this->classname) . '_TABLE' : '';
		$DATASOURCE = !empty($this->maintable) ? 'table:' . $this->maintable : 'custom:';
		$TABLEEXISTS = ($this->makeTable) ? true : false;
		
		if($this->makePerms) {
			$PERMISSIONCONDITION = 'EDIT_APP_' . strtoupper($this->classname);
			$DELETECONDITION = 'DELETE_APP_' . strtoupper($this->classname);
		} else {
			$PERMISSIONCONDITION = '';
			$DELETECONDITION = '';
		}
		
		//$_prohibit_names = array('navigation','doctype','first_steps_wizard','weSearch','cache','toolfactory');
		
		//if(in_array($TOOLREALNAME,$_prohibit_names)) {
			//die('The name ' . $TOOLREALNAME . ' is prohibit');
		//}
	
		$_templateDir = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/toolfactory/pattern';
		
		$_toolDir = $GLOBALS['__WE_APP_URL__'] . '/' . $TOOLNAME . '/';
		
		$_files = array();
	
		weToolLookup::getFilesOfDir($_files,$_templateDir);

		foreach ($_files as $_file) {

			$_newname = str_replace($_templateDir,$_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__'] . "/". $TOOLNAME,$_file);
			$_newname = dirname($_newname) . '/' . $this->getNewFileName(basename($_newname),$TOOLNAME,$CLASSNAME);
			$length = strlen($_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__']);
			$replaceString = substr($_newname, $length); 
			$_newname = str_replace($replaceString,$this->getNewFileName($replaceString,$TOOLNAME,$CLASSNAME),$_newname);

			if($this->shouldInclude($_newname)) {

				$_ext = substr($_file,-4);
				$is_php = $_ext=='.php' ? true : false;
				
				if(!$is_php) {
					if($_ext=='.sql') {
						ob_start();
						include($_file);
						$_content = ob_get_contents();
						ob_end_clean();
					}
					elseif($_ext=='.css') {
						ob_start();
						include($_file);
						$_content = ob_get_contents();
						ob_end_clean();
						$_content = str_replace('{$TOOLREALNAME}',$TOOLREALNAME,$_content);
						$_content = str_replace('{$TOOLNAME}',$TOOLNAME,$_content);	
						$_content = str_replace('{$TOOLNAMELANG}',$TOOLNAMELANG,$_content);	
					} else {
						$_content = weFile::load($_file);
					}
					if($_ext=='.xml') {
						$_content = weFile::load($_file);
						$start = strpos($_content, '<?xml ');
						$end = strpos($_content, '</tmx>')+$start;
						$xmlString = substr($_content, $start, $end); 
						
						$charset = we_core_Local::getComputedUICharset();
						if($charset!='UTF-8') {
							$xmlString = utf8_decode($xmlString);
						}
						
						$_content = str_replace('{$TOOLREALNAME}',$TOOLREALNAME,$xmlString);
						$_content = str_replace('{$TOOLNAME}',$TOOLNAME,$_content);	
						$_content = str_replace('{$TOOLNAMELANG}',$TOOLNAMELANG,$_content);	
						
						if($charset!='UTF-8') {
							$_content = utf8_encode($_content);
						}
						
					}
				} else {
					$_content = '<?php
					';
					ob_start();
					include($_file);
					$_content .= ob_get_contents();
					ob_end_clean();
					
					$_content .= '
		?>';
				}
									
					if(!is_dir(dirname($_newname))) {
						$path = dirname($_newname);
						$pathteile = explode("/", $path) ;
						$path = "";
						 for ($i=1; $i < count($pathteile); $i++) {
					         $path .= "/". $pathteile[$i];
					         if(!is_dir($path)) {
					         	mkdir($path);
					         }
						}
					}
				
				$_dirSelectorFile = $_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__'] . '/' . $TOOLNAME . '/we_' . $TOOLNAME . 'DirSelect.php';
				$_dirSelectorClass = $_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__'] . '/' . $TOOLNAME . '/we_' . $TOOLNAME . 'DirSelector.class.php';
				$_sqlFile = $_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__'] . '/' . $TOOLNAME . '/' . $TOOLNAME . '.sql';
				if (($_sqlFile===$_newname || $_dirSelectorFile===$_newname || $_dirSelectorClass===$_newname) && !$this->makeTable) {
				}
				else {
					//print "Saving file " . $_newname . "...<br>";
					if(eregi('_UTF-8.inc.php',$_newname)) {
						$_content = utf8_encode($_content);
					}
					weFile::save($_newname,$_content);
				}
			}
		}
		
		if($this->makeTable) {
			$_sqlDumpFile = $_SERVER['DOCUMENT_ROOT'].$GLOBALS['__WE_APP_URL__'] . '/' . $TOOLNAME . '/' . $TOOLNAME . '.sql';
			$_sqlDump = file($_sqlDumpFile);
			$_db = we_io_DB::sharedAdapter();
			foreach ($_sqlDump as $_sql) {
				//print "Execute query " . $_sql . "...<br>";
				$_db->query($_sql);
			}		
		}
		
		$this->ID = $this->Text;
		
		$hook = new weHook($this, 'save', $this->classname);
		$hook->executeHook();
				
		return true;
			
	}
	
	/**
	 * checks the file include for the application
	 * 
	 * @return boolean
	 */
	function shouldInclude($file) {
		
		$_dn = dirname($file);
		$_bn = basename($file);
		
		if($_bn!=$this->Text . '.sql' && $_bn!='permission.conf.php' && $_bn!='backup.conf.php' && $_dn!=$GLOBALS['__WE_APP_URL__'] . $this->Text . '/tags' && $_dn!=$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/cmds' && $_dn!=$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/views/json' && $_dn!=$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/views/text') {
			return true;
		}
		
		if($this->makePerms && $_bn=='permission.conf.php') {
			return true;
		}
		if($this->makeBackup && $_bn=='backup.conf.php') {
			return true;
		}
		
		if($this->makeTags && ($_dn==$GLOBALS['__WE_APP_URL__'] . $this->Text . '/tags')) {
			return true;
		}
		
		if($this->makeServices && ($_dn==$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/cmds' || $_dn==$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/views')) {
			return true;
		}
		
		if($this->makeServices && ($_dn==$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/views/text' || $_dn==$GLOBALS['__WE_APP_URL__'] . $this->Text . '/service/views/json')) {
			return true;
		}
		
		if($this->makeTable && $_bn==$this->Text . '.sql') {
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * checks Text for file name
	 * 
	 * @return boolean
	 */
	function filenameNotValid() {
		return eregi(',',$this->Text);
	}
	
	/**
	 * checks classname
	 * 
	 * @return boolean
	 */
	function fileclassnameNotValid() {
		if(eregi('[^a-z0-9\-]',$this->classname) || is_numeric(substr($this->classname, 0 , 1))) {
			return true;
		}
		return false;

	}
		
	/**
	 * checks maintable
	 * 
	 * @return boolean
	 */
	function maintablenameNotValid() {
		return eregi('[^a-z0-9_\-]',$this->maintable);
	}
	
	/**
	 * checks if model class exists
	 * 
	 * @param string $classname
	 * @return boolean
	 */
	function modelclassExists($classname) {
		
		$_menuItems = weToolLookup::getAllTools(true);

		$_prohibit_classnames = array($_menuItems);
		
		foreach ($_menuItems as $_menuItem) {
			$_prohibit_classnames[] = $_menuItem["classname"];
		}

		if(in_array($classname,$_prohibit_classnames)) {
			return true;
		}
		else return false;
		
	}
	
	/**
	 * checks if tool exists
	 * 
	 * @param string $name
	 * @return boolean
	 */
	function toolExists($name){
		
		$_menuItems = weToolLookup::getAllTools(true);

		$_prohibit_names = array($_menuItems);
		
		foreach ($_menuItems as $_menuItem) {
			if(isset($_menuItem["realname"])) {
				$_prohibit_names[] = $_menuItem["realname"];	
			}	
		}

		if(in_array($name,$_prohibit_names)) {
			return true;
		}
		else return false;
	}	

}
