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
 * @package    webEdition_base
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL
 */

include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_classes/taskFragment.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_versions/version_wizard/we_version.class.php");
include_once ($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we_logging/versions/versionsLog.class.php");

class versionFragment extends taskFragment
{

	function versionFragment($name, $taskPerFragment, $pause = 0, $bodyAttributes = "", $initdata = "")
	{
		parent::taskFragment($name, $taskPerFragment, $pause, $bodyAttributes, $initdata);
	
	}

	function doTask()
	{
		we_version::todo($this->data);
		$this->updateProgressBar();
	}

	function updateProgressBar()
	{
		$percent = round((100 / count($this->alldata)) * (1 + $this->currentTask));
		print 
				'<script language="JavaScript" type="text/javascript">if(parent.wizbusy.document.getElementById("progr")){parent.wizbusy.document.getElementById("progr").style.display="";};parent.wizbusy.setProgressText("pb1",(parent.wizbusy.document.getElementById("progr") ? "' . addslashes(
						shortenPath(
								$this->data["path"] . " - " . $GLOBALS["l_versions"]['version'] . " " . $this->data["version"], 
								33)) . '" : "' . "test" . addslashes(
						shortenPath(
								$this->data["path"] . " - " . $GLOBALS["l_versions"]['version'] . " " . $this->data["version"], 
								60)) . '") );parent.wizbusy.setProgress(' . $percent . ');</script>';
	
	}

	function finish()
	{
		if (!empty($_SESSION['versions']['logResetIds'])) {
			$versionslog = new versionsLog();
			$versionslog->saveVersionsLog($_SESSION['versions']['logResetIds'], WE_LOGGING_VERSIONS_RESET);
		}
		unset($_SESSION['versions']['logResetIds']);
		$responseText = isset($_REQUEST["responseText"]) ? $_REQUEST["responseText"] : "";
		htmlTop();
		if ($_REQUEST['type'] == "delete_versions") {
			$responseText = $GLOBALS["l_versions"]["deleteDateVersionsOK"];
		}
		if ($_REQUEST['type'] == "reset_versions") {
			$responseText = $GLOBALS["l_versions"]["resetAllVersionsOK"];
		}
		print 
				'<script language="JavaScript" type="text/javascript">
			' . we_message_reporting::getShowMessageCall(
						addslashes($responseText ? $responseText : ""), 
						WE_MESSAGE_NOTICE) . '
			
			// reload current document => reload all open Editors on demand
						
			var _usedEditors =  top.opener.weEditorFrameController.getEditorsInUse();
			for (frameId in _usedEditors) {

				if ( _usedEditors[frameId].getEditorIsActive() ) { // reload active editor
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
					_usedEditors[frameId].setEditorIsActive(true);

				} else {
					_usedEditors[frameId].setEditorReloadAllNeeded(true);
				}
			}
			_multiEditorreload = true;

			//reload tree
			top.opener.we_cmd("load", top.opener.treeData.table ,0);
			
			top.close();
		</script>
		</head>
		</html>';
	}

	function printHeader()
	{
		protect();
		//print "<html><head><title></title></head>";
	}

	function printBodyTag($attributes = "")
	{
	
	}

	function printFooter()
	{
		$this->printJSReload();
	}
}
?>