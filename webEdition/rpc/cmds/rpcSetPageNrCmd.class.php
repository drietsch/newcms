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

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_session.inc.php");

class rpcSetPageNrCmd  extends rpcCmd {

	function execute() {
		$we_transaction = isset($_REQUEST['transaction']) ? $_REQUEST['transaction'] : '';
		if (isset($_SESSION["we_data"][$we_transaction])) {
			$_SESSION["we_data"][$we_transaction][0]['EditPageNr'] = $_REQUEST['editPageNr'];
		}
		$resp = new rpcResponse();
    	return $resp;
	}
	
}

?>
