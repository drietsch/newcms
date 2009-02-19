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

require_once($_SERVER['DOCUMENT_ROOT']. "/webEdition/we/include/we_modules/customer/weDocumentCustomerFilter.class.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/webEdition/we/include/we_classes/we_folder.inc.php");
require_once($_SERVER['DOCUMENT_ROOT']. "/webEdition/we/include/we_classes/we_webEditionDocument.inc.php");

if (defined("OBJECT_TABLE")) {
	require_once($_SERVER['DOCUMENT_ROOT']. "/webEdition/we/include/we_modules/object/we_objectFile.inc.php");
}

class rpcGetUpdateDocumentCustomerFilterQuestionCmd extends rpcCmd {

	function execute() {


		$resp = new rpcResponse();

		// compare filter of document with fitler of folder...
		$_filterOfFolder = $this->getFilterOfFolder( $_REQUEST["folderId"], $_REQUEST["table"] );

		if (isset($_REQUEST["we_transaction"])) {
			$we_dt = isset($_SESSION["we_data"][$_REQUEST["we_transaction"]]) ? $_SESSION["we_data"][$_REQUEST["we_transaction"]] : "";

		}

		// filter of document
		$_document = new $_REQUEST["classname"];
		$_document->we_initSessDat($we_dt);
		$_filterOfDocument = $_document->documentCustomerFilter;

		if ( weDocumentCustomerFilter::filterAreQual($_filterOfFolder, $_filterOfDocument, true) ) {
			$_ret = "false";

		} else {
			$_ret = "true";

		}

		$resp->setData('data',$_ret);

		return $resp;
	}

	function getFilterOfFolder($id, $table) {
		if ($id > 0) {
			$folder = new we_folder();
			$folder->initByID($id, $table);
			return $folder->documentCustomerFilter;

		} else {
			return "";

		}
	}
}

?>