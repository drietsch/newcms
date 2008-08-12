<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLog.class.php");

class rpcDeleteVersionCmd extends rpcCmd {
	
	function execute() {
						
		$db = new DB_WE();
			
		$ids = array();

		if(isset($_REQUEST["we_cmd"]["deleteVersion"]) && $_REQUEST["we_cmd"]["deleteVersion"]!="") {
			
			$ids = makeArrayFromCSV($_REQUEST["we_cmd"]["deleteVersion"]);	

		}

		if(!empty($ids)) {
			$_SESSION['versions']['logDeleteIds'] = array();
			foreach($ids as $k => $v) {
				weVersions::deleteVersion($v);		
			}
			if(!empty($_SESSION['versions']['logDeleteIds'])) {
				$versionslog = new versionsLog();
				$versionslog->saveVersionsLog($_SESSION['versions']['logDeleteIds'],WE_LOGGING_VERSIONS_DELETE);
			}
			unset($_SESSION['versions']['logDeleteIds']);
		}
	}
}

?>