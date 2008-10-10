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


include_once($_SERVER["DOCUMENT_ROOT"]."/webEdition/we/include/"."we.inc.php");

protect();
/**
 * Checks if the start-document is a valid document. Content Type text/webedition or text/html
 * @return bool
 * @param int $id
 */
function checkIfValidStartdocument( $id , $type = "document"){

	if($type == "object") {
		$ctype = f("SELECT ContentType FROM " . OBJECT_FILES_TABLE . " WHERE ID=" . $id . "","ContentType",$GLOBALS["DB_WE"]);

		if($ctype == "objectFile"){
			return true;
		} else {
			return false;
		}

	} else {
		$ctype = f("SELECT ContentType FROM " . FILE_TABLE . " WHERE ID=" . $id . "","ContentType",$GLOBALS["DB_WE"]);

		if($ctype == "text/webedition"){
			return true;
		} else {
			return false;
		}
	}
}

//	Here begins the code for showing the correct frameset.
//	To improve readability the different cases are outsourced
//	in several functions, for SEEM, normal or edit_include-Mode.


function _buildJsCommand($cmdArray = array( "", "", "cockpit", "open_cockpit","","","","","" ) ) {
	return 'if(top && top.weEditorFrameController) top.weEditorFrameController.openDocument("' . implode('", "', $cmdArray) . '");';	
}

$jsCommand = _buildJsCommand();


if( isset($_REQUEST['we_cmd']) && isset($_REQUEST['we_cmd'][4]) && $_REQUEST['we_cmd'][4] == 'SEEM_edit_include' ){ // Edit-Include-Mode
	// in multiEditorFrameset we_cmd[1] can be set to reach this
	$directCmd = array();
	for ($i=1;$i<sizeof($_REQUEST["we_cmd"]) && $i<4; $i++) {
		$directCmd[] = $_REQUEST["we_cmd"][$i];
	}
	$jsCommand = _buildJsCommand($directCmd);

} else { // check preferences for which document to open at startup
	// <we:linkToSeeMode> !!!!
	if (isset($_SESSION["SEEM"]) && isset($_SESSION["SEEM"]["open_selected"])) {

		if ( isset($_SESSION["SEEM"]["startType"]) && ($_SESSION["SEEM"]["startType"] == 'document' && checkIfValidStartdocument($_SESSION["SEEM"]["startId"]) ) ) {

			$directCmd = array(
				FILE_TABLE,
				$_SESSION["SEEM"]["startId"],
				'text/webedition',
			);
			$jsCommand = _buildJsCommand($directCmd);

		} else if (isset($_SESSION["SEEM"]["startType"]) && ($_SESSION["SEEM"]["startType"] == 'object')) {

			$directCmd = array(
				OBJECT_FILES_TABLE,
				$_SESSION["SEEM"]["startId"],
				'objectFile'
			);
			$jsCommand = _buildJsCommand($directCmd);
		}
		unset($_SESSION["SEEM"]["open_selected"]);

	// normal mode, start document depends on settings
	} else if (isset( $_SESSION["prefs"]["seem_start_type"] )) {
		if($_SESSION["prefs"]["seem_start_type"] == "object" && $_SESSION["prefs"]["seem_start_file"] != 0 && checkIfValidStartdocument($_SESSION["prefs"]["seem_start_file"], "object")){	//	if a stardocument is already selected - show this

			$directCmd = array(
				OBJECT_FILES_TABLE,
				$_SESSION["prefs"]["seem_start_file"],
				'objectFile',
			);
			$jsCommand = _buildJsCommand($directCmd);

		} else if(($_SESSION["prefs"]["seem_start_type"] == "document" || $_SESSION["prefs"]["seem_start_type"] == "")&& $_SESSION["prefs"]["seem_start_file"] != 0 && checkIfValidStartdocument($_SESSION["prefs"]["seem_start_file"])){	//	if a stardocument is already selected - show this

			$directCmd = array(
				FILE_TABLE,
				$_SESSION["prefs"]["seem_start_file"],
				'text/webedition',
			);
			$jsCommand = _buildJsCommand($directCmd);
		} else if (($_SESSION["prefs"]["seem_start_type"] == "document" || $_SESSION["prefs"]["seem_start_type"] == "object") && $_SESSION["prefs"]["seem_start_file"] == 0){
			$_SESSION["prefs"]["seem_start_type"] = "cockpit";
			$jsCommand = _buildJsCommand();
		}
	}
	// :ToDO: alert Box when no vald start document is selected => open cockpit then
}
if ($_SESSION["prefs"]["seem_start_type"] !== "") {
	print we_htmlElement::jsElement(
		$jsCommand
		
	);
} else {
	print we_htmlElement::jsElement(
		"top.weEditorFrameController.toggleFrames();"
		
	);
}

?>