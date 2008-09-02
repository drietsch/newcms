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

	class weBackupUtil {


		function getRealTableName($table) {

			$table = strtolower($table);

			if(ereg("tblobject_([0-9]*)$",$table,$match)){

				if(isset($_SESSION['weBackupVars']['tables']['tblobject_'])){
					return $_SESSION['weBackupVars']['tables']['tblobject_'] . $match[1];
				} else {
					return false;
				}
			}

			if(isset($_SESSION['weBackupVars']['tables'][$table])) {

					return $_SESSION['weBackupVars']['tables'][$table];

			}

			return false;

		}

		function getDefaultTableName($table) {

			$match = array();
			if(defined('OBJECT_X_TABLE') && eregi("^".OBJECT_X_TABLE . "([0-9]*)$",$table,$match)){
				if(isset($_SESSION['weBackupVars']['tables']['tblobject_'])){
					$_max = f('SELECT MAX(TableID) AS MaxTableID FROM ' . OBJECT_FILES_TABLE,'MaxTableID',new DB_WE());
					if($match[1]<=$_max){
						return 'tblobject_' . $match[1];
					}
				}

				return false;

			}


			//$_def_table = array_search($table,$_SESSION['weBackupVars']['tables']);
			foreach($_SESSION['weBackupVars']['tables'] as $_key => $_value) {
				if(strtolower($table) == strtolower($_value)){
					$_def_table = $_key;
				}
			}

			// return false or default table name
			if(!empty($_def_table)) {
				return $_def_table;
			}

			return false;

		}


		function setBackupVar($name,$value){
			$_SESSION['weBackupVars'][$name] = $value;
		}


		function getDescription($table,$prefix) {
			global $l_backup;

			if($table == CONTENT_TABLE) {
				return $l_backup[$prefix . '_content'];
			}

			if($table == FILE_TABLE) {
				return $l_backup[$prefix . '_files'];
			}

			if($table == LINK_TABLE) {
				return $l_backup[$prefix . '_links'];
			}

			if($table == TEMPLATES_TABLE) {
				return $l_backup[$prefix . '_templates'];
			}

			if($table == TEMPORARY_DOC_TABLE) {
				return $l_backup[$prefix . '_temporary_data'];
			}

			if($table == INDEX_TABLE) {
				return $l_backup[$prefix . '_indexes'];
			}

			if($table == DOC_TYPES_TABLE) {
					return $l_backup[$prefix . '_doctypes'];
			}

			if(defined('USER_TABLE') && $table == USER_TABLE) {
					return $l_backup[$prefix . '_user_data'];
			}

			if(defined('CUSTOMER_TABLE') && $table == CUSTOMER_TABLE) {
				return $l_backup[$prefix . '_customer_data'];
			}

			if(defined('SHOP_TABLE') && $table == SHOP_TABLE) {
				return $l_backup[$prefix . '_shop_data'];
			}

			if(defined('PREFS_TABLE') && $table == PREFS_TABLE) {
				return $l_backup[$prefix . '_prefs'];
			}

			if(defined('BACKUP_TABLE') && $table == BACKUP_TABLE) {
				return $l_backup[$prefix . '_extern_data'];
			}

			if(defined('BANNER_CLICKS_TABLE') && $table == BANNER_CLICKS_TABLE) {
				return $l_backup[$prefix . '_banner_data'];
			}

			return $l_backup['working'];

		}

		function getImportPercent(){
				if(isset($_SESSION['weBackupVars']['files_to_delete_count'])){
					$rest1 = ((int)$_SESSION['weBackupVars']['files_to_delete_count'] - count($_SESSION['weBackupVars']['files_to_delete']));
					$rest2 = (int)$_SESSION['weBackupVars']['files_to_delete_count'];
				} else {
					$rest1 = 0;
					$rest2 = 0;
				}

				$percent = (int) (((float)
				((int)($_SESSION['weBackupVars']['offset'] + $rest1) /
				((int) $_SESSION['weBackupVars']['offset_end'] + $rest2))) * 100);

				if ($percent > 100) {
						$percent = 100;
				} else if ($percent < 0) {
						$percent = 0;
				}
				return $percent;

		}

		function getExportPercent(){

			$all = (int)$_SESSION['weBackupVars']['row_count'];

			$done=(int)$_SESSION['weBackupVars']['row_counter'];

			if(isset($_SESSION['weBackupVars']['extern_files'])){
				$all += (int)$_SESSION['weBackupVars']['extern_files_count'];
				$done += ((int)$_SESSION['weBackupVars']['extern_files_count'] - count($_SESSION['weBackupVars']['extern_files']));
			}

			$percent = (int)(($done / $all) * 100);
			if ($percent < 0) {
				$percent = 0;
			} else if ($percent > 100) {
				$percent = 100;
			}

			return $percent;
		}


		function canImportBinary($id,$path) {

			if(!empty($id) && $_SESSION['weBackupVars']['options']['backup_binary']){
				return true;
			}

			if(empty($id) && $path=='/webEdition/we/include/conf/we_conf_global.inc.php' && $_SESSION['weBackupVars']['handle_options']['settings']){
				return true;
			}

			if(empty($id) && $_SESSION['weBackupVars']['options']['backup_extern'] && $path!='/webEdition/we/include/conf/we_conf_global.inc.php'){
				return true;
			}

			if(empty($id) && strpos($path,'/webEdition/we/include/we_modules/spellchecker')===0 && $_SESSION['weBackupVars']['handle_options']['spellchecker']){
				return true;
			}

			return false;
		}
		
		function canImportVersion($id,$path) {

			if(!empty($id) && stristr($path, '/webEdition/we/version') && $_SESSION['weBackupVars']['handle_options']['versions_binarys']){
				return true;
			}

			return false;
		}


		function exportFile($file,$fh) {

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weContentProvider.class.php');

			$bin=weContentProvider::getInstance('weBinary',0);
			$bin->Path = $file;

			weContentProvider::binary2file($bin,$fh,false);

		}

		function exportFiles($to,$files) {

			$fh = fopen($to,'ab');
			$count = count($files);

			if($fh) {
				for ($i=0;$i<$count;$i++) {
					$file_to_export = $files[$i];
					weBackupUtil::exportFile($file_to_export,$fh);
				}
				fclose($fh);
			}

		}

		function getNextTable(){


			$_db = new DB_WE();
			// get all table names from database
			$_tables = $_db->table_names();

			$_do = true;

			do{
				$_SESSION['weBackupVars']['current_table_id']++;

				if($_SESSION['weBackupVars']['current_table_id']<count($_tables)){
					// get real table name from database
					$_table = $_tables[$_SESSION['weBackupVars']['current_table_id']]['table_name'];

					$_def_table = weBackupUtil::getDefaultTableName($_table);

					if($_def_table !== false){

						$_do = false;

						$_SESSION['weBackupVars']['current_table'] = $_table;

					}


				} else{
					$_SESSION['weBackupVars']['current_table'] = false;
					$_do = false;

				}

			}while($_do);




			return $_SESSION['weBackupVars']['current_table'];

		}

		function getCurrentTable(){
			/*if(!isset($_SESSION['weBackupVars']['current_table'])){
				return weBackupUtil::getNextTable();
			} else {*/
				return $_SESSION['weBackupVars']['current_table'];
			//}
		}

		function addLog($log) {
			if(isset($_SESSION['weBackupVars']['backup_log_data'])){
				$_SESSION['weBackupVars']['backup_log_data'] .= '[' . date('d-M-Y H:i:s',time()) . '] ' . $log . "\r\n";
			}
		}

		function writeLog(){

			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/base/weFile.class.php');

			weFile::save($_SESSION['weBackupVars']['backup_log_file'],$_SESSION['weBackupVars']['backup_log_data'],'ab');
			$_SESSION['weBackupVars']['backup_log_data'] = '';
		}


		function getHttpLink($server,$url,$port='',$username='',$password='') {

			return getServerProtocol(true) . (($username && $password) ? "$username:$password@" : '') . $server . ':' . $port . $url;

		}


		function getFormat($file,$iscompr=0){

			$_part = weFile::loadPart($file,0,512,$iscompr);

			if(eregi('<\?xml ',$_part)){
				return 'xml';
			} else if(eregi('create table',$_part)){
				return 'sql';
			}

			return 'unknown';
		}

		function getXMLImportType($file,$iscompr=0,$end_off=0){

			$_found = 'unknown';
			$_try = 0;
			$_count = 30;
			$_part_len = 16384;
			$_part_skip_len = 204800;

			if($end_off==0){
				$end_off = weBackupUtil::getEndOffset($file,$iscompr);
			}

			$_start = $end_off - $_part_len;

			$_part = weFile::loadPart($file,0,$_part_len,$iscompr);

			if(eregi('<webEdition',$_part)){

				$_hasbinary = false;
				while($_found=='unknown' && $_try<$_count) {

					if(eregi('<we:document',$_part) || eregi('<we:template',$_part) || eregi('<we:class',$_part) || eregi('<we:object',$_part) || eregi('<we:info',$_part) || eregi('<we:navigation',$_part)){
						$_found = 'weimport';
					} else if(eregi('<we:table',$_part)){
						$_found = 'backup';
					} else if(eregi('<we:binary',$_part)){
						$_hasbinary = true;
					} else if(eregi('<customer',$_part)){
						$_found = 'customer';
					}

					$_part = weFile::loadPart($file,$_start,$_part_len,$iscompr);

					$_start = $_start - $_part_skip_len;

					$_try++;

				}
			}

			if($_found=='unknown' && $_hasbinary) {
				$_found = 'weimport';
			}

			return $_found;
		}

		function getEndOffset($filename,$iscompressed){

			$end = 0;

			if($iscompressed==0){

				$fh = fopen($filename,'rb');
				if($fh) {
					fseek($fh,0,SEEK_END);
					$end = ftell($fh);
					fclose($fh);
				}


			} else {

				$fh = gzopen($filename,'rb');
				$d  = 1<<14;
				$end = $d;
				while ( gzseek($fh, $end) == 0 ){
					$end += $d;
				}

				while ( $d > 1 ){
					$d >>= 1;
					$end += $d * (gzseek($fh, $end)? -1 : 1);
				}

				$end--;
			}
			return $end;

		}

		function hasNextTable() {

				$_current_id = $_SESSION['weBackupVars']['current_table_id'];
				$_current_id++;

				$_db = new DB_WE();
				$_tables = $_db->table_names();
				unset($_db);

				if($_current_id < count($_tables)){

					$_table = $_tables[$_current_id]['table_name'];

					if(weBackupUtil::getDefaultTableName($_table)===false) {
						return false;
					}

					return true;

				}

				return false;

		}


	}


?>