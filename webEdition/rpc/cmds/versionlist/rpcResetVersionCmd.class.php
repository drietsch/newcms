<?php

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_versions/weVersions.class.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_logging/versions/versionsLog.class.php");

class rpcResetVersionCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
		
		$db = new DB_WE();

		$id = $_REQUEST["id"];

		if(stristr($id, ',')) {
			$ids = explode(",", $id);
		}
		else {
			$ids = array(
			"0" => $id
			);
		}
		
		$_SESSION['versions']['logResetIds'] = array();
		
		foreach($ids as $k => $id) {
			
			$parts = array();
			
			if(stristr($id, '___')) {
				$parts = explode("___", $id);
			}
			$id = isset($parts[0]) ? $parts[0] : $id;
			$publish = isset($parts[1]) ? $parts[1] : 0;

			if(isset($_REQUEST["version"]) && $_REQUEST["version"]!=0) {
				$version = $_REQUEST["version"];
			}
			else {
				$version = f("SELECT version FROM " . VERSIONS_TABLE . " WHERE ID='".$id."' ","version",$db);
			}
			
			$docID = (isset($_REQUEST["documentID"]) && $_REQUEST["documentID"]!=0) ? $_REQUEST["documentID"] : "";
			$docTable = (isset($_REQUEST["documentTable"]) && $_REQUEST["documentTable"]!=0) ? $_REQUEST["documentTable"] : "";
			
			weVersions::resetVersion($id, $version, $publish);		
			
		}
		
		if(!empty($_SESSION['versions']['logResetIds'])) {
			$versionslog = new versionsLog();
			$versionslog->saveVersionsLog($_SESSION['versions']['logResetIds'],WE_LOGGING_VERSIONS_RESET);
		}
		unset($_SESSION['versions']['logResetIds']);
		
		
	}
	

}

?>