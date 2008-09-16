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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_exim/weContentProvider.class.php");
if(defined("WORKFLOW_TABLE")) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/workflow/"."weWorkflowUtility.php");
}

class rpcPublishDocsCmd extends rpcCmd {
	
	function execute() {
						
		$db = new DB_WE();
			
		$docs = array();
		
		$arr = $_REQUEST['we_cmd'];
		if(!empty($arr)) {
			$allDocs = explode(",", $arr[0]);
			foreach($allDocs as $k=>$v) {
				$teile = explode("_", $v, 2);
				$docs[$teile[1]][] = $teile[0];
			}
		}
		if(!empty($docs)) {
			foreach($docs as $k=>$v) {
				if(!empty($v)) {
					foreach($v as $key=>$val) {
						$ContentType = f("SELECT ContentType FROM `".$k."` WHERE ID='".$val."'","ContentType",$db);
						$object=weContentProvider::getInstance($ContentType, $val, $k);
						we_temporaryDocument::delete($object->ID);
						$object->initByID($object->ID);
						$object->ModDate = $object->Published;
						$_SESSION['versions']['doPublish'] = true;
						$object->we_save();
						$object->we_publish();
						if(defined("WORKFLOW_TABLE") && $object->ContentType == "text/webedition") {
							if(weWorkflowUtility::inWorkflow($object->ID,$object->Table)){
								weWorkflowUtility::removeDocFromWorkflow($object->ID,$object->Table,$_SESSION["user"]["ID"],"");
							}
						}
						unset($_SESSION['versions']['doPublish']);
					}
				}
			}
		}
	}
}

?>