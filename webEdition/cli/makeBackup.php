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
 * @package    webEdition_cli
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

/**
 * The script exports webEdition backup file to the given file
 * webEdition must be installed
 */


include_once("cliConfig.php");


// CONFIGURATION BEGINS ---------------------------------------------------------

/**
 * Path to backup file
 */
$_backup_filename = $_SERVER['DOCUMENT_ROOT'] . '/weBackup_daily.xml';

/**
 *  set to true for gzip compression
 */
$_REQUEST['compress'] = true;

// export details

/**
 * export webEdition Core Data (Documents, Templates and Navigation)
 */
$_REQUEST['handle_core'] = true;

/**
 * export binary data
 */
$_REQUEST['handle_binary'] = true;

/**
 * export version data
 */
$_REQUEST['handle_versions'] = true;

/**
 * export version binary files
 */
$_REQUEST['handle_versions_binarys'] = true;

/**
 * export user data
 */
$_REQUEST['handle_user'] = true;

/**
 * export customer data
 */
$_REQUEST['handle_customer'] = true;

/**
 * export shop data
 */
$_REQUEST['handle_shop'] = true;

/**
 * export workflow data
 */
$_REQUEST['handle_workflow'] = true;

/**
 * export user data
 */
$_REQUEST['handle_todo'] = true;

/**
 * export newsletter data
 */
$_REQUEST['handle_newsletter'] = true;

/**
 * export temporary data
 */
$_REQUEST['handle_temporary'] = true;

/**
 * export banner data
 */
$_REQUEST['handle_banner'] = true;

/**
 * export objects and classes
 */
$_REQUEST['handle_object'] = true;

/**
 * export scheduler data
 */
$_REQUEST['handle_schedule'] = true;

/**
 * export settings and preferences
 */
$_REQUEST['handle_settings'] = true;

/**
 * export configuration data
 */
$_REQUEST['handle_configuration'] = true;

/**
 * export webEdition export data
 */
$_REQUEST['handle_export'] = true;

/**
 * export voting data
 */
$_REQUEST['handle_voting'] = true;

/**
 * export extern fi�es
 */
$_REQUEST['handle_extern'] = false;

// be user friendly :-)
$_REQUEST['verbose'] = true;

// CONFIGURATION ENDS ---------------------------------------------------------

// we want to see errors
ini_set("display_errors", 1);
error_reporting(E_ALL);

// knock out time limit if possible
@set_time_limit(0);

// set memory limit to an equitable value if possible
@ini_set("memory_limit", "128M");

// knock out identifiation and permissions
$_SESSION["perms"] = array();
$_SESSION["perms"]["ADMINISTRATOR"] = true;
$_SESSION["user"]["Username"] = 1;


if (!isset($_SERVER['SERVER_NAME'])) {
	$_SERVER['SERVER_NAME'] = $SERVER_NAME;
}


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/PEAR.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/Getopt.php");

// Define exit codes for errors
define('NO_ARGS',10);
define('INVALID_OPTION',11);

// Reading the incoming arguments - same as $argv
$args = Console_Getopt::readPHPArgv();


$_cliHelp = 'Usage: makeBackup.php [options] [file]
Options:
  -z, --compress             gzip compression for output file

  -v, --verbose              Verbosely list files processed

  --help                     Prints out this help

 Options what to backup:
  --all                      Backups everything except external files
  --core                     Documents and templates
  --versions                 Versions
  --versions_binarys         Versions binarys
  --binary                   Binary data
  --user                     User data
  --customer                 Customer data
  --shop                     Shop data
  --workflow                 Workflow data
  --todo                     Task/Messaging data
  --newsletter               Newsletter data
  --temporary                Temporary data (unpublished data)
  --banner                   Banner data
  --object                   Objects and Classes
  --schedule                 Scheduler data
  --settings                 Settings
  --configuration            Configuration Data
  --export                   webEdition-Export Data
  --voting                   Voting data
  --extern                   Extern files (only use this if you have
                             enough memory and cpu power)
';

// Make sure we got them (for non CLI binaries)
if (PEAR::isError($args)) {
   fwrite(STDERR,$args->getMessage()."\n");
   exit(NO_ARGS);
}

// Short options
$short_opts = 'zv';

// Long options
$long_opts = array(
'all',
'core',
'versions',
'versions_binarys',
'binary',
'user',
'customer',
'shop',
'workflow',
'todo',
'newsletter',
'temporary',
'banner',
'object',
'schedule',
'settings',
'configuration',
'export',
'voting',
'extern',
'verbose',
'help',
'compress'
);

// Convert the arguments to options - check for the first argument
if ( count($_SERVER['argv']) && realpath($_SERVER['argv'][0]) == __FILE__ ) {
   $options = Console_Getopt::getOpt($args,$short_opts,$long_opts);
} else {
   $options = Console_Getopt::getOpt2($args,$short_opts,$long_opts);
}

// Check the options are valid
if (PEAR::isError($options)) {
   fwrite(STDERR,$options->getMessage()."\n");
   fwrite(STDERR,$_cliHelp."\n");
   exit(INVALID_OPTION);
}
if (count($args) ) {
	$_REQUEST['compress'] = false;
	$_REQUEST['verbose'] = false;
	$_REQUEST['handle_extern'] = false;
	_checkAll(false);
}

foreach ($options[0] as $opt) {
	switch ($opt[0]) {
		case '--all':
			_checkAll(true);
		break;

		case '--compress':
		case 'z':
			$_REQUEST['compress'] = true;
		break;

		case 'v':
		case '--verbose':
			$_REQUEST['verbose'] = true;
		break;

		case '--help':
			print $_cliHelp;
			exit(0);
		break;

		default:
			$_REQUEST['handle_' . preg_replace('/^--/', '', $opt[0])] = true;
	}
}


// check if no option is checked

$__optionsSelected = false;

foreach ($_REQUEST as $_k=>$_v) {
	if (substr($_k,0,7) == "handle_") {
		if ($_v) {
			$__optionsSelected = true;
			break;
		}
	}
}

// if no option is checked, then check the dafaults
if ($__optionsSelected === false) {
	$_REQUEST['handle_core'] = true;
}


if (isset($options[1][0])) {
	$_backup_filename = $options[1][0];
}


$_REQUEST['filename'] = basename($_backup_filename);

// include needed libraries
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupPreparer.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupExport.class.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_exim/backup/weBackupUtil.class.php');

if(!isset($_SESSION['weBackupVars']) || empty($_SESSION['weBackupVars'])){

	include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupPreparer.class.php');

	$_SESSION['weBackupVars'] = array();

	if(weBackupPreparer::prepareExport()===true) {

		if($_REQUEST['verbose']) {
				print "\nExporting to ".$_backup_filename."\n";
		}

		if(isset($_SESSION['weBackupVars']['extern_files']) && count($_SESSION['weBackupVars']['extern_files'])>0) {

			if($_REQUEST['verbose']) {
				print "Exporting extern files...\n";
			}

			$fh = fopen($_SESSION['weBackupVars']['backup_file'],'ab');
			if($fh) {
				foreach($_SESSION['weBackupVars']['extern_files'] as $file_to_export) {
					if($_REQUEST['verbose']) {
						print "-";
					}
					if(!empty($file_to_export)){
						weBackupUtil::exportFile($file_to_export,$fh);
					}
				}
				fclose($fh);
			}

		}

		include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_classes/base/weFile.class.php');
		include_once($_SERVER['DOCUMENT_ROOT'].'/webEdition/we/include/we_exim/backup/weBackupExport.class.php');
		if($_REQUEST['verbose']) {
				print "\nExporting repository\n";
		}
		while (($_SESSION['weBackupVars']['row_counter']<$_SESSION['weBackupVars']['row_count']) || weBackupUtil::hasNextTable()) {
			if($_REQUEST['verbose']) {
						print "-";
			}
			if(weBackupExport::export(
					$_SESSION['weBackupVars']['backup_file'],
					$_SESSION['weBackupVars']['offset'],
					$_SESSION['weBackupVars']['row_counter'],
					$_SESSION['weBackupVars']['backup_steps'],
					$_SESSION['weBackupVars']['options']['backup_binary'],
					$_SESSION['weBackupVars']['backup_log']
			) === false){
				// force end
				$_SESSION['weBackupVars']['row_counter']=$_SESSION['weBackupVars']['row_count'];
			}
		}

		if($_SESSION['weBackupVars']['handle_options']['settings']){
			$fh = fopen($_SESSION['weBackupVars']['backup_file'],'ab');
			if($fh) {
				$file_to_export = '/webEdition/we/include/conf/we_conf_global.inc.php';
				weBackupUtil::exportFile($file_to_export,$fh);
				fclose($fh);
			}
		}
		weFile::save($_SESSION['weBackupVars']['backup_file'],$GLOBALS['weXmlExImFooter'],'ab');

		if(!empty($_SESSION['weBackupVars']['options']['compress'])){
				if($_REQUEST['verbose']) {
						print "\nCompressing...\n";
				}
				$_SESSION['weBackupVars']['backup_file']=weFile::compress($_SESSION['weBackupVars']['backup_file'],'gzip');
				$_SESSION['weBackupVars']['filename'] .= '.gz';
				$_backup_filename .= '.gz';
		}

		//copy the file to right location
		rename($_SESSION['weBackupVars']['backup_file'],$_backup_filename);

	}

}

if($_REQUEST['verbose']) {
		print "\nDone\n";
}

if(isset($_SESSION['weBackupVars'])) {
	unset($_SESSION['weBackupVars']);
}


function _checkAll($flag=true) {
	$_REQUEST['handle_core'] = $flag;
	$_REQUEST['handle_binary'] = $flag;
	$_REQUEST['handle_versions'] = $flag;
	$_REQUEST['handle_versions_binarys'] = $flag;
	$_REQUEST['handle_user'] = $flag;
	$_REQUEST['handle_customer'] = $flag;
	$_REQUEST['handle_shop'] = $flag;
	$_REQUEST['handle_workflow'] = $flag;
	$_REQUEST['handle_todo'] = $flag;
	$_REQUEST['handle_newsletter'] = $flag;
	$_REQUEST['handle_temporary'] = $flag;
	$_REQUEST['handle_banner'] = $flag;
	$_REQUEST['handle_object'] = $flag;
	$_REQUEST['handle_schedule'] = $flag;
	$_REQUEST['handle_settings'] = $flag;
	$_REQUEST['handle_configuration'] = $flag;
	$_REQUEST['handle_export'] = $flag;
	$_REQUEST['handle_voting'] = $flag;
}
?>