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

class rpcPreparePreviewCmd extends rpcCmd {
	
	function execute() {
		
		$_SESSION["rpc_previewCode"] = $_REQUEST["source"];
		
		// an empty rpcResponse is enough
		$resp = new rpcResponse();
		return $resp;
	}
}

?>