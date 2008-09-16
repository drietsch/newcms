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
 * Class weTableItem
 *
 * Provides functions for exporting and importing table rows.
 */

	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/"."modules/weModelBase.php");
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/weDBUtil.class.php");

	class weTableItem extends weModelBase{

		var $Pseudo="weTableItem";
		var $attribute_slots=array();
		function weTableItem($table){
			if(weDBUtil::isTabExist($table)) weModelBase::weModelBase($table);
			else{
				$this->db=new DB_WE();
				$this->table=$table;
			}
			$this->attribute_slots["table"]=weTableItem::rmTablePrefix($table);
			$this->setKeys($this->getTableKey($this->table));
		}

		function load($id){
			weModelBase::load($id);
			// remove binary content
			if($this->table==CONTENT_TABLE && weContentProvider::IsBinary($id)) $this->Dat="";
		}


		function getTableKey($table){
			$table = strtolower($table);
			include($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weTableKeys.inc.php');
			if(in_array($table,array_keys($tableKeys))) {
				return $tableKeys[$table];
			} else {
				return array('ID');
			}

		}

		function rmTablePrefix($tabname) {
			$len=strlen(TBL_PREFIX);
			if(substr($tabname,0,$len)==TBL_PREFIX) return strtolower(substr_replace($tabname,"",0,$len));
		}
		
        function save($force_new=false){
            // create table if doesn't exists;
            /*if(!weDBUtil::isTabExist($this->table)){
            	$keys=array();
            	$cols=array();
            	foreach ($this->persistent_slots as $value) {
            		$cols[$value]="VARCHAR(255) NOT NULL DEFAULT ''";
            		if($value=="ID") $keys[]="PRIMARY KEY (".$value.")";
            	}
            	if(count($cols)) weDBUtil::addTable($this->table,$cols,$keys);
            }*/
            weModelBase::save($force_new);
        }
	}
	
?>