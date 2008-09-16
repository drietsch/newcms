<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */


/**
 * Class weVersion
 *
 * Provides functions for exporting and importing backups.
 */

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");	
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/"."weFile.class.php");

	class weVersion{
		
		var $db;
		var $ClassName="weVersion";
		var $Pseudo="weVersion";
						
		var $attribute_slots=array();
		var $persistent_slots=array();
		
		var $ID=0;
		var $Path="";
		var $Data="";
		var $SeqN=0;
		
		var $linkData=true;
		
		function weVersion($id=0){
			$this->Pseudo="weVersion";
			$this->persistent_slots=array("ID", "ClassName","Path","Data","SeqN");
			foreach($this->persistent_slots as $slot) $this->$slot="";
			$this->SeqN = 0;
			$this->ClassName="weVersion";
			$this->db=new DB_WE();
			if($id) $this->load($id);
		}
		
		function load($id,$loadData=true){
			$this->ID=$id;
			$this->db->query("SELECT binaryPath FROM ".VERSIONS_TABLE." WHERE ID='".$id."';");
			if($this->db->next_record()){
				$this->Path=$this->db->f("binaryPath");
				if($this->Path && $loadData){
					return $this->loadFile($_SERVER["DOCUMENT_ROOT"].SITE_DIR.$this->Path);
				}
				return false;
			}
			else return false;
		}
		
		function loadFile($file){
			$path=eregi_replace($_SERVER["DOCUMENT_ROOT"],"",$file);
			$path=eregi_replace(SITE_DIR,"",$path);
			$this->Path=$path;
			if($this->linkData)
				return $this->Data=weFile::load($file);
			else
				return true;
		}
				
		function save($force=true){		
			if($this->ID){			
				$path=$_SERVER["DOCUMENT_ROOT"].$this->Path;
				if(file_exists($path) && !$force) return false;
				if(!is_dir(dirname($path))) {
					createLocalFolderByPath(dirname($path));
				}
				weFile::save($_SERVER["DOCUMENT_ROOT"].$this->Path,$this->Data,($this->SeqN==0 ? 'wb' : 'ab'));
			}
			else{
				$path=$_SERVER["DOCUMENT_ROOT"].$this->Path;
				if(file_exists($path) && !$force) return false;
				if(!is_dir(dirname($path))){
					createLocalFolderByPath(dirname($path));
				}
				weFile::save($_SERVER["DOCUMENT_ROOT"].$this->Path,$this->Data,($this->SeqN==0 ? 'wb' : 'ab'));
			}			
			return true;
		}
		
		//alias 
		function we_save(){
			return $this->save();
		}
		
	} 
		

?>