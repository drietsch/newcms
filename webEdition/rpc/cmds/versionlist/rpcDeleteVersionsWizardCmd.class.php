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
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLog.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");

class rpcDeleteVersionsWizardCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();

		$db = new DB_WE();	
		
		$query = "DELETE FROM `".VERSIONS_TABLE."` WHERE ".$_SESSION['versions']['deleteWizardWhere'];
		$db->query($query);
		
		unset($_SESSION['versions']['deleteWizardWhere']);

//		while($db->next_record()) {
//			weVersions::deleteVersion($db->f("ID"));
//		}
//		foreach($_SESSION['versions']['IDs'] as $k=>$v) {
//			weVersions::deleteVersion($v);
//		}
		if(isset($_SESSION['versions']['deleteWizardbinaryPath']) && is_array($_SESSION['versions']['deleteWizardbinaryPath']) && !empty($_SESSION['versions']['deleteWizardbinaryPath'])) {
			foreach($_SESSION['versions']['deleteWizardbinaryPath'] as $k=>$v) {
				$binaryPath = $_SERVER["DOCUMENT_ROOT"].$v;
				$binaryPathUsed = f("SELECT binaryPath FROM " . VERSIONS_TABLE . " WHERE binaryPath='".$v."' LIMIT 1","binaryPath",$db);
	
				if(file_exists($binaryPath) && $binaryPathUsed=="") {
					@unlink($binaryPath);
				}
			}
			unset($_SESSION['versions']['deleteWizardbinaryPath']);
		}
		
		if(!empty($_SESSION['versions']['logDeleteIds'])) {
			$versionslog = new versionsLog();
			$versionslog->saveVersionsLog($_SESSION['versions']['logDeleteIds'], WE_LOGGING_VERSIONS_DELETE);
		}
		unset($_SESSION['versions']['logDeleteIds']);
		
		
		$WE_PB = new we_progressBar(100,0,true);
		$WE_PB->setStudLen(200);
		$WE_PB->addText($GLOBALS['l_versions']['deleteDateVersionsOK'],0,"pb1");
		$js = $WE_PB->getJSCode();
		$pb = $WE_PB->getHTML();
		
		
		$resp->setData("data",$pb) ;
	
		return $resp;
		
		
		

						
//		$db = new DB_WE();
//			
//		$ids = array();
//
//		if(isset($_REQUEST["we_cmd"]["deleteVersion"]) && $_REQUEST["we_cmd"]["deleteVersion"]!="") {
//			
//			$ids = makeArrayFromCSV($_REQUEST["we_cmd"]["deleteVersion"]);	
//
//		}
//
//		if(!empty($ids)) {
//			$_SESSION['versions']['logDeleteIds'] = array();
//			foreach($ids as $k => $v) {
//				weVersions::deleteVersion($v);		
//			}
//			if(!empty($_SESSION['versions']['logDeleteIds'])) {
//				$versionslog = new versionsLog();
//				$versionslog->saveVersionsLog($_SESSION['versions']['logDeleteIds'],WE_LOGGING_VERSIONS_DELETE);
//			}
//			unset($_SESSION['versions']['logDeleteIds']);
//		}

		
	}
}

?>