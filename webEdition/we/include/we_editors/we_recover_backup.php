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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weBackupWizard.inc.php");

	protect();
	
	if(isset($_REQUEST["pnt"])) $what=$_REQUEST["pnt"];
	else $what="frameset";
		
	if(isset($_REQUEST["step"])) $step=$_REQUEST["step"];
	else $step=1;	

	$weBackupWizard=new weBackupWizard("/webEdition/we/include/we_editors/we_recover_backup.php",RECOVER_MODE);

	switch($what){
		case "frameset": print $weBackupWizard->getHTMLFrameset();break;
		case "body": print $weBackupWizard->getHTMLStep($step);break;
		case "cmd": print $weBackupWizard->getHTMLCmd();break;
		case "busy":  print $weBackupWizard->getHTMLBusy();break;
		case "extern":  print $weBackupWizard->getHTMLExtern();break;
		case "checker":  print $weBackupWizard->getHTMLChecker();break;
		default:
			error_log(__FILE__ . " unknown reference: $what");
	}

?>