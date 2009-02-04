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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */


/**
 * Class weTable
 *
 * Provides functions for loading and saving db tables.
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/base/"."weDBUtil.class.php");


	class weTable {

		var $ClassName="weTable";
		var $db;
		var $table="";
		var $elements;

		var $persistent_slots=array();
		var $attribute_slots=array();

		function weTable($table,$force_columns=false){
			$this->db=new DB_WE();
			$this->table=$table;
			$this->elements=array();

			$this->attribute_slots["name"]=weTable::rmTablePrefix($table);

			$update_table=true;
			
			if(defined("OBJECT_X_TABLE") && !$force_columns){
				 if(strtolower(substr($table,0,10))==strtolower(substr(OBJECT_X_TABLE, strlen(TBL_PREFIX)))) $update_table=false;
			}

			if(defined("CUSTOMER_TABLE") && !$force_columns){
				 if(strtolower($table)==strtolower(CUSTOMER_TABLE)) $update_table=false;
			}

			if($update_table) $this->getColumns();

		}

		function getColumns(){
			if(weDBUtil::isTabExist($this->table)){
				$metadata=$this->db->query("SHOW COLUMNS FROM $this->table;");
				while($this->db->next_record()){
					$this->elements[$this->db->f("Field")]=array(
									"Field"=>$this->db->f("Field"),
									"Type"=>$this->db->f("Type"),
									"Null"=>$this->db->f("Null"),
									"Key"=>$this->db->f("Key"),
									"Default"=>$this->db->f("Default"),
									"Extra"=>$this->db->f("Extra")
					);
				}
			}
		
			$this->fetchNewColumns();
		}

		function save(){

			weDBUtil::delTable($this->table);
			$cols=array();
			$keys=array();

			foreach($this->elements as $element){
				
					$_defalut_for_type = eregi('int',$element["Type"]) ||  eregi('double',$element["Type"]) || eregi('float',$element["Type"]) ? 0 : "''";
					
					$_default_value = ("DEFAULT " .((isset($element["Default"]) && $element["Default"]!="")  ? ("'".$element["Default"]."'") : ((isset($element["Null"]) && $element["Null"]=="YES") ? "NULL" : $_defalut_for_type)));
				
					$cols[$element["Field"]]= $element["Type"]." ".((isset($element["Null"]) && $element["Null"]=="YES") ? "NULL " : "NOT NULL ").((isset($element["Extra"]) && strtolower($element["Extra"])!="auto_increment") ? $_default_value  : "")." ".((isset($element["Extra"])) ? $element["Extra"] : '');

					if(isset($element["Key"]) && $element["Key"]){
						if($element["Key"]=="PRI")
								$keys[]="PRIMARY KEY (".$element["Field"].")";
					}

			}

			if(!empty($cols)) {
				
				 return weDBUtil::addTable($this->table,$cols,$keys);
				
				
			}
			
			return false;

		}

		function rmTablePrefix($tabname) {
			$len=strlen(TBL_PREFIX);
			if(substr($tabname,0,$len)==TBL_PREFIX) return strtolower(substr_replace($tabname,"",0,$len));

		}
		
		// add new fields to the table before import
		function fetchNewColumns() {
			// fix for bannerclicks table - primary key has been added
			if(defined('BANNER_CLICKS_TABLE') && $this->table==BANNER_CLICKS_TABLE) {
				if(!isset($this->elements['clickid'])) {
					$this->elements['clickid']=array(
										'Field'=>'clickid',
										'Type'=>'BIGINT',
										'Null'=>'NO',
										'Key'=>'PRI',
										'Default'=>'NULL',
										'Extra'=>'auto_increment'
					);
				}
			}
			// fix for bannerviews table - primary key has been added
			if(defined('BANNER_VIEWS_TABLE') && $this->table==BANNER_VIEWS_TABLE) {
				if(!isset($this->elements['viewid'])) {
					$this->elements['viewid']=array(
										'Field'=>'viewid',
										'Type'=>'BIGINT',
										'Null'=>'NO',
										'Key'=>'PRI',
										'Default'=>'NULL',
										'Extra'=>'auto_increment'
					);
				}
			}
			
		}
		

	}

?>