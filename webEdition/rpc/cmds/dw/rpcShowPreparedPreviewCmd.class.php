<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   we
 * @package    we_rpc
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */

class rpcShowPreparedPreviewCmd extends rpcCmd {
	
	function execute() {
		
		$resp = new rpcResponse();
		
		include_once($_SERVER['DOCUMENT_ROOT'] . "/webEdition/we/include/we_classes/we_template.inc.php");
		
		$we_dt = "";
		
		$_REQUEST['we_cmd'][0] = "";
		
		if (isset($_REQUEST["we_dt"])) {
			$we_dt = isset($_SESSION["we_data"][$_REQUEST["we_dt"]]) ? $_SESSION["we_data"][$_REQUEST["we_dt"]] : "";
		}
		
		$GLOBALS["we_doc"] = new we_template();
		$GLOBALS["we_doc"]->we_initSessDat($we_dt);
		
		$GLOBALS["we_doc"]->setElement("data", stripslashes($_SESSION["rpc_previewCode"]) );
		
		if ($_REQUEST["mode"] == "preview") {
			$GLOBALS["we_doc"]->EditPageNr = WE_EDITPAGE_PREVIEW_TEMPLATE;
			
		} else {
			$GLOBALS["we_doc"]->EditPageNr = WE_EDITPAGE_PREVIEW;
		}
		
		$we_doc = $GLOBALS["we_doc"];
		
		ob_start();
		include( $GLOBALS["we_doc"]->editor() );
		$data = ob_get_contents();
		ob_end_clean();
		
		$resp->addData("data", $data);
		
		return $resp;
	}
}

?>