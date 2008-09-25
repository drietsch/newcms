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


	define('TOOL_REGISTRY_NAME','weToolsRegistry');
	
	class weToolLookup {
		
		
		function weToolLookup() {
			
		}
		
		function getAllTools($force=false, $addInternTools=false) {

			if(!$force && !defined("NO_SESS") && isset($_SESSION[TOOL_REGISTRY_NAME]['meta'])) {
				return $_SESSION[TOOL_REGISTRY_NAME]['meta'];
			}

			$_tools = array();
			
			$_toolsDirs = array();

			//$_ignore = array('','.','..','cvs','cache','search','first_steps_wizard','weSearch','navigation');
			
			/*
			if($addInternTools) {
				$addSearch = current(array_keys($_ignore, 'weSearch'));	
				unset($_ignore[$addSearch]);
				$addNavigation = current(array_keys($_ignore, 'navigation'));	
				unset($_ignore[$addNavigation]);
			}
			*/
			
			$_bd = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps';
			$_d = opendir($_bd);

			while( $_entry = readdir($_d) ){
				//if( !in_array($_entry,$_ignore) && is_dir($_bd . '/' . $_entry)){
					$_toolsDirs[] = $_bd . '/' . $_entry;
				//}
			}
			closedir($_d);
						
			$lang = isset($GLOBALS['WE_LANGUAGE']) ? $GLOBALS['WE_LANGUAGE'] : we_core_Local::getComputedUILang();

			foreach ($_toolsDirs as $_toolDir) {
				$_metaFile = $_toolDir . '/conf/meta.conf.php';
				if(file_exists($_metaFile)) {
					include($_metaFile);
					if(isset($metaInfo)) {
						//$langFile = $_bd . '/' . $metaInfo['name'] . '/language/language_' . $lang . '.inc.php';
						//$langStr = '';
						if(isset($metaInfo['realname'])) {
							$langStr = html_entity_decode($metaInfo['realname']);
						}
						else {
							$langStr = $metaInfo['name'];
						}
						
						$metaInfo['text'] = stripslashes($langStr);
						
						$_tools[] = $metaInfo;
						unset($metaInfo);
					}
				}
			}
			if($addInternTools) {
				include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $lang . '/searchtool.inc.php');
				include ($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $lang . '/navigation.inc.php');
				
				$internToolDir = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/';
				$internTools = array('weSearch', 'navigation');
				
				foreach ($internTools as $_toolName) {
					$_metaFile = $internToolDir . $_toolName . '/conf/meta.conf.php';
					if(file_exists($_metaFile)) {
						include($_metaFile);
						if(isset($metaInfo)) {
							$metaInfo['text'] = ${'l_' . $metaInfo['name']}[$metaInfo['name']];
							$_tools[] = $metaInfo;
							unset($metaInfo);
						}
					}
				}
			
			}
			
			if(!defined("NO_SESS")) {
				$_SESSION[TOOL_REGISTRY_NAME]['meta'] = $_tools;
			}
	
			return $_tools;
			
		}
		
		function getAllCustomTools() {
			$_tools = weToolLookup::getAllTools();
			$_builtin = array('toolfactory','navigation','weSearch');
			$_custom = array();
			foreach ($_tools as $_tool) {
				if(!in_array($_tool['name'],$_builtin)){
					$_tool['text'] = htmlentities($_tool['text'],ENT_QUOTES);
				
					$_custom[] = $_tool;
				}
			}
			return $_custom;
		}
		
		
		function getToolProperties($name) {
			
			$_tools = weToolLookup::getAllTools(true,false);
			
			foreach ($_tools as $_tool) {
				if($_tool['name']==$name) {
					return $_tool;
				}
			}
			return array();
			
			
		}
		
		
		function getPhpCmdInclude() {
						
			$_inc = '';
			if(isset($_REQUEST['we_cmd'][0])) {
				$_tools = weToolLookup::getAllTools(true,true);
				foreach($_tools as $_tool){
					if(eregi("^tool_" . $_tool['name'] . "_",$_REQUEST['we_cmd'][0])){
						$_REQUEST['tool'] = $_tool['name'];
						if($_REQUEST['tool']=='weSearch' || $_REQUEST['tool']=='navigation') {
							$_inc='we_tools/'.$_tool['name'].'/hook/we_phpCmdHook_' . $_tool['name'] . '.inc.php';
						}
						else {
							$_inc='apps/'.$_tool['name'].'/hook/we_phpCmdHook_' . $_tool['name'] . '.inc.php';
						}
						break;
					}
				}
			}

			return $_inc;
		}
		
		function getJsCmdInclude() {

			$_inc = array();
			$_tools = weToolLookup::getAllTools(true,true);
			foreach($_tools as $_tool){
				if(($_tool['name']=='weSearch' || $_tool['name']=='navigation') && file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/' . $_tool['name'] . '/hook/we_jsCmdHook_' . $_tool['name'] . '.inc.php')){
					$_inc[] = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/' . $_tool['name'] . '/hook/we_jsCmdHook_' . $_tool['name'] . '.inc.php';
				}
				elseif(file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/hook/we_jsCmdHook_' . $_tool['name'] . '.inc.php')){
					$_inc[] = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/hook/we_jsCmdHook_' . $_tool['name'] . '.inc.php';
				}
			}

			return $_inc;
		}
		
		function getDefineInclude() {
			
			if(!defined("NO_SESS") && isset($_SESSION[TOOL_REGISTRY_NAME]['defineinclude'])) {
				return $_SESSION[TOOL_REGISTRY_NAME]['defineinclude'];
			}
			
			$_inc = array();
			$_tools = weToolLookup::getAllTools();
			foreach($_tools as $_tool){
				if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/conf/define.conf.php')){
					$_inc[] = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/conf/define.conf.php';
				}
			}
			if(!defined("NO_SESS")) {
				$_SESSION[TOOL_REGISTRY_NAME]['defineinclude'] = $_inc;
			}
				
			return $_inc;
		}
		
		function isTool($name) {
			$_tools = weToolLookup::getAllTools();
			foreach ($_tools as $_tool) {
				if($_tool['name']==$name) {
					return true;
				}
			}
			return in_array($name,$_tools);
			
		}
		
		function getCmdInclude($namespace,$name,$cmd) {
			if(!defined('WE_TOOLS_DIR')) {
				$toolFolder = $GLOBALS['__WE_APP_PATH__'].'/';
			}
			else {
				$toolFolder = WE_TOOLS_DIR;
			}
			return $toolFolder . $name . '/service/cmds'. $namespace . 'rpc' . $cmd . 'Cmd.class.php';
		}
		
		function getViewInclude($protocol,$namespace,$name,$view) {
			if(!defined('WE_TOOLS_DIR')) {
				$toolFolder = $GLOBALS['__WE_APP_PATH__'].'/';
			}
			else {
				$toolFolder = WE_TOOLS_DIR;
			}
			return $toolFolder . $name . '/service/views/' . $this->Protocol . $namespace . 'rpc' . $view . 'View.class.php';
			
		}
		
		function getAllToolTags($toolname) {
			
			return weToolLookup::getFileRegister($toolname,'/tags',"^we_tag_",'we_tag_','.inc.php');
						
		}
		
		
		function getAllToolServices($toolname) {

			return weToolLookup::getFileRegister($toolname,'/service/cmds',"^rpc",'rpc','Cmd.class.php');
			
		}
		
		function getAllToolLanguages($toolname, $subdir='/lang') {
			
			$_founds = array();
			if(!defined('WE_TOOLS_DIR')) {
				$toolFolder = $_SERVER["DOCUMENT_ROOT"].$GLOBALS['__WE_APP_URL__'].'/';
			}
			else {
				$toolFolder = WE_TOOLS_DIR;
			}
			$_tooldir = $toolFolder . $toolname . $subdir;
			if(weToolLookup::isTool($toolname) && is_dir($_tooldir)) {
				$_d = opendir($_tooldir);
				while( $_entry = readdir($_d) ){
					if(is_dir($_tooldir . '/' . $_entry) && stristr($_entry, '.') === FALSE) {
						$_tagname = we_core_Local::localeToWeLang($_entry);
						$_founds[$_tagname] = $_tooldir . '/' . $_entry. '/default.xml';
					}
				}
				closedir($_d);
			}
			return $_founds;
		}
		
		function getFileRegister($toolname,$subdir,$filematch,$rem_before='',$rem_after='') {
			$_founds = array();
			if(!defined('WE_TOOLS_DIR')) {
				$toolFolder = $_SERVER["DOCUMENT_ROOT"].$GLOBALS['__WE_APP_URL__'].'/';
			}
			else {
				$toolFolder = WE_TOOLS_DIR;
			}
			$_tooldir = $toolFolder . $toolname . $subdir;
			if(weToolLookup::isTool($toolname) && is_dir($_tooldir)) {
				$_d = opendir($_tooldir);
				while( $_entry = readdir($_d) ){
					if(!is_dir($_tooldir . '/' . $_entry) && eregi($filematch,$_entry)){
						$_tagname = str_replace($rem_before,'',$_entry);
						$_tagname = str_replace($rem_after,'',$_tagname);
						$_founds[$_tagname] = $_tooldir . '/' . $_entry;
					}
				}
				closedir($_d);
			}
			return $_founds;
		}
		
		
		function getToolTag($name,&$include) {
			$_tools = weToolLookup::getAllTools();
			if(!defined('WE_TOOLS_DIR')) {
				$toolFolder = $GLOBALS['__WE_APP_PATH__'].'/';
			}
			else {
				$toolFolder = WE_TOOLS_DIR;
			}
			foreach ($_tools as $_tool) {
				if(file_exists($toolFolder . $_tool['name'] . '/tags/we_tag_' . $name . '.inc.php')) {
					$include = $toolFolder . $_tool['name'] . '/tags/we_tag_' . $name . '.inc.php';
					return true;
				}
			}
			return false;
		}
		
		function getPermissionIncludes() {
			$_inc = array();
			$_tools = weToolLookup::getAllTools();
			foreach($_tools as $_tool){
				if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/conf/permission.conf.php')){
					$_inc[] = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/conf/permission.conf.php';
				}
			}

			return $_inc;
		}

		function getLanguageInclude($name) {
			if($name=='weSearch') {
				$toolFolder = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/';
				return $toolFolder . $GLOBALS['WE_LANGUAGE'] . '/searchtool.inc.php';
			}
			elseif($name=='navigation') {
				$toolFolder = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/';
				return $toolFolder . $GLOBALS['WE_LANGUAGE'] . '/navigation.inc.php';
			}
			else {
				if(!defined('WE_TOOLS_DIR')) {
					$toolFolder = $GLOBALS['__WE_APP_PATH__'].'/';
				}
				else {
					$toolFolder = WE_TOOLS_DIR;
				}
				return $toolFolder . $name . '/conf/meta.conf.php';
			}

		}
		
		function getToolsForBackup() {
			$_inc = array();
			$_tools = weToolLookup::getAllTools();
			foreach($_tools as $_tool){
				if(file_exists($_SERVER['DOCUMENT_ROOT'] . '/webEdition/apps/' . $_tool['name'] . '/conf/backup.conf.php')){
					if($_tool['maintable']!='') {
						$_inc[] = $_tool['name'];
					}
				}
			}
			$_inc[] = 'weSearch';

			
			return $_inc;
		}
		
		function getBackupTables($name) {
			if($name=='weSearch' || $name=='navigation') {
				$toolFolder = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/';
			}
			else {
				if(!defined('WE_TOOLS_DIR')) {
					$toolFolder = $GLOBALS['__WE_APP_PATH__'].'/';
				}
				else {
					$toolFolder = WE_TOOLS_DIR;
				}
			}
			if(file_exists($toolFolder . $name . '/conf/backup.conf.php')) {
				include($toolFolder . $name . '/conf/backup.conf.php');
				if (!empty($toolTables)) {
					return $toolTables;
				}
			}
			return array();
		}
		
		
		function getFilesOfDir(&$allFiles, $baseDir) {

			if (file_exists($baseDir)) {
	
				$dh = opendir($baseDir);
				while( $entry = readdir($dh) ){
	
					if( $entry != "" && $entry != "." && $entry != ".."){
	
						$_entry = $baseDir . "/" . $entry;
	
			            if( !is_dir( $_entry ) ){
			                $allFiles[] = $_entry;
			            }
	
						if(is_dir( $_entry ) && strtolower(strtolower($entry)!="cvs") ){
							weToolLookup::getFilesOfDir( $allFiles, $_entry);
						}
					}
				}
				closedir($dh);
			}

		}
		
		function getDirsOfDir(&$allDirs, $baseDir) {

			if (file_exists($baseDir)) {
	
				$dh = opendir($baseDir);
				while( $entry = readdir($dh) ){
	
					if( $entry != "" && $entry != "." && $entry != ".."  && strtolower($entry!="cvs")){
	
						$_entry = $baseDir . "/" . $entry;
	
			            if( is_dir( $_entry ) ){
			                $allDirs[] = $_entry;
			                weToolLookup::getDirsOfDir( $allDirs, $_entry);
			            }

					}
				}
				closedir($dh);
			}

		}		
		
		function getIgnoreList() {
			return  array('doctype','category','navigation','toolfactory','weSearch');
		}
		
		function isInIgnoreList($toolname) {
			$_ignore = weToolLookup::getIgnoreList();
			return in_array($toolname,$_ignore);
			
		}
		
		function getModelClassName($name) {
			if($name=='weSearch' || $name=='navigation') {
				include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_tools/".$name."/conf/meta.conf.php");
				return $metaInfo['classname'];
			}
			
			$_tool = weToolLookup::getToolProperties($name);
			if(!empty($_tool)) {
				return $_tool['classname'];
			}
			
			return '';			
		}

	}


?>
