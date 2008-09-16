<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpcCopyNavigationFolderCmd extends rpcCmd {
	
	function execute() {
		$resp = new rpcResponse();
		if(		isset($_REQUEST['we_cmd'][0]) && !empty($_REQUEST['we_cmd'][0]) && 
				isset($_REQUEST['we_cmd'][1]) && !empty($_REQUEST['we_cmd'][1]) && 
				isset($_REQUEST['we_cmd'][2]) && !empty($_REQUEST['we_cmd'][2]) &&
				isset($_REQUEST['we_cmd'][3]) && !empty($_REQUEST['we_cmd'][3]) &&
				(strpos($_REQUEST['we_cmd'][2],$_REQUEST['we_cmd'][0]) ===false || strpos($_REQUEST['we_cmd'][2],$_REQUEST['we_cmd'][0]) > 0)
		){
			include_once($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_tools/navigation/class/weNavigation.class.php');
			
			$db = new DB_WE();
			$query = "SELECT * FROM " . NAVIGATION_TABLE . " WHERE Path LIKE '".addslashes($_REQUEST['we_cmd'][2])."/%' ORDER BY Path";
			$db->query($query);
			$result = $db->getAll();
			$querySet = "";
			$query = "";
			$folders = array($_REQUEST['we_cmd'][1]);
			$mapedId = array($_REQUEST['we_cmd'][3]=>$_REQUEST['we_cmd'][1]);
			foreach ($result as $row) {
				$querySet = "(";
				foreach ($row as $key=>$val) {
					switch ($key){
						case "ID" :
							$querySet .= "''";
							break;
						case "Path" :
							$path = str_replace($_REQUEST['we_cmd'][2],$_REQUEST['we_cmd'][0],$val);
							$querySet .= ", '$path'"; 
							break;
						case "ParentID" :
							$querySet .= ", '".$mapedId[$val]."'";
							break;
						default :
							$querySet .= ", '$val'";
					}
				}
				$querySet .= ")";
				if ($row['IsFolder']) {
					if (!empty($query)) {
						$query = "INSERT INTO " . NAVIGATION_TABLE . " VALUES " . $query;
						$db->query($query);
					}
					$query = "INSERT INTO " . NAVIGATION_TABLE . " VALUES " . $querySet;
					$db->query($query);
					$mapedId[$row['ID']] = $db->getInsertId();
					$folders[] = $mapedId[$row['ID']];
					$query = "";
				} else {
					if (!empty($query)) {
						$query .= ", ";
					}
					$query .= $querySet;
				}
				$lastInserted = $row['IsFolder'];		
			}
			if (!$lastInserted) {
				$query = "INSERT INTO " . NAVIGATION_TABLE . " VALUES " . $query;
				$db->query($query);
			}
			foreach ($folders as $folder) {
				$newNavi = new weNavigation($folder);
				$newNavi->save();
			}
			$resp->setData("status","ok") ;
			$resp->setData("folders",$folders) ;
		} else {
			$resp->setData("folders","") ;
		}
		
		return $resp;
	}
}
?>
