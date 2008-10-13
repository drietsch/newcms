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

class rpcDeleteVersionCmd extends rpcCmd {
	
	function execute() {
						
		$db = new DB_WE();
			
		$ids = array();
		
		protect();

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