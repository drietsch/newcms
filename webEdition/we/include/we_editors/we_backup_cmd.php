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

			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we.inc.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupUtil.class.php');
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $GLOBALS['WE_LANGUAGE'] . '/backup.inc.php');

			protect();
			@set_time_limit(360);
			
			if (isset($_REQUEST['cmd'])) {

				if(($_REQUEST['cmd']=='export' || $_REQUEST['cmd']=='import') && isset($_SESSION['weBackupVars'])) {

					$_steps=array(1,5,7,10,15,20,30,40,50,80,100,500,1000);

					if(isset($_REQUEST['reload']) && $_REQUEST['reload']) {
						$_key = array_search($_SESSION['weBackupVars']['backup_steps'],$_steps);

						if($_key>0) {
							$_SESSION['weBackupVars']['backup_steps'] = $_steps[$_key-1];
							if($_SESSION['weBackupVars']['backup_log']){
								weBackupUtil::addLog('Backup step reduced to ' . $_SESSION['weBackupVars']['backup_steps']);
							}

							print 'Backup step reduced to ' . $_SESSION['weBackupVars']['backup_steps'] .'
							Reload...';
							flush();
						}



						if($_key<1) {
							if(!isset($_SESSION['weBackupVars']['retry'])) {
								$_SESSION['weBackupVars']['retry']=1;
							} else {
								$_SESSION['weBackupVars']['retry']++;
							}

							if($_SESSION['weBackupVars']['retry']>10) {
								$_SESSION['weBackupVars']['retry'] = 1;
								print we_htmlElement::jsElement(
									we_message_reporting::getShowMessageCall($l_backup['error_timeout'], WE_MESSAGE_ERROR)
								);
								exit();
							}
						}
					} else {
						$_pref = getPref('BACKUP_STEPS');
						if($_SESSION['weBackupVars']['backup_steps']<$_pref) {
							$_key = array_search($_SESSION['weBackupVars']['backup_steps'],$_steps);
							$_SESSION['weBackupVars']['backup_steps'] = $_steps[$_key+1];
							if($_SESSION['weBackupVars']['backup_log']){
								weBackupUtil::addLog('Backup step increased to ' . $_SESSION['weBackupVars']['backup_steps']);
							}
						}
					}

				}

				switch ($_REQUEST['cmd']) {

					case 'export':

						if(!isset($_SESSION['weBackupVars']) || empty($_SESSION['weBackupVars'])){

							include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupPreparer.class.php');

							$_SESSION['weBackupVars'] = array();

							if(weBackupPreparer::prepareExport()===true) {

								if($_SESSION['weBackupVars']['backup_log']){
											weBackupUtil::addLog('Start backup export');
											weBackupUtil::addLog('Export to server: ' . ($_SESSION['weBackupVars']['options']['export2server'] ? 'yes' : 'no'));
											weBackupUtil::addLog('Export to local: ' . ($_SESSION['weBackupVars']['options']['export2send'] ? 'yes' : 'no'));
											weBackupUtil::addLog('File name: ' . $_SESSION['weBackupVars']['backup_file']);
											weBackupUtil::addLog('Use compression: ' . ($_SESSION['weBackupVars']['options']['compress'] ? 'yes' : 'no'));
											weBackupUtil::addLog('Export external files: ' . ($_SESSION['weBackupVars']['options']['backup_extern'] ? 'yes' : 'no'));
											weBackupUtil::addLog('Backup steps: ' . $_SESSION['weBackupVars']['backup_steps']);
								}
							} else {
								if($_SESSION['weBackupVars']['backup_log']){
									weBackupUtil::writeLog();
								}
								die('No write permissions!');
							}

							$description = $l_backup['working'];

						} else if(isset($_SESSION['weBackupVars']['extern_files']) && count($_SESSION['weBackupVars']['extern_files'])>0) {
							$fh = fopen($_SESSION['weBackupVars']['backup_file'],'ab');
							if($fh) {
								for($i=0;$i<$_SESSION['weBackupVars']['backup_steps'];$i++) {

									$file_to_export = array_pop($_SESSION['weBackupVars']['extern_files']);
									if(!empty($file_to_export)){

										if($_SESSION['weBackupVars']['backup_log']){
											weBackupUtil::addLog('Exporting file ' . $file_to_export);
										}
										weBackupUtil::exportFile($file_to_export,$fh);
									}
								}
								fclose($fh);
							}
							$description = $l_backup['external_backup'];
						} else {
							include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupExport.class.php');
							if(weBackupExport::export(
									$_SESSION['weBackupVars']['backup_file'],
									$_SESSION['weBackupVars']['offset'],
									$_SESSION['weBackupVars']['row_counter'],
									$_SESSION['weBackupVars']['backup_steps'],
									$_SESSION['weBackupVars']['options']['backup_binary'],
									$_SESSION['weBackupVars']['backup_log'],
									$_SESSION['weBackupVars']['handle_options']['versions_binarys']
							) === false){
								// force end
								$_SESSION['weBackupVars']['row_counter']=$_SESSION['weBackupVars']['row_count'];
							}

							$description = weBackupUtil::getDescription($_SESSION['weBackupVars']['current_table'],'export');

						}

						if(($_SESSION['weBackupVars']['row_counter']<$_SESSION['weBackupVars']['row_count']) || (isset($_SESSION['weBackupVars']['extern_files']) && count($_SESSION['weBackupVars']['extern_files'])>0) || weBackupUtil::hasNextTable()){

							$percent = weBackupUtil::getExportPercent();

							print '
							<script language="JavaScript" type="text/javascript">

								function run() {

											if(top.busy.setProgressText && top.busy.setProgress){
												top.busy.setProgressText("current_description","' . $description . '");
												top.busy.setProgress('.$percent.');
											}

											top.cmd.location="/webEdition/we/include/we_editors/we_backup_cmd.php?cmd=export";
											top.checker.location="/webEdition/we/include/we_editors/we_make_backup.php?pnt=checker";

								}

								run();

							</script>
							';


						} else {

							include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/weXMLExImConf.inc.php');
							include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_classes/base/weFile.class.php');

							$_files = array();
							// export spellchecker files
							if(defined('SPELLCHECKER') && $_SESSION['weBackupVars']['handle_options']['spellchecker']){
								if($_SESSION['weBackupVars']['backup_log']){
										weBackupUtil::addLog('Exporting data for spellchecker');
								}

								$_files[] = WE_SPELLCHECKER_MODULE_PATH . 'spellchecker.conf.inc.php';
								$_dir = dir(WE_SPELLCHECKER_MODULE_DIR . 'dict');
								while (false !== ($entry = $_dir->read())) {
									if($entry != '.' && $entry != '..' && (ereg('.zip',$entry) || ereg('.php',$entry) || ereg('.dict',$entry)) && !is_dir(WE_SPELLCHECKER_MODULE_DIR . 'dict/' . $entry)){
										$_files[] = WE_SPELLCHECKER_MODULE_PATH . 'dict/' . $entry;
									}
								}
								$_dir->close();

							}

							// export settings from the file
							if($_SESSION['weBackupVars']['handle_options']['settings']){
								if($_SESSION['weBackupVars']['backup_log']){
										weBackupUtil::addLog('Exporting settings');
								}
								$_files[] = '/webEdition/we/include/conf/we_conf_global.inc.php';
							}

							if(count($_files)) {
								weBackupUtil::exportFiles($_SESSION['weBackupVars']['backup_file'],$_files);
							}


							weFile::save($_SESSION['weBackupVars']['backup_file'],$GLOBALS['weXmlExImFooter'],'ab');

							//compress file
							if(!empty($_SESSION['weBackupVars']['options']['compress']) && !isset($_SESSION['weBackupVars']['compression_done'])){

								if($_SESSION['weBackupVars']['backup_log']){
										weBackupUtil::addLog('Compressing...');
								}

								if($_SESSION['weBackupVars']['protect']) {
									weFile::save($_SESSION['weBackupVars']['backup_file'] . '.gz',$GLOBALS['weXmlExImProtectCode']);
								}

								$_SESSION['weBackupVars']['backup_file']=weFile::compress($_SESSION['weBackupVars']['backup_file'],'gzip','',true,'ab');

								if($_SESSION['weBackupVars']['backup_file']===false) {
									weBackupUtil::addLog('Fatal error: compression failed!');
									print '
									<script language="JavaScript" type="text/javascript">
										if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$l_backup["error"].'");
										if(top.busy.setProgress) top.busy.setProgress(100);
										top.checker.location = "/webEdition/html/blank.html";
										alert("' . $l_backup['error_compressing_backup'] . '");
									</script>
									';
									unset($_SESSION['weBackupVars']);
									exit();
								}
								$_SESSION['weBackupVars']['compression_done'] = 1;
								$_SESSION['weBackupVars']['filename'] = basename($_SESSION['weBackupVars']['backup_file']);
							}

							if($_SESSION['weBackupVars']['protect'] && substr($_SESSION['weBackupVars']['filename'],-4) != ".php") {
								$_SESSION['weBackupVars']['filename'] .= '.php';
							}

							//copy the file to right location
							if($_SESSION['weBackupVars']['options']['export2server']==1) {
								$_backup_filename = $_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . $_SESSION['weBackupVars']['filename'];

								if($_SESSION['weBackupVars']['backup_log']){
										weBackupUtil::addLog('Move file to ' . $_backup_filename);
								}

								if($_SESSION['weBackupVars']['options']['export2send']==0) {
									rename($_SESSION['weBackupVars']['backup_file'],$_backup_filename);
									$_SESSION['weBackupVars']['backup_file'] = $_backup_filename;
								} else {
									copy($_SESSION['weBackupVars']['backup_file'],$_backup_filename);
								}
							}

							if($_SESSION['weBackupVars']['options']['export2send']==1) {
								insertIntoCleanUp($_SESSION['weBackupVars']['backup_file'],time()+300);
							}

							print '
								<script language="JavaScript" type="text/javascript">

								if(top.busy.setProgressText) top.busy.setProgressText("current_description","'.$l_backup["finished"].'");
								if(top.busy.setProgress) top.busy.setProgress(100);
								top.body.location="/webEdition/we/include/we_editors/we_make_backup.php?pnt=body&step=2";
								top.checker.location = "/webEdition/html/blank.html";
							</script>
							';

							if($_SESSION['weBackupVars']['backup_log']){
								weBackupUtil::addLog('Backup export finished');
							}

						}

						if($_SESSION['weBackupVars']['backup_log']){
							weBackupUtil::writeLog();
						}

					break;

					case 'import':

						if(!isset($_SESSION['weBackupVars']) || empty($_SESSION['weBackupVars'])){

							include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupPreparer.class.php');

							if(weBackupPreparer::prepareImport()===true){

								if($_SESSION['weBackupVars']['options']['compress'] && !weFile::hasGzip()) {
									$_err = weBackupPreparer::getErrorMessage();
									unset($_SESSION['weBackupVars']);
									print $_err;
									exit();
								}


								if($_SESSION['weBackupVars']['backup_log']){
											weBackupUtil::addLog('Start backup import');
											weBackupUtil::addLog('File name: ' . $_SESSION['weBackupVars']['backup_file']);
											weBackupUtil::addLog('Format: ' . $_SESSION['weBackupVars']['options']['format']);
											weBackupUtil::addLog('Use compression: ' . ($_SESSION['weBackupVars']['options']['compress'] ? 'yes' : 'no'));
											weBackupUtil::addLog('Import external files: ' . ($_SESSION['weBackupVars']['options']['backup_extern'] ? 'yes' : 'no'));
								}

							} else {

								$_err = weBackupPreparer::getErrorMessage();

								if($_SESSION['weBackupVars']['backup_log']){
									weBackupUtil::writeLog();
								}
								unset($_SESSION['weBackupVars']);
								print $_err;
								exit();
							}

							$description = $l_backup['working'];

						} else if(isset($_SESSION['weBackupVars']['files_to_delete']) && count($_SESSION['weBackupVars']['files_to_delete'])>0) {
							for($i=0;$i<$_SESSION['weBackupVars']['backup_steps'];$i++) {
								$file_to_delete = array_pop($_SESSION['weBackupVars']['files_to_delete']);
								if(is_dir($file_to_delete)){
									@rmdir($file_to_delete);
								} else {
									@unlink($file_to_delete);
								}
							}
							$description = $l_backup['delete_old_files'];

						} else {
							if($_SESSION['weBackupVars']['options']['format']=='xml') {
								include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupImport.class.php');
								weBackupImport::import(	$_SESSION['weBackupVars']['backup_file'],
														$_SESSION['weBackupVars']['offset'],
														$_SESSION['weBackupVars']['backup_steps'],
														$_SESSION['weBackupVars']['options']['compress'],
														$_SESSION['weBackupVars']['encoding'],
														$_SESSION['weBackupVars']['backup_log']
								);

							} else {
								include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupImportSql.class.php');
								weBackupImportSql::import(	$_SESSION['weBackupVars']['backup_file'],
														$_SESSION['weBackupVars']['offset'],
														$_SESSION['weBackupVars']['backup_steps'],
														$_SESSION['weBackupVars']['options']['compress'],
														$_SESSION['weBackupVars']['encoding'],
														$_SESSION['weBackupVars']['backup_log']
								);
							}

							$description = weBackupUtil::getDescription($_SESSION['weBackupVars']['current_table'],'import');

						}

						if(	($_SESSION['weBackupVars']['offset'] < $_SESSION['weBackupVars']['offset_end']) ||
							(isset($_SESSION['weBackupVars']['files_to_delete']) && count($_SESSION['weBackupVars']['files_to_delete']))
						){

							$percent = weBackupUtil::getImportPercent();


							print '
							<script language="JavaScript" type="text/javascript">

								function run() {

											if(top.busy.setProgressText && top.busy.setProgress){
												top.busy.setProgressText("current_description","' . $description . '");
												top.busy.setProgress('.$percent.');
											}

											top.cmd.location="/webEdition/we/include/we_editors/we_backup_cmd.php?cmd=import";
											top.checker.location="/webEdition/we/include/we_editors/we_recover_backup.php?pnt=checker";

								}

								run();

							</script>
							';


						} else {

							// perform update
							include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupUpdater.class.php');
							$updater=new weBackupUpdater();
							$updater->doUpdate();

							if($_SESSION['weBackupVars']['options']['format']=='sql') {
								weBackupImportSql::delBackupTable();
							}

							if(is_file($_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . 'tmp/' . $_SESSION['weBackupVars']['backup_file'])){
								unlink($_SERVER['DOCUMENT_ROOT'] . BACKUP_DIR . 'tmp/' . $_SESSION['weBackupVars']['backup_file']);
							}

							// reload user prefs
							$_SESSION['prefs'] = getHash("SELECT * from ".PREFS_TABLE,$DB_WE);
							$exprefs = getHash('SELECT * FROM '.PREFS_TABLE.' WHERE userID='.$_SESSION['user']['ID'],$DB_WE);
							if(is_array($exprefs) && (isset($exprefs['userID']) && $exprefs['userID'] != 0) && sizeof($exprefs)>0){
								$_SESSION['prefs']=$exprefs;
							}


							print '
								<script language="JavaScript" type="text/javascript">
									top.checker.location = "/webEdition/html/blank.html";
									var op = top.opener.top.makeFoldersOpenString();
									top.opener.top.we_cmd("load",top.opener.top.treeData.table);
									top.opener.top.header.location.reload();
									top.busy.location="/webEdition/we/include/we_editors/we_recover_backup.php?pnt=busy&operation_mode=busy&current_description=' . $l_backup['finished'] . '&percent=100";
								'.(( $_SESSION['weBackupVars']['options']['rebuild']) ? ('
									top.cmd.location="/webEdition/we/include/we_editors/we_recover_backup.php?pnt=cmd&operation_mode=rebuild";
								 ') : ('
								top.body.location="/webEdition/we/include/we_editors/we_recover_backup.php?pnt=body&step=4&temp_filename=' . $_SESSION['weBackupVars']['backup_file'] . '";
								')).'


								if(top.busy.setProgressText){
									top.busy.setProgressText("current_description","' . $l_backup['finished'] . '");
								}

								if(top.busy.setProgress){
									top.busy.setProgress(100);
								}

							</script>
							';

							if($_SESSION['weBackupVars']['backup_log']){
								weBackupUtil::addLog('Backup import finished');
							}

						}

						if($_SESSION['weBackupVars']['backup_log']){
							weBackupUtil::writeLog();
						}

					break;

					case 'rebuild':
						print we_htmlElement::jsElement('
							top.opener.top.openWindow("'.WEBEDITION_DIR.'we_cmd.php?we_cmd[0]=rebuild&step=2&btype=rebuild_all&responseText='.$l_backup["finished_success"].'","rebuildwin",-1,-1,600,130,0,true);
							setTimeout("top.close();",300);
						');
					break;

					default:

				}
			}


?>