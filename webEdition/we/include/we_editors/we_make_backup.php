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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we_html_tools.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/".$GLOBALS["WE_LANGUAGE"]."/backup.inc.php");


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/weBackupWizard.inc.php");

	protect();

	if(isset($_REQUEST["pnt"])) $what=$_REQUEST["pnt"];
	else $what="frameset";
		
	if(isset($_REQUEST["step"])) $step=$_REQUEST["step"];
	else $step=1;	

	$weBackupWizard=new weBackupWizard("/webEdition/we/include/we_editors/we_make_backup.php",BACKUP_MODE);

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