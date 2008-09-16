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

	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we.inc.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/base/weFile.class.php');

	class weBackupPreparer{

		function checkFilePermission(){

			if(!is_writable($_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR)){
				weBackupUtil::addLog('Error: Can\'t write to ' . $_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR);
				return false;
			}

			if(!is_writable($_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . 'tmp/')){
				weBackupUtil::addLog('Error: Can\'t write to ' . $_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . 'tmp/');
				return false;
			}
			return true;
		}


		function prepare(){

			if(!weBackupPreparer::checkFilePermission()) {
				return false;
			}


			$_SESSION['weBackupVars'] = array();

			$_SESSION['weBackupVars']['options'] = array();
			$_SESSION['weBackupVars']['handle_options'] = array();

			weBackupPreparer::getOptions($_SESSION['weBackupVars']['options'],$_SESSION['weBackupVars']['handle_options']);


			$_SESSION['weBackupVars']['offset'] = 0;

			$_SESSION['weBackupVars']['tables'] = weBackupPreparer::getTables($_SESSION['weBackupVars']['handle_options']);
			$_SESSION['weBackupVars']['current_table'] = '';

			$_SESSION['weBackupVars']['backup_steps'] = getPref('BACKUP_STEPS');
			if($_SESSION['weBackupVars']['backup_steps']==0){
				$_SESSION['weBackupVars']['backup_steps'] = weBackupPreparer::getAutoSteps();
			}

			$_SESSION['weBackupVars']['backup_log'] = (isset($_REQUEST['backup_log']) && $_REQUEST['backup_log']) ? $_REQUEST['backup_log'] : 0;

			if($_SESSION['weBackupVars']['backup_log']){
				$_SESSION['weBackupVars']['backup_log_data'] = '';
				$_SESSION['weBackupVars']['backup_log_file'] = $_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . 'tmp/lastlog.php';
				weFile::save($_SESSION['weBackupVars']['backup_log_file'],"<?php exit();?>\r\n");
			}

			return true;


		}


		function prepareExport() {

			if(!weBackupPreparer::prepare()){
				return false;
			}

			$_SESSION['weBackupVars']['protect'] = (isset($_REQUEST['protect']) && $_REQUEST['protect']) ? $_REQUEST['protect'] : 0;

			$_SESSION['weBackupVars']['filename'] = ((isset($_REQUEST['filename']) && $_REQUEST['filename']) ? ($_REQUEST['filename']) : '');
			$_SESSION['weBackupVars']['backup_file'] = $_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . 'tmp/' . $_SESSION['weBackupVars']['filename'];
			$_SESSION['weBackupVars']['options']['compress'] = (isset($_REQUEST['compress']) && $_REQUEST['compress']) ? $_REQUEST['compress'] : 0;

			$_SESSION['weBackupVars']['current_table_id'] = -1;

			if($_SESSION['weBackupVars']['options']['backup_extern']) {
				weBackupPreparer::getFileList($_SESSION['weBackupVars']['extern_files']);
				$_SESSION['weBackupVars']['extern_files_count'] = count($_SESSION['weBackupVars']['extern_files']);
			}

			$_SESSION['weBackupVars']['row_counter'] = 0;
			$_SESSION['weBackupVars']['row_count'] = 0;
			$ver = getMysqlVer();
			if ($ver>3230 || $ver==3230) {
				$db = new DB_WE();
				$db->query('SHOW TABLE STATUS');
				while ($db->next_record()) {
					// fix for object tables
					//if(in_array($db->f('Name'),$_SESSION['weBackupVars']['tables'])) {
					if(weBackupUtil::getDefaultTableName($db->f('Name'))!==false) {
						$_SESSION['weBackupVars']['row_count'] += $db->f('Rows');
					}

				}


			}

			if(defined('BANNER_TABLE')) {
				include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupUpdater.class.php');
				if(!weBackupUpdater::isColExist(BANNER_VIEWS_TABLE,'viewid')) {
					$db->query('ALTER TABLE ' . BANNER_VIEWS_TABLE . ' ADD viewid BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
				}
				if(!weBackupUpdater::isColExist(BANNER_CLICKS_TABLE,'clickid')) {
					$db->query('ALTER TABLE ' . BANNER_CLICKS_TABLE . ' ADD clickid BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
				}
			}

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLExImConf.inc.php');
			if($_SESSION['weBackupVars']['protect'] && !$_SESSION['weBackupVars']['options']['compress']) {
				weFile::save($_SESSION['weBackupVars']['backup_file'],$GLOBALS['weXmlExImProtectCode'].$GLOBALS['weXmlExImHeader']);
			} else {
				weFile::save($_SESSION['weBackupVars']['backup_file'],$GLOBALS['weXmlExImHeader']);
			}

			return true;

		}


		function prepareImport() {

			if(!weBackupPreparer::prepare()){
				return false;
			}

			include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupUtil.class.php');

			$_SESSION['weBackupVars']['backup_file'] = weBackupPreparer::getBackupFile();
			if($_SESSION['weBackupVars']['backup_file']===false){
				return false;
			}

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLExImConf.inc.php');

			$_offset = strlen($GLOBALS['weXmlExImProtectCode']);
			$_SESSION['weBackupVars']['offset'] = (weFile::loadLine($_SESSION['weBackupVars']['backup_file'],0,($_offset+1))==$GLOBALS['weXmlExImProtectCode']) ? $_offset : 0;

			$_SESSION['weBackupVars']['options']['compress'] = weFile::isCompressed($_SESSION['weBackupVars']['backup_file'],$_SESSION['weBackupVars']['offset']) ? 1 : 0;
			if($_SESSION['weBackupVars']['options']['compress']) {
				$_SESSION['weBackupVars']['backup_file'] = weBackupPreparer::makeCleanGzip($_SESSION['weBackupVars']['backup_file'],$_SESSION['weBackupVars']['offset']);
				insertIntoCleanUp($_SESSION['weBackupVars']['backup_file'],time()+(8*3600)); //valid for 8 hours
				$_SESSION['weBackupVars']['offset'] = 0;
			}

			$_SESSION['weBackupVars']['options']['format'] = weBackupUtil::getFormat($_SESSION['weBackupVars']['backup_file'],$_SESSION['weBackupVars']['options']['compress']);

			if($_SESSION['weBackupVars']['options']['format']!='xml' && $_SESSION['weBackupVars']['options']['format']!='sql') {
				return false;
			}

			$_SESSION['weBackupVars']['offset_end'] = weBackupUtil::getEndOffset($_SESSION['weBackupVars']['backup_file'],$_SESSION['weBackupVars']['options']['compress']);

			if($_SESSION['weBackupVars']['options']['format'] == 'xml'){
				$_SESSION['weBackupVars']['options']['xmltype'] = weBackupUtil::getXMLImportType($_SESSION['weBackupVars']['backup_file'],$_SESSION['weBackupVars']['options']['compress'],$_SESSION['weBackupVars']['offset_end']);
				if($_SESSION['weBackupVars']['options']['xmltype']!='backup') {
					return false;
				}

			}

			$_SESSION['weBackupVars']['encoding'] = weBackupPreparer::getEncoding($_SESSION['weBackupVars']['backup_file'],$_SESSION['weBackupVars']['options']['compress']);

			if($_SESSION['weBackupVars']['handle_options']['core']){
				weBackupPreparer::clearTemporaryData('tblFile');
				$_SESSION['weBackupVars']['files_to_delete'] = weBackupPreparer::getFileLists();
				$_SESSION['weBackupVars']['files_to_delete_count'] = count($_SESSION['weBackupVars']['files_to_delete']);
			}
			
			if($_SESSION['weBackupVars']['handle_options']['versions'] 
			|| $_SESSION['weBackupVars']['handle_options']['core'] 
			|| $_SESSION['weBackupVars']['handle_options']['object'] 
			|| $_SESSION['weBackupVars']['handle_options']['versions_binarys'] 
			) {
				weBackupPreparer::clearVersionData();
			}

			if($_SESSION['weBackupVars']['handle_options']['object']) {
				weBackupPreparer::clearTemporaryData('tblObjectFiles');
			}
			
			return true;
		}


		function getOptions(&$options,&$handle_options){

			$options['backup_extern'] = (isset($_REQUEST['handle_extern']) && $_REQUEST['handle_extern']) ? 1 : 0;
			$options['compress'] = (isset($_REQUEST['compress']) && $_REQUEST['compress']) ? 1 : 0;
			$options['backup_binary'] = (isset($_REQUEST['handle_binary']) && $_REQUEST['handle_binary']) ? 1 : 0;
			$options['rebuild'] = (isset($_REQUEST['rebuild']) && $_REQUEST['rebuild']) ? 1 : 0;

			$options['export2server'] = (isset($_REQUEST['export_server']) && $_REQUEST['export_server']) ? 1 : 0;
			$options['export2send'] = (isset($_REQUEST['export_send']) && $_REQUEST['export_send']) ? 1 : 0;

			$options['do_import_after_backup'] = (isset($_REQUEST['do_import_after_backup']) && $_REQUEST['do_import_after_backup']) ? 1 : 0;


			//include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weTableMap.inc.php');

			$handle_options['user'] = (isset($_REQUEST['handle_user']) && $_REQUEST['handle_user']) ? 1 : 0;
			$handle_options['customer'] = (isset($_REQUEST['handle_customer']) && $_REQUEST['handle_customer']) ? 1 : 0;
			$handle_options['shop'] = (isset($_REQUEST['handle_shop']) && $_REQUEST['handle_shop']) ? 1 : 0;
			$handle_options['workflow'] = (isset($_REQUEST['handle_workflow']) && $_REQUEST['handle_workflow']) ? 1 : 0;
			$handle_options['todo'] = (isset($_REQUEST['handle_todo']) && $_REQUEST['handle_todo']) ? 1 : 0;
			$handle_options['newsletter'] = (isset($_REQUEST['handle_newsletter']) && $_REQUEST['handle_newsletter']) ? 1 : 0;
			$handle_options['temporary'] = (isset($_REQUEST['handle_temporary']) && $_REQUEST['handle_temporary']) ? 1 : 0;
			$handle_options['banner'] = (isset($_REQUEST['handle_banner']) && $_REQUEST['handle_banner']) ? 1 : 0;
			$handle_options['core'] = (isset($_REQUEST['handle_core']) && $_REQUEST['handle_core']) ? 1 : 0;
			$handle_options['object'] = (isset($_REQUEST['handle_object']) && $_REQUEST['handle_object']) ? 1 : 0;
			$handle_options['schedule'] = (isset($_REQUEST['handle_schedule']) && $_REQUEST['handle_schedule']) ? 1 : 0;
			$handle_options['settings'] = (isset($_REQUEST['handle_settings']) && $_REQUEST['handle_settings']) ? 1 : 0;
			$handle_options['configuration'] = (isset($_REQUEST['handle_configuration']) && $_REQUEST['handle_configuration']) ? 1 : 0;
			$handle_options['export'] = (isset($_REQUEST['handle_export']) && $_REQUEST['handle_export']) ? 1 : 0;
			$handle_options['voting'] = (isset($_REQUEST['handle_voting']) && $_REQUEST['handle_voting']) ? 1 : 0;
			$handle_options['spellchecker'] = (isset($_REQUEST['handle_spellchecker']) && $_REQUEST['handle_spellchecker']) ? 1 : 0;
			$handle_options['versions'] = (isset($_REQUEST['handle_versions']) && $_REQUEST['handle_versions']) ? 1 : 0;
			$handle_options['versions_binarys'] = (isset($_REQUEST['handle_versions_binarys']) && $_REQUEST['handle_versions_binarys']) ? 1 : 0;
			
			$handle_options['tools'] = array();

			foreach($_REQUEST as $_k=>$_val) {
				if(eregi("^handle_tool_",$_k)) {
					$_tool = str_replace("handle_tool_",'',$_k);
					if(weToolLookup::isTool($_tool)) {
						$handle_options['tools'][] = $_tool;
					}
				}
			}
			$handle_options['spellchecker'] = (isset($_REQUEST['handle_spellchecker']) && $_REQUEST['handle_spellchecker']) ? 1 : 0;

			// exception for sql imports			
			$handle_options['glossary'] = (isset($_REQUEST['handle_glossary']) && $_REQUEST['handle_glossary']) ? 1 : 0;
			// exception for sql imports
			$handle_options['backup'] = $options['backup_extern'];


		}

		function getTables($options) {
			include($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weTableMap.inc.php');

			$tables = array();
			foreach($options as $group=>$enabled) {
				if($enabled && isset($tableMap[$group])) {
					$tables = array_merge($tables,$tableMap[$group]);
				}
			}
			
			if(!empty($options['tools'])) {
				foreach ($options['tools'] as $_tool) {
					$tables = array_merge($tables,weToolLookup::getBackupTables($_tool));
				}
			}
			
			return $tables;

		}

		function getBackupFile() {

			$backup_select = (isset($_REQUEST['backup_select']) && $_REQUEST['backup_select']) ? $_REQUEST['backup_select'] : '';
			$we_upload_file = (isset($_FILES['we_upload_file']) && $_FILES['we_upload_file']) ? $_FILES['we_upload_file'] : '';

			if ($backup_select) {
				return $_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . $backup_select;

			} else if ($we_upload_file && ($we_upload_file != 'none')) {

				$_SESSION['weBackupVars']['options']['upload'] = 1;

				if(empty($_FILES['we_upload_file']['tmp_name']) || $_FILES['we_upload_file']['error']) {
					return false;
				}

				$filename = $_SERVER['DOCUMENT_ROOT'].BACKUP_DIR.'tmp/'.$_FILES['we_upload_file']['name'];

				if(move_uploaded_file($_FILES['we_upload_file']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].BACKUP_DIR.'tmp/'.$_FILES['we_upload_file']['name'])){
					insertIntoCleanUp($filename, time());
					return $filename;

				}
			}

			return null;

		}

		function getExternalFiles() {
			weBackupPreparer::getFileList($list,$_SERVER['DOCUMENT_ROOT'].'/webEdition/we/templates',true,false);
		}

		function getFileLists(){
			$list = array();
			weBackupPreparer::getFileList($list,$_SERVER['DOCUMENT_ROOT'].'/webEdition/we/templates',true,false);
			weBackupPreparer::getFileList($list,$_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_tools/navigation/cache',true,false);
			return array_merge($list,weBackupPreparer::getSiteFiles());
		}


		function getFileList(&$list,$dir='',$with_dirs=false,$rem_doc_root=true){
			if($dir=='') $dir=$_SERVER['DOCUMENT_ROOT'];
			if(!is_readable($dir)) {
				return false;
			}
			if(is_dir($dir)) {
				$d=dir($dir);
				while (false !== ($entry=$d->read())) {
					if($entry != '.' && $entry != '..' && $entry != 'CVS' && $entry != 'webEdition' && $entry != 'sql_dumps' && $entry!='.project' && $entry!='.trustudio.dbg.php' && $entry!='LanguageChanges.csv') {
						$file=$dir.'/'.$entry;
						if(!weBackupPreparer::isPathExist(str_replace($_SERVER['DOCUMENT_ROOT'],'',$file))){
							if(is_dir($file)){
								if($with_dirs){
									weBackupPreparer::addToFileList($list,$file,$rem_doc_root);
								}
								weBackupPreparer::getFileList($list,$file,$with_dirs,$rem_doc_root);
							}
							else{
								weBackupPreparer::addToFileList($list,$file,$rem_doc_root);
							}
						}
					}
				}
				$d->close();
			}
		}

		function addToFileList(&$list,$file,$rem_doc_root=true){
			if($rem_doc_root){
				$list[]=str_replace($_SERVER['DOCUMENT_ROOT'],'',$file);
			} else {
				$list[]=$file;
			}
		}

		function getSiteFiles() {
			global $DB_WE;

			$list = array();
			$out = array();
			weBackupPreparer::getFileList($list,$_SERVER['DOCUMENT_ROOT'].'/webEdition/site',true,false);
			foreach ($list as $file) {
				$ct = f('SELECT ContentType FROM ' . FILE_TABLE . ' WHERE Path="' . str_replace($_SERVER['DOCUMENT_ROOT'].'/webEdition/site' , '' , $file) . '";','ContentType',$DB_WE);
				if($ct) {
					if($ct != 'image/*' && $ct != 'application/*' && $ct != 'application/x-shockwave-flash') {
						$out[]=$file;
					}
				} else {
					$out[]=$file;
				}
			}
			return $out;
		}


		function clearTemporaryData($docTable){
			global $DB_WE;
			$DB_WE->query('DELETE FROM '.TEMPORARY_DOC_TABLE." WHERE DocTable='$docTable';");
			$DB_WE->query('TRUNCATE TABLE '.NAVIGATION_TABLE.';');
			$DB_WE->query('TRUNCATE TABLE '.NAVIGATION_RULE_TABLE.';');
			$DB_WE->query('TRUNCATE TABLE '.HISTORY_TABLE.';');
		}
		
		function clearVersionData(){
			global $DB_WE;
			$DB_WE->query('TRUNCATE TABLE '.VERSIONS_TABLE.';');
			$path = $_SERVER["DOCUMENT_ROOT"].VERSION_DIR;
			if($dir=opendir($path)) {
				while($file=readdir($dir)) {
					if (!is_dir($file) && $file != "." && $file != ".." && $file != "dummy") {
						unlink($path.$file);
					}
				}
				closedir($dir);
			}
		}



		function isPathExist($path) {
			global $DB_WE;

			$tmp_db = new DB_WE;
			$DB_WE->query("SELECT ID FROM ".FILE_TABLE." WHERE Path='".$path."'");
			$tmp_db->query("SELECT ID FROM ".TEMPLATES_TABLE." WHERE Path='".$path."'");
			if(($DB_WE->next_record())||($tmp_db->next_record()))
				return true;
			else
				return false;
		}

		function getEncoding($file,$iscompressed){

				if(!empty($file)) {
					$data = weFile::loadPart($file,0,256,$iscompressed);


					$match = array();
					$encoding = 'ISO-8859-1';
					$trenner = "[\040|\n|\t|\r]*";
					$pattern ="(encoding".$trenner."=".$trenner."[\"|\'|\\\\]".$trenner.")([^\'\">\040? \\\]*)";

					if(eregi($pattern,$data,$match)){
						if(strtoupper($match[2])!='ISO-8859-1'){
							$encoding = 'UTF-8';
						}
					}

				}

				return $encoding;
		}

	 	function getAutoSteps(){
			$i=0;
			$time = explode(" ",microtime());
			$time = $time[1] + $time[0];
			$start = $time;
			while($i<100000) $i++;
			$time = explode(" ",microtime());
			$time = $time[1] + $time[0];
			$end = $time;
			$total = $end-$start;
			$cpu=(100/($total*1000));
	 		$met=ini_get('max_execution_time');
	 		return floor($cpu*$met);
	 	}


	 	function isOtherXMLImport($format){

			if($format == 'weimport'){

				if(we_hasPerm('WXML_IMPORT')) {
					return '
						<script language="JavaScript" type="text/javascript">
							if(confirm("' . $GLOBALS['l_backup']['import_file_found'] . ' \n\n' . $GLOBALS['l_backup']['import_file_found_question'] . '")){
								top.opener.top.we_cmd("import");
								top.close();
							} else {
								top.body.location = "/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2";
							}

						</script>
					';
				} else {
					return '
						<script language="JavaScript" type="text/javascript">
							' . we_message_reporting::getShowMessageCall($GLOBALS['l_backup']['import_file_found'], WE_MESSAGE_WARNING) . '
							top.body.location = "/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2";
						</script>
					';

				}

			} else if($format == 'customer'){

				return '
					<script language="JavaScript" type="text/javascript">
						' . we_message_reporting::getShowMessageCall($GLOBALS['l_backup']['customer_import_file_found'], WE_MESSAGE_WARNING) . '
						top.body.location = "/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2";
					</script>
				';

			} else {

				return '
					<script language="JavaScript" type="text/javascript">
						' . we_message_reporting::getShowMessageCall($GLOBALS['l_backup']['format_unknown'], WE_MESSAGE_WARNING) . '
						top.body.location = "/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2";
					</script>
				';


			}

	 		return '';

	 	}


	 	function getErrorMessage() {

	 		$_mess = '';


	 		if(empty($_SESSION['weBackupVars']['backup_file'])) {

				if(isset($_SESSION['weBackupVars']['options']['upload'])) {

					$maxsize = getUploadMaxFilesize();
					$_mess = sprintf($GLOBALS['l_backup']['upload_failed'],round($maxsize / (1024*1024),3) . "MB");

				} else {

					$_mess = $GLOBALS['l_backup']['file_missing'];

				}

			} else if(!is_readable($_SESSION['weBackupVars']['backup_file'])) {

					$_mess = $GLOBALS['l_backup']['file_not_readable'];

			} else if($_SESSION['weBackupVars']['options']['format']!='xml' && $_SESSION['weBackupVars']['options']['format']!='sql') {

				$_mess = $GLOBALS['l_backup']['format_unknown'];

			} else if($_SESSION['weBackupVars']['options']['xmltype']!='backup'){

	 			return weBackupPreparer::isOtherXMLImport($_SESSION['weBackupVars']['options']['xmltype']);

			} else if($_SESSION['weBackupVars']['options']['compress'] && !weFile::hasGzip()) {

				$_mess = $GLOBALS['l_backup']['cannot_split_file_ziped'];

			} else {

				$_mess = $GLOBALS['l_backup']['unspecified_error'];

			}

			if($_SESSION['weBackupVars']['backup_log']){
				weBackupUtil::addLog('Error: ' . $_mess);
			}

			return '
				<script language="JavaScript" type="text/javascript">
					' . we_message_reporting::getShowMessageCall($_mess, WE_MESSAGE_ERROR) . '
					top.body.location = "/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=2";
				</script>
			';


	 	}

		function makeCleanGzip($gzfile,$offset) {

			$file = $_SERVER['DOCUMENT_ROOT'] . '/webEdition/we_backup/tmp/' . weFile::getUniqueId();
			$fs=@fopen($gzfile,"rb");

			if($fs){
				if(fseek($fs,$offset,SEEK_SET)==0) {
					$fp=@fopen($file,"wb");
					if($fp){
						do {
		   					$data = fread($fs,8192);
		   					if (strlen($data) == 0) break;
		   					fwrite($fp,$data);
						} while (true);
						fclose($fp);
					}
					else{
						fclose($fs);
						return false;
					}
				}
				fclose($fs);
			}
			else{
				return false;
			}

			return $file;

		}


	}

?>