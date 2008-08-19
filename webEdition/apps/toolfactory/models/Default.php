<?php

include_once ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/tools/weToolLookup.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weFile.class.php');

class toolfactory_models_Default extends we_app_Model
{

	public $ContentType = "toolfactory/item";

	protected $_appName = 'toolfactory';

	public $_requiredFields = array('Text','classname');
	
	public $realname = '';

	public $classname = '';

	public $maintable = '';

	public $datasource = 'custom:';
	
	public $Text = '';
	
	public $makeTable = 0;

	public $makeTags = 1;

	public $makeServices = 1;

	public $makePerms = 1;

	public $makeBackup = 1;

	public $tags = array();

	public $services = array();

	public $languages = array();

	public $permissions = array();

	public $backupTables = array();

	function __construct($toolfactoryID = 0)
	{
		parent::__construct('');
		if ($toolfactoryID) {
			$this->{$this->_primaryKey} = $toolfactoryID;
			$this->load($toolfactoryID);
		}
		
		$this->setPersistentSlots(array('ID', 'Text', 'classname', 'maintable', 'datasource', 'makeTable', 'makeTags', 'makeServices', 'makePerms', 'makeBackup'));
	}
	
	public function setFields($fields) {
		parent::setFields($fields);
	}
	
	public function setTextOutput($textOutput) {
		
		$this->TextOutput= $textOutput;
	}
	
	function realNameToIntern($realname) {
		
		$name = preg_replace('/[^a-z0-9]/','',strtolower($realname));
		
		return $name;
	}
		

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
		
		$name = isset($_props['realname']) ? html_entity_decode($_props['realname'], ENT_QUOTES) : $_props['name'];
		
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
	
	function getNewFileName($name,$TOOLNAME,$CLASSNAME) {
		
		$_newname = str_replace("TOOLNAME",$TOOLNAME,$name);	
		$_newname = str_replace("CLASSNAME",$CLASSNAME,$_newname);
		
		return $_newname;
	}
	
	
	function save() {

		$TOOLREALNAME = $this->realname;
		$TOOLNAMELANG = htmlspecialchars($this->Text, ENT_NOQUOTES);
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
					         	mkdir($path, 0777);
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
				
		return true;
			
	}
	
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
	
	function filenameNotValid() {
		return eregi(',',$this->Text);
	}
	
	function fileclassnameNotValid() {
		if(eregi('[^a-z0-9\-]',$this->classname) || is_numeric(substr($this->classname, 0 , 1))) {
			return true;
		}
		return false;

	}
		
	function maintablenameNotValid() {
		return eregi('[^a-z0-9_\-]',$this->maintable);
	}
	
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
