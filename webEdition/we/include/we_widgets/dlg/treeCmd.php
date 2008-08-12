<?php

include_once($_SERVER["DOCUMENT_ROOT"] . "/webEdition/we/include/we.inc.php");

if(isset($_REQUEST["cmd"])) {
	switch($_REQUEST["cmd"]) {
		case "load":
			if (isset($_REQUEST["pid"])){
				print we_htmlElement::jsElement("self.location='/webEdition/we/include/we_export/exportLoadTree.php?we_cmd[1]=".$_REQUEST["tab"]."&we_cmd[2]=".$_REQUEST["pid"]."&we_cmd[3]=".(isset($_REQUEST["openFolders"]) ? $_REQUEST["openFolders"] : "")."&we_cmd[4]=top'");
			}
			break;
	}
}

?>