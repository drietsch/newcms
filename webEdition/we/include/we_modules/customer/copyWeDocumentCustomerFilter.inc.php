<?php
/**
 * webEdition CMS
 *
 * LICENSETEXT_CMS
 *
 *
 * @category   webEdition
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENSETEXT_CMS  TODO insert license type and url
 */





include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/taskFragment.class.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_progressBar.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/html/we_button.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_folder.inc.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_classes/we_webEditionDocument.inc.php");
if (defined("OBJECT_FILES_TABLE") ) {
	include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/object/we_objectFile.inc.php");

}
include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_modules/customer/weDocumentCustomerFilter.class.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/we_language/" . $GLOBALS["WE_LANGUAGE"] . "/modules/customerFilter.inc.php");

class copyWeDocumentCustomerFilterFrag extends taskFragment{

	function init(){

		// init the fragment
		// REQUEST[we_cmd][1] = id of folder
		// REQUEST[we_cmd][2] = table
		$_id = $_REQUEST["we_cmd"][1];
		$_table = $_REQUEST["we_cmd"][2];

		// if we_cmd 3 is set, take filters of that folder as parent!!
		if (isset($_REQUEST["we_cmd"][3])) {
			$_idForFilter = $_REQUEST["we_cmd"][3];

		} else {
			$_idForFilter = $_id;

		}

		$_theFolder = new we_folder();
		$_theFolder->initByID($_id, $_table);

		// now get all childs of this folder
		$_query = "
		SELECT *, ID, ContentType
		FROM $_table
		WHERE
			( ContentType = \"folder\" OR ContentType = \"text/webedition\" OR ContentType=\"objectFile\" )
			AND PATH LIKE \"" . $_theFolder->Path . "/%\"
		";

		$_db = new DB_WE();
		$_db->query( $_query );

		$this->alldata = array();

		if ($_db->num_rows()) {

			while ($_db->next_record()) {
				array_push(
					$this->alldata,
					array(
						"folder_id" => $_id,
						"table" => $_table,
						"idForFilter" => $_idForFilter,
						"id" => $_db->f("ID"),
						"contenttype" => $_db->f("ContentType"),
					)
				);
			}
		}
	}

	function doTask(){

		// getFilter of base-folder
		$_theFolder = new we_folder();
		$_theFolder->initByID( $this->data["idForFilter"], $this->data["table"] );

		// getTarget-Document
		$_targetDoc = null;
		switch ($this->data["contenttype"]) {
			case "folder":
				$_targetDoc = new we_folder();
			break;
			case "text/webedition":
				$_targetDoc = new we_webEditionDocument();
			break;
			case "objectFile":
				$_targetDoc = new we_objectFile();
			break;
		}
		$_targetDoc->initById($this->data["id"], $this->data["table"]);

		if ($_theFolder->documentCustomerFilter) {
			$_targetDoc->documentCustomerFilter = $_theFolder->documentCustomerFilter;

		} else {
			$_targetDoc->documentCustomerFilter = weDocumentCustomerFilter::getEmptyDocumentCustomerFilter();
		}

		// write filter to target document


		// save filter
		$_targetDoc->documentCustomerFilter->saveForModel($_targetDoc);

		print we_htmlElement::jsElement("
			parent.setProgressText('copyWeDocumentCustomerFilterText', '" . shortenPath($_targetDoc->Path, 55) . "');
			parent.setProgress(" . number_format( ( ( $this->currentTask ) / $this->numberOfTasks) *100 , 0 ) . ");
		");
	}

	function finish(){

		print we_htmlElement::jsElement("
			parent.setProgressText('copyWeDocumentCustomerFilterText', '" . $GLOBALS["l_customerFilter"]["apply_filter_done"] . "');
			parent.setProgress(100);
			" . we_message_reporting::getShowMessageCall( $GLOBALS["l_customerFilter"]["apply_filter_done"], WE_MESSAGE_NOTICE) . "
			window.setTimeout('parent.top.close()', 2000);
		");
	}
}


if (isset($_REQUEST["startCopy"])) { // start the fragment

	$_theFrag = new copyWeDocumentCustomerFilterFrag("copyWeDocumentCustomerFilter", 1, 200);

} else { // print the window

	// if any childs of the folder are open - bring message to close them

		// REQUEST[we_cmd][1] = id of folder
		// REQUEST[we_cmd][2] = table
		$_id = $_REQUEST["we_cmd"][1];
		$_table = $_REQUEST["we_cmd"][2];

		// if we_cmd 3 is set, take filters of that folder as parent!!
		if (isset($_REQUEST["we_cmd"][3])) {
			$_idForFilter = $_REQUEST["we_cmd"][3];

		} else {
			$_idForFilter = $_id;

		}

		$_theFolder = new we_folder();
		$_theFolder->initByID($_id, $_table);

		// now get all childs of this folder
		$_query = "
		SELECT *, ID, ContentType
		FROM $_table
		WHERE
			( ContentType = \"folder\" OR ContentType = \"text/webedition\" OR ContentType=\"objectFile\" )
			AND PATH LIKE \"" . $_theFolder->Path . "/%\"
		";

		$_db = new DB_WE();
		$_db->query( $_query );

		$allChilds = array();
		$_allChildsJS = "
			var _allChilds = new Object();";

		if ($_db->num_rows()) {

			while ($_db->next_record()) {
				$_allChildsJS .= "
				_allChilds['id_" . $_db->f("ID") . "'] = '" . $_db->f("ContentType") . "';";
			}
		}
		$_js = '
			var _openChilds = Array();
			var _usedEditors = top.opener.top.weEditorFrameController.getEditorsInUse();

			for (frameId in _usedEditors) {

				// table muss FILE_TABLE sein
				if ( _usedEditors[frameId].getEditorEditorTable() == "' . $_table . '" ) {
					if ( _allChilds["id_" + _usedEditors[frameId].getEditorDocumentId()] && _allChilds["id_" + _usedEditors[frameId].getEditorDocumentId()] == _usedEditors[frameId].getEditorContentType() ) {
						_openChilds.push( frameId );
					}
				}
			}
			';

	$we_button = new we_button();
	$js = "";

	$pb = new we_progressBar(0, 0, true);
	$pb->addText("&nbsp;", 0, "copyWeDocumentCustomerFilterText");
	$pb->setStudWidth(10);
	$pb->setStudLen(300);
	$js .= $pb->getJS();
	$js .= $pb->getJSCode();

	// image and progressbar
	$content = $pb->getHTML();

	$buttonBar = $we_button->create_button("cancel", "javascript:top.close();");

	$_iframeLocation = "/webEdition/we_cmd.php?we_cmd[0]=" . $_REQUEST["we_cmd"][0] . "&we_cmd[1]=" . $_REQUEST["we_cmd"][1] . "&we_cmd[2]=" . $_REQUEST["we_cmd"][2] . (isset($_REQUEST["we_cmd"][3]) ? "&we_cmd[3]=" . $_REQUEST["we_cmd"][3] : "" ) ."&startCopy=1";

	htmlTop();
	print STYLESHEET;
	print we_htmlElement::jsElement("

		function checkForOpenChilds() {

			$_allChildsJS
			$_js

			if (_openChilds.length) {
				if ( confirm(\"" . $GLOBALS['l_customerFilter']["apply_filter_cofirm_close"] . "\") ) {
					// close all
					for (i=0;i<_openChilds.length;i++) {
						_usedEditors[_openChilds[i]].setEditorIsHot(false);
						top.opener.top.weEditorFrameController.closeDocument(_openChilds[i]);

					}

				} else {
					window.close();
					return;
				}

			}
			document.getElementById(\"iframeCopyWeDocumentCustomerFilter\").src=\"" . $_iframeLocation . "\";
		}

	");
	print "</head>
<body class=\"weDialogBody\" onload=\"checkForOpenChilds()\">
" . $js . "
" . htmlDialogLayout($content, $GLOBALS['l_customerFilter']["apply_filter"], $buttonBar) . "
<div style=\"display: none;\"> <!-- hidden -->
	<iframe style=\"position: absolute; top: 150; height: 1px; width: 1px;\" name=\"iframeCopyWeDocumentCustomerFilter\" id=\"iframeCopyWeDocumentCustomerFilter\" src=\"about:blank\"></iframe>
</div>
</html>
";

}


?>